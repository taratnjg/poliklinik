<?php
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php?page=login");
    exit;
}

$id_pasien = '';
$id_dokter = '';
$tgl_periksa = '';
$catatan = '';
$obat = '';
if (isset($_GET['id'])) {
  $ambil = mysqli_query($db, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $id_pasien = $row['id_pasien'];
        $id_dokter = $row['id_dokter'];
        $tgl_periksa = $row['tgl_periksa'];
        $catatan = $row['catatan'];
        $obat = $row['obat'];
    }
}

if (isset($_POST['id_pasien'])) {
  // cek apakah form input nama tidak kosong
  if ($_POST['id']) {
    $update = mysqli_query($db, "UPDATE `periksa` SET `id_pasien`='". $_POST['id_pasien'] ."', `id_dokter`='". $_POST['id_dokter'] ."', `tgl_periksa`='". $_POST['tgl_periksa'] ."', `catatan`='". $_POST['catatan'] ."', obat='". $_POST['obat'] ."' WHERE `id`='". $_POST['id'] ."'");
  } else {
    $add = mysqli_query($db, "INSERT INTO `periksa` (`id_pasien`, `id_dokter`, `tgl_periksa`, `catatan`, `obat`)
            VALUES ('". $_POST['id_pasien'] ."', '". $_POST['id_dokter'] ."', '". $_POST['tgl_periksa'] ."', '". $_POST['catatan'] ."', '". $_POST['obat'] ."')");
  }
  header('location:index.php?page=periksa');
}

if (isset($_GET['aksi'])) {
  if ($_GET['aksi'] == 'hapus') {
      $hapus = mysqli_query($db, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
  }

  header('location:index.php?page=periksa');
}
?>
<div class="mt-3">
      <!-- Form untuk tambah dan edit -->
      <form method="POST" action="index.php?page=periksa">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">
        <!-- input pasien -->
        <div class="form-group mx-sm-3 mb-2">
          <label for="inputPasien" class="sr-only">Pasien</label>
          <select class="form-control" name="id_pasien">
              <?php
              $selected = '';
              
              $pasien=mysqli_query($db, "SELECT * FROM pasien");
              while ($data = $pasien->fetch_array()) {
                  if ($data['id'] == $id_pasien) {
                      $selected = 'selected="selected"';
                  } else {
                      $selected = '';
                  }
              ?>
                  <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
              <?php
              }
              ?>
          </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
          <label for="inputDokter" class="sr-only">Dokter</label>
          <select id="inputDokter" class="form-control" name="id_dokter">
              <?php
              $selected = '';
              
              $dokter=mysqli_query($db, "SELECT * FROM dokter");
              while ($data = $dokter->fetch_array()) {
                  if ($data['id'] == $id_dokter) {
                      $selected = 'selected="selected"';
                  } else {
                      $selected = '';
                  }
              ?>
                  <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
              <?php
              }
              ?>
          </select>
        </div>
        <!-- input tgl periksa -->
        <div class="form-group mx-sm-3 mb-2">
          <label for="tgl_periksa" class="form-label">Tanggal Periksa</label>
          <input id="tgl_periksa" type="datetime-local" class="form-control" name="tgl_periksa" placeholder="Tanggal Periksa" aria-label="Tgl_periksa" value="<?php echo isset($_GET['id']) ? $tgl_periksa : ''; ?>">
        </div>
        <div class="form-group mx-sm-3 mb-2">
          <label for="catatan" class="form-label">Catatan</label>
          <!-- value diberi kondisi apabila ada parameter edit maka mengisi value dengan data yang ada -->
          <textarea id="catatan" type="text" class="form-control" name="catatan" placeholder="Catatan" aria-label="Catatan"><?php echo isset($_GET['id']) ? $catatan : ''; ?></textarea>
        </div>
        <div class="form-group mx-sm-3 mb-2">
          <label for="obat" class="form-label">Obat</label>
          <input id="obat" type="text" class="form-control" name="obat" placeholder="Obat" aria-label="Obat" value="<?php echo isset($_GET['id']) ? $obat : ''; ?>">
        </div>
        <button type="submit" value="simpan" class="btn btn-primary mx-sm-3 mb-2" name="simpan">Simpan</button>
      </form>
    </div>
    <!-- Menampilkan data -->
    <table class="table table-striped mt-3">
      <thead>
        <tr>
          <th>#</th>
          <th>Pasien</th>
          <th>Dokter</th>
          <th>Tanggal Periksa</th>
          <th>Catatan</th>
          <th>Obat</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Ambil data dari database
          $result = mysqli_query($db, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
          $no = 1;
          // looping data
          while ($data = $result->fetch_array()) {
        ?>
        <tr class="border-bottom">
          <td><?php echo $no++ ?></td>
          <td><?php echo $data['nama_pasien'] ?></td>
          <td><?php echo $data['nama_dokter'] ?></td>
          <td><?php echo $data['tgl_periksa'] ?></td>
          <td><?php echo $data['catatan'] ?></td>
          <td><?php echo $data['obat'] ?></td>
          <td>
            <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>