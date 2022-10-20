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
        $role = 2;
      }
      $_SESSION['data-user'] = [
        'id' => $row['nidn_dosen'],
        'role' => $role,
        'username' => $row['nama_dosen'],
      ];
    } else if (mysqli_num_rows($checkAccount1) == 0) {
      $checkAccount2 = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$id'");
      if (mysqli_num_rows($checkAccount2) > 0) {
        $row = mysqli_fetch_assoc($checkAccount2);
        $_SESSION['data-user'] = [
          'id' => $row['nim_mhs'],
          'role' => 3,
          'username' => $row['nama_mhs'],
        ];
      } else if (mysqli_num_rows($checkAccount2) == 0) {
        $_SESSION['message-danger'] = "Maaf, NIM/NIDN yang anda masukan belum terdaftar.";
        $_SESSION['time-message'] = time();
        return false;
      }
    }
  }
  function absen_hadir($data)
  {
    global $conn, $time;
    $nim = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nim']))));
    $id_jadwal = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-jadwal']))));
    $checkNIM = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$nim'");
    if (mysqli_num_rows($checkNIM) == 0) {
      $_SESSION['message-danger'] = "Maaf, NIM yang anda masukan belum terdaftar.";
      $_SESSION['time-message'] = time();
      return false;
    }
    $date = date('Y-m-d');
    $checkWaktu = mysqli_query($conn, "SELECT * FROM absen WHERE nim_mhs='$nim' AND tgl_masuk='$date'");
    if (mysqli_num_rows($checkWaktu) > 0) {
      $_SESSION['message-danger'] = "Maaf, anda sudah melakukan absensi sebelumnya.";
      $_SESSION['time-message'] = time();
      return false;
    }
    $mulai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['mulai']))));
    $selesai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['selesai']))));
    if ("0" . $time < $mulai) {
      $_SESSION['message-danger'] = "Maaf, jam pelajaran belum dimulai.";
      $_SESSION['time-message'] = time();
      return false;
    }
    if ("0" . $time > $selesai) {
      $status = "Alpha";
      $_SESSION['message-warning'] = "Maaf, jam pelajaran telah selesai dan anda dinyatakan alpha.";
      $_SESSION['time-message'] = time();
    } else if ("0" . $time <= $selesai) {
      $status = "Hadir";
      $_SESSION['message-success'] = "Anda telah dinyatakan hadir pada mata kuliah " . $data['mk'] . ".";
      $_SESSION['time-message'] = time();
    }
    mysqli_query($conn, "INSERT INTO absen(id_jadwal,nim_mhs,status) VALUES('$id_jadwal','$nim','$status')");
    return mysqli_affected_rows($conn);
  }
}
if (isset($_SESSION['data-user'])) {
  if ($_SESSION['data-user']['role'] <= 2) {
    function ubah_profil_dosen($data)
    {
      global $conn;
      $nidn = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidn']))));
      $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
      $jk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['jk']))));
      mysqli_query($conn, "UPDATE dosen SET nama_dosen='$nama', jenis_kelamin='$jk' WHERE nidn_dosen='$nidn'");
      return mysqli_affected_rows($conn);
    }
    function ubah_presensi($data)
    {
      global $conn;
      $id_absen = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-absen']))));
      $status = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['status']))));
      mysqli_query($conn, "UPDATE absen SET status='$status' WHERE id_absen='$id_absen'");
      return mysqli_affected_rows($conn);
    }

    if ($_SESSION['data-user']['role'] == 1) {
      function tambah_dosen($data)
      {
        global $conn;
        $nidn = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidn']))));
        $checkNIDN = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen='$nidn'");
        if (mysqli_num_rows($checkNIDN) > 0) {
          $_SESSION['message-danger'] = "Maaf, NIDN yang anda masukan sudah terdaftar.";
          $_SESSION['time-message'] = time();
          return false;
        }
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $jk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['jk']))));
        $gelar = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['gelar']))));
        $jabatan = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['jabatan']))));
        mysqli_query($conn, "INSERT INTO dosen(nidn_dosen,nama_dosen,jenis_kelamin,gelar,jabatan) VALUES('$nidn','$nama','$jk','$gelar','$jabatan')");
        return mysqli_affected_rows($conn);
      }
      function ubah_dosen($data)
      {
        global $conn;
        $nidnOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidnOld']))));
        $nidn = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidn']))));
        if ($nidn != $nidnOld) {
          $checkNIDN = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn_dosen='$nidn'");
          if (mysqli_num_rows($checkNIDN) > 0) {
            $_SESSION['message-danger'] = "Maaf, NIDN yang anda masukan sudah terdaftar.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $jk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['jk']))));
        $gelar = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['gelar']))));
        $jabatan = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['jabatan']))));
        mysqli_query($conn, "UPDATE dosen SET nidn_dosen='$nidn', nama_dosen='$nama', jenis_kelamin='$jk', gelar='$gelar', jabatan='$jabatan' WHERE nidn_dosen='$nidnOld'");
        return mysqli_affected_rows($conn);
      }
      function hapus_dosen($data)
      {
        global $conn;
        $nidnOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidnOld']))));
        mysqli_query($conn, "DELETE FROM dosen WHERE nidn_dosen='$nidnOld'");
        return mysqli_affected_rows($conn);
      }
      function tambah_prodi($data)
      {
        global $conn;
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $checkNama = mysqli_query($conn, "SELECT * FROM prodi WHERE nama_prodi='$nama'");
        if (mysqli_num_rows($checkNama) > 0) {
          $_SESSION['message-danger'] = "Maaf, Nama yang anda masukan sudah ada.";
          $_SESSION['time-message'] = time();
          return false;
        }
        $fakultas = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['fakultas']))));
        mysqli_query($conn, "INSERT INTO prodi(id_fakultas,nama_prodi) VALUES('$fakultas','$nama')");
        return mysqli_affected_rows($conn);
      }
      function ubah_prodi($data)
      {
        global $conn;
        $id_prodi = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-prodi']))));
        $namaOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['namaOld']))));
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        if ($nama != $namaOld) {
          $checkNama = mysqli_query($conn, "SELECT * FROM prodi WHERE nama_prodi='$nama'");
          if (mysqli_num_rows($checkNama) > 0) {
            $_SESSION['message-danger'] = "Maaf, Nama yang anda masukan sudah ada.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
        $fakultas = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['fakultas']))));
        mysqli_query($conn, "UPDATE prodi SET id_fakultas='$fakultas', nama_prodi='$nama' WHERE id_prodi='$id_prodi'");
        return mysqli_affected_rows($conn);
      }
      function hapus_prodi($data)
      {
        global $conn;
        $id_prodi = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-prodi']))));
        mysqli_query($conn, "DELETE FROM prodi WHERE id_prodi='$id_prodi'");
        return mysqli_affected_rows($conn);
      }
      function tambah_fakultas($data)
      {
        global $conn;
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $checkNama = mysqli_query($conn, "SELECT * FROM fakultas WHERE nama_fakultas='$nama'");
        if (mysqli_num_rows($checkNama) > 0) {
          $_SESSION['message-danger'] = "Maaf, Nama yang anda masukan sudah ada.";
          $_SESSION['time-message'] = time();
          return false;
        }
        mysqli_query($conn, "INSERT INTO fakultas(nama_fakultas) VALUES('$nama')");
        return mysqli_affected_rows($conn);
      }
      function ubah_fakultas($data)
      {
        global $conn;
        $id_fakultas = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-fakultas']))));
        $namaOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['namaOld']))));
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        if ($nama != $namaOld) {
          $checkNama = mysqli_query($conn, "SELECT * FROM fakultas WHERE nama_fakultas='$nama'");
          if (mysqli_num_rows($checkNama) > 0) {
            $_SESSION['message-danger'] = "Maaf, Nama yang anda masukan sudah ada.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
        mysqli_query($conn, "UPDATE fakultas SET nama_fakultas='$nama' WHERE id_fakultas='$id_fakultas'");
        return mysqli_affected_rows($conn);
      }
      function hapus_fakultas($data)
      {
        global $conn;
        $id_fakultas = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-fakultas']))));
        mysqli_query($conn, "DELETE FROM fakultas WHERE id_fakultas='$id_fakultas'");
        return mysqli_affected_rows($conn);
      }
      function tambah_mahasiswa($data)
      {
        global $conn;
        $nim = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nim']))));
        $checkNIM = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$nim'");
        if (mysqli_num_rows($checkNIM) > 0) {
          $_SESSION['message-danger'] = "Maaf, NIM yang anda masukan sudah ada.";
          $_SESSION['time-message'] = time();
          return false;
        }
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $tempat_lahir = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tempat-lahir']))));
        $tgl = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tgl-lahir']))));
        $agama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['agama']))));
        $alamat = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['alamat']))));
        $no_hp = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['no-hp']))));
        $prodi = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['prodi']))));
        mysqli_query($conn, "INSERT INTO mahasiswa(nim_mhs,id_prodi,nama_mhs,tempat_lahir,tanggal_lahir,agama,alamat,no_hp) VALUES('$nim','$prodi','$nama','$tempat_lahir','$tgl','$agama','$alamat','$no_hp')");
        return mysqli_affected_rows($conn);
      }
      function ubah_mahasiswa($data)
      {
        global $conn;
        $nimOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nimOld']))));
        $nim = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nim']))));
        if ($nim != $nimOld) {
          $checkNIM = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim_mhs='$nim'");
          if (mysqli_num_rows($checkNIM) > 0) {
            $_SESSION['message-danger'] = "Maaf, NIM yang anda masukan sudah ada.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $tempat_lahir = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tempat-lahir']))));
        $tgl = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tgl-lahir']))));
        $agama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['agama']))));
        $alamat = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['alamat']))));
        $no_hp = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['no-hp']))));
        $prodi = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['prodi']))));
        mysqli_query($conn, "UPDATE mahasiswa SET nim_mhs='$nim', id_prodi='$prodi', nama_mhs='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tgl', agama='$agama', alamat='$alamat', no_hp='$no_hp' WHERE nim_mhs='$nimOld'");
        return mysqli_affected_rows($conn);
      }
      function hapus_mahasiswa($data)
      {
        global $conn;
        $nimOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nimOld']))));
        $checkAbsen = mysqli_query($conn, "SELECT * FROM absen WHERE nim_mhs='$nimOld'");
        if (mysqli_num_rows($checkAbsen) > 0) {
          mysqli_query($conn, "DELETE FROM absen WHERE nim_mhs='$nimOld'");
        }
        mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim_mhs='$nimOld'");
        return mysqli_affected_rows($conn);
      }
      function tambah_mk($data)
      {
        global $conn;
        $nidn = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidn']))));
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        $checkNama = mysqli_query($conn, "SELECT * FROM mata_kuliah WHERE nama_matakuliah='$nama'");
        if (mysqli_num_rows($checkNama) > 0) {
          $_SESSION['message-danger'] = "Maaf, Mata Kuliah yang anda masukan sudah ada.";
          $_SESSION['time-message'] = time();
          return false;
        }
        $sks = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['sks']))));
        mysqli_query($conn, "INSERT INTO mata_kuliah(nidn_dosen,nama_matakuliah,sks) VALUES('$nidn','$nama','$sks')");
        return mysqli_affected_rows($conn);
      }
      function ubah_mk($data)
      {
        global $conn;
        $id_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-mk']))));
        $nidn = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nidn']))));
        $namaOld = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['namaOld']))));
        $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
        if ($nama != $namaOld) {
          $checkNama = mysqli_query($conn, "SELECT * FROM mata_kulaih WHERE nama_matakuliah='$nama'");
          if (mysqli_num_rows($checkNama) > 0) {
            $_SESSION['message-danger'] = "Maaf, Mata Kuliah yang anda masukan sudah ada.";
            $_SESSION['time-message'] = time();
            return false;
          }
        }
        $sks = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['sks']))));
        mysqli_query($conn, "UPDATE mata_kuliah SET nidn_dosen='$nidn', nama_matakuliah='$nama', sks='$sks' WHERE id_mk='$id_mk'");
        return mysqli_affected_rows($conn);
      }
      function hapus_mk($data)
      {
        global $conn;
        $id_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-mk']))));
        $checkJadwal = mysqli_query($conn, "SELECT * FROM jadwal WHERE id_mk='$id_mk'");
        if (mysqli_num_rows($checkJadwal) > 0) {
          $row = mysqli_fetch_assoc($checkJadwal);
          $id_jadwal = $row['id_jadwal'];
          $checkAbsen = mysqli_query($conn, "SELECT * FROM absen WHERE id_jadwal='$id_jadwal'");
          if (mysqli_num_rows($checkAbsen) > 0) {
            mysqli_query($conn, "DELETE FROM absen WHERE id_jadwal='$id_jadwal'");
            mysqli_query($conn, "DELETE FROM jadwal WHERE id_mk='$id_mk'");
          }
        }
        mysqli_query($conn, "DELETE FROM mata_kuliah WHERE id_mk='$id_mk'");
        return mysqli_affected_rows($conn);
      }
      function qrcode($data_encrypt)
      {
        global $baseURL;
        require_once('../assets/phpqrcode/qrlib.php');
        $qrvalue = $baseURL . 'absen?studyID=' . $data_encrypt;
        $tempDir = "../assets/images/qrcode/";
        $codeContents = $qrvalue;
        $fileName = $data_encrypt . ".jpg";
        $pngAbsoluteFilePath = $tempDir . $fileName;
        if (!file_exists($pngAbsoluteFilePath)) {
          QRcode::png($codeContents, $pngAbsoluteFilePath);
        }
        return $fileName;
      }
      function tambah_jadwal($data)
      {
        global $conn;
        $id_mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-mk']))));
        $hari = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['hari']))));
        $ruang = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['ruang']))));
        $mulai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['mulai']))));
        $selesai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['selesai']))));
        $data_encrypt = mt_rand(1000, 9999);
        $qrcode = qrcode($data_encrypt);
        mysqli_query($conn, "INSERT INTO jadwal(id_mk,hari,ruang,mulai,selesai,qr_code) VALUES('$id_mk','$hari','$ruang','$mulai','$selesai','$qrcode')");
        return mysqli_affected_rows($conn);
      }
      function ubah_jadwal($data)
      {
        global $conn;
        $id_jadwal = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-jadwal']))));
        $hari = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['hari']))));
        $ruang = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['ruang']))));
        $mulai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['mulai']))));
        $selesai = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['selesai']))));
        mysqli_query($conn, "UPDATE jadwal SET hari='$hari', ruang='$ruang', mulai='$mulai', selesai='$selesai' WHERE id_jadwal='$id_jadwal'");
        return mysqli_affected_rows($conn);
      }
      function hapus_jadwal($data)
      {
        global $conn;
        $id_jadwal = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id-jadwal']))));
        $qrcode = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['qrcode']))));
        $checkAbsen = mysqli_query($conn, "SELECT * FROM absen WHERE id_jadwal='$id_jadwal'");
        if (mysqli_num_rows($checkAbsen) > 0) {
          mysqli_query($conn, "DELETE FROM absen WHERE id_jadwal='$id_jadwal'");
        }
        unlink('../assets/images/qrcode/' . $qrcode);
        mysqli_query($conn, "DELETE FROM jadwal WHERE id_jadwal='$id_jadwal'");
        return mysqli_affected_rows($conn);
      }
    }
  }

  if ($_SESSION['data-user']['role'] == 3) {
    function ubah_profil_mhs($data)
    {
      global $conn;
      $nim = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nim']))));
      $nama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['nama']))));
      $tempat = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tempat-lahir']))));
      $tgl = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['tgl-lahir']))));
      $agama = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['agama']))));
      $alamat = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['alamat']))));
      $no_hp = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['no-hp']))));
      mysqli_query($conn, "UPDATE mahasiswa SET nama_mhs='$nama', tempat_lahir='$tempat', tanggal_lahir='$tgl', agama='$agama', alamat='$alamat', no_hp='$no_hp' WHERE nim_mhs='$nim'");
      return mysqli_affected_rows($conn);
    }
  }
}
