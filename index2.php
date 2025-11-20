<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
      header('Location: php/login.php');
      exit;
  }
  $name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/dashboardStyle.css">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-3 col-lg-2 sidebar">
      <h4 class="text-center mb-4"><img src="./img/logoPNJ.png" alt="" width="25%" class="me-3">E-PNJ</h4>
      <a class="active" href="#">Beranda</a>
      <a href="#">Absensi</a>
      <a href="#">Pengumuman</a>
      <a href="#">Jadwal kelas</a>
      <a href="#">Event kampus</a>
      <a href="#">Layanan mahasiswa</a>
      <hr>
      <a href="#">Profil</a>
      <a href="#">Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">
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
                <h4 class="fw-bold text-primary m-0">3</h4>
              </div>
              <div class="text-end">
                <small>Tugas Deadline</small>
                <h4 class="fw-bold text-warning m-0">1</h4>
              </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
              <div>
                <small>Persentase Absensi</small>
                <h4 class="fw-bold text-success m-0">92%</h4>
              </div>
              <div class="text-end">
                <small>Semester</small>
                <h4 class="fw-bold text-info m-0">Ganjil</h4>
              </div>
            </div>
          </div>

          <div class="card-custom p-0 overflow-hidden">
            <div class="p-4 pb-2">
              <h5 class="mb-3">Berita Kampus</h5>
            </div>

            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">

                <div class="carousel-item active">
                  <img src="./img/mahasiswa.jpg" class="d-block w-100" style="height: 150px; object-fit: cover;">
                  <div class="p-4">
                    <h5 class="fw-bold">Dies Natalis PNJ ke-40</h5>
                    <small class="text-muted">12 November 2024</small>
                    <p class="mt-2">
                      PNJ merayakan Dies Natalis ke-40 dengan seminar nasional, expo teknologi,
                      dan pertunjukan seni dari mahasiswa.
                    </p>
                  </div>
                </div>

                <div class="carousel-item">
                  <img src="./img/pkm.jpg" class="d-block w-100" style="height: 180px; object-fit: cover;">
                  <div class="p-4">
                    <h5 class="fw-bold">Pendaftaran PKM 2024 Dibuka</h5>
                    <small class="text-muted">5 November 2024</small>
                    <p class="mt-2">
                      Kemendikbud membuka pendaftaran Program Kreativitas Mahasiswa.
                      Ayo siapkan proposal terbaikmu!
                    </p>
                  </div>
                </div>

                <div class="carousel-item">
                  <img src="./img/uiux.jpg" class="d-block w-100" style="height: 180px; object-fit: cover;">
                  <div class="p-4">
                    <h5 class="fw-bold">Workshop UI/UX PNJ</h5>
                    <small class="text-muted">29 Oktober 2024</small>
                    <p class="mt-2">
                      Jurusan TIK mengadakan workshop UI/UX dengan pembicara dari industri.
                      Gratis untuk mahasiswa PNJ.
                    </p>
                  </div>
                </div>

              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
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

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 500,
      events: [
        { title: 'Mulai Perkuliahan', start: '2024-11-05' },
        { title: 'UTS', start: '2024-11-20', end: '2024-11-24' }
      ]
    });

    calendar.render();
  });
</script>

</body>
</html>
