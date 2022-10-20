<?php require_once("../controller/script.php");
require_once("redirect.php");
if (!isset($_SESSION['jadwal'])) {
  header("Location: mata-kuliah");
  exit();
}

$_SESSION['page-name'] = "Jadwal";
$_SESSION['page-url'] = "jadwal";
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
        <p><a href="mata-kuliah" class="btn btn-primary btn-sm text-white">kembali</a></p>

        <div class="row g-4">
          <?php if ($_SESSION['data-user']['role'] == 1) { ?>
            <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
              <div class="app-card app-card-doc shadow-sm h-100">
                <div class="app-card-thumb-holder p-5 h-100">
                  <span class="icon-holder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>
                  </span>
                  <a class="app-card-link-mask" href="#" data-bs-toggle="modal" data-bs-target="#tambah"></a>
                  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                          <div class="modal-body text-center">
                            <div class="mb-3">
                              <label for="nama" class="form-label">Mata Kuliah</label>
                              <input type="text" value="<?= $_SESSION['jadwal']['nama-mk'] ?>" class="form-control" id="nama" placeholder="Mata Kuliah" readonly>
                            </div>
                            <div class="mb-3">
                              <label for="hari" class="form-label">Hari</label>
                              <select name="hari" class="form-select" id="hari" aria-label="Default select example" required>
                                <option selected value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                              </select>
                            </div>
                            <div class="mb-3">
                              <label for="ruang" class="form-label">Ruang Kelas</label>
                              <input type="text" name="ruang" class="form-control" id="ruang" placeholder="Ruang Kelas" required>
                            </div>
                            <div class="mb-3">
                              <label for="mulai" class="form-label">Mulai</label>
                              <input type="time" name="mulai" class="form-control" id="mulai" placeholder="Mulai" required>
                            </div>
                            <div class="mb-3">
                              <label for="selesai" class="form-label">Selesai</label>
                              <input type="time" name="selesai" class="form-control" id="selesai" placeholder="Selesai" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                            <input type="hidden" name="id-mk" value="<?= $id_mk ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="tambah-jadwal" class="btn btn-primary">Tambah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php }
          if (mysqli_num_rows($jadwal) > 0) {
            while ($row = mysqli_fetch_assoc($jadwal)) { ?>
              <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                <div class="app-card app-card-doc shadow-sm h-100">
                  <div class="app-card-thumb-holder" style="height: 240px;max-height: 65%;">
                    <img src="../assets/images/qrcode/<?= $row['qr_code'] ?>" style="width: 100%;" alt="">
                  </div>
                  <div class="app-card-body p-3 has-card-actions">

                    <h4 class="app-doc-title truncate mb-0"><?= $row['nama_matakuliah'] ?></h4>
                    <div class="app-doc-meta">
                      <ul class="list-unstyled mb-0">
                        <li><span class="text-muted">Hari:</span> <?= $row['hari'] ?></li>
                        <li><span class="text-muted">Ruang Kelas:</span> <?= $row['ruang'] ?></li>
                        <li><span class="text-muted">Mulai:</span> <?= $row['mulai'] ?></li>
                        <li><span class="text-muted">Selesai:</span> <?= $row['selesai'] ?></li>
                        <li><span class="text-muted">Dosen:</span> <?= $row['nama_dosen'] ?></li>
                      </ul>
                    </div>
                    <!--//app-doc-meta-->

                    <div class="app-card-actions">
                      <div class="dropdown">
                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                          </svg>
                        </div>
                        <!--//dropdown-toggle-->
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#jadwal<?= $row['id_jadwal'] ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-qr-code me-2" viewBox="0 0 16 16">
                                <path d="M2 2h2v2H2V2Z" />
                                <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                                <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                                <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                                <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                              </svg>
                              Lihat QR Code
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['id_jadwal'] ?>">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                              </svg>
                              Ubah Data
                            </a>
                          </li>
                          <!-- <li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="window.open('https://api.whatsapp.com/send?text=Absensi Mata Kuliah <?= $row['nama_matakuliah'] ?> pada hari <?= $row['hari'] ?> mulai jam <?= $row['mulai'] ?> sampai jam <?= $row['selesai'] ?> <?= $baseURL ?>/absen?studyID=<?= $string ?>', '_blank', 'width=600,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');">
                              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-share-fill me-2" viewBox="0 0 16 16">
                                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                              </svg>
                              Bagikan
                            </a>
                          </li> -->
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_jadwal'] ?>">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                              </svg>
                              Delete
                            </a>
                          </li>
                        </ul>
                      </div>
                      <!--//dropdown-->
                    </div>
                    <!--//app-card-actions-->

                  </div>
                  <!--//app-card-body-->

                  <div class="modal fade" id="jadwal<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_matakuliah'] ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                          <img src="../assets/images/qrcode/<?= $row['qr_code'] ?>" style="width: 100%;" alt="">
                          <small><?php
                                  $string = $row['qr_code'];
                                  $string = preg_replace("/[^0-9]/", "", $string);
                                  echo $baseURL . "absen?studyID=" . $string;
                                  ?></small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="ubah<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_matakuliah'] ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                          <div class="modal-body text-center">
                            <div class="mb-3">
                              <label for="nama" class="form-label">Mata Kuliah</label>
                              <input type="text" value="<?= $_SESSION['jadwal']['nama-mk'] ?>" class="form-control" id="nama" placeholder="Mata Kuliah" readonly>
                            </div>
                            <div class="mb-3">
                              <label for="hari" class="form-label">Hari</label>
                              <select name="hari" class="form-select" id="hari" aria-label="Default select example" required>
                                <option selected value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                              </select>
                            </div>
                            <div class="mb-3">
                              <label for="ruang" class="form-label">Ruang Kelas</label>
                              <input type="text" name="ruang" value="<?= $row['ruang'] ?>" class="form-control" id="ruang" placeholder="Ruang Kelas" required>
                            </div>
                            <div class="mb-3">
                              <label for="mulai" class="form-label">Mulai</label>
                              <input type="time" name="mulai" value="<?= $row['mulai'] ?>" class="form-control" id="mulai" placeholder="Mulai" required>
                            </div>
                            <div class="mb-3">
                              <label for="selesai" class="form-label">Selesai</label>
                              <input type="time" name="selesai" value="<?= $row['selesai'] ?>" class="form-control" id="selesai" placeholder="Selesai" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center">
                            <input type="hidden" name="id-jadwal" value="<?= $row['id_jadwal'] ?>">
                            <input type="hidden" name="namaOld" value="<?= $row['nama_matakuliah'] ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="ubah-jadwal" class="btn btn-warning">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="hapus<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_matakuliah'] ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                          <div class="modal-body text-center">
                            Anda yakin ingin menghapus jadwal <?= $row['nama_matakuliah'] ?> hari <?= $row['hari'] ?>?
                          </div>
                          <div class="modal-footer justify-content-center">
                            <input type="hidden" name="id-jadwal" value="<?= $row['id_jadwal'] ?>">
                            <input type="hidden" name="namaOld" value="<?= $row['nama_matakuliah'] ?>">
                            <input type="hidden" name="qrcode" value="<?= $row['qr_code'] ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="hapus-jadwal" class="btn btn-danger">Hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
                <!--//app-card-->
              </div>
          <?php }
          } ?>
          <!--//col-->
        </div>

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->


    <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>