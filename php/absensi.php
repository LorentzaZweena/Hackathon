<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: php/login.php');
    exit;
}
$name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'];
$user_id = $_SESSION['user_id'];
$jadwal = $conn->query("SELECT * FROM tbl_jadwal_hari_ini WHERE user_id = $user_id");
$matkul = $conn->query("SELECT * FROM tbl_jadwal_hari_ini WHERE user_id = $user_id LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Absensi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboardStyle.css">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-3 col-lg-2 sidebar">
      <h4 class="text-center mb-4">
        <img src="../img/logoPNJ.png" alt="" width="25%" class="me-3">E-PNJ
      </h4>

      <a href="index2.php"><i class="bi bi-house-door me-2"></i> Beranda</a>
      <a href="#" class="active"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
      <a href="#"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
      <a href="#"><i class="bi bi-calendar-week me-2"></i> Jadwal Kelas</a>
      <a href="#"><i class="bi bi-activity me-2"></i> Event Kampus</a>
      <a href="#"><i class="bi bi-headset me-2"></i> Layanan Mahasiswa</a>

      <hr>

      <a href="#"><i class="bi bi-person-circle me-2"></i> Profil</a>
      <a href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">

    <h2>Selamat datang, <?= htmlspecialchars($name) ?> 👋</h2>
    <h3 class="fw-bold mb-4">Materi hari ini</h3>

    <div class="row g-4 mb-4">
        <?php while($m = $matkul->fetch_assoc()): ?>
        <div class="col-lg-4">
            <div class="card-custom p-3 d-flex align-items-center">
                <img src="<?= htmlspecialchars($m['gambar']) ?>" width="55" height="55" class="rounded-circle me-3" style="object-fit: cover;">
                <div>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($m['nama_matkul']) ?></h5>
                    <small class="text-muted">
                        <?= htmlspecialchars($m['nama_dosen']) ?>
                    </small>
                </div>

            </div>
        </div>
        <?php endwhile; ?>
    </div>


    <div class="card-custom p-4 mb-4">
        <h5 class="mb-3">Daftar Absensi Hari Ini</h5>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>Jam</th>
                    <th>Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row = $jadwal->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                    <td><?= date("H.i", strtotime($row['jam_mulai'])) . " - " . date("H.i", strtotime($row['jam_selesai'])) ?></td>
                    <td><?= htmlspecialchars($row['ruang']) ?></td>
                    <td>
                        <button class="btn btn-success btn-sm">
                            Hadir
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-custom p-4 h-100">
                <h5 class="mb-3">Grafik Nilai</h5>
                <div style="height: 280px; background: #eef2ff; border-radius: 12px;"
                     class="d-flex justify-content-center align-items-center text-muted">
                    (Grafik nanti ditaruh di sini)
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-custom p-4 h-90">
              <h5 class="mb-3">Dosen Yang Mengajar Hari Ini</h5>

              <?php 
              $dosens = $conn->query("SELECT * FROM tbl_jadwal_hari_ini WHERE user_id = $user_id LIMIT 3"); 
              while($d = $dosens->fetch_assoc()):
              ?>
              <div class="d-flex align-items-center mb-3">
                  <img src="<?= htmlspecialchars($d['gambar'] ?: '../img/default.jpg') ?>" 
                      width="50" height="50" class="me-3 rounded-circle" style="object-fit: cover;">
                  <div>
                      <strong><?= htmlspecialchars($d['nama_dosen']) ?></strong><br>
                      <small class="text-muted"><?= htmlspecialchars($d['nama_matkul']) ?></small>
                  </div>
                  <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-primary btn-sm ms-auto"><i class="bi bi-whatsapp me-1"></i> Chat</a>

              </div>
              <?php endwhile; ?>
          </div>

        </div>
    </div>

</div>

</div>

        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var eventsData = <?php echo json_encode($events); ?>;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        events: eventsData,
    });

    calendar.render();
});
</script>

</body>
</html>
