<title><?php if (isset($_SESSION['page-name'])) {
          if ($_SESSION['page-name'] != "") {
            echo $_SESSION['page-name'] . " - ";
          }
        } ?>Absensi Teknik Elektro PNK</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?= $baseURL ?>assets/images/logo.png">

<!-- FontAwesome JS-->
<script defer src="<?= $baseURL ?>assets/js/all.min.js"></script>

<!-- App CSS -->
<link id="theme-style" rel="stylesheet" href="<?= $baseURL ?>assets/css/portal.css">

<script src="<?= $baseURL; ?>assets/sweetalert/dist/sweetalert2.all.min.js"></script>