<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Profil";
$_SESSION['page-url'] = "profil";
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

        <?php foreach ($profil as $row) : ?>
          <div class="row flex-row-reverse">
            <div class="col-lg-4">
              <div class="card shadow border-0">
                <div class="card-body text-center">
                  <h4>Ubah Data Pribadi</h4>
                  <form action="" method="post">
                    <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                      <div class="mb-3 mt-4">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" value="<?= $row['nama_dosen'] ?>" class="form-control" id="nama" placeholder="Nama" required>
                      </div>
                      <div class="mb-3">
                        <label for="jenis-kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jk" class="form-select" aria-label="Default select example" required>
                          <option selected value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-Laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                      <input type="hidden" name="nidn" value="<?= $row['nip_dosen'] ?>">
                      <button type="submit" name="ubah-profil-dosen" class="btn btn-primary text-white">Ubah</button>
                    <?php }
                    if ($_SESSION['data-user']['role'] == 3) { ?>
                      <div class="mb-3 mt-4">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" value="<?= $row['nama_mhs'] ?>" class="form-control" id="nama" placeholder="Nama" required>
                      </div>
                      <div class="mb-3">
                        <label for="tempat-lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat-lahir" value="<?= $row['tempat_lahir'] ?>" class="form-control" id="tempat-lahir" placeholder="Tempat Lahir">
                      </div>
                      <div class="mb-3">
                        <label for="tgl-lahir" class="form-label">Tgl Lahir</label>
                        <input type="date" name="tgl-lahir" value="<?= $row['tanggal_lahir'] ?>" class="form-control" id="tgl-lahir" placeholder="Tgl Lahir">
                      </div>
                      <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" class="form-select" aria-label="Default select example" required>
                          <option selected value="">Pilih Agama</option>
                          <option value="Islam">Islam</option>
                          <option value="Kristen Protestan">Kristen Protestan</option>
                          <option value="Kristen Katolik">Kristen Katolik</option>
                          <option value="Hindu">Hindu</option>
                          <option value="Buddha">Buddha</option>
                          <option value="Konghucu">Konghucu</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" value="<?= $row['alamat'] ?>" class="form-control" id="alamat" placeholder="Alamat">
                      </div>
                      <div class="mb-3">
                        <label for="no-hp" class="form-label">No. Handphone</label>
                        <input type="number" name="no-hp" value="<?= $row['no_hp'] ?>" class="form-control" id="no-hp" placeholder="No. Handphone">
                      </div>
                      <input type="hidden" name="nim" value="<?= $row['nim_mhs'] ?>">
                      <button type="submit" name="ubah-profil-mhs" class="btn btn-primary text-white">Ubah</button>
                    <?php } ?>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card shadow border-0">
                <div class="card-body">
                  <h4>Data Profil Saya</h4>
                  <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                    <table class="table table-sm table-borderless">
                      <tbody>
                        <tr>
                          <th scope="row">NIP</th>
                          <td>:</td>
                          <td style="width: 450px;"><?= $row['nip_dosen'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Nama</th>
                          <td>:</td>
                          <td><?= $row['nama_dosen'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Jenis Kelamin</th>
                          <td>:</td>
                          <td><?= $row['jenis_kelamin'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Gelar</th>
                          <td>:</td>
                          <td><?= $row['gelar'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Jabatan</th>
                          <td>:</td>
                          <td><?= $row['jabatan'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  <?php }
                  if ($_SESSION['data-user']['role'] == 3) { ?>
                    <table class="table table-sm table-borderless">
                      <tbody>
                        <tr>
                          <th scope="row">NIM</th>
                          <td>:</td>
                          <td style="width: 450px;"><?= $row['nim_mhs'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Nama</th>
                          <td>:</td>
                          <td><?= $row['nama_mhs'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">TTL</th>
                          <td>:</td>
                          <?php $date = date_create($row['tanggal_lahir']);
                          $date = date_format($date, 'd M Y'); ?>
                          <td><?= $row['tempat_lahir'] . ", " . $date ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Agama</th>
                          <td>:</td>
                          <td><?= $row['agama'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">No. Handphone</th>
                          <td>:</td>
                          <td><?= $row['no_hp'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Program Studi</th>
                          <td>:</td>
                          <td><?= $row['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Fakultas</th>
                          <td>:</td>
                          <td><?= $row['nama_fakultas'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->


    <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>