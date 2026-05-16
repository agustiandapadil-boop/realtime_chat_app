# Tugas Pemograman Web - Realtime Chat Application
## Nama: Padil Agustianda Matondang
## NIM: 240180050 

# Realtime Chat Application - Laravel 12
Aplikasi Realtime Chat adalah aplikasi berbasis web yang dibangun menggunakan Laravel 12 dengan teknologi WebSocket untuk melakukan komunikasi secara realtime tanpa perlu refresh halaman.

Aplikasi ini mendukung fitur:
- Authentication (Login/Register)
- Realtime Messaging
- Private Chat
- Group Chat
- Online/Offline Presence Tracking
- WebSocket Broadcasting menggunakan Laravel Reverb
---

## Fitur Aplikasi
- Login & Register
- Chat realtime tanpa refresh
- Private chat
- Group chat
- Status online/offline user
- Event broadcasting
---

## Teknologi Yang Digunakan
- Laravel 12
- PHP 8+
- MySQL
- Laravel Reverb
- Laravel Queue
- Blade
- Vite
- TailwindCSS
- Laravel Echo

## Realtime Communication
- WebSocket
- Laravel Broadcasting
- Laravel Reverb
---

## Persyaratan Sistem
Pastikan sudah menginstall:
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL
- Git
---

## Cara Instalasi
## 1. Clone Repository
git clone https://github.com/agustiandapadil-boop/realtime_chat_app.git
---

## 2. Masuk ke Folder Project
cd realtime_chat_app
---

## 3. Install Dependency
## Install Dependency PHP
composer install

## Install Dependency Frontend
npm install
---

## 4. Copy File Environment
cp .env.example .env
---

## Konfigurasi Environment
Buat database terlebih dahulu:
- Nama Database : **realtime_chat**
Buka phpMyAdmin atau MySQL lalu buat database dengan nama:

CREATE DATABASE realtime_chat;

Lalu edit file `.env` dan sesuaikan dengan konfigurasi berikut:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=realtime_chat
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=reverb
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

REVERB_APP_ID=app-id
REVERB_APP_KEY=app-key
REVERB_APP_SECRET=app-secret
REVERB_HOST="127.0.0.1"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

BROADCAST_CONNECTION=reverb
---

## 5. Generate Application Key
php artisan key:generate
---

## 6. Migrasi Database
php artisan migrate
---

## Menjalankan Project
Project ini menggunakan 4 terminal secara bersamaan.
---

## Terminal 1 - Menjalankan Laravel Server
php artisan serve
Default URL:
http://127.0.0.1:8000
---

## Terminal 2 - Menjalankan WebSocket Server (Reverb)
php artisan reverb:start
---

## Terminal 3 - Menjalankan Frontend Vite
npm run dev
---

## Terminal 4 - Menjalankan Queue Worker
php artisan queue:work
---

## Akses Aplikasi
Buka browser dan akses:
http://127.0.0.1:8000
