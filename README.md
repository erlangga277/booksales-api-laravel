<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
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

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## 📁 Struktur Direktori Penting

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Handler autentikasi (Register, Login, Logout)
│   │   │   ├── BookController.php          # Handler CRUD & relasi buku (Author, Genre, Cover)
│   │   │   ├── GenreController.php         # Handler CRUD kategori / genre
│   │   │   ├── AuthorController.php        # Handler CRUD data penulis
│   │   │   ├── TransactionController.php   # Handler transaksi, checkout, & webhook Midtrans
│   │   │   ├── UserController.php           # Handler manajemen pengguna & ubah role (Admin)
│   │   │   └── MessageController.php       # Handler pesan kontak masuk & respon (Admin & Customer)
│   │   └── Middleware/
│   │       └── AdminMiddleware.php         # Proteksi hak akses role khusus Admin
│   ├── Models/
│   │   ├── User.php                        # Model pengguna (Role: admin, customer)
│   │   ├── Book.php                        # Model buku & relasi (Genre, Author, Items)
│   │   ├── Genre.php                       # Model genre/kategori buku
│   │   ├── Author.php                      # Model penulis buku
│   │   ├── Transaction.php                 # Model pesanan/transaksi & status pembayaran
│   │   ├── TransactionItem.php             # Model rincian item buku dalam transaksi
│   │   └── Message.php                     # Model pesan kontak/inbox
│   └── Services/
│       └── MidtransService.php             # Service integrasi Midtrans Snap API & verifikasi webhook
├── database/
│   ├── migrations/                         # File migrasi skema tabel database
│   └── seeders/                            # Seeder data awal (User, Book, Genre, Author, Transaction)
├── routes/
│   ├── api.php                             # Definisi seluruh RESTful API endpoints & proteksi Sanctum
│   └── web.php                             # Routing web dasar
└── config/
    └── services.php                        # Konfigurasi kredensial 3rd party (Midtrans server/client key)
```

## 🌐 Daftar Endpoint RESTful API

| Endpoint | Method | Format | Deskripsi & Hak Akses |
| :--- | :---: | :---: | :--- |
| **Autentikasi** | | | |
| `/api/register` | `POST` | `JSON` | Registrasi user baru (default role: `customer`) |
| `/api/login` | `POST` | `JSON` | Login user & generate token Sanctum |
| `/api/logout` | `POST` | `JSON` | Logout & pencabutan token akses (`auth:sanctum`) |
| **Katalog & Master Data** | | | |
| `/api/books` | `GET` | `JSON` | Mengambil seluruh katalog buku (beserta relasi `genre` & `author`) |
| `/api/books/{id}` | `GET` | `JSON` | Mengambil detail spesifik buku |
| `/api/books` | `POST` | `JSON / Form-Data` | Tambah buku baru (beserta upload cover photo) |
| `/api/books/{id}` | `PUT` / `PATCH` | `JSON / Form-Data` | Perbarui data buku |
| `/api/books/{id}` | `DELETE` | `JSON` | Hapus buku dari database & storage cover |
| `/api/genres` | `GET` | `JSON` | Mengambil daftar seluruh kategori / genre |
| `/api/genres/{id}` | `GET` | `JSON` | Mengambil detail spesifik genre |
| `/api/genres` | `POST` | `JSON` | Tambah genre baru |
| `/api/genres/{id}` | `PUT` / `PATCH` | `JSON` | Perbarui nama / data genre |
| `/api/genres/{id}` | `DELETE` | `JSON` | Hapus genre dari database |
| `/api/authors` | `GET` | `JSON` | Mengambil daftar seluruh penulis / author |
| `/api/authors/{id}` | `GET` | `JSON` | Mengambil detail spesifik author |
| `/api/authors` | `POST` | `JSON` | Tambah data penulis baru |
| `/api/authors/{id}` | `PUT` / `PATCH` | `JSON` | Perbarui data penulis |
| `/api/authors/{id}` | `DELETE` | `JSON` | Hapus data penulis dari database |
| **Transaksi & Pembayaran** | | | |
| `/api/transactions` | `GET` | `JSON` | Melihat daftar semua transaksi (`admin` only) |
| `/api/transactions` | `POST` | `JSON` | Checkout transaksi baru (`customer`, `auth:sanctum`) |
| `/api/transactions/{id}` | `GET` | `JSON` | Melihat detail transaksi tertentu (`auth:sanctum`) |
| `/api/transactions/{id}` | `DELETE` | `JSON` | Hapus transaksi (`admin` only) |
| `/api/transactions/{id}/simulate-paid` | `POST` | `JSON` | Simulasi pembayaran transaksi menjadi paid / lunas |
| `/api/midtrans-callback` | `POST` | `JSON` | Webhook notifikasi pembayaran dari Midtrans |
| **Manajemen Pengguna** | | | |
| `/api/users` | `GET` | `JSON` | Menampilkan seluruh data pengguna (`admin` only) |
| `/api/users/{id}` | `GET` | `JSON` | Menampilkan detail pengguna tertentu (`admin` only) |
| `/api/users/{id}/role` | `PATCH` | `JSON` | Mengubah role pengguna (`admin` only) |
| **Pesan & Kontak** | | | |
| `/api/contact` | `POST` | `JSON` | Kirim pesan / kontak ke admin (`customer`, `auth:sanctum`) |
| `/api/messages` | `GET` | `JSON` | Melihat seluruh pesan masuk (`admin` only) |
| `/api/messages/{id}` | `DELETE` | `JSON` | Hapus pesan dari daftar masuk (`admin` only) |

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
