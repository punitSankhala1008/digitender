# DigiTender Project Flow and File Roles

## 1) End-to-End Application Flow

1. User opens the site through [web/index.php](web/index.php).
2. Registration starts on [web/register.php](web/register.php), and OTP is generated/sent by [web/send_otp.php](web/send_otp.php).
3. Login is handled in [web/login.php](web/login.php). On success, user session data is stored.
4. Logged-in users browse active tenders in [web/tender.php](web/tender.php), and search via [web/search.php](web/search.php).
5. Tender details are shown in [web/bid.php](web/bid.php), while bid creation/update happens in [web/bidding.php](web/bidding.php).
6. Pending bids are visible in [web/mybiddings.php](web/mybiddings.php); approved bids are visible in [web/confirm_biddings.php](web/confirm_biddings.php).
7. Admin logs in from [web/admin/index.php](web/admin/index.php).
8. Admin creates tenders in [web/admin/ticket.php](web/admin/ticket.php), reviews open tenders in [web/admin/tables.php](web/admin/tables.php), and reviews bids in [web/admin/biddings.php](web/admin/biddings.php).
9. Admin confirms bids using [web/admin/confirm_bidding.php](web/admin/confirm_bidding.php), which marks the bid confirmed and the tender allotted.
10. Allocated tenders are listed in [web/admin/allot_tender.php](web/admin/allot_tender.php), and confirmed bids are listed in [web/admin/confirm_tenders.php](web/admin/confirm_tenders.php).
11. Tender attachment downloads are served by [web/download.php](web/download.php).

## 2) Core Data Model

Main tables (defined in SQL dumps):

- registration: user accounts
- head: admin accounts
- tender: tender records and allocation state
- bidding: bid records and confirmation state
- team, ticket: legacy/alternate workflow data

Primary SQL files:

- [web/database/test.sql](web/database/test.sql)
- [web/admin/database/test.sql](web/admin/database/test.sql)

## 3) Root-Level Files

- [docker-compose.yml](docker-compose.yml): Runs PHP web service and MySQL service.
- [Dockerfile](Dockerfile): PHP 7.4 Apache image with mysqli extension.
- [README.md](README.md): Main project documentation.
- [RUN.md](RUN.md): Full run and endpoint guide.
- [QUICKSTART.md](QUICKSTART.md): Quick setup reference.
- [run.sh](run.sh): Linux helper script for start/stop/restart.
- [run.bat](run.bat): Windows helper script for start/stop/restart.
- [test_features.sh](test_features.sh): Smoke tests for key features.

## 4) User-Side Files in web

### Authentication and session

- [web/dbconfig.php](web/dbconfig.php): DB settings, session start, common DB helper functions.
- [web/login.php](web/login.php): User login flow.
- [web/register.php](web/register.php): User registration and OTP verification.
- [web/send_otp.php](web/send_otp.php): OTP generation and SMS/local fallback.
- [web/logout.php](web/logout.php): User logout.

### Navigation and main pages

- [web/nav.php](web/nav.php): Session-aware top menu.
- [web/index.php](web/index.php): Home/landing page.
- [web/tender.php](web/tender.php): Tender listing and category filter.
- [web/search.php](web/search.php): Tender search results.
- [web/bid.php](web/bid.php): Tender details view.
- [web/bidding.php](web/bidding.php): Bid submit/update logic.
- [web/mybiddings.php](web/mybiddings.php): User pending bids.
- [web/confirm_biddings.php](web/confirm_biddings.php): User confirmed bids.
- [web/profile.php](web/profile.php): User profile update page.
- [web/download.php](web/download.php): Attachment download handler.

### Informational/legacy template pages

- [web/about.php](web/about.php)
- [web/services.php](web/services.php)
- [web/contact.php](web/contact.php)
- [web/project.php](web/project.php)
- [web/mar.php](web/mar.php)

### User-side assets

- [web/css/bootstrap.css](web/css/bootstrap.css)
- [web/css/style.css](web/css/style.css)
- [web/js/jquery.min.js](web/js/jquery.min.js)
- [web/js/jquery-1.11.0.min.js](web/js/jquery-1.11.0.min.js)
- [web/js/move-top.js](web/js/move-top.js)
- [web/js/easing.js](web/js/easing.js)
- [web/js/responsiveslides.min.js](web/js/responsiveslides.min.js)
- [web/images](web/images): image and icon assets

## 5) Admin Files in web/admin

### Active tender/bidding workflow

- [web/admin/dbconfig.php](web/admin/dbconfig.php): Admin DB helpers and connection.
- [web/admin/sidebar.php](web/admin/sidebar.php): Admin auth guard and menu.
- [web/admin/index.php](web/admin/index.php): Admin login entry.
- [web/admin/logout.php](web/admin/logout.php): Admin logout.
- [web/admin/ticket.php](web/admin/ticket.php): Create/generate tender.
- [web/admin/tables.php](web/admin/tables.php): View/manage open tenders.
- [web/admin/biddings.php](web/admin/biddings.php): View pending bids and confirm/delete.
- [web/admin/confirm_bidding.php](web/admin/confirm_bidding.php): Confirm bid and close tender.
- [web/admin/confirm_tenders.php](web/admin/confirm_tenders.php): View confirmed bids.
- [web/admin/allot_tender.php](web/admin/allot_tender.php): View allotted tenders.
- [web/admin/delete.php](web/admin/delete.php): Delete tender.
- [web/admin/delete_bidding.php](web/admin/delete_bidding.php): Delete bid.
- [web/admin/profile.php](web/admin/profile.php): Admin profile page.

### Template/demo/legacy support pages

- [web/admin/404.php](web/admin/404.php)
- [web/admin/blank.php](web/admin/blank.php)
- [web/admin/buttons.php](web/admin/buttons.php)
- [web/admin/cards.php](web/admin/cards.php)
- [web/admin/charts.php](web/admin/charts.php)
- [web/admin/utilities-animation.php](web/admin/utilities-animation.php)
- [web/admin/utilities-border.php](web/admin/utilities-border.php)
- [web/admin/utilities-color.php](web/admin/utilities-color.php)
- [web/admin/utilities-other.php](web/admin/utilities-other.php)
- [web/admin/forgot-password.php](web/admin/forgot-password.php)
- [web/admin/register.php](web/admin/register.php)
- [web/admin/send_otp.php](web/admin/send_otp.php)
- [web/admin/verify_otp.php](web/admin/verify_otp.php)
- [web/admin/close_ticket.php](web/admin/close_ticket.php)
- [web/admin/myphp.php](web/admin/myphp.php)

### Admin tooling/theme files

- [web/admin/css](web/admin/css)
- [web/admin/js](web/admin/js)
- [web/admin/scss](web/admin/scss)
- [web/admin/vendor](web/admin/vendor)
- [web/admin/img](web/admin/img)
- [web/admin/team](web/admin/team)
- [web/admin/README.md](web/admin/README.md)
- [web/admin/LICENSE](web/admin/LICENSE)
- [web/admin/package.json](web/admin/package.json)
- [web/admin/package-lock.json](web/admin/package-lock.json)
- [web/admin/gulpfile.js](web/admin/gulpfile.js)
- [web/admin/.travis.yml](web/admin/.travis.yml)

## 6) Nested Legacy Module in web/admin/head

This is an additional older admin-head module (mostly SB Admin template derived), separate from the currently active main admin flow.

Common files:

- [web/admin/head/login.php](web/admin/head/login.php)
- [web/admin/head/index.php](web/admin/head/index.php)
- [web/admin/head/dbconfig.php](web/admin/head/dbconfig.php)
- [web/admin/head/sidebar.php](web/admin/head/sidebar.php)
- [web/admin/head/tables.php](web/admin/head/tables.php)
- [web/admin/head/tickets_a.php](web/admin/head/tickets_a.php)
- [web/admin/head/ticket_a.php](web/admin/head/ticket_a.php)
- [web/admin/head/client_detail.php](web/admin/head/client_detail.php)
- [web/admin/head/client_reply.php](web/admin/head/client_reply.php)
- [web/admin/head/solved_tickets.php](web/admin/head/solved_tickets.php)
- [web/admin/head/mamber.php](web/admin/head/mamber.php)

Asset/tooling folders:

- [web/admin/head/css](web/admin/head/css)
- [web/admin/head/js](web/admin/head/js)
- [web/admin/head/scss](web/admin/head/scss)
- [web/admin/head/vendor](web/admin/head/vendor)
- [web/admin/head/img](web/admin/head/img)

## 7) Practical Notes

- Main production flow is centered around:
  - user pages in [web](web)
  - admin pages in [web/admin](web/admin)
- The [web/admin/head](web/admin/head) subtree is legacy and can be treated as a separate older module unless you explicitly plan to revive it.
