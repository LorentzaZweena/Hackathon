<?php
    session_start();
    require_once __DIR__ . '/config.php';

    if (isset($_POST['login'])) {

        $username = mysqli_real_escape_string($conn, $_POST['nim']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT * FROM tbl_mahasiswa WHERE nim='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nim'] = $username;
            $_SESSION['nama_mahasiswa'] = $row['nama_mahasiswa'];
            header("Location: index2.php");
            exit();
        } else {
            $error = "NIM atau password salah!";
        }
    }
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">

</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <div class="card shadow">
        <div class="row g-0">
          <div class="col-md-6 p-4">
            <h3 class="mb-4 text-center">Login</h3>

            <form action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan NIM" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
              </div>

              <button type="submit" name="login" class="btn btn-primaryPNJ w-100 mt-3">
                Login
              </button>
            </form>
          </div>
          <div class="col-md-6">
            <img src="https://th.bing.com/th/id/R.0a4ae4df2c9f4df17c898874195dfffa?rik=WYcwkLQX%2bh5hMg&riu=http%3a%2f%2fkuliah-sabtu-minggu.com%2fwp-content%2fuploads%2f2023%2f01%2f2022-11-02-680x437.jpg&ehk=%2bFSwsRfvGhIZdRHPtHboCMmlML60PQlUiM7xb6215wo%3d&risl=&pid=ImgRaw&r=0" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="Login Image">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
