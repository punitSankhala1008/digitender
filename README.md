# Digitender

A web-based tender and bidding management system built with PHP, MySQL, and Bootstrap.

## Project Overview

Digitender is a platform that enables organizations to post tenders and allows vendors to place bids on those tenders. It includes both user-facing and admin dashboard interfaces for comprehensive tender management.

## Features

### User Features

- **User Registration & Authentication** - Secure signup and login with OTP verification
- **Tender Browsing** - Search and view available tenders
- **Bidding System** - Submit and manage bids on tenders
- **My Biddings** - Track all submitted bids
- **User Profile** - Manage personal information
- **Contact & Support** - Reach out through contact form

### Admin Features

- **Tender Management** - Create, view, and manage tenders
- **Bidding Management** - Review and confirm bids
- **Tender Allocation** - Allot tenders to vendors
- **Ticket System** - Handle support tickets from users
- **Dashboard Analytics** - View system statistics
- **User Management** - Manage registered users
- **Reporting** - Generate tender and bidding reports

## Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Framework**: Bootstrap (Admin UI)
- **Additional Libraries**: jQuery, Responsive Slides

## Project Structure

```
digitender/
├── Dockerfile                 # Docker configuration
├── README.md                  # Project documentation
├── web/                       # User-facing application
│   ├── index.php             # Home page
│   ├── login.php             # User login
│   ├── register.php          # User registration
│   ├── tender.php            # Tender listing and details
│   ├── bid.php               # Bidding interface
│   ├── mybiddings.php        # User's bids management
│   ├── search.php            # Tender search functionality
│   ├── contact.php           # Contact page
│   ├── about.php             # About page
│   ├── services.php          # Services page
│   ├── dbconfig.php          # Database configuration
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   ├── images/               # Image assets
│   ├── database/             # Database schema
│   └── admin/                # Admin dashboard
│       ├── index.php         # Admin dashboard
│       ├── tables.php        # Data tables view
│       ├── allot_tender.php  # Tender allocation
│       ├── confirm_bidding.php # Bid confirmation
│       ├── biddings.php      # Bidding management
│       ├── ticket.php        # Support tickets
│       ├── css/              # Admin styles
│       ├── js/               # Admin scripts
│       └── vendor/           # Third-party libraries
└── [database files]          # SQL files for database setup
```

## Installation

### Prerequisites

Recommended (validated):

- Docker

Optional (non-Docker):

- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx

## Quick Start (Recommended: Docker)

1. Open project root

   ```bash
   cd /path/to/digitender
   ```

2. Build PHP image (includes mysqli extension)

   ```bash
   docker build -t digitender-php:local .
   ```

3. Create Docker network

   ```bash
   docker network create digitender-net || true
   ```

4. Start MySQL container

   ```bash
   docker rm -f digitender-db >/dev/null 2>&1 || true
   docker run -d --name digitender-db --network digitender-net \
     -e MYSQL_ALLOW_EMPTY_PASSWORD=yes -e MYSQL_DATABASE=test mysql:5.7
   ```

5. Start web container

   ```bash
   docker rm -f digitender-web >/dev/null 2>&1 || true
   docker run -d --name digitender-web --network digitender-net -p 8080:80 \
     -e DB_HOST=digitender-db -e DB_USER=root -e DB_PASSWORD= -e DB_NAME=test \
     -v "$PWD/web":/var/www/html digitender-php:local
   ```

6. Create required tables and seed baseline data

   ```bash
   docker exec -i digitender-db mysql -uroot -D test <<'SQL'
   CREATE TABLE IF NOT EXISTS registration (
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255) NOT NULL,
     email VARCHAR(255) UNIQUE NOT NULL,
     mobile VARCHAR(15) UNIQUE NOT NULL,
     aadhaar VARCHAR(12) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

   CREATE TABLE IF NOT EXISTS tender (
     id INT(3) NOT NULL AUTO_INCREMENT,
     TID INT(30) NOT NULL,
     sector_name VARCHAR(50) NOT NULL,
     discription VARCHAR(50) NOT NULL,
     fileone VARCHAR(150) NOT NULL,
     filetwo VARCHAR(150) NOT NULL,
     city VARCHAR(60) NOT NULL,
     INR VARCHAR(50) NOT NULL,
     due_date DATE NOT NULL,
     time VARCHAR(34) NOT NULL,
     allot BIT(1) NOT NULL DEFAULT b'0',
     PRIMARY KEY (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

   CREATE TABLE IF NOT EXISTS bidding (
     bid_id INT(3) NOT NULL AUTO_INCREMENT,
     name VARCHAR(60) NOT NULL,
     email VARCHAR(30) NOT NULL,
     mobile VARCHAR(30) NOT NULL,
     charge VARCHAR(30) NOT NULL,
     days VARCHAR(50) NOT NULL,
     tenderid INT(3) NOT NULL,
     userid INT(3) NOT NULL,
     status BIT(1) NOT NULL DEFAULT b'0',
     PRIMARY KEY (bid_id)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

   CREATE TABLE IF NOT EXISTS head (
     headid INT(3) NOT NULL AUTO_INCREMENT,
     email VARCHAR(30) NOT NULL,
     password VARCHAR(30) NOT NULL,
     department VARCHAR(30) NOT NULL,
     PRIMARY KEY (headid)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

   CREATE TABLE IF NOT EXISTS team (
     teamid INT(3) NOT NULL AUTO_INCREMENT,
     name VARCHAR(30) NOT NULL,
     email VARCHAR(30) NOT NULL,
     mobile VARCHAR(30) NOT NULL,
     department VARCHAR(30) NOT NULL,
     password VARCHAR(40) NOT NULL,
     PRIMARY KEY (teamid)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

   CREATE TABLE IF NOT EXISTS ticket (
     id INT(3) NOT NULL AUTO_INCREMENT,
     priority VARCHAR(30) NOT NULL,
     department VARCHAR(30) NOT NULL,
     title VARCHAR(50) NOT NULL,
     discription VARCHAR(50) NOT NULL,
     fileone VARCHAR(60) NOT NULL,
     filetwo VARCHAR(60) NOT NULL,
     clientid INT(3) NOT NULL,
     assign_id VARCHAR(3) NOT NULL DEFAULT '---',
     reply VARCHAR(50) NOT NULL DEFAULT '0',
     close INT(3) NOT NULL DEFAULT 0,
     PRIMARY KEY (id)
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
   SQL
   ```

7. Open app
   - User UI: http://localhost:8080
   - Admin UI: http://localhost:8080/admin

## Local (Non-Docker) Setup

If you run locally, install PHP + MySQL first, then ensure database config values are available using environment variables:

- `DB_HOST`
- `DB_USER`
- `DB_PASSWORD`
- `DB_NAME`

Current app defaults (if env vars are missing):

- host: `localhost`
- user: `root`
- password: empty
- database: `test`

## Database Schema

The project includes database schema files in:

- `web/database/test.sql` - Main application schema
- `web/admin/database/test.sql` - Admin panel schema

Note: the legacy SQL dump has compatibility issues in some environments (for example malformed `registration` DDL in one dump). If import fails, use the Quick Start table-creation commands above.

## Usage

### For Users

1. Register a new account
2. Verify via OTP
3. Browse available tenders
4. Submit bids on desired tenders
5. Manage active bids from "My Biddings"

Development OTP behavior:

- If SMS API key is not configured, OTP is generated and returned in response for local testing.

### For Admins

1. Login to admin dashboard at `/admin`
2. Create and manage tenders
3. Review and confirm bids
4. Allocate tenders to winning bidders
5. Handle support tickets
6. View system analytics

## Configuration

Key configuration files:

- `web/dbconfig.php` - Database connection settings
- `web/admin/dbconfig.php` - Admin database settings
- `web/nav.php` - Navigation menu
- `web/admin/sidebar.php` - Admin sidebar

OTP provider configuration:

- Set `FAST2SMS_API_KEY` in web container/server environment to enable real SMS delivery.

## Security Notes

- Implement HTTPS for production
- Use prepared statements to prevent SQL injection
- Validate all user inputs
- Store passwords using secure hashing (bcrypt/password_hash)
- Implement proper session management
- Add CSRF protection tokens
- Regular security audits recommended

Current compatibility behavior:

- Login currently supports both bcrypt-hashed and legacy plaintext passwords for backward compatibility with old seed data.

## File Descriptions

### Core Pages

- **login.php** - User authentication
- **register.php** - User registration with OTP
- **tender.php** - Tender display and details
- **bid.php** - Bidding submission form
- **mybiddings.php** - User's bid history and status
- **search.php** - Advanced tender search

### Admin Pages

- **allot_tender.php** - Assign tenders to vendors
- **confirm_bidding.php** - Approve/reject bids
- **biddings.php** - View all bids
- **ticket.php** - Support ticket management

## Support

For support or issues:

- Use the Contact form at `/contact.php`
- Reach out through the support ticket system in admin panel

## License

Please refer to the LICENSE file for licensing information.

## Contributing

Guidelines for contributing to this project:

1. Follow PSR-12 PHP coding standards
2. Test thoroughly before submitting
3. Document any new features
4. Update this README with significant changes

## Future Enhancements

- Mobile application
- Real-time notifications
- Advanced reporting and analytics
- API integration
- Payment gateway integration
- Email notifications
- Bid evaluation workflow

---

**Last Updated**: April 2026
