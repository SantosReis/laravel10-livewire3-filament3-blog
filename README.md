# Laravel Starter Pack for a Blog

This is a Laravel-based application designed to be quickly booted with Docker and ready for local development. It includes migrations, seeding, and a complete test setup.

---

## Requirements

- [Docker & Docker Compose](https://docs.docker.com/get-docker/)
- PHP
- Node
- Git

---

## Quickstart (with Docker)

```bash
# Clone the repository
git clone https://github.com/your-org/your-project.git
cd your-project

# Copy .env file
cp .env.example .env

# Start containers
docker-compose up -d --build

# Install dependencies
docker-compose exec app composer install

# Generate key and set permissions
docker-compose exec app php artisan key:generate
docker-compose exec app chmod -R 775 storage bootstrap/cache

# Run migrations and seed database
docker-compose exec app php artisan migrate --seed

# Done! Visit: http://localhost
```

## Database

The .env is pre-configured for Docker containers:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Use migrations and seeders to build the database:

### Run migrations

```
docker-compose exec app php artisan migrate
```

### Run seeders

docker-compose exec app php artisan db:seed
To reset everything:

```
docker-compose exec app php artisan migrate:fresh --seed
```

## Running Tests

Add `.env.testing` for test isolation.

### Run tests

```
docker-compose exec app php artisan test #all

docker-compose exec app php artisan test --filter=PostResourceTest #feature

docker-compose exec app php artisan test --filter=PostResourceTest::test_can_create_post #test
```

## Frontend Setup

This app uses a modern Laravel/Livewire+Vite+Tailwind stack.

### Install Dependencies

```
npm install

npm run dev

npm run build
```

## Backups

### Run a backup manually

php artisan backup:run

### Run backup of only database

php artisan backup:run --only-db

### Run backup of only files

php artisan backup:run --only-files

### List all backups

php artisan backup:list

### Clean old backups

php artisan backup:clean

### Monitor backup health

php artisan backup:monitor

## License

This project is open-source and available under the MIT License.
