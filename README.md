# Laravel Two-Factor Authentication App

A secure Laravel application implementing **Two-Factor Authentication (2FA)** using **Laravel Fortify**.  
This app enhances login security by requiring users to verify their identity through an additional method, such as:

- **Primary:** SMS verification (e.g., via Twilio)
- **Fallback:** Time-based One-Time Password (TOTP) using Google Authenticator

---

## Features

- 🔒 **Secure Authentication** using Laravel Fortify
- 📱 **Two-Factor Authentication** with SMS as the primary method
- ⏱ **TOTP Fallback** when SMS delivery fails
- 👤 User registration and login
- 🛡 CSRF, XSS, and SQL injection protection (Laravel defaults)
- 📦 Modular & clean code structure

---

## Requirements

- PHP >= 8.2
- Composer
- Laravel 11
- MySQL or PostgreSQL
- Node.js & npm
- Twilio account (for SMS verification)
- Google Authenticator or any TOTP app (for fallback authentication)

---

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/<your-username>/<your-repo>.git
   cd <your-repo>
   ```bash
   composer install
   npm install && npm run build
   cp .env.example .env
APP_NAME="Laravel 2FA App"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Twilio credentials
TWILIO_SID=your_twilio_sid
TWILIO_AUTH_TOKEN=your_twilio_auth_token
TWILIO_FROM=your_twilio_phone_number
php artisan migrate
php artisan serve
