<?php
// konfigurasi database
// koneksi ke database
$db = mysqli_connect("localhost", "root", "", "poliklinik")
    or
    // jika gagal, tampilkan pesan error
    die("Connection failed: " . mysqli_connect_error());