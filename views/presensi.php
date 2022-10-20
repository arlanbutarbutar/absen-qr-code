<?php require_once("../controller/script.php");
require_once("redirect.php");
if (!isset($_GET['jw'])) {
  header("Location: kelola-absen");
  exit();
} else if (isset($_GET['jw'])) {
  if ($_GET['jw'] == "") {
    header("Location: kelola-absen");
    exit();
  } else {
    $id_jadwal = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_GET['jw']))));
    $presensi = mysqli_query($conn, "SELECT * FROM absen JOIN jadwal ON absen.id_jadwal=jadwal.id_jadwal JOIN mahasiswa ON absen.nim_mhs=mahasiswa.nim_mhs WHERE absen.id_jadwal='$id_jadwal'");
  }
}

$_SESSION['page-name'] = "Presensi Kehadiran";
$_SESSION['page-url'] = "presensi?jw=" . $id_jadwal;
$_SESSION['actual-link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/header-dash.php"); ?></head>

<body class="app">
  <?php if (isset($_SESSION['message-success'])) { ?>
    <div class="message-success" data-message-success="<?= $_SESSION['message-success'] ?>"></div>
  <?php }
  if (isset($_SESSION['message-info'])) { ?>
    <div class="message-info" data-message-info="<?= $_SESSION['message-info'] ?>"></div>
  <?php }
  if (isset($_SESSION['message-warning'])) { ?>
    <div class="message-warning" data-message-warning="<?= $_SESSION['message-warning'] ?>"></div>
  <?php }
  if (isset($_SESSION['message-danger'])) { ?>
    <div class="message-danger" data-message-danger="<?= $_SESSION['message-danger'] ?>"></div>
  <?php } ?>
  <header class="app-header fixed-top">
    <?php require_once("../resources/topbar.php"); ?>
    <!--//app-header-inner-->
    <?php require_once("../resources/sidebar.php"); ?>
    <!--//app-sidepanel-->
  </header>
  <!--//app-header-->

  <div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
      <div class="container-xl">

        <h1 class="app-page-title"><?= $_SESSION['page-name'] ?></h1>

        <a href="kelola-absen" class="btn btn-primary text-white mb-3">kembali</a>

        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-borderless text-center">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Mahasiswa</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Tgl Masuk</th>
                        <th scope="col">Status Kehadiran</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (mysqli_num_rows($presensi) == 0) { ?>
                        <tr>
                          <th scope="row" colspan="5">Belum ada mahasiswa yang mengisi absen</th>
                        </tr>
                        <?php } else if (mysqli_num_rows($presensi) > 0) {
                        $no = 1;
                        while ($row_absen = mysqli_fetch_assoc($presensi)) { ?>
                          <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= $row_absen['nama_mhs'] ?></td>
                            <td><?= $row_absen['jam_masuk'] ?></td>
                            <td><?php $date = date_create($row_absen['tgl_masuk']);
                                echo date_format($date, 'l, d M Y'); ?></td>
                            <td><?= $row_absen['status'] ?></td>
                            <td>
                              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah-absen<?= $row_absen['id_absen'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                              </button>
                              <div class="modal fade" id="ubah-absen<?= $row_absen['id_absen'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel"><?= $row_absen['nama_mhs'] ?></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                      <div class="modal-body text-center">
                                        <div class="mb-3">
                                          <label for="status" class="form-label">Status Kehadiran</label>
                                          <select name="status" id="status" class="form-select" aria-label="Default select example" required>
                                            <option selected value="">Pilih Status Kehadiran</option>
                                            <option value="Hadir">Hadir</option>
                                            <option value="Ijin">Ijin</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Alpha">Alpha</option>
                                            <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="modal-footer justify-content-center">
                                        <input type="hidden" name="id-absen" value="<?= $row_absen['id_absen'] ?>">
                                        <input type="hidden" name="namaOld" value="<?= $row_absen['nama_mhs'] ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="ubah-presensi" class="btn btn-warning">Ubah</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                      <?php $no++;
                        }
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->


    <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>