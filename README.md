<div style="font-family: sans-serif; line-height: 1.6;">

  <h1 style="font-size: 28px; margin-bottom: 10px;">📦 Sistem Inventory / Admin Stok Barang</h1>

  <p>
    Aplikasi berbasis <strong>Laravel 11</strong> yang berfungsi sebagai 
    <strong>sistem manajemen inventory</strong>, digunakan untuk mengelola dan memantau 
    <strong>barang masuk</strong> dan <strong>barang keluar</strong>.  
    Proyek ini menggunakan <strong>admin template</strong> agar tampilan dashboard lebih modern, responsif, 
    dan mudah digunakan oleh admin.
  </p>

  <h2>✨ Fitur Utama</h2>
  <ul>
    <li>Manajemen data master barang (tambah, edit, hapus).</li>
    <li>Pencatatan <strong>Barang Masuk</strong> secara detail.</li>
    <li>Pencatatan <strong>Barang Keluar</strong> untuk tracking stok keluar.</li>
    <li>Dashboard admin menggunakan template UI agar lebih rapi dan user-friendly.</li>
    <li>CRUD lengkap untuk kategori, barang, serta transaksi.</li>
    <li>Sistem autentikasi Laravel (Login & akses admin).</li>
  </ul>

  <h2>🛠️ Teknologi & Stack</h2>
  <ul>
    <li><strong>Laravel 11</strong> — backend utama aplikasi.</li>
    <li><strong>Blade Template + Admin Template</strong> — tampilan UI/UX.</li>
    <li><strong>MySQL / MariaDB</strong> — database (ikuti konfigurasi di <code>.env</code>).</li>
    <li>Composer & NPM untuk dependency management.</li>
  </ul>

  <h2>📁 Struktur Folder Utama</h2>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
app/          — Backend (Controllers, Models, Middleware)
config/       — Konfigurasi aplikasi
database/     — Migration & seeders
public/       — Assets publik & file template admin
resources/    — Views (Blade), components, dll
routes/       — route web & api
  </pre>

  <h2>🚀 Cara Menjalankan Proyek</h2>

  <h3>1. Clone Repository</h3>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
git clone https://github.com/PasaYB/laravel11_sinvent
cd laravel11_sinvent
  </pre>

  <h3>2. Install Dependencies</h3>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
composer install
npm install
  </pre>

  <h3>3. Setup Environment</h3>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
cp .env.example .env
php artisan key:generate
  </pre>

  <h3>4. Migrasi Database</h3>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
php artisan migrate
  </pre>

  <h3>5. Jalankan Server</h3>
  <pre style="background: #f6f8fa; padding: 12px; border-radius: 6px;">
php artisan serve
  </pre>

  <p>Aplikasi kini dapat diakses melalui:  
    <code>http://localhost:8000</code>
  </p>

  <h2>📌 Tujuan Proyek</h2>
  <p>
    Proyek ini dibuat sebagai sarana belajar Laravel 11 sekaligus membangun 
    aplikasi admin inventory yang bisa dikembangkan menjadi sistem yang lebih kompleks 
    seperti manajemen supplier, laporan stok, dan integrasi API.
  </p>

  <hr>

</div>
