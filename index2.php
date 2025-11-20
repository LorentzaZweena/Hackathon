<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
      header('Location: login.php');
      exit;
  }
  $name = $_SESSION['name'] ?? $_SESSION['nim'];
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
        <div class="col-lg-6">
          <div class="card-custom p-4">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Mata kuliah selanjutnya</h5>
              <a href="" class="text-decoration-none">Lihat jadwal</a>
            </div>

            <p class="text-muted mb-1">Serie A</p>
            <p class="fw-semibold mb-0">21:00, 11 November 2020</p>

            <div class="d-flex align-items-center mt-3">
              <strong class="me-2">Juventus</strong>
              <span class="px-3">vs</span>
              <strong>Sassuolo</strong>
            </div>
          </div>

        </div>

        <div class="col-lg-6">
          <div class="card-custom p-4">
            <h5>Game Statistics</h5>
            <div class="mt-3">
              <div class="d-flex justify-content-between">
                <span>Played</span><span>8</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>Victories</span>
                <span>6</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>Draws</span>
                <span>1</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>Lost</span>
                <span>1</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="card-custom p-4">
            <h5>Standings</h5>
            <table class="table mt-3">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Team</th>
                  <th>MP</th>
                  <th>W</th>
                  <th>D</th>
                  <th>L</th>
                  <th>Pts</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Juventus</td>
                  <td>8</td>
                  <td>6</td>
                  <td>1</td>
                  <td>1</td>
                  <td>19</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Atalanta</td>
                  <td>8</td>
                  <td>5</td>
                  <td>1</td>
                  <td>2</td>
                  <td>16</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Inter</td>
                  <td>8</td>
                  <td>5</td>
                  <td>0</td>
                  <td>3</td>
                  <td>15</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Napoli</td>
                  <td>8</td>
                  <td>4</td>
                  <td>1</td>
                  <td>3</td>
                  <td>13</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Milan</td>
                  <td>8</td>
                  <td>4</td>
                  <td>1</td>
                  <td>3</td>
                  <td>13</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="row g-3">
            <div class="col-12 col-sm-6">
              <div class="card-custom p-3 text-center">
                <h6>Possession</h6>
                <h3>65%</h3>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="card-custom p-3 text-center">
                <h6>Overall Price</h6>
                <h3>$690.2m</h3>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="card-custom p-3 text-center">
                <h6>Transfer Budget</h6>
                <h3>$240.6m</h3>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="card-custom p-3 text-center">
                <h6>Average Score</h6>
                <h3>7.2</h3>
              </div>
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
