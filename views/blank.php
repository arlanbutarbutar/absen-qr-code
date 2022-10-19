<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "";
$_SESSION['page-url'] = "";
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

        <!-- code -->

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->


  <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>