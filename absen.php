<?php require_once("controller/script.php");
if (!isset($_GET['studyID'])) {
  header("Location: ./");
  exit();
} else if (isset($_GET['studyID'])) {
  if ($_GET['studyID'] == "") {
    header("Location: ./");
    exit();
  } else {
    $idQR = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_GET['studyID']))));
    $qr_code = $idQR . ".jpg";
    $absen = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.qr_code='$qr_code'");
  }
}

$_SESSION['page-name'] = "Absen";
$_SESSION['page-url'] = "absen";
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
                <a href="#absen" class="">
                  Absen
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="about_section layout_padding-bottom" id="absen">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php foreach ($absen as $row) { ?>
            <div class="detail-box">
              <div class="heading_container mb-4">
                <h2>
                  Absen <?= $row['nama_matakuliah'] ?>
                </h2>
              </div>
              <form action="" method="post">
                <div class="form-group">
                  <label for="nim">NIM</label>
                  <input type="number" name="nim" class="form-control" id="nim" placeholder="NIM" required>
                </div>
                <input type="hidden" name="mk" value="<?= $row['nama_matakuliah'] ?>">
                <input type="hidden" name="id-jadwal" value="<?= $row['id_jadwal'] ?>">
                <input type="hidden" name="mulai" value="<?= $row['mulai'] ?>">
                <input type="hidden" name="selesai" value="<?= $row['selesai'] ?>">
                <input type="hidden" name="hari" value="<?= $row['hari'] ?>">
                <button type="submit" name="absen-hadir" class="btn btn-success">Hadir</button>
              </form>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>

  <?php require_once("resources/footer.php") ?>


</body>

</html>