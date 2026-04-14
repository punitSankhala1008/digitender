# Digitender - Quick Reference

## 🚀 Start Application

### On Linux/Mac

```bash
cd /path/to/digitender
./run.sh start
```

### On Windows

```cmd
cd C:\path\to\digitender
run.bat start
```

### Manual Command

```bash
docker compose up -d
```

---

## 🌐 Access Application

| Page            | URL                                   |
| --------------- | ------------------------------------- |
| **Home**        | http://localhost:8080                 |
| **User Login**  | http://localhost:8080/login.php       |
| **Register**    | http://localhost:8080/register.php    |
| **Tenders**     | http://localhost:8080/tender.php      |
| **Admin Login** | http://localhost:8080/admin/index.php |

---

## 👤 Test Accounts

### User

```
Email:    punit@gmail.com
Password: 111111
```

### Admin

```
Email:    admin.new@digitender.com
Password: Admin@123
```

---

## 🛑 Stop Application

```bash
docker compose stop         # Stop (keep data)
docker compose down         # Stop and remove containers
docker compose down -v      # Clean everything
```

---

## 📋 Useful Commands

```bash
# View real-time logs
docker logs -f digitender-web

# Access MySQL database
docker exec -it digitender-db mysql -udigitender -pdigitender digitender

# Check container status
docker compose ps

# Restart application
docker compose restart

# View web server status
curl http://localhost:8080
```

---

## 🔧 Troubleshooting

| Issue                | Solution                                                             |
| -------------------- | -------------------------------------------------------------------- |
| Port 8080 in use     | Stop other services or use: `docker compose down -v`                 |
| Database won't start | Check: `docker logs digitender-db`                                   |
| Can't access website | Wait 15 seconds and try: `curl http://localhost:8080`                |
| Files not uploading  | Verify: `docker exec digitender-web ls -la /var/www/html/admin/img/` |

---

## 📂 Directory Structure

```
digitender/
├── docker-compose.yml    # Docker configuration
├── Dockerfile           # PHP image definition
├── RUN.md              # Full documentation
├── run.sh              # Linux startup script
├── run.bat             # Windows startup script
├── web/                # Application files
│   ├── index.php       # Home page
│   ├── login.php       # User login
│   ├── register.php    # User registration
│   ├── tender.php      # Tender listing
│   ├── admin/          # Admin panel
│   │   ├── index.php   # Admin login
│   │   ├── tables.php  # Dashboard
│   │   ├── ticket.php  # Create tender
│   │   └── img/        # File uploads
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   ├── database/       # Database schema
│   └── dbconfig.php    # Database config
└── [other files]
```

---

## 📊 Database

**Access:** http://localhost:3306  
**User:** digitender  
**Password:** digitender  
**Database:** digitender

**Tables:**

- `registration` - User accounts
- `head` - Admin accounts
- `tender` - Tender postings
- `bidding` - Bids
- `team` - Staff
- `ticket` - Support tickets

---

## 🔗 Features

✅ User registration with OTP  
✅ User authentication  
✅ Tender browsing & search  
✅ Bidding system  
✅ Admin panel  
✅ File uploads  
✅ Modern responsive UI

---

**For detailed information, see: RUN.md**
