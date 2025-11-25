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
    $nilaiQuery = $conn->query("SELECT nama_matkul, nilai FROM tbl_nilai WHERE user_id = $user_id");
    $labels = [];
    $values = [];

    while($row = $nilaiQuery->fetch_assoc()) {
        $labels[] = $row['nama_matkul'];
        $values[] = (float)$row['nilai'];
    }
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      <a href="#" class="active"><i class="bi bi-clipboard-check me-2"></i> Absensi</a>
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

      <h2>Selamat datang, <?= htmlspecialchars($name) ?> 👋</h2>
      <h3 class="fw-bold mb-4">Materi hari ini</h3>

      <div class="row g-4 mb-4">
          <?php while($m = $matkul->fetch_assoc()): ?>
          <div class="col-lg-4">
              <div class="card-custom p-3 d-flex align-items-center">
                  <img src="<?= htmlspecialchars($m['gambar']) ?>" width="55" height="55" class="rounded-circle me-3" style="object-fit: cover;">
                  <div>
                      <h5 class="fw-bold mb-1"><a href="https://repository.bsi.ac.id/repo/files/381149/download/MODUL%20WEB%201.pdf" class="text-decoration-none text-black" target="_blank"><?= htmlspecialchars($m['nama_matkul']) ?></a></h5>
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
          <div class="table-responsive">
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
                            <button class="btn btn-success btn-sm hadirBtn" data-id="<?= $row['id']; ?>"> Hadir </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
          </div>
      </div>

      <div class="row g-4">
          <div class="col-lg-8">
              <div class="card-custom p-4 h-100">
                  <h5 class="mb-3">Grafik Nilai</h5>
                  <canvas id="grafikNilai" style="height: 100px; background: #eef2ff; border-radius: 12px;"></canvas>
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
                    <a href="https://wa.me/6289526303760" target="_blank" class="btn btn-primary btn-sm ms-auto"><i class="bi bi-whatsapp me-1"></i> Chat</a>

                </div>
                <?php endwhile; ?>
            </div>

          </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const ctx = document.getElementById('grafikNilai').getContext('2d');
    const data = {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [{
        label: 'Nilai Mata Kuliah',
        data: <?php echo json_encode($values); ?>,
        backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 1
    }]
};
    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {  
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    };
    
    new Chart(ctx, config);
</script>
<script>
document.querySelectorAll('.hadirBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        let jadwal_id = this.getAttribute('data-id');
        let button = this;

        fetch("fungsiAbsensi.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "jadwal_id=" + jadwal_id
        })
        .then(res => res.text())
        .then(res => {
            if (res.includes("success")) {
                button.classList.remove("btn-success");
                button.classList.add("btn-secondary");
                button.innerText = "Hadir ✔";
                button.disabled = true;
            } else {
                alert("Gagal absen! Server said: " + res);
            }
        });
    });
});
</script>
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
