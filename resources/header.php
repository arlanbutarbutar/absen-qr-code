<!-- Basic -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!-- Site Metas -->
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<link rel="shortcut icon" href="assets/images/logo.png">

<title><?php if (isset($_SESSION['page-name'])) {
          if ($_SESSION['page-name'] != "") {
            echo $_SESSION['page-name'] . " - ";
          }
        } ?>Absensi Teknik Elektro PNK</title>

<!-- bootstrap core css -->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />

<!-- fonts style -->
<link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Raleway:400,700&display=swap" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/css/style.css" rel="stylesheet" />
<!-- responsive style -->
<link href="assets/css/responsive.css" rel="stylesheet" />

<script src="assets/sweetalert/dist/sweetalert2.all.min.js"></script>