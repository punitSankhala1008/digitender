#!/bin/bash

# Digitender - Quick Start Script
# This script automates the setup and launch of the Digitender application

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Functions
print_header() {
    echo -e "${BLUE}================================================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}================================================================${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

# Check prerequisites
check_docker() {
    if ! command -v docker &> /dev/null; then
        print_error "Docker is not installed. Please install Docker first."
        echo "Visit: https://docs.docker.com/get-docker/"
        exit 1
    fi
    print_success "Docker is installed"
}

check_docker_compose() {
    if ! docker compose version &> /dev/null; then
        print_error "Docker Compose is not installed."
        echo "Visit: https://docs.docker.com/compose/install/"
        exit 1
    fi
    print_success "Docker Compose is installed"
}

check_ports() {
    if lsof -Pi :8080 -sTCP:LISTEN -t >/dev/null 2>&1 ; then
        print_warning "Port 8080 is already in use"
        read -p "Do you want to proceed anyway? (y/n) " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "Startup cancelled"
            exit 1
        fi
    else
        print_success "Port 8080 is available"
    fi

    if lsof -Pi :3306 -sTCP:LISTEN -t >/dev/null 2>&1 ; then
        print_warning "Port 3306 is already in use"
        read -p "Do you want to proceed anyway? (y/n) " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_info "Startup cancelled"
            exit 1
        fi
    else
        print_success "Port 3306 is available"
    fi
}

cleanup_containers() {
    print_info "Cleaning up old containers..."
    docker compose down -v 2>/dev/null || true
    sleep 2
}

start_application() {
    print_info "Starting containers..."
    docker compose up -d

    print_info "Waiting for services to be ready..."
    sleep 15

    # Verify database is healthy
    max_attempts=30
    attempt=0
    while [ $attempt -lt $max_attempts ]; do
        if docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT 1;" &>/dev/null; then
            print_success "Database is ready"
            break
        fi
        attempt=$((attempt + 1))
        sleep 1
    done

    if [ $attempt -eq $max_attempts ]; then
        print_error "Database failed to start"
        print_info "Checking logs:"
        docker logs digitender-db | tail -20
        exit 1
    fi
}

verify_application() {
    print_info "Verifying application..."
    
    local http_code=$(curl -sS -o /dev/null -w '%{http_code}' http://localhost:8080)
    if [ "$http_code" = "200" ]; then
        print_success "Web server is responding (HTTP $http_code)"
    else
        print_warning "Web server returned HTTP $http_code"
    fi
}

show_credentials() {
    print_header "CREDENTIALS"
    
    echo ""
    echo -e "${YELLOW}User Account:${NC}"
    echo "  Email:    punit@gmail.com"
    echo "  Password: 111111"
    echo ""
    echo -e "${YELLOW}Admin Account:${NC}"
    echo "  Email:    admin.new@digitender.com"
    echo "  Password: Admin@123"
}

show_endpoints() {
    print_header "APPLICATION ENDPOINTS"
    
    echo ""
    echo -e "${YELLOW}USER PORTAL:${NC}"
    echo "  🏠 Home:             http://localhost:8080"
    echo "  📝 Register:         http://localhost:8080/register.php"
    echo "  🔑 Login:            http://localhost:8080/login.php"
    echo "  📦 Browse Tenders:   http://localhost:8080/tender.php"
    echo "  🔍 Search:           http://localhost:8080/search.php"
    echo "  💰 Submit Bid:       http://localhost:8080/bid.php"
    echo "  📋 My Biddings:      http://localhost:8080/mybiddings.php"
    echo ""
    echo -e "${YELLOW}ADMIN PANEL:${NC}"
    echo "  🔐 Admin Login:      http://localhost:8080/admin/index.php"
    echo "  📊 Dashboard:        http://localhost:8080/admin/tables.php"
    echo "  ➕ Create Tender:    http://localhost:8080/admin/ticket.php"
    echo "  📝 Manage Bids:      http://localhost:8080/admin/biddings.php"
}

show_database_info() {
    print_header "DATABASE INFORMATION"
    
    echo ""
    echo "Registered Users:"
    docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM registration;" 2>&1 | grep -v Warning | tail -2
    
    echo ""
    echo "Admin Users:"
    docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM head;" 2>&1 | grep -v Warning | tail -2
    
    echo ""
    echo "Active Tenders:"
    docker exec digitender-db mysql -udigitender -pdigitender digitender -e "SELECT COUNT(*) as count FROM tender WHERE allot = 0;" 2>&1 | grep -v Warning | tail -2
}

show_help() {
    cat << EOF
Usage: ./run.sh [OPTION]

Options:
  start     Start the application (default)
  stop      Stop the application
  restart   Restart the application
  logs      Show application logs
  clean     Clean up everything (containers, volumes, data)
  help      Show this help message

Examples:
  ./run.sh start
  ./run.sh stop
  ./run.sh logs
  ./run.sh clean

More information: See RUN.md for detailed documentation
EOF
}

# Main execution
main() {
    local command="${1:-start}"

    case "$command" in
        start)
            print_header "DIGITENDER - APPLICATION STARTUP"
            
            print_info "Checking prerequisites..."
            check_docker
            check_docker_compose
            check_ports
            
            print_info "Starting application..."
            cleanup_containers
            start_application
            verify_application
            
            echo ""
            show_database_info
            echo ""
            show_endpoints
            echo ""
            show_credentials
            echo ""
            print_header "APPLICATION READY!"
            echo -e "${GREEN}The application is now running!${NC}"
            echo ""
            print_info "To view logs:     docker logs -f digitender-web"
            print_info "To stop:          $0 stop"
            print_info "To restart:       $0 restart"
            echo ""
            ;;
        stop)
            print_header "STOPPING DIGITENDER"
            docker compose stop
            print_success "Application stopped"
            ;;
        restart)
            print_header "RESTARTING DIGITENDER"
            docker compose restart
            print_success "Application restarted"
            sleep 5
            verify_application
            ;;
        logs)
            print_header "APPLICATION LOGS"
            docker logs -f digitender-web
            ;;
        clean)
            print_header "CLEANING UP DIGITENDER"
            read -p "This will delete all containers and data. Continue? (y/n) " -n 1 -r
            echo
            if [[ $REPLY =~ ^[Yy]$ ]]; then
                docker compose down -v
                print_success "Cleanup completed"
            else
                print_info "Cleanup cancelled"
            fi
            ;;
        help|--help|-h)
            show_help
            ;;
        *)
            print_error "Unknown command: $command"
            show_help
            exit 1
            ;;
    esac
}

# Run main function
main "$@"
