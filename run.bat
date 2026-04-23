@echo off
REM DigiTender - Quick Start Script for Windows
REM This script automates the setup and launch of the DigiTender application

setlocal enabledelayedexpansion

REM Color codes using title attribute
title DigiTender - Application Launcher

:main
if "%1"=="" goto start
if /i "%1"=="start" goto start
if /i "%1"=="stop" goto stop
if /i "%1"=="restart" goto restart
if /i "%1"=="logs" goto logs
if /i "%1"=="clean" goto clean
if /i "%1"=="help" goto help
if /i "%1"=="-h" goto help
if /i "%1"=="--help" goto help

echo Unknown command: %1
goto help

:start
cls
echo ================================================================
echo DIGITENDER - APPLICATION STARTUP
echo ================================================================
echo.

echo Checking Docker installation...
docker --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Docker is not installed or not in PATH
    echo Please install Docker from: https://docs.docker.com/get-docker/
    pause
    exit /b 1
)
echo [OK] Docker is installed

echo.
echo Checking Docker Compose...
docker compose version >nul 2>&1
if errorlevel 1 (
    echo [WARNING] Docker Compose might not be available
    docker-compose --version >nul 2>&1
    if errorlevel 1 (
        echo [ERROR] Docker Compose not found
        pause
        exit /b 1
    )
)
echo [OK] Docker Compose is available

echo.
echo Cleaning up old containers...
docker compose down -v 2>nul
timeout /t 2 /nobreak >nul

echo.
echo Starting containers...
docker compose up -d

echo.
echo Waiting for services to be ready...
timeout /t 15 /nobreak >nul

echo.
echo Verifying database...
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT 1;" >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Database failed to start
    echo Checking logs...
    docker logs digitender-db
    pause
    exit /b 1
)
echo [OK] Database is ready

echo.
echo Verifying web server...
for /f "tokens=*" %%A in ('curl -sS -o nul -w "%%{http_code}" http://localhost:8080') do set "http_code=%%A"
if "%http_code%"=="200" (
    echo [OK] Web server is responding (HTTP %http_code%)
) else (
    echo [WARNING] Web server returned HTTP %http_code%
)

echo.
echo ================================================================
echo DATABASE INFORMATION
echo ================================================================
echo.
echo Registered Users:
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM registration;" 2>nul | findstr /V "Warning"

echo.
echo Admin Users:
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM head;" 2>nul | findstr /V "Warning"

echo.
echo Active Tenders:
docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM tender WHERE allot = 0;" 2>nul | findstr /V "Warning"

echo.
echo ================================================================
echo APPLICATION ENDPOINTS
echo ================================================================
echo.
echo USER PORTAL:
echo   Home:             http://localhost:8080
echo   Register:         http://localhost:8080/register.php
echo   Login:            http://localhost:8080/login.php
echo   Browse Tenders:   http://localhost:8080/tender.php
echo   Search:           http://localhost:8080/search.php
echo   Submit Bid:       http://localhost:8080/bid.php
echo   My Biddings:      http://localhost:8080/mybiddings.php
echo.
echo ADMIN PANEL:
echo   Admin Login:      http://localhost:8080/admin/index.php
echo   Dashboard:        http://localhost:8080/admin/tables.php
echo   Create Tender:    http://localhost:8080/admin/ticket.php
echo   Manage Bids:      http://localhost:8080/admin/biddings.php
echo.
echo ================================================================
echo CREDENTIALS
echo ================================================================
echo.
echo User Account:
echo   Email:    punit@gmail.com
echo   Password: 111111
echo.
echo Admin Account:
echo   Email:    admin.new@digitender.com
echo   Password: Admin@123
echo.
echo ================================================================
echo APPLICATION READY!
echo ================================================================
echo.
echo The application is now running and ready to use!
echo.
echo To view logs:     docker logs -f digitender-web
echo To stop:          run.bat stop
echo To restart:       run.bat restart
echo.
pause
exit /b 0

:stop
echo.
echo Stopping DigiTender...
docker compose stop
echo [OK] Application stopped
pause
exit /b 0

:restart
echo.
echo Restarting DigiTender...
docker compose restart
echo [OK] Application restarted
timeout /t 5 /nobreak >nul
pause
exit /b 0

:logs
echo.
echo Showing application logs (Press Ctrl+C to exit)...
echo.
docker logs -f digitender-web
pause
exit /b 0

:clean
echo.
echo WARNING: This will delete all containers and data!
set /p confirm=Do you want to continue? (y/n): 
if /i "%confirm%"=="y" (
    docker compose down -v
    echo [OK] Cleanup completed
) else (
    echo Cleanup cancelled
)
pause
exit /b 0

:help
echo.
echo Usage: run.bat [OPTION]
echo.
echo Options:
echo   start     Start the application (default)
echo   stop      Stop the application
echo   restart   Restart the application
echo   logs      Show application logs
echo   clean     Clean up everything (containers, volumes, data)
echo   help      Show this help message
echo.
echo Examples:
echo   run.bat start
echo   run.bat stop
echo   run.bat logs
echo.
echo For more information, see RUN.md
echo.
pause
exit /b 0
