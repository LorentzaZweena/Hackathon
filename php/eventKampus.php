<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: php/login.php');
    exit;
}
$name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'];
$user_id = $_SESSION['user_id'];

$events = $conn->query("SELECT * FROM tbl_event ORDER BY date_event DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Kampus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboardStyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-3 col-lg-2 sidebar">
      <h4 class="text-center mb-4">
        <img src="../img/logoPNJ.png" alt="" width="25%" class="me-3">E-PNJ
      </h4>
      <a href="index2.php"><i class="bi bi-house-door me-2"></i> Beranda</a>
      <a href="absensi.php"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
      <a href="pengumuman.php"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
      <a href="jadwalKelas.php"><i class="bi bi-calendar-week me-2"></i> Jadwal Kelas</a>
      <a href="#" class="active"><i class="bi bi-activity me-2"></i> Event Kampus</a>
      <a href="#"><i class="bi bi-headset me-2"></i> Layanan Mahasiswa</a>
      <hr>
      <a href="#"><i class="bi bi-person-circle me-2"></i> Profil</a>
      <a href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">
      <br>
      <h2>Selamat datang, <?= htmlspecialchars($name) ?> 👋</h2>
      <h3 class="fw-bold mb-4">Event Kampus</h3>

      <div class="row g-4">
        <?php while($event = $events->fetch_assoc()): ?>
          <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
              <?php if(!empty($event['image_url'])): ?>
                <img src="<?= htmlspecialchars($event['image_url']) ?>" class="card-img-top rounded-top-4" alt="<?= htmlspecialchars($event['title']) ?>">
              <?php endif; ?>
              <div class="card-body d-flex flex-column justify-content-between p-3">
                <div>
                  <div class="d-flex justify-content-between mb-2">
                    <div>
                      <small class="text-muted d-block mb-2"><?= htmlspecialchars($event['category']) ?></small>
                      <h5 class="fw-bold mb-1"><?= htmlspecialchars($event['title']) ?></h5>
                      <?php if(!empty($event['subtitle'])): ?>
                        <span class="fw-semibold text-primary d-block mb-2"><?= htmlspecialchars($event['subtitle']) ?></span>
                      <?php endif; ?>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                      <i class="bi <?= htmlspecialchars($event['icon']) ?> text-primary fs-4"></i>
                    </div>
                  </div>
                  <p class="text-muted small mb-4" style="min-height:60px;"><?= htmlspecialchars($event['description']) ?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                  <span class="badge rounded-pill text-bg-light border text-primary px-3 py-2"><?= htmlspecialchars($event['tag']) ?></span>
                  <small class="text-muted"><?= htmlspecialchars($event['location']) ?>, <?= date('d M Y', strtotime($event['date_event'])) ?> <?= substr($event['time_event'],0,5) ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
