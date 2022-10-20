<?php
// error_reporting(~E_NOTICE & ~E_DEPRECATED);
if (!isset($_SESSION[''])) {
  session_start();
}
require_once("db_connect.php");
require_once("time.php");
require_once("functions.php");

// pagination now at role 3

if (isset($_SESSION['time-message'])) {
  if ((time() - $_SESSION['time-message']) > 2) {
    if (isset($_SESSION['message-success'])) {
      unset($_SESSION['message-success']);
    }
    if (isset($_SESSION['message-info'])) {
      unset($_SESSION['message-info']);
    }
    if (isset($_SESSION['message-warning'])) {
      unset($_SESSION['message-warning']);
    }
    if (isset($_SESSION['message-danger'])) {
      unset($_SESSION['message-danger']);
    }
    if (isset($_SESSION['message-dark'])) {
      unset($_SESSION['message-dark']);
    }
    unset($_SESSION['time-alert']);
  }
}

$baseURL = "https://$_SERVER[HTTP_HOST]/apps/absen-qr-code/";

if (!isset($_SESSION['data-user'])) {
  if (isset($_POST['masuk'])) {
    if (masuk($_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION['data-user'])) {
  $idUser = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_SESSION['data-user']['id']))));

  // ringkasan
  $count_dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen!='$idUser'");
  $countDosen = mysqli_num_rows($count_dosen);
  $count_mhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
  $countMhs = mysqli_num_rows($count_mhs);
  $count_mk = mysqli_query($conn, "SELECT * FROM mata_kuliah");
  $countMk = mysqli_num_rows($count_mk);
  $count_absen = mysqli_query($conn, "SELECT * FROM absen JOIN jadwal ON absen.id_jadwal=jadwal.id_jadwal");
  $countAbsen = mysqli_num_rows($count_absen);

  if ($_SESSION['data-user']['role'] <= 2) {
    // profil
    $profil = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen='$idUser'");
    if (isset($_POST['ubah-profil-dosen'])) {
      if (ubah_profil_dosen($_POST) > 0) {
        $_SESSION['message-success'] = "Profil berhasil di ubah.";
        $_SESSION['time-message'] = time();
        header("Location: " . $_SESSION['page-url']);
        exit();
      }
    }

    // mahasiswa
    $data_role2 = 25;
    $result_role2 = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen!='$idUser'");
    $total_role2 = mysqli_num_rows($result_role2);
    $total_page_role2 = ceil($total_role2 / $data_role2);
    $page_role2 = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $awal_data_role2 = ($page_role2 > 1) ? ($page_role2 * $data_role2) - $data_role2 : 0;
    $mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa 
      JOIN prodi ON mahasiswa.id_prodi=prodi.id_prodi 
      JOIN fakultas ON prodi.id_fakultas=fakultas.id_fakultas 
      ORDER BY mahasiswa.nim_mhs ASC LIMIT $awal_data_role2, $data_role2
    ");

    // select data
    $selectProdi = mysqli_query($conn, "SELECT * FROM prodi");
    $selectFakultas = mysqli_query($conn, "SELECT * FROM fakultas");

    // prodi/fakultas
    $prodi = mysqli_query($conn, "SELECT * FROM prodi JOIN fakultas ON prodi.id_fakultas=fakultas.id_fakultas ORDER BY prodi.id_prodi DESC");
    $fakultas = mysqli_query($conn, "SELECT * FROM fakultas ORDER BY id_fakultas DESC");

    // mata kuliah
    $selectDosen = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen!='$idUser'");
    $data_role3 = 25;
    $result_role3 = mysqli_query($conn, "SELECT * FROM mata_kuliah JOIN dosen ON mata_kuliah.nidn_dosen=dosen.nidn_dosen");
    $total_role3 = mysqli_num_rows($result_role3);
    $total_page_role3 = ceil($total_role3 / $data_role3);
    $page_role3 = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $awal_data_role3 = ($page_role3 > 1) ? ($page_role3 * $data_role3) - $data_role3 : 0;
    $mata_kuliah = mysqli_query($conn, "SELECT * FROM mata_kuliah 
      JOIN dosen ON mata_kuliah.nidn_dosen=dosen.nidn_dosen 
      ORDER BY mata_kuliah.id_mk DESC LIMIT $awal_data_role2, $data_role2
    ");

    // jadwal
    if (isset($_POST['buat-jadwal'])) {
      $id_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['id-mk']))));
      $nama_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['nama-mk']))));
      $_SESSION['jadwal'] = [
        'id-mk' => $id_mk,
        'nama-mk' => $nama_mk,
      ];
      header("Location: jadwal");
      exit();
    }
    if (isset($_SESSION['jadwal'])) {
      $id_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_SESSION['jadwal']['id-mk']))));
      $jadwal = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nidn_dosen=dosen.nidn_dosen WHERE jadwal.id_mk='$id_mk' ORDER BY jadwal.id_jadwal DESC");
    }

    // absen
    $jadwalCheck=mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk");

    if ($_SESSION['data-user']['role'] == 1) {
      // dosen
      $data_role1 = 25;
      $result_role1 = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen!='$idUser'");
      $total_role1 = mysqli_num_rows($result_role1);
      $total_page_role1 = ceil($total_role1 / $data_role1);
      $page_role1 = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
      $awal_data_role1 = ($page_role1 > 1) ? ($page_role1 * $data_role1) - $data_role1 : 0;
      $dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen!='$idUser' ORDER BY nidn_dosen ASC LIMIT $awal_data_role1, $data_role1");
      if (isset($_POST['tambah-dosen'])) {
        if (tambah_dosen($_POST) > 0) {
          $_SESSION['message-success'] = "Dosen baru berhasil di tambahkan.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['ubah-dosen'])) {
        if (ubah_dosen($_POST) > 0) {
          $_SESSION['message-success'] = "Dosen " . $_POST['namaOld'] . " berhasil di ubah.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['hapus-dosen'])) {
        if (hapus_dosen($_POST) > 0) {
          $_SESSION['message-success'] = "Dosen " . $_POST['namaOld'] . " berhasil di hapus.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }

      // prodi
      if (isset($_POST['tambah-prodi'])) {
        if (tambah_prodi($_POST) > 0) {
          $_SESSION['message-success'] = "Program Studi baru berhasil di tambahkan.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['ubah-prodi'])) {
        if (ubah_prodi($_POST) > 0) {
          $_SESSION['message-success'] = "Program Studi " . $_POST['namaOld'] . " berhasil di ubah.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['hapus-prodi'])) {
        if (hapus_prodi($_POST) > 0) {
          $_SESSION['message-success'] = "Program Studi " . $_POST['namaOld'] . " berhasil di hapus.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }

      // fakultas
      if (isset($_POST['tambah-fakultas'])) {
        if (tambah_fakultas($_POST) > 0) {
          $_SESSION['message-success'] = "Fakultas baru berhasil di tambahkan.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['ubah-fakultas'])) {
        if (ubah_fakultas($_POST) > 0) {
          $_SESSION['message-success'] = "Fakultas " . $_POST['namaOld'] . " berhasil di ubah.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['hapus-fakultas'])) {
        if (hapus_fakultas($_POST) > 0) {
          $_SESSION['message-success'] = "Fakultas " . $_POST['namaOld'] . " berhasil di hapus.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }

      // mahasiswa
      if (isset($_POST['tambah-mahasiswa'])) {
        if (tambah_mahasiswa($_POST) > 0) {
          $_SESSION['message-success'] = "Mahasiswa baru berhasil di tambahkan.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['ubah-mahasiswa'])) {
        if (ubah_mahasiswa($_POST) > 0) {
          $_SESSION['message-success'] = "Mahasiswa " . $_POST['namaOld'] . " berhasil di ubah.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['hapus-mahasiswa'])) {
        if (hapus_mahasiswa($_POST) > 0) {
          $_SESSION['message-success'] = "Mahasiswa " . $_POST['namaOld'] . " berhasil di hapus.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }

      // mata kuliah
      if (isset($_POST['tambah-mk'])) {
        if (tambah_mk($_POST) > 0) {
          $_SESSION['message-success'] = "Mata Kuliah baru berhasil di tambahkan.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['ubah-mk'])) {
        if (ubah_mk($_POST) > 0) {
          $_SESSION['message-success'] = "Mata Kuliah " . $_POST['namaOld'] . " berhasil di ubah.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }
      if (isset($_POST['hapus-mk'])) {
        if (hapus_mk($_POST) > 0) {
          $_SESSION['message-success'] = "Mata Kuliah " . $_POST['namaOld'] . " berhasil di hapus.";
          $_SESSION['time-message'] = time();
          header("Location: " . $_SESSION['page-url']);
          exit();
        }
      }

      // jadwal
      if (isset($_SESSION['jadwal'])) {
        if (isset($_POST['tambah-jadwal'])) {
          if (tambah_jadwal($_POST) > 0) {
            $_SESSION['message-success'] = "Jadwal baru berhasil di tambahkan.";
            $_SESSION['time-message'] = time();
            header("Location: " . $_SESSION['page-url']);
            exit();
          }
        }
        if (isset($_POST['ubah-jadwal'])) {
          if (ubah_jadwal($_POST) > 0) {
            $_SESSION['message-success'] = "Jadwal " . $_POST['namaOld'] . " berhasil di ubah.";
            $_SESSION['time-message'] = time();
            header("Location: " . $_SESSION['page-url']);
            exit();
          }
        }
        if (isset($_POST['hapus-jadwal'])) {
          if (hapus_jadwal($_POST) > 0) {
            $_SESSION['message-success'] = "Jadwal " . $_POST['namaOld'] . " berhasil di hapus.";
            $_SESSION['time-message'] = time();
            header("Location: " . $_SESSION['page-url']);
            exit();
          }
        }
      }

      // 
    }
  }

  if ($_SESSION['data-user']['role'] == 3) {
    $profil = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$idUser'");
    if (isset($_POST['ubah-profil-mhs'])) {
      if (ubah_profil_mhs($_POST) > 0) {
        $_SESSION['message-success'] = "Profil berhasil di ubah.";
        $_SESSION['time-message'] = time();
        header("Location: " . $_SESSION['page-url']);
        exit();
      }
    }
  }
}
