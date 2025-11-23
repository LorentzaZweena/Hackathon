<?php
    include 'config.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: php/login.php');
        exit;
    }
    $name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'];
    $user_id = $_SESSION['user_id'];

    $jadwal_kelas = $conn->query("SELECT * FROM tbl_jadwal");
    $tugas_belum_selesai = $conn->query("SELECT * FROM tbl_tugas WHERE status = 'belum' AND user_id = $user_id");
    $tugas_sudah_selesai = $conn->query("SELECT * FROM tbl_tugas WHERE status = 'selesai' AND user_id = $user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jadwal Kelas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/dashboardStyle.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    .tablePNJ th {
      background-color: #018797 !important;
      color: white;
    }
    .bgPNJ {
        background-color: #018797 !important;
    }

  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-3 col-lg-2 sidebar">
      <h4 class="text-center mb-4">
        <img src="../img/logoPNJ.png" alt="" width="25%" class="me-3" />E-PNJ
      </h4>

      <a href="index2.php"><i class="bi bi-house-door me-2"></i> Beranda</a>
      <a href="absensi.php"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
      <a href="pengumuman.php"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
      <a href="#" class="active"><i class="bi bi-calendar-week me-2"></i> Jadwal Kelas</a>
      <a href="eventKampus.php"><i class="bi bi-activity me-2"></i> Event Kampus</a>
      <a href="#"><i class="bi bi-headset me-2"></i> Layanan Mahasiswa</a>

      <hr />

      <a href="#"><i class="bi bi-person-circle me-2"></i> Profil</a>
      <a href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">

      <br />
      <h2>Selamat datang, <?= htmlspecialchars($name) ?> 👋</h2>
      <h3 class="fw-bold mb-4">Jadwal kelas 2025/2026</h3>

      <div class="container mt-4">
        <table class="table table-bordered">
          <thead class="tablePNJ">
            <tr>
              <th scope="col">Tanggal</th>
              <th scope="col">Waktu</th>
              <th scope="col">Mata kuliah</th>
              <th scope="col">Penanggung jawab</th>
              <th scope="col">Nama Dosen</th>
            </tr>
          </thead>

          <tbody>
            <?php while($row = $jadwal_kelas->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['tanggal']) ?></td>
                <td>
                  <?= htmlspecialchars(substr($row['waktu_mulai'], 0, 5)) ?>
                  -
                  <?= htmlspecialchars(substr($row['waktu_selesai'], 0, 5)) ?>
                </td>
                <td><?= htmlspecialchars($row['mata_kuliah']) ?></td>
                <td><?= htmlspecialchars($row['PJ']) ?></td>
                <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="row mt-1 g-4">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bgPNJ text-white">
              <h5 class="mb-0">List Tugas yang Belum Selesai</h5>
            </div>
            <div class="card-body">
              <?php if ($tugas_belum_selesai->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                  <?php while($tugas = $tugas_belum_selesai->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <strong><?= htmlspecialchars($tugas['judul']) ?></strong><br />
                        <small class="text-muted mt-1">Deadline: <?= htmlspecialchars($tugas['deadline']) ?></small>
                      </div>
                      <a href="https://repository.bsi.ac.id/repo/files/381149/download/MODUL%20WEB%201.pdf" class="btn btn-primary btn-sm">Kerjakan Tugas</a>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php else: ?>
                <p class="text-muted">Tidak ada tugas belum selesai.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">List Tugas yang Sudah Selesai</h5>
            </div>
            <div class="card-body">
              <?php if ($tugas_sudah_selesai->num_rows > 0): ?>
                <ul class="list-group list-group-flush">
                  <?php while($tugas = $tugas_sudah_selesai->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                        <strong><?= htmlspecialchars($tugas['judul']) ?></strong><br />
                        <small class="text-muted">Selesai pada: <?= htmlspecialchars($tugas['tanggal_selesai']) ?></small>
                      </div>
                      <button class="btn btn-secondary btn-sm" disabled>Sudah Selesai</button>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php else: ?>
                <p class="text-muted">Tidak ada tugas yang sudah selesai.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
