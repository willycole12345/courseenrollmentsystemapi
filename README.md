# 🎓 Course Enrollment System

A Laravel 11-based course enrollment system REST API endpoints secured with JWT (Sanctum). Supports enrollment management, commenting, email notifications, and rate limiting.

---

## Features

# API (RESTful)
- `POST /api/login`: Login Users
- `GET /api/courses`: List of user's enrolled courses
- `GET /api/courses/{id}`: Specific course details + first 5 comments
- `GET /api/courses/{id}/comments`: Paginated comments
- `POST /api/courses/{id}/comments`: Add comment to course
- `POST /api/enrollcourses/{id}`: Enrollment for course
- JWT authentication with Laravel Sanctum
- Rate limiting with Laravel RateLimiter
- Authorization policy for enrolled courses only

# Queues
- Email notification upon course enrollment
- Notification queue on new comments
- Configurable for Redis or Database driver

---

# Getting Started

# Prerequisites
- PHP 8.2+
- Composer
- Laravel 11
- Node.js & npm
- Redis (or use `database` driver for queue)
- MySQL / PostgreSQL

# Installation


git clone https://github.com/willycole12345/courseenrollmentsystemapi
cd courseenrollmentsystemapi

# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrate and seed database
php artisan migrate --seed

# Run queue worker
php artisan queue:work

# Start development server
php artisan serve

# Login details for test

{
  "email": "user@example.com",
  "password": "password"
}
