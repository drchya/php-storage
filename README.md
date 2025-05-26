# PHP Storage

PHP Storage adalah aplikasi sederhana berbasis PHP yang mengusung konsep arsitektur seperti MVC (Model-View-Controller), namun dengan pendekatan yang lebih ringan: **tidak menggunakan Model** sebagai pemroses data ke database. Semua proses pengolahan data ditangani langsung melalui Controller, sehingga memudahkan pemahaman dan pengembangan untuk proyek kecil atau skala personal.

## 🧱 Struktur Proyek

php-storage/
├── Config/ # Konfigurasi aplikasi (jika ada)
├── Controllers/ # Berisi file controller untuk logika aplikasi
├── Helpers/ # Fungsi-fungsi pembantu (utility functions)
├── Public/ # Root direktori web, berisi aset statis
│ └── Assets/ # CSS, JS, dan gambar
├── Uploads/
│ └── BuktiTransfer/ # Folder penyimpanan file upload
├── Views/ # File tampilan (HTML + PHP)
├── .htaccess # Konfigurasi Apache (mod_rewrite)
└── index.php # Entry point aplikasi

markdown
Copy
Edit

## 🚀 Fitur

- Struktur mirip MVC, namun lebih sederhana.
- Tidak menggunakan model; query dan pemrosesan data dilakukan langsung di controller.
- Routing manual melalui `index.php`.
- Mendukung upload file.
- Aset statis dipisahkan di dalam folder `Public/Assets`.

## 🛠️ Cara Menggunakan

1. **Klon repositori ini** ke direktori lokal:

   ```bash
   git clone https://github.com/drchya/php-storage.git
Buka folder project:

bash
Copy
Edit
cd php-storage
Jalankan di server lokal (misalnya dengan PHP built-in server):

bash
Copy
Edit
php -S localhost:8000
Atau pastikan server Apache/Nginx kamu mengarah ke folder php-storage/.

Pastikan folder Uploads/BuktiTransfer/ dapat ditulisi:

bash
Copy
Edit
chmod -R 775 Uploads/BuktiTransfer/
💡 Catatan
Aplikasi ini cocok untuk pembelajaran, percobaan, atau proyek kecil.

Struktur kode bisa diperluas ke sistem MVC penuh jika dibutuhkan.

Tidak disarankan untuk produksi skala besar tanpa refactor ke sistem yang lebih terstruktur.

📄 Lisensi
Proyek ini menggunakan lisensi MIT.
