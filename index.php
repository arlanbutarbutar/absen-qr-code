<?php require_once("controller/script.php");

$_SESSION['page-name'] = "";
$_SESSION['page-url'] = "./";
?>

<!DOCTYPE html>
<html style="scroll-behavior: smooth;">

<head><?php require_once("resources/header.php") ?></head>

<body>
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
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <?php require_once("resources/navbar.php") ?>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 offset-md-1">
            <div class="detail-box">
              <h1>
                <span>Politeknik</span> <br>
                Negeri<br>
                Kupang
              </h1>
              <p>
                Sistem absensi kehadiran mahasiswa/i dengan menggunakan QR Code.
              </p>
              <div class="btn-box">
                <a href="#cari-mk" class="">
                  Cari MK
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>

  <!-- find section -->
  <section class="find_section " id="cari-mk">
    <div class="container">
      <form action="" method="POST">
        <div class=" form-row">
          <div class="col-md-10">
            <input type="text" name="mk" class="form-control" placeholder="Cari Mata Kuliah" required>
          </div>
          <div class="col-md-2">
            <button type="submit" name="cari-mk" class="">
              cari
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- end find section -->


  <!-- about section -->
  <?php if (isset($_POST['cari-mk'])) {
    $mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['mk']))));
    $search_mk = mysqli_query($conn, "SELECT * FROM mata_kuliah JOIN jadwal ON mata_kuliah.id_mk=jadwal.id_mk WHERE mata_kuliah.nama_matakuliah LIKE '%$mk%'"); ?>
    <section class="about_section layout_padding-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 shadow">
              <div class="card-body">
                <?php if (mysqli_num_rows($search_mk) == 0) { ?>
                  <p>Absensi Mata Kuliah <?= $mk; ?> belum tersedia</p>
                  <?php } else if (mysqli_num_rows($search_mk) > 0) {
                  while ($row = mysqli_fetch_assoc($search_mk)) { ?>
                    <div class="d-flex justify-content-between mt-3">
                      <h6><?= $row['nama_matakuliah'] ?> (hari <?= $row['hari'] ?>)</h6>
                      <div class="qr-code">
                        <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#mk<?= $row['id_jadwal'] ?>">
                          QR Absen<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8zm-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5z" />
                          </svg>
                        </button>
                        <div class="modal fade" id="mk<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_matakuliah'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body text-center">
                                <img src="assets/images/qrcode/<?= $row['qr_code'] ?>" style="width: 100%;" alt="">
                                <small><?php
                                        $string = $row['qr_code'];
                                        $string = preg_replace("/[^0-9]/", "", $string);
                                        echo $baseURL . "absen?studyID=" . $string;
                                        ?></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php }
                } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>

  <!-- end about section -->



  <?php require_once("resources/footer.php") ?>


</body>

</html>