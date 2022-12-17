<?php require_once("../controller/script.php");
require_once("redirect.php");
if ($_SESSION['data-user']['role'] == 3) {
  header("Location: absen");
  exit();
}
$_SESSION['page-name'] = "Cetak Laporan";
$_SESSION['page-url'] = "cetak-laporan";

$id_jadwal = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['id-jadwal']))));
$mk = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['mk']))));
$hari = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['hari']))));
$absen = mysqli_query($conn, "SELECT * FROM absen 
  JOIN jadwal ON absen.id_jadwal=jadwal.id_jadwal 
  JOIN mahasiswa ON absen.nim_mhs=mahasiswa.nim_mhs 
  JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk
  JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen
  JOIN kelas ON mahasiswa.id_kelas=kelas.id_kelas
  JOIN prodi ON kelas.id_prodi=prodi.id_prodi
  WHERE absen.id_jadwal='$id_jadwal'
");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $mk . " Hari " . $hari . ".xls");
?>

<center>
  <h3>Presensi Kehadiran Mata Kuliah <?= $mk ?></h3>
</center>
<table border="1">
  <thead>
    <tr align="center">
      <th>No</th>
      <th>NIM</th>
      <th>Mahasiswa</th>
      <th>Semester</th>
      <th>Prodi</th>
      <th>Jam Masuk</th>
      <th>Tgl Masuk</th>
      <th>Status Kehadiran</th>
      <th>Dosen Pengajar</th>
      <th>Ruang Kelas</th>
      <th>Waktu</th>
    </tr>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($absen) == 0) { ?>
      <tr>
        <th colspan="12">Belum ada mahasiswa yang mengisi absen</th>
      </tr>
      <?php } else if (mysqli_num_rows($absen) > 0) {
      $no = 1;
      while ($row = mysqli_fetch_assoc($absen)) { ?>
        <tr align="center">
          <td><?= $no ?></td>
          <td><?= $row['nim_mhs'] ?></td>
          <td><?= $row['nama_mhs'] ?></td>
          <td><?= $row['semester'] ?></td>
          <td><?= $row['nama_prodi'] ?></td>
          <td><?= $row['jam_masuk'] ?></td>
          <td><?php $date = date_create($row['tgl_masuk']);
              echo date_format($date, 'l, d M Y'); ?></td>
          <td><?= $row['status'] ?></td>
          <td><?= $row['nama_dosen'] ?></td>
          <td><?= $row['ruang'] ?></td>
          <td><?= $row['mulai'] . " - " . $row['selesai'] ?></td>
        </tr>
    <?php $no++;
      }
    } ?>
  </tbody>
</table>