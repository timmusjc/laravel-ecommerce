Laravel E-commerce Shop — Diploma Project

This repository contains a fully functional e-commerce web application developed as part of a diploma project in Computer Science.
The project demonstrates practical implementation of modern web technologies using Laravel 10, including dynamic product pages, category management, image handling, and a responsive Bootstrap-based frontend.

Features:

- Dynamic product pages (/product/{slug})
- Category pages (/category/{slug})
- Product–category relationship via Eloquent ORM

Tech Stack

- Laravel 10
- PHP 8+
- MySQL
- Blade Templates
- Bootstrap 5
- Eloquent ORM

Installation

1. Clone the repository:

git clone https://github.com/YOURNAME/laravel-ecommerce.git
cd laravel-ecommerce

2. Install dependencies:

composer install
npm install
npm run build

3. Copy the environment file:

cp .env.example .env
php artisan key:generate

4. Configure your database in .env, then run:

php artisan migrate

5. Run the local server:

composer run dev

Project Structure

app/Http/Controllers/
app/Models/
resources/views/
routes/web.php
public/storage/
database/migrations/

About the Project

This application will be developed as part of a diploma project in Computer Science.
The goal was to design a realistic and extensible e-commerce platform, demonstrating practical skills in:

- backend development with Laravel,
- relational database modeling,
- REST-style routing with slugs,
- modern frontend development with Bootstrap,
- clean code architecture.

The project will be structured in a way that allows easy future expansion (user accounts, shopping cart, order system, admin dashboard).

License - MIT License.