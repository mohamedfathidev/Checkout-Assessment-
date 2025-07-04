<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/# Checkout PayTabs Package

A Laravel-based checkout and payment system integrating PayTabs for seamless online payments. This project demonstrates checkout flow, order creation, billing/shipping collection, payment processing, and refund support.

---

## Features

1. Create order
2. Store the order in the database
3. Checkout page to enter customer details
4. Update the order with customer details
5. Pass the customer info to payment gateway without needing to re enter it again 
6. PayTabs hosted page to pay through the gateway
7. Optional: Full refund for paid orders

---

## Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL (or SQLite/Postgres)
- [ngrok](https://ngrok.com/) (for local callback URLs)

### Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd checkout-paytabs-package
   ```
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
   
3. **Copy and configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env and set required variables (see below)
   ```
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start development servers:**
   ```bash
   php artisan serve (then )
   ```
7. **Start ngrok and set NGROK_URL:**
   - Start your Laravel server (e.g. `php artisan serve`)
   - In a new terminal, run:
     ```bash
     ngrok http 8000
     ```
   - Copy the public URL from ngrok (e.g. `https://abcd1234.ngrok.io`)
   - Add it to your `.env` file:
     ```env
     NGROK_URL=https://abcd1234.ngrok.io
     ```
   - Add in .env NGROK_URL and Assign this URL to it (run php artisan cache:clear) after adding this in .env
   - This is required for PayTabs to send payment callbacks to your local environment.

---

## Environment Variables

Set these in your `.env` file:

- `APP_KEY`, `APP_ENV`, `APP_DEBUG`, `APP_URL`
- `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.
- `paytabs_profile_id` (PayTabs profile ID)
- `paytabs_server_key` (PayTabs server key)
- `paytabs_currency` (e.g., EGP)
- `paytabs_region` (e.g., EGY)
- `NGROK_URL` (required for PayTabs callbacks)

---

## Usage

1. Visit the home page to view the cart and create an order.
2. Enter billing and shipping details.
3. Proceed to payment (PayTabs checkout page will open).
4. On payment completion, you will be redirected to a success or failure page.
5. Refunds can be initiated from the success page for paid orders.

---

## Tools & Technologies

- Laravel
- Laravel PayTabs package
- MySQL
- VS Code
- PHP
- Postman
- Git
- ngrok

---

## Project Structure

- `app/Http/Controllers/` – Main controllers for order and checkout
- `app/Models/` – Eloquent models for Order and Payment
- `app/Services/` – Payment and validation logic
- `resources/views/` – Blade templates for UI
- `routes/web.php` – Web routes
- `config/paytabs.php` – PayTabs integration config
- 
---

## License

This project is open-sourced under the MIT license.

---

## Contact

- **Email:** mohamedfathidev161@gmail.com
- **Phone:** +201020131424

---

**Note:**
You must set up ngrok and use its public URL in your `.env` file as `NGROK_URL` to receive payment callbacks from PayTabs during local development.
framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Checkout-Assessment-
>>>>>>> d65e7d553a88dfb2ead62469aaf958914df6c351
