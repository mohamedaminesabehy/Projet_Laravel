# Docker Setup Guide for Laravel Project

## Prerequisites
- Docker Desktop installed and running
- Docker Compose installed

## Quick Start

1. **Clone and setup the project:**
   ```bash
   git clone <your-repo>
   cd Projet_Laravel
   ```

2. **Copy environment file:**
   ```bash
   cp .env.docker .env
   ```

3. **Generate application key:**
   ```bash
   docker-compose run --rm app php artisan key:generate
   ```

4. **Build and start containers:**
   ```bash
   docker-compose up -d --build
   ```

5. **Run database migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Install dependencies (if needed):**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install && npm run build
   ```

## Services

- **Laravel App**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080
- **MailHog**: http://localhost:8025
- **MySQL**: localhost:3306
- **Redis**: localhost:6379

## Useful Commands

### Application Commands
```bash
# Access application container
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Run composer commands
docker-compose exec app composer install
docker-compose exec app composer update

# Run npm commands
docker-compose exec app npm install
docker-compose exec app npm run dev
docker-compose exec app npm run build
```

### Database Commands
```bash
# Access MySQL container
docker-compose exec db mysql -u laravel -p

# Import database
docker-compose exec -T db mysql -u laravel -p laravel < database.sql

# Export database
docker-compose exec db mysqldump -u laravel -p laravel > database.sql
```

### Container Management
```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Rebuild containers
docker-compose up -d --build

# View logs
docker-compose logs -f app
docker-compose logs -f db

# Remove all containers and volumes
docker-compose down -v --remove-orphans
```

## Database Configuration

The MySQL database is configured with:
- Database: `laravel`
- Username: `laravel`
- Password: `secret`
- Root Password: `root`

## Troubleshooting

### Permission Issues
If you encounter permission issues:
```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage
```

### Clear All Caches
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Rebuild Everything
```bash
docker-compose down -v
docker-compose up -d --build
docker-compose exec app php artisan migrate
```

## Development Workflow

1. Make code changes in your local files
2. Changes are automatically reflected in the container via volume mounts
3. For dependency changes, rebuild the container:
   ```bash
   docker-compose up -d --build
   ```

## Production Notes

For production deployment:
1. Update `.env` with production values
2. Set `APP_ENV=production` and `APP_DEBUG=false`
3. Use proper SSL certificates
4. Configure proper database credentials
5. Set up proper backup strategies