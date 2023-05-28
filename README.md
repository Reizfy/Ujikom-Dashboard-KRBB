<p align="center">
  <img src="https://github.com/Reizfy/Ujikom-Dashboard-KRBB/assets/87867288/065461d5-95fe-4dd5-b95c-0dcab86ab361" alt="Logo-KRRB" style="width: 100px;">
</p>

# Tentang Website
Website KRBB Adalah Website Yang Digunakan Untuk Mengelola Data Member Dan Data Uang Kas Komunitas. Website Ini Menggunakan Laravel 10 Dan Minimal PHP 8.2.4, Apabila Ada Error Saat Installasi Mungkin Ada Error Dan Kemungkinan Karena Versi PHP Yang Digunakan Tidak Support.

# Fitur Fitur
- Management Data Member
    - Tambah Data Baru
    - Delete Data
    - Edit Data
- Management Uang Kas
    - Kredit
    - Debit
    - Saldo (Auto Hitung)
    - Cetak Data Ke Excel
- Management Profil Admin
- Grafik ChartJS Pada Dashboard
- Total Saldo, Debit, Kredit, Dan Member Pada Dashboard

# Instalasi
Via GIT 
```bash
git clone https://github.com/Reizfy/Ujikom-Dashboard-KRBB.git
```

Atau

[Download ZIP File](https://github.com/Reizfy/Ujikom-Dashboard-KRBB/archive/refs/heads/main.zip)

Setup

Jalankan perintah 
```bash
composer update
```
Atau :
```bash
composer install
```
Copy file .env dari .env.example
```bash
cp .env.example .env
```
Konfigurasi file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example_app
DB_USERNAME=root
DB_PASSWORD=
```
Opsional
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:7ny8i06U6BGjRyeIDxeiJ1Oz3+SLjK3QIDaeesQdqWo=
APP_DEBUG=true
APP_URL=http://localhost
```
Generate key
```bash
php artisan key:generate
```
Migrate database
```bash
php artisan migrate --seed
```
Menjalankan aplikasi
```bash
php artisan serve
```

## License

[MIT license](https://opensource.org/licenses/MIT)










