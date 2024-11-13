<?php
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php?page=login");
    exit;
}
$error = "";
$nama = '';
$alamat = '';
$no_hp = '';
if (isset($_GET['id'])) {
  $ambil = mysqli_query($db, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_hp = $row['no_hp'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = trim($_POST['nama']);
  $alamat = trim($_POST['alamat']);
  $no_hp = trim($_POST['no_hp']);
  // Check if name already exists
  $check_sql = "SELECT * FROM dokter WHERE nama = ?";
  $check_stmt = $db->prepare($check_sql);
  $check_stmt->bind_param("s", $nama);
  $check_stmt->execute();
  $check_result = $check_stmt->get_result();

  if ($check_result->num_rows > 0) {
    $error = "Nama dokter sudah ada. Silakan pilih nama lain.";
  } else {
    // Check if id is not empty, if empty then it's a new record
    if ($_POST['id']) {
      $update = mysqli_query($db, "UPDATE `dokter` SET `nama`='". $nama ."', `alamat`='". $alamat ."', `no_hp`='". $no_hp ."' WHERE `id`='". $_POST['id'] ."'");
    } else {
      $add = mysqli_query($db, "INSERT INTO `dokter` (`nama`, `alamat`, `no_hp`)
              VALUES ('". $nama ."', '". $alamat ."', '". $no_hp ."')") or die(mysqli_error($db));
    }
    header('location:index.php?page=dokter');
  }
}

if (isset($_GET['aksi'])) {
  if ($_GET['aksi'] == 'hapus') {
      $hapus = mysqli_query($db, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
  }

  header('location:index.php?page=dokter');
}
?>
<div class="mt-3">
  <?php if ($error): ?>
      <div class="alert alert-danger">
          <?php echo $error; ?>
      </div>
  <?php endif; ?>
    <!-- Form Tambah/Edit Dokter -->
    <form method="POST" action="index.php?page=dokter">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">
        <div class="row align-items-center">
          <!-- input nama -->
          <div class="col">
            <label for="nama" class="form-label">Nama</label>
            <!-- value diberi kondisi apabila ada parameter edit maka mengisi value dengan data yang ada -->
            <input id="nama" type="text" class="form-control" name="nama" placeholder="Nama" aria-label="Nama" value="<?php echo isset($_GET['id']) ? $nama : ''; ?>">
          </div>
          <!-- input alamat -->
          <div class="col">
            <label for="alamat" class="form-label">Alamat</label>
            <input id="alamat" type="text" class="form-control" name="alamat" placeholder="Alamat" aria-label="Alamat" value="<?php echo isset($_GET['id']) ? $alamat : ''; ?>">
          </div>
          <!-- input No HP -->
          <div class="col">
            <label for="no_hp" class="form-label">No HP</label>
            <input id="no_hp" type="tel" class="form-control" name="no_hp" placeholder="No HP" aria-label="No HP" value="<?php echo isset($_GET['id']) ? $no_hp : ''; ?>">
          </div>
          <div class="col">
            <button type="submit" value="simpan" class="btn btn-primary" name="simpan">Simpan</button>
          </div>
        </div>
      </form>
</div>
<!-- Menampilkan data -->
<table class="table table-striped mt-3">
  <thead>
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>No HP</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Ambil data dari database
      $result = mysqli_query($db, "SELECT * FROM `dokter` ORDER BY `id` DESC");
      $no = 1;
      // looping data
      while ($data = $result->fetch_array()) {
    ?>
    <tr class="border-bottom">
      <td><?php echo $no++ ?></td>
      <td><?php echo $data['nama'] ?></td>
      <td><?php echo $data['alamat'] ?></td>
      <td><?php echo $data['no_hp'] ?></td>
      <td>
        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>