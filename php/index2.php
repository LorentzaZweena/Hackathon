<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'];
$user_id = $_SESSION['user_id'];
$jadwal = $conn->query("SELECT * FROM tbl_jadwal_hari_ini WHERE user_id = $user_id");

$statsQuery = $conn->query("SELECT * FROM tbl_statistik WHERE user_id = $user_id");
$stats = $statsQuery->fetch_assoc();

if (!$stats) {
    $stats = [
        'total_matkul_hari_ini' => 0,
        'tugas_deadline' => 0,
        'persentase_absensi' => 0,
        'semester' => 'Tidak ada'
    ];
}

$events = [];
$result = $conn->query("SELECT id, judul, mulai, akhir, warna FROM kalender");

while ($row = $result->fetch_assoc()) {
    $startDate = date('Y-m-d', strtotime($row['mulai']));
    $endDate = date('Y-m-d', strtotime($row['akhir']));
    if ($startDate && $endDate) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['judul'],
            'start' => $startDate,
            'end'   => $endDate,
            'color' => $row['warna']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboardStyle.css">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
  <style>
    @media (max-width: 767px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        z-index: 1001;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        overflow-y: auto;
      }
      .sidebar.sidebar-open {
        transform: translateX(0);
      }
      .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
      }
      .overlay.show {
        display: block;
      }
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

  <div class="row">
    <div class="col-12 col-md-3 col-lg-2 sidebar d-md-block" id="sidebar">
      <h4 class="text-center mb-4">
        <img src="../img/logoPNJ.png" alt="" width="25%" class="me-3">E-PNJ
      </h4>

      <a class="active" href="#"><i class="bi bi-house-door me-2"></i> Beranda</a>
      <a href="absensi.php"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
      <a href="pengumuman.php"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
      <a href="jadwalKelas.php"><i class="bi bi-calendar-week me-2"></i> Jadwal Kelas</a>
      <a href="eventKampus.php"><i class="bi bi-activity me-2"></i> Event Kampus</a>
      <a href="layananMahasiswa.php"><i class="bi bi-headset me-2"></i> Layanan Mahasiswa</a>
      <hr>

      <a href="https://www.instagram.com/politekniknegerijakarta/"><i class="bi bi-instagram me-2"></i> Instagram</a>
      <a href="https://pnj.ac.id/"><i class="bi bi-browser-chrome me-2"></i> Web</a>
      <hr>
      <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">
      <button class="btn btn-primary d-md-none mb-3" type="button" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
      </button>

      <br>
      <h2>Selamat datang, <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?> 👋</h2>
      <h3 class="fw-bold mb-4">Dashboard</h3>

      <div class="row g-4">
        <div class="col-lg-7">
          <div class="card-custom p-4">
            <h5>Kalender Akademik</h5>
            <div id="calendar"></div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card-custom p-4 mb-4">
            <h5 class="mb-3">Statistik Singkat</h5>

            <div class="d-flex justify-content-between mb-3">
              <div>
                <small>Total Mata Kuliah Hari Ini</small>
                <h4 class="fw-bold text-primary m-0">
                  <?= $stats['total_matkul_hari_ini'] ?>
                </h4>
              </div>
              <div class="text-end">
                <small>Tugas Deadline</small>
                <h4 class="fw-bold text-warning m-0">
                  <?= $stats['tugas_deadline'] ?>
                </h4>
              </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
              <div>
                <small>Persentase Absensi</small>
                <h4 class="fw-bold text-success m-0">
                  <?= $stats['persentase_absensi'] ?>%
                </h4>
              </div>
              <div class="text-end">
                <small>Semester</small>
                <h4 class="fw-bold text-info m-0">
                  <?= htmlspecialchars($stats['semester']) ?>
                </h4>
              </div>
            </div>
          </div>

          <div class="card-custom p-4 mb-4">
            <h5 class="mb-3">Jadwal Mata Kuliah Hari Ini</h5>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Gambar</th>
                    <th>Matkul</th>
                    <th>Dosen</th>
                    <th>Jam</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $jadwal->fetch_assoc()): ?>
                    <tr>
                      <td>
                        <img src="<?= $row['gambar'] ?>" width="60" height="40" style="object-fit: cover; border-radius: 6px;">
                      </td>
                      <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                      <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                      <td><?= date("H:i", strtotime($row['jam_mulai'])) ?></td>
                      <td>
                        <?php
                        $status = $row['status_kehadiran'];
                        $badge = "secondary";
                        if ($status == "Hadir") $badge = "success";
                        else if ($status == "Tidak Hadir") $badge = "danger";
                        ?>
                        <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
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
        height: window.innerWidth < 768 ? 300 : 500,
        events: eventsData,
    });

    calendar.render();
});

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    sidebar.classList.add('sidebar-open');
    overlay.classList.add('show');
}

function closeSidebar() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    sidebar.classList.remove('sidebar-open');
    overlay.classList.remove('show');
}
</script>

</body>
</html>
