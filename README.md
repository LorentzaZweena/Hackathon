````markdown
# Hackathon Web Application

## 1. Cara Menjalankan

1. Pastikan sudah menginstal **XAMPP** atau **Web Server** dengan PHP & MySQL.
2. Clone repository ini ke folder `htdocs` (jika XAMPP) atau web root server ini.
3. Buat database MySQL baru dengan nama `hackathon`.
4. Import database:
   - Gunakan file `hackathon.dump` atau `hackathon.sql` yang ada di folder `database`.
   - Bisa melalui **phpMyAdmin**:
     - Buka http://localhost/phpmyadmin
     - Pilih database `hackathon`
     - Klik tab **Import** → pilih file `.sql` atau `.dump` → klik **Go**
   - Atau melalui command line:
     ```bash
     mysql -u root -p hackathon < hackathon.sql
     ```
5. Sesuaikan konfigurasi database di file `connection.php`:
   ```php
   <?php
       $host = '127.0.0.1';
       $user = 'root';
       $pass = '';
       $db   = 'hackathon';

       $conn = mysqli_connect($host, $user, $pass, $db);

       if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
       }
   ?>
````

6. Buka browser dan akses aplikasi melalui:

   ```
   http://localhost/<Hackathon>/
   ```

---

## 2. Struktur Project

```
hackathon/
│
├── css/                  # File CSS
├── database/             # File dump atau SQL database
│   └── hackathon.dump
├── img/                  # File gambar
├── index.php             # Halaman utama
├── login.php             # Halaman login
├── logout.php            # Logout user
├── README.md             # Dokumentasi
```

---

## 3. List Teknologi

* **Backend:** PHP Native
* **Database:** MySQL (dikelola dengan TablePlus)
* **Frontend:** HTML, CSS, JavaScript, Bootstrap 5

---

## 4. Fitur yang Dibuat

* **Manajemen Kalender:** Menampilkan jadwal penting, event, libur, dan UTS/UAS
* **Absensi Mahasiswa:** Melacak kehadiran mahasiswa
* **Event & Pengumuman:** Menampilkan informasi kegiatan dan pengumuman kampus
* **FAQ & Layanan:** Mahasiswa dapat mengajukan layanan, melihat status, dan FAQ
* **Tugas & Nilai:** Menyimpan data tugas dan nilai mahasiswa
* **Dashboard Statistik:** Statistik absensi, tugas, dan mata kuliah hari ini
* **Autentikasi:** Login dan Logout mahasiswa

---

## Catatan

* File database utama: `hackathon.dump` atau `hackathon.sql`
* Pastikan PHP version ≥ 7.4 dan MySQL version ≥ 8.0
* Gunakan browser modern untuk tampilan optimal
```
