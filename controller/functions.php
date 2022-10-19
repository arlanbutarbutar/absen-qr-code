<?php
if (!isset($_SESSION['data-user'])) {
  function masuk($data)
  {
    global $conn;
    $id = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nim-nidn']))));
    $password = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['password']))));
    if ($id != $password) {
      $_SESSION['message-danger'] = "Maaf, NIM/NIDN dan Password yang anda masukan belum sesuai.";
      $_SESSION['time-message'] = time();
      return false;
    }

    // check account
    $checkAccount1 = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen='$id'");
    if (mysqli_num_rows($checkAccount1) > 0) {
      $row = mysqli_fetch_assoc($checkAccount1);
      if ($row['nama_dosen'] == "admin") {
        $role = 1;
      } else {
        $rolw = 2;
      }
      $_SESSION['data-user'] = [
        'id' => $row['nidn_dosen'],
        'role' => $role,
        'username' => $row['nama_dosen'],
        'image' => $row['foto'],
      ];
    } else if (mysqli_num_rows($checkAccount1) == 0) {
      $checkAccount2 = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$id'");
      if (mysqli_num_rows($checkAccount2) > 0) {
        $row = mysqli_fetch_assoc($checkAccount2);
        $_SESSION['data-user'] = [
          'id' => $row['nidn_dosen'],
          'role' => 3,
          'username' => $row['nama_mhs'],
          'image' => 'user.png',
        ];
      } else if (mysqli_num_rows($checkAccount2) == 0) {
        $_SESSION['message-danger'] = "Maaf, NIM/NIDN yang anda masukan belum terdaftar.";
        $_SESSION['time-message'] = time();
        return false;
      }
    }
  }
}
if (isset($_SESSION['data-user'])) {
}
