# PHP Multi Container App

Dockerized Development

This repository contains a simple **PHP Todo Application** running on **PHP 8.4** and MySQL.

The project includes:
- A custom PHP Dockerfile with Composer & Xdebug
- SQL schema and CRUD Todo example
- Docker Compose–based local development environment

## Features

- **PHP 8.4 + Apache** with custom Dockerfile  
- **MySQL 8** database container
- **Docker Volumes** for persistent data
- **Docker-based local development workflow**
- **Composer integrated** into the PHP image  
- **Xdebug enabled** for local development  
- **Simple CRUD Todo App** using PDO  

# Running the Application

## Setup Environment Variables

The application can be configured using a `.env` file.

Example:

```ini
# Application
APP_ENV=local

# Database
DB_PORT=3306
DB_NAME=todoapp
DB_USER=user
DB_PASS=password

# Webserver
APP_PORT=8081

```

## Local Development

Start:

```bash
docker compose up --build -d
```

## Database

Load initial schema manually:

```
docker exec -i mysql-todo mysql -u root -ppassword todoapp < migration/db.sql
```

App available at: http://localhost:8081

## Docker Commands

Stop:

```bash
docker compose down
```

Full rebuild:

```bash
docker compose build --no-cache
```

Delete the existing data volumes and recreate everything:

```
docker-compose down -v
docker-compose up -d
```

## Composer Commands

Composer is preinstalled inside the PHP container.

Install dependencies
```
docker exec -it php-todo composer install
```

Update dependencies

```
docker exec -it php-todo composer update
```

Require a package

```
docker exec -it php-todo composer require vendor/package
```


## Multi-Container Setup with Bind-Mounts

A **multi-container setup** means your application is split into multiple isolated services, each running in its own container.  

In this project, you have:

- a **PHP/Apache container** (serving your app)
- a **MySQL database container**

Both run side-by-side, controlled by Docker Compose.

1. What is a multi-container setup?

Instead of installing PHP, Apache, MySQL, and tools directly on your machine, each component runs in its **own container**.

For example:

php → php:8.4-apache image
db → mysql:8.0 image

Each container has a specific purpose:

| Container | Purpose |
|----------|----------|
| php      | Runs your PHP code (index.php) |
| db       | Runs the MySQL server |

Docker Compose links them so they can talk to each other as one application.


### What is a bind-mount?

A **bind-mount** maps a folder on your local computer into a folder inside a container.

Example:

```yaml
volumes:
  - ./src:/var/www/html
```

This means:

```
local folder:     ./app
container folder: /var/www/html
```

So when you change a file on your computer (e.g. edit index.php),
PHP immediately sees the change inside the container - without rebuilding anything.

This is ideal for **local development**.

### Docker Volumes (for persistent data)

Data is stored outside the container.

The container can be deleted, but the database data remains

This is ideal for MySQL, since it must keep data across restarts.

