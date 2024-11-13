<?php 
require_once 'koneksi.php';
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Title -->
  <title>Poliklinik</title>
  <!-- Import Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler"
    type="button" data-bs-toggle="collapse"
    data-bs-target="#navbarNavDropdown"
    aria-controls="navbarNavDropdown" aria-expanded="false"
    aria-label="Toggle navigation">
    </button>
    <div class="collapse navbar-collapse d-lg-flex" id="navbarNavDropdown">
      <a class="navbar-brand col-lg-3 me-0" href="#">Sistem Informasi Poliklinik</a>
      <ul class="navbar-nav col-lg-6 justify-content-lg-center">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">
            Home
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
            Data Master
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="index.php?page=dokter">
                Dokter
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="index.php?page=pasien">
                Pasien
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" 
          href="index.php?page=periksa">
            Periksa
          </a>
        </li>
      </ul>
      
      <div class="d-lg-flex col-lg-3 justify-content-lg-end gap-2">
        <?php if (!isset($_SESSION['username'])) { ?>
          <a class="btn btn-outline-primary" aria-current="page" href="index.php?page=register">
            Register
          </a>
          <a class="btn btn-primary" aria-current="page" href="index.php?page=login">
            Login
          </a>
        <?php } else { ?>
          <a class="btn btn-danger" aria-current="page" href="logout.php">
            Logout
          </a>
        <?php } ?>
      </div>
    </div>
  </div>
</nav>
<main role="main" class="container mt-5">
    <?php
    if (isset($_GET['page'])) {
    ?>
        <h2><?php echo ucwords($_GET['page']) ?></h2>
    <?php
        include($_GET['page'] . ".php");
    } else {
        echo "Selamat Datang di Sistem Informasi Poliklinik";
    }
    ?>
</main>
</body>