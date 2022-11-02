<?php require_once("../controller/script.php");
if (isset($_SESSION['data-user'])) {
  header("Location: ../views/");
  exit();
}

$_SESSION['page-name'] = "Masuk";
$_SESSION['page-url'] = "masuk";
$_SESSION['actual-link'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/header-auth.php") ?></head>

<body class="app app-signup p-0">
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
  <div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
      <div class="d-flex flex-column align-content-end">
        <div class="app-auth-body mx-auto">
          <div class="app-auth-branding mb-4"><a class="app-logo" href="../"><img class="logo-icon me-2" src="../assets/images/logo.png" alt="logo"></a></div>
          <h2 class="auth-heading text-center mb-4">Masuk</h2>
          <div class="auth-form-container text-start mx-auto">
            <form class="auth-form auth-signup-form" method="POST">
              <div class="mb-3">
                <label class="sr-only" for="nim-nidn">NIM/NIP</label>
                <input id="nim-nidn" name="nim-nidn" type="number" class="form-control signup-name" placeholder="NIM/NIDN" required>
              </div>
              <div class="mb-3">
                <label class="sr-only" for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control signup-name" placeholder="Password" required>
              </div>
              <div class="text-center">
                <button type="submit" name="masuk" class="btn app-btn-primary w-100 theme-btn mx-auto">Masuk</button>
              </div>
            </form>
          </div>
        </div>
        <?php require_once("../resources/footer-auth.php") ?>
</body>

</html>