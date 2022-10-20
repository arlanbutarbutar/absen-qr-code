<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "";
$_SESSION['page-url'] = "./";
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

        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
          <div class="inner">
            <div class="app-card-body p-2">
              <h3 class="mb-3">Selamat datang, <?= $_SESSION['data-user']['username']; ?>!</h3>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <!--//app-card-body-->

          </div>
          <!--//inner-->
        </div>
        <!--//app-card-->

        <div class="row g-4 mb-4">
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Dosen</h4>
                <div class="stats-figure"><?= $countDosen ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                <a class="app-card-link-mask" href="dosen"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->

          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Mahasiswa</h4>
                <div class="stats-figure"><?= $countMhs ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                <a class="app-card-link-mask" href="mahasiswa"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Mata Kuliah</h4>
                <div class="stats-figure"><?= $countMk ?></div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="mata-kuliah"></a>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Absen</h4>
                <div class="stats-figure"><?= $countAbsen ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                <a class="app-card-link-mask" href="kelola-absen"></a>
              <?php }
              if ($_SESSION['data-user']['role'] == 3) { ?>
                <a class="app-card-link-mask" href="absen"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
        </div>
        <!--//row-->

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->

    <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>