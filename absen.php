<?php require_once("controller/script.php");
if (!isset($_GET['studyID'])) {
  header("Location: ./");
  exit();
} else if (isset($_GET['studyID'])) {
  if ($_GET['studyID'] == "") {
    header("Location: ./");
    exit();
  } else {
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
                <a href="#cari-mk" class="">
                  Cari MK
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="about_section layout_padding-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                About Our Apartment
              </h2>
            </div>
            <p>
              There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
              in
              some form, by injected humour, or randomised words
            </p>
            <a href="">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php require_once("resources/footer.php") ?>


</body>

</html>