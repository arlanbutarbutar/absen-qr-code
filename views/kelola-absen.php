<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Kelola Absen";
$_SESSION['page-url'] = "kelola-absen";
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
                  <table class="table table-striped table-borderless">
                    <thead class="text-center">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mata Kuliah</th>
                        <th scope="col">Hari</th>
                        <th scope="col" colspan="2">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (mysqli_num_rows($jadwalCheck) == 0) { ?>
                        <tr>
                          <th scope="row" colspan="4">Belum ada data mata kuliah di absen ini</th>
                        </tr>
                        <?php } else if (mysqli_num_rows($jadwalCheck) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($jadwalCheck)) { ?>
                          <tr>
                            <th scope="row"><?= $no ?></th>
                            <td><?= $row['nama_matakuliah'] ?></td>
                            <td><?= $row['hari'] . " (mulai jam " . $row['mulai'] . " - " . $row['selesai'] . ")" ?></td>
                            <td>
                              <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#lihat<?= $row['id_jadwal'] ?>">
                                Lihat Presensi Kehadiran
                              </button>
                              <div class="modal fade" id="lihat<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_matakuliah'] ?> Hari <?= $row['hari'] ?></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                      <div class="table-responsive">
                                        <table class="table table-striped table-borderless">
                                          <thead class="text-center">
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Nama Mahasiswa</th>
                                              <th scope="col">Jam Masuk</th>
                                              <th scope="col">Tgl Masuk</th>
                                              <th scope="col">Status Kehadiran</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php $id_jadwal = $row['id_jadwal'];
                                            $absen = mysqli_query($conn, "SELECT * FROM absen JOIN jadwal ON absen.id_jadwal=jadwal.id_jadwal JOIN mahasiswa ON absen.nim_mhs=mahasiswa.nim_mhs WHERE absen.id_jadwal='$id_jadwal'");
                                            if (mysqli_num_rows($absen) == 0) { ?>
                                              <tr>
                                                <th scope="row" colspan="5">Belum ada mahasiswa yang mengisi absen</th>
                                              </tr>
                                              <?php } else if (mysqli_num_rows($absen) > 0) {
                                              $no = 1;
                                              while ($row_absen = mysqli_fetch_assoc($absen)) { ?>
                                                <tr>
                                                  <th scope="row"><?= $no ?></th>
                                                  <td><?= $row_absen['nama_mhs'] ?></td>
                                                  <td><?= $row_absen['jam_masuk'] ?></td>
                                                  <td><?= $row_absen['tgl_masuk'] ?></td>
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
                            </td>
                            <td>
                              <form action="cetak-laporan" method="post">
                                <input type="hidden" name="id-jadwal" value="<?= $row['id_jadwal'] ?>">
                                <input type="hidden" name="mk" value="<?= $row['nama_matakuliah'] ?>">
                                <input type="hidden" name="hari" value="<?= $row['hari'] ?>">
                                <button type="submit" class="btn btn-success text-white">Cetak Laporan</button>
                              </form>
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