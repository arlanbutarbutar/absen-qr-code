<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Presensi";
$_SESSION['page-url'] = "absen";
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

        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 shadow">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-borderless text-center">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mata Kuliah</th>
                        <th scope="col">Dosen Pengajar</th>
                        <th scope="col">Ruang Kelas</th>
                        <th scope="col">Waktu Pelajaran</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Tgl Masuk</th>
                        <th scope="col">Status Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (mysqli_num_rows($presensi) == 0) { ?>
                        <tr>
                          <th scope="row" colspan="6">Belum ada data absensi</th>
                        </tr>
                        <?php } else if (mysqli_num_rows($presensi) > 0) {
                        $no = 1;
                        while ($row_absen = mysqli_fetch_assoc($presensi)) { ?>
                          <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= $row_absen['nama_matakuliah'] ?></td>
                            <td><?= $row_absen['nama_dosen'] ?></td>
                            <td><?= $row_absen['ruang'] ?></td>
                            <td>Hari <?= $row_absen['hari'] ?><br><?= $row_absen['mulai'] . " - " . $row_absen['selesai'] ?></td>
                            <td><?= $row_absen['jam_masuk'] ?></td>
                            <td><?php $date = date_create($row_absen['tgl_masuk']);
                                echo date_format($date, 'l, d M Y'); ?></td>
                            <td><?= $row_absen['status'] ?></td>
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