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

        <h1 class="app-page-title">Ringkasan</h1>

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
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Dosen</h4>
                <div class="stats-figure"><?= $countDosen ?></div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="dosen"></a>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->

          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Mahasiswa</h4>
                <div class="stats-figure"><?= $countMhs?></div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="mahasiswa"></a>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Projects</h4>
                <div class="stats-figure">23</div>
                <div class="stats-meta">
                  Open</div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="#"></a>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Invoices</h4>
                <div class="stats-figure">6</div>
                <div class="stats-meta">New</div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="#"></a>
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