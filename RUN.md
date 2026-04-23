# DigiTender - Application Setup & Run Guide

## Quick Start (Docker - Recommended)

### Prerequisites

- Docker and Docker Compose installed on your system
- Port 8080 (web) and 3306 (database) available

### Step 1: Navigate to Project Directory

```bash
cd /path/to/digitender
```

### Step 2: Start the Application

```bash
docker compose up -d
```

This command will:

- Build the PHP 7.4 web server image
- Start MySQL 5.7 database container
- Initialize database with schema and sample data
- Launch both services in the background

### Step 3: Verify Application is Running

```bash
# Check container status
docker compose ps

# Or verify by accessing the home page
curl http://localhost:8080
```

### Step 4: Access the Application

Open your browser and navigate to:

- **Home Page:** http://localhost:8080
- **Admin Panel:** http://localhost:8080/admin/index.php

### Step 5: Stop the Application

```bash
# Stop containers but keep data
docker compose stop

# Stop and remove containers (data persisted in volume)
docker compose down

# Stop and remove everything including database (fresh start)
docker compose down -v
```

---

## Test Credentials

### User Account

```
Email:    punit@gmail.com
Password: 111111
```

### Admin Account

```
Email:    admin.new@digitender.com
Password: Admin@123
```

---

## User Portal Endpoints

| Feature           | URL                                  |
| ----------------- | ------------------------------------ |
| Home Page         | http://localhost:8080                |
| User Registration | http://localhost:8080/register.php   |
| User Login        | http://localhost:8080/login.php      |
| Browse Tenders    | http://localhost:8080/tender.php     |
| Search Tenders    | http://localhost:8080/search.php     |
| Submit Bid        | http://localhost:8080/bid.php        |
| My Biddings       | http://localhost:8080/mybiddings.php |
| About             | http://localhost:8080/about.php      |
| Services          | http://localhost:8080/services.php   |
| Contact           | http://localhost:8080/contact.php    |

---

## Admin Panel Endpoints

| Feature         | URL                                             |
| --------------- | ----------------------------------------------- |
| Admin Login     | http://localhost:8080/admin/index.php           |
| Dashboard       | http://localhost:8080/admin/tables.php          |
| Create Tender   | http://localhost:8080/admin/ticket.php          |
| Manage Biddings | http://localhost:8080/admin/biddings.php        |
| Confirm Bids    | http://localhost:8080/admin/confirm_bidding.php |
| Allot Tenders   | http://localhost:8080/admin/allot_tender.php    |
| View Tickets    | http://localhost:8080/admin/tickets_a.php       |

---

## Database Details

### Connection Settings

- **Host:** localhost (or `db` from within container)
- **Port:** 3306
- **Username:** digitender
- **Password:** digitender
- **Database:** digitender

### Tables Created

1. `registration` - Regular user accounts
2. `head` - Admin user accounts
3. `tender` - Tender postings
4. `bidding` - User bids on tenders
5. `team` - Staff members
6. `ticket` - Support tickets

### Sample Data Included

- 2 registered users
- 3 admin users (including new admin.new@digitender.com)
- 2 active tenders
- 2 biddings sample records

---

## Manual Database Access

### Connect to MySQL Container

```bash
# Interactive MySQL CLI
docker exec -it digitender-db mysql -udigitender -pdigitender -D digitender

# Run a query
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT * FROM registration;"

# View all tables
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SHOW TABLES;"
```

---

## View Application Logs

### Web Server Logs

```bash
docker logs digitender-web
```

### Database Logs

```bash
docker logs digitender-db
```

### Live Log Streaming

```bash
docker logs -f digitender-web    # Web server (Ctrl+C to exit)
docker logs -f digitender-db     # Database (Ctrl+C to exit)
```

---

## File Upload Directory

File uploads from tender creation are stored in:

```
/path/to/digitender/web/admin/img/
```

The directory is automatically created with proper permissions (777) inside the container.

---

## Features & Functionality

### User Features

✅ **Registration with OTP Verification**

- Mobile validation (10 digits)
- Aadhaar validation (12 digits)
- Password strength requirements
- OTP via SMS (dev mode shows OTP in response)

✅ **User Authentication**

- Secure password hashing (bcrypt support)
- Session-based login
- Password reset via OTP

✅ **Tender Management**

- Browse all active tenders
- Search tenders by keywords
- View tender details (sector, budget, deadline)
- Download tender documents

✅ **Bidding System**

- Submit bids on active tenders
- Track bid status (pending/confirmed)
- View all submitted bids
- Bid history

### Admin Features

✅ **Admin Authentication**

- Separate admin login (role-based)
- Only `head` table users can access admin panel
- Session-based admin verification

✅ **Tender Management**

- Create new tenders with file attachments
- View all tenders and biddings
- Allot tenders to vendors
- Mark tenders as complete

✅ **Bidding Management**

- Review vendor bids
- Confirm/reject bids
- View bidding analytics

✅ **Support System**

- Manage user support tickets
- Respond to tickets
- Track ticket status

---

## Troubleshooting

### Application won't start

```bash
# Check if ports are already in use
sudo lsof -i :8080    # Web port
sudo lsof -i :3306    # Database port

# Clean up and restart
docker compose down -v
docker compose up -d
```

### Database connection errors

```bash
# Verify database is healthy
docker exec digitender-db mysql -uroot -prootpassword -e "SELECT 1;"

# Check database logs
docker logs digitender-db | grep -i error
```

### 404 on pages

- Ensure you're using correct URLs (see Endpoints section)
- Verify all volumes are mounted: `docker compose ps`

### File upload not working

```bash
# Check upload directory permissions
docker exec digitender-web ls -la /var/www/html/admin/img/

# If needed, fix permissions
docker exec digitender-web chmod 777 /var/www/html/admin/img
```

---

## Configuration Files

### Docker Compose Configuration

File: `docker-compose.yml`

- Defines web and database services
- Sets environment variables
- Configures volumes and networking

### Web Configuration

File: `web/dbconfig.php`

- Database connection settings
- Reads environment variables (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
- Provides `select()` and `iud()` helper functions

### Database Schema

File: `web/database/test.sql`

- Full database schema
- Sample data for testing

---

## Environment Variables

The application uses these environment variables (if needed for customization):

```
DB_HOST=db                       # Database host
DB_USER=digitender              # Database username
DB_PASSWORD=digitender          # Database password
DB_NAME=digitender              # Database name
FAST2SMS_API_KEY=                # Optional: For real SMS OTP delivery
```

To modify, edit `docker-compose.yml` under the `web:` service `environment:` section.

---

## Technology Stack

- **Backend:** PHP 7.4 with Apache 2.4
- **Database:** MySQL 5.7
- **Frontend:** HTML5, CSS3, JavaScript, jQuery
- **Framework:** Bootstrap 4
- **OTP:** FAST2SMS API (with dev fallback)
- **File Handling:** Procedural PHP

---

## Development Notes

### Database Helpers

The application uses custom helper functions in `web/dbconfig.php`:

```php
// Select query - returns mysqli result
select("SELECT * FROM tender");

// Insert/Update/Delete - returns affected rows
iud("INSERT INTO registration ...");
```

### Session Management

- Users: `$_SESSION['login']` (set on successful login)
- Admins: `$_SESSION['admin_login']` (set on successful admin login)

### File Upload Location

- Upload directory: `/var/www/html/admin/img/`
- Accessible via: `http://localhost:8080/admin/img/filename`

---

## Next Steps for Production

1. **Enable HTTPS** - Add SSL certificate configuration
2. **Prepared Statements** - Migrate from string interpolation to prepared statements
3. **Input Sanitization** - Add comprehensive input validation
4. **Rate Limiting** - Add rate limiting on registration/login
5. **Logging** - Implement comprehensive application logging
6. **Backup Strategy** - Set up automated database backups
7. **Monitoring** - Add health checks and alerts
8. **API Key Management** - Securely manage sensitive credentials

---

## Support

For issues or questions:

1. Check application logs: `docker logs digitender-web`
2. Verify database connectivity: `docker compose ps`
3. Review browser console for JavaScript errors
4. Check file permissions in `/web/admin/img/`

---

**Last Updated:** April 14, 2026  
**Version:** 1.0
