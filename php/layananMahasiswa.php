<?php
  include 'config.php';
  session_start();
  if (!isset($_SESSION['user_id'])) {
      header('Location: php/login.php');
      exit;
  }
  $name = $_SESSION['nama_mahasiswa'] ?? $_SESSION['nim'] ?? "";
  $user_id = $_SESSION['user_id'];

  $riwayat = $conn->prepare("SELECT * FROM tbl_layanan WHERE user_id = ? ORDER BY created_at DESC");
  $riwayat->bind_param("i", $user_id);
  $riwayat->execute();
  $riwayat_result = $riwayat->get_result();

  $faq = $conn->query("SELECT * FROM tbl_faq");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layanan Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dashboardStyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
      <a href="index2.php"><i class="bi bi-house-door me-2"></i> Beranda</a>
      <a href="absensi.php"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
      <a href="pengumuman.php"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
      <a href="jadwalKelas.php"><i class="bi bi-calendar-week me-2"></i> Jadwal Kelas</a>
      <a href="eventKampus.php"><i class="bi bi-activity me-2"></i> Event Kampus</a>
      <a href="#" class="active"><i class="bi bi-headset me-2"></i> Layanan Mahasiswa</a>
      <hr>
      <a href="#"><i class="bi bi-person-circle me-2"></i> Profil</a>
      <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="col-12 col-md-9 col-lg-10 p-4">
      <button class="btn btn-primary d-md-none mb-3" type="button" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
      </button>

    <h2>Selamat datang, <?= htmlspecialchars($name) ?> 👋</h2>
    <h2 class="fw-bold mb-3">Layanan Mahasiswa</h2>

    <div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 rounded-4">
            <h5 class="fw-bold mb-2">Buat Permintaan Baru</h5>
            <p class="text-muted mb-4">Isi semua informasi berikut, lalu klik tombol kirim.</p>

            <form action="fungsiLayanan.php" method="POST">
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label class="form-label fw-semibold">Jenis Permintaan *</label>
                      <select class="form-select rounded-3" name="jenis" required>
                          <option value="">Pilih jenis permintaan</option>
                          <option value="Surat Keterangan">Surat Keterangan</option>
                          <option value="Perbaikan Data">Perbaikan Data</option>
                      </select>
                  </div>

                  <div class="col-md-6">
                      <label class="form-label fw-semibold">Kategori</label>
                      <select class="form-select rounded-3" name="kategori">
                          <option value="">Pilih kategori</option>
                          <option value="Akademik">Akademik</option>
                          <option value="Administrasi">Administrasi</option>
                      </select>
                  </div>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Deskripsi</label>
                  <textarea class="form-control rounded-3" rows="4" name="deskripsi"
                            placeholder="Tulis detail permintaan..."></textarea>
              </div>

              <button class="btn btn-primary px-4 py-2 rounded-3">
                  Kirim Permintaan
              </button>
            </form>

        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3">
          <h5 class="fw-bold mb-3">Riwayat Permintaan</h5>
          <?php while ($row = $riwayat_result->fetch_assoc()): ?>
              <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                  <div>
                      <div class="fw-semibold">REQ#<?= str_pad($row['id'], 5, '0', STR_PAD_LEFT) ?></div>
                      <small class="text-muted"><?= htmlspecialchars($row['jenis_permintaan']) ?></small>
                  </div>

                  <?php
                  $badge = [
                      "Menunggu" => "secondary",
                      "Proses"   => "warning text-dark",
                      "Selesai"  => "success"
                  ];
                  ?>
                  <span class="badge bg-<?= $badge[$row['status']] ?>"><?= $row['status'] ?></span>
              </div>
          <?php endwhile; ?>

          <?php if ($riwayat_result->num_rows == 0): ?>
              <p class="text-muted">Belum ada permintaan.</p>
          <?php endif; ?>
      </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h5 class="fw-bold mb-3">FAQ</h5>

            <div class="accordion" id="faqAccordion">
              <?php $i = 1; while ($row = $faq->fetch_assoc()): ?>
                  <div class="accordion-item border-0">
                      <h2 class="accordion-header">
                          <button class="accordion-button <?= $i==1?'':'collapsed' ?> fw-semibold" 
                                  type="button" data-bs-toggle="collapse"
                                  data-bs-target="#faq<?= $i ?>">
                              <?= $row['pertanyaan'] ?>
                          </button>
                      </h2>
                      <div id="faq<?= $i ?>" 
                          class="accordion-collapse collapse <?= $i==1?'show':'' ?>" 
                          data-bs-parent="#faqAccordion">
                          <div class="accordion-body text-muted">
                              <?= $row['jawaban'] ?>
                          </div>
                      </div>
                  </div>
              <?php $i++; endwhile; ?>
            </div>


        </div>
    </div>

</div>

</div>

    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
