#!/usr/bin/env bash

# End-to-end smoke tests for DigiTender setup.
# Usage:
#   ./test_features.sh
# Optional env overrides:
#   BASE_URL=http://localhost:8080
#   USER_EMAIL=punit@gmail.com
#   USER_PASSWORD=111111
#   ADMIN_EMAIL=admin.new@digitender.com
#   ADMIN_PASSWORD=Admin@123
#   TENDER_ID=5

set -u

BASE_URL="${BASE_URL:-http://localhost:8080}"
USER_EMAIL="${USER_EMAIL:-punit@gmail.com}"
USER_PASSWORD="${USER_PASSWORD:-111111}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin.new@digitender.com}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-Admin@123}"
TENDER_ID="${TENDER_ID:-5}"
DB_CONTAINER="${DB_CONTAINER:-digitender-db}"
DB_NAME="${DB_NAME:-digitender}"
DB_USER="${DB_USER:-digitender}"
DB_PASS="${DB_PASS:-digitender}"

USER_COOKIE="/tmp/digitender_user_cookie_$$.txt"
ADMIN_COOKIE="/tmp/digitender_admin_cookie_$$.txt"
TMP_DIR="/tmp/digitender_test_$$"
mkdir -p "$TMP_DIR"

PASS_COUNT=0
FAIL_COUNT=0

cleanup() {
  rm -f "$USER_COOKIE" "$ADMIN_COOKIE"
  rm -rf "$TMP_DIR"
}
trap cleanup EXIT

pass() {
  PASS_COUNT=$((PASS_COUNT + 1))
  printf "[PASS] %s\n" "$1"
}

fail() {
  FAIL_COUNT=$((FAIL_COUNT + 1))
  printf "[FAIL] %s\n" "$1"
}

check_http_200() {
  local name="$1"
  local path="$2"
  local code
  code="$(curl -sS -o /dev/null -w "%{http_code}" "$BASE_URL$path")"
  if [ "$code" = "200" ]; then
    pass "$name returns HTTP 200"
  else
    fail "$name expected HTTP 200 but got $code"
  fi
}

check_contains() {
  local name="$1"
  local file="$2"
  local pattern="$3"
  if grep -qi "$pattern" "$file"; then
    pass "$name"
  else
    fail "$name"
  fi
}

echo "Running DigiTender feature tests against $BASE_URL"

echo "== Basic endpoint checks =="
check_http_200 "Home page" "/"
check_http_200 "User login page" "/login.php"
check_http_200 "Registration page" "/register.php"
check_http_200 "Tender listing page" "/tender.php"
check_http_200 "Admin login page" "/admin/index.php"

echo "== Database health checks =="
if docker exec "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "SELECT 1;" >/dev/null 2>&1; then
  pass "Database connection is healthy"
else
  fail "Database connection failed (container: $DB_CONTAINER, db: $DB_NAME)"
fi

AUTO_INC_CHECK="$(docker exec "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -N -e "SELECT CASE WHEN EXTRA LIKE '%auto_increment%' THEN 'yes' ELSE 'no' END FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$DB_NAME' AND TABLE_NAME='bidding' AND COLUMN_NAME='bid_id';" 2>/dev/null || true)"
if [ "$AUTO_INC_CHECK" = "yes" ]; then
  pass "bidding.bid_id is AUTO_INCREMENT"
else
  fail "bidding.bid_id is not AUTO_INCREMENT"
fi

TENDER_CAT_COL="$(docker exec "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -N -e "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$DB_NAME' AND TABLE_NAME='tender' AND COLUMN_NAME='category';" 2>/dev/null || true)"
BIDDING_CAT_COL="$(docker exec "$DB_CONTAINER" mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" -N -e "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$DB_NAME' AND TABLE_NAME='bidding' AND COLUMN_NAME='category';" 2>/dev/null || true)"
if [ "$TENDER_CAT_COL" = "1" ]; then
  pass "tender.category column exists"
else
  fail "tender.category column missing"
fi
if [ "$BIDDING_CAT_COL" = "1" ]; then
  pass "bidding.category column exists"
else
  fail "bidding.category column missing"
fi

echo "== User login and bidding flow =="
USER_LOGIN_FILE="$TMP_DIR/user_login.html"
curl -sS -c "$USER_COOKIE" -b "$USER_COOKIE" -L -X POST "$BASE_URL/login.php" \
  --data "email=$USER_EMAIL&password=$USER_PASSWORD&login=LOGIN" > "$USER_LOGIN_FILE"
check_contains "User login succeeds" "$USER_LOGIN_FILE" "Login successful"

UNIQ_CHARGE="TEST$RANDOM$RANDOM"
BID_FILE="$TMP_DIR/bid_submit.html"
curl -sS -c "$USER_COOKIE" -b "$USER_COOKIE" -L -X POST "$BASE_URL/bidding.php?id=$TENDER_ID" \
  --data "name=autotest&email=$USER_EMAIL&mobile=9998887776&charge=$UNIQ_CHARGE&day=7+days&bidding=BIDDING" > "$BID_FILE"
if grep -qi "BIDDING SUCCESSFUL" "$BID_FILE" || grep -qi "BID UPDATED SUCCESSFULLY" "$BID_FILE"; then
  pass "Bid submission/update succeeds"
else
  fail "Bid submission/update failed"
fi

MY_BIDS_FILE="$TMP_DIR/my_bids.html"
curl -sS -c "$USER_COOKIE" -b "$USER_COOKIE" "$BASE_URL/mybiddings.php" > "$MY_BIDS_FILE"
check_contains "New bid appears in My Biddings" "$MY_BIDS_FILE" "$UNIQ_CHARGE"
check_contains "Bid category shown in My Biddings" "$MY_BIDS_FILE" "Category-"

echo "== Tender category filter =="
TENDER_FILTER_FILE="$TMP_DIR/tender_filter.html"
curl -sS "$BASE_URL/tender.php?category=General" > "$TENDER_FILTER_FILE"
check_contains "Tender page supports category filter" "$TENDER_FILTER_FILE" "Category"

echo "== Admin login flow =="
ADMIN_LOGIN_FILE="$TMP_DIR/admin_login.html"
curl -sS -c "$ADMIN_COOKIE" -b "$ADMIN_COOKIE" -L -X POST "$BASE_URL/admin/index.php" \
  --data "email=$ADMIN_EMAIL&password=$ADMIN_PASSWORD&login=Login" > "$ADMIN_LOGIN_FILE"
if grep -qi "login success" "$ADMIN_LOGIN_FILE" || grep -qi "ticket.php" "$ADMIN_LOGIN_FILE"; then
  pass "Admin login succeeds"
else
  fail "Admin login failed"
fi

echo ""
echo "== Summary =="
printf "Passed: %d\n" "$PASS_COUNT"
printf "Failed: %d\n" "$FAIL_COUNT"

if [ "$FAIL_COUNT" -gt 0 ]; then
  exit 1
fi

echo "All feature checks passed."
exit 0
