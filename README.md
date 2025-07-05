<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h2 align="center">💳 Laravel Checkout System with PayTabs Integration</h2>

<p align="center">
  A Laravel-based checkout and payment system built using the official <strong>PayTabs package</strong> to enable seamless, secure, and professional online payments.
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## ✨ Features

- 🛒 Create new orders and store them in database  
- 📋 Enter customer billing and shipping details  
- 🔄 Pass customer data directly to PayTabs without re-entering  
- 💳 Pay securely using PayTabs Hosted Checkout Page  
- ✅ Automatically handle success and failure callbacks  
- ↩️ Full refund functionality for completed payments  
- 🌐 Local development support using ngrok  

---

## 🛠 Tech Stack

- Laravel 10 (PHP 8.2+)  
- MySQL  
- PayTabs Laravel Package  
- Blade Templates  
- Ngrok (for local callback URLs)  
- Composer & Git  

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/checkout-paytabs-package.git
cd checkout-paytabs-package
```

### 2. Install dependencies

```bash
composer install
```

### 3. Create and configure `.env` file

```bash
cp .env.example .env
```

Edit your `.env` file and set the following variables:

```env
APP_URL=http://localhost:8000
NGROK_URL=https://abcd1234.ngrok.io

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass

paytabs_profile_id=your_paytabs_profile_id
paytabs_server_key=your_paytabs_server_key
paytabs_currency=EGP
paytabs_region=EGY
```

Then run:

```bash
php artisan key:generate
php artisan migrate
php artisan cache:clear
```

---

## 🔧 Run Project Locally

1. Start Laravel server:

```bash
php artisan serve
```

2. Start ngrok in a separate terminal:

```bash
ngrok http 8000
```

3. Copy the ngrok URL and paste it in `.env` as `NGROK_URL`.

---

## 💡 How It Works

1. Go to the homepage and create an order.  
2. Enter billing & shipping info.  
3. The system passes that info to PayTabs.  
4. PayTabs opens its hosted payment page.  
5. After payment, you're redirected to success/failure page.  
6. You can refund the order if payment was successful.  

---

## 📂 Project Structure

```
app/
├── Http/
│   └── Controllers/       # OrderController, PaymentController
├── Models/                # Order, Payment
├── Services/              # PaymentService, ValidationService
resources/
└── views/                 # Blade templates for checkout and success pages
routes/
└── web.php                # Web routes
config/
└── paytabs.php            # PayTabs configuration
```

---

## 📫 Contact

- **Name:** Mohamed Fathi  
- **Email:** mohamedfathidev161@gmail.com  
- **Phone:** +20 1020131424  

---

## 📄 License

This project is open-sourced under the MIT License.

---

## 📝 Notes

- Make sure to run `php artisan cache:clear` after setting or changing `.env` variables.  
- PayTabs requires public callback URLs — use **ngrok** during local development.  
- Refunds are only available for orders that were paid successfully.
