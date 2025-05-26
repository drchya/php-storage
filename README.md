# PHP Storage

**PHP Storage** adalah aplikasi sederhana berbasis PHP yang mengusung konsep arsitektur seperti MVC (Model-View-Controller), namun dengan pendekatan yang lebih ringan: **tidak menggunakan Model** sebagai pemroses data ke database. Semua proses pengolahan data ditangani langsung melalui Controller, sehingga memudahkan pemahaman dan pengembangan untuk proyek kecil atau skala personal.

---

## 🧱 Struktur Proyek

```text
php-storage/
├── Config/                 # Konfigurasi aplikasi (jika ada)
├── Controllers/            # Berisi file controller untuk logika aplikasi
├── Helpers/                # Fungsi-fungsi pembantu (utility functions)
├── Public/                 # Root direktori web, berisi aset statis
│   └── Assets/             # CSS, JS, dan gambar
├── Uploads/
│   └── BuktiTransfer/      # Folder penyimpanan file upload
├── Views/                  # File tampilan (HTML + PHP)
├── .htaccess               # Konfigurasi Apache (mod_rewrite)
└── index.php               # Entry point aplikasi
```

---

## 🚀 Fitur

- Struktur mirip MVC, namun lebih sederhana.
- Tidak menggunakan model; query dan pemrosesan data dilakukan langsung di controller.
- Routing manual melalui `index.php`.
- Mendukung upload file.
- Aset statis dipisahkan di dalam folder `Public/Assets`.

---

## 🛠️ Cara Menggunakan

1. **Klon repositori ini** ke direktori lokal:

   ```bash
   git clone https://github.com/drchya/php-storage.git
   ```

2. **Masuk ke folder proyek:**

   ```bash
   cd php-storage
   ```

3. **Jalankan dengan PHP built-in server (untuk testing lokal):**

   ```bash
   php -S localhost:8000
   ```

   Atau jika menggunakan Apache/Nginx, pastikan document root diarahkan ke folder `php-storage/`.

   Atau tidak perlu melakukan cara diatas, artinya langsung menggunakan Web Browser dengan melakukan access ke http://localhost langsung.

5. **Pastikan folder upload dapat ditulisi:**

   ```bash
   chmod -R 775 Uploads/BuktiTransfer/
   ```

   *Seharusnya tidak perlu melakukan chmod karena sudah dilakukan configurasi sebelumnya.

---

## 💡 Catatan

- Aplikasi ini cocok untuk pembelajaran, percobaan, atau proyek kecil.
- Struktur kode bisa dikembangkan lebih lanjut ke pola MVC penuh jika dibutuhkan.
- Tidak disarankan untuk penggunaan skala besar tanpa refactor yang lebih mendalam.

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).

---

> Dibuat oleh [@drchya](https://github.com/drchya) — feel free to fork, modify, and contribute!
