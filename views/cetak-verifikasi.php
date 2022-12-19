<?php require_once("../controller/script.php");
require_once("redirect.php");
if ($_SESSION['data-user']['role'] == 3) {
  header("Location: absen");
  exit();
}
$_SESSION['page-name'] = "Cetak Verifikasi";
$_SESSION['page-url'] = "cetak-verifikasi";

$id_prodi = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['id-prodi']))));
$kepro = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $_POST['kepro']))));
$verifikasi_mkExport = mysqli_query($conn, "SELECT * FROM prodi WHERE prodi.id_prodi='$id_prodi'");
$dataAll = mysqli_fetch_assoc($verifikasi_mkExport);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Realisasi Pengajaran Dan Verifikasi Materi Kuliah.xls");
?>

<center>
  <h3>REALISASI PENGAJARAN DAN VERIFIKASI MATERI KULIAH</h3>
  <p>Status Pertemuan: a.Sesuai Jadwal, b. Pertukaran, c. Tambahan (dilingkar)*</p>
</center>
<table border="1" class="table table-striped table-sm table-hover text-center table-bordered">
  <thead>
    <tr>
      <th scope="col" rowspan="2">Hari</th>
      <th scope="col" rowspan="2">Tgl</th>
      <th scope="col" rowspan="2">Mata Kuliah Ke-</th>
      <th scope="col" rowspan="2">Mata Kuliah/Job</th>
      <th scope="col" rowspan="2">Jml. Jam</th>
      <th scope="col" rowspan="2">Pengajar/Dosen</th>
      <th scope="col" rowspan="2">Status Pertemuan</th>
      <th scope="col" rowspan="2">Materi Kuliah</th>
      <th scope="col" rowspan="2">Verifikasi Materi Kuliah (oleh Kaprodi)</th>
      <th scope="col" colspan="3">Paraf</th>
      <th scope="col">
    <tr>
      <th>Ketua Kelas</th>
      <th>PLP</th>
      <th>Dosen</th>
    </tr>
    </th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    if (mysqli_num_rows($verifikasi_mkExport) == 0) { ?>
      <tr>
        <th scope="row" colspan="12">belum ada data</th>
      </tr>
    <?php } else if (mysqli_num_rows($verifikasi_mkExport) > 0) {
    ?>
      <tr>
        <th scope="row">Senin</th>
        <?php $senin = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal JOIN kelas ON jadwal.id_kelas=kelas.id_kelas JOIN prodi ON kelas.id_prodi=prodi.id_prodi WHERE prodi.id_prodi='$id_prodi' AND jadwal.hari='Senin'");
        if (mysqli_num_rows($senin) > 0) {
          while ($row_senin = mysqli_fetch_assoc($senin)) { ?>
            <td>
              <?php $date = date_create($row_senin['tgl_masuk']);
              echo date_format($date, 'd M Y'); ?></td>
            <?php $hari_senin = $row_senin['hari'];
            $dataSenin = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_senin'");
            $dataNoSenin = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_senin'");
            $dataDosenSenin = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE jadwal.hari='$hari_senin'");
            $dataSPSenin = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_senin'");
            $dataVerSenin = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_senin'");
            if (mysqli_num_rows($dataSenin) > 0) {
            ?>
              <td><?php $mk_ke = 1;
                  while ($row_noSenin = mysqli_fetch_assoc($dataNoSenin)) {
                    echo $mk_ke . "<br>";
                    $mk_ke++;
                  } ?></td>
              <td><?php while ($row_senin = mysqli_fetch_assoc($dataSenin)) {
                    echo $row_senin['nama_matakuliah'] . "<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_dosenSenin = mysqli_fetch_assoc($dataDosenSenin)) {
                    echo $row_dosenSenin['nama_dosen'] . "<br>";
                  } ?></td>
              <td><?php while ($row_spSenin = mysqli_fetch_assoc($dataSPSenin)) {
                    echo "a / b / c<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_verSenin = mysqli_fetch_assoc($dataVerSenin)) {
                    echo "Sesuai / Tidak<br>";
                  } ?></td>
              <td></td>
              <td></td>
              <td></td>
            <?php
            } ?>
        <?php }
        } ?>
      </tr>
      <tr>
        <th scope="row">Selasa</th>
        <?php $selasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal JOIN kelas ON jadwal.id_kelas=kelas.id_kelas JOIN prodi ON kelas.id_prodi=prodi.id_prodi WHERE prodi.id_prodi='$id_prodi' AND jadwal.hari='Selasa'");
        if (mysqli_num_rows($selasa) > 0) {
          while ($row_selasa = mysqli_fetch_assoc($selasa)) { ?>
            <td>
              <?php $date = date_create($row_selasa['tgl_masuk']);
              echo date_format($date, 'd M Y'); ?></td>
            <?php $hari_selasa = $row_selasa['hari'];
            $dataSelasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_selasa'");
            $dataNoSelasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_selasa'");
            $dataDosenSelasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE jadwal.hari='$hari_selasa'");
            $dataSPSelasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_selasa'");
            $dataVerSelasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_selasa'");
            if (mysqli_num_rows($dataSelasa) > 0) {
            ?>
              <td><?php $mk_ke = 1;
                  while ($row_noSelasa = mysqli_fetch_assoc($dataNoSelasa)) {
                    echo $mk_ke . "<br>";
                    $mk_ke++;
                  } ?></td>
              <td><?php while ($row_selasa = mysqli_fetch_assoc($dataSelasa)) {
                    echo $row_selasa['nama_matakuliah'] . "<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_dosenSelasa = mysqli_fetch_assoc($dataDosenSelasa)) {
                    echo $row_dosenSelasa['nama_dosen'] . "<br>";
                  } ?></td>
              <td><?php while ($row_spSelasa = mysqli_fetch_assoc($dataSPSelasa)) {
                    echo "a / b / c<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_verSelasa = mysqli_fetch_assoc($dataVerSelasa)) {
                    echo "Sesuai / Tidak<br>";
                  } ?></td>
              <td></td>
              <td></td>
              <td></td>
            <?php
            } ?>
        <?php }
        } ?>
      </tr>
      <tr>
        <th scope="row">Rabu</th>
        <?php $Rabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal JOIN kelas ON jadwal.id_kelas=kelas.id_kelas JOIN prodi ON kelas.id_prodi=prodi.id_prodi WHERE prodi.id_prodi='$id_prodi' AND jadwal.hari='Rabu'");
        if (mysqli_num_rows($Rabu) > 0) {
          while ($row_Rabu = mysqli_fetch_assoc($Rabu)) { ?>
            <td>
              <?php $date = date_create($row_Rabu['tgl_masuk']);
              echo date_format($date, 'd M Y'); ?></td>
            <?php $hari_Rabu = $row_Rabu['hari'];
            $dataRabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Rabu'");
            $dataNoRabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Rabu'");
            $dataDosenRabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE jadwal.hari='$hari_Rabu'");
            $dataSPRabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Rabu'");
            $dataVerRabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Rabu'");
            if (mysqli_num_rows($dataRabu) > 0) {
            ?>
              <td><?php $mk_ke = 1;
                  while ($row_noRabu = mysqli_fetch_assoc($dataNoRabu)) {
                    echo $mk_ke . "<br>";
                    $mk_ke++;
                  } ?></td>
              <td><?php while ($row_Rabu = mysqli_fetch_assoc($dataRabu)) {
                    echo $row_Rabu['nama_matakuliah'] . "<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_dosenRabu = mysqli_fetch_assoc($dataDosenRabu)) {
                    echo $row_dosenRabu['nama_dosen'] . "<br>";
                  } ?></td>
              <td><?php while ($row_spRabu = mysqli_fetch_assoc($dataSPRabu)) {
                    echo "a / b / c<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_verRabu = mysqli_fetch_assoc($dataVerRabu)) {
                    echo "Sesuai / Tidak<br>";
                  } ?></td>
              <td></td>
              <td></td>
              <td></td>
            <?php
            } ?>
        <?php }
        } ?>
      </tr>
      <tr>
        <th scope="row">Kamis</th>
        <?php $kamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal JOIN kelas ON jadwal.id_kelas=kelas.id_kelas JOIN prodi ON kelas.id_prodi=prodi.id_prodi WHERE prodi.id_prodi='$id_prodi' AND jadwal.hari='Kamis'");
        if (mysqli_num_rows($kamis) > 0) {
          while ($row_Kamis = mysqli_fetch_assoc($kamis)) { ?>
            <td>
              <?php $date = date_create($row_Kamis['tgl_masuk']);
              echo date_format($date, 'd M Y'); ?></td>
            <?php $hari_Kamis = $row_Kamis['hari'];
            $dataKamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Kamis'");
            $dataNoKamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Kamis'");
            $dataDosenKamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE jadwal.hari='$hari_Kamis'");
            $dataSPKamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Kamis'");
            $dataVerKamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Kamis'");
            if (mysqli_num_rows($dataKamis) > 0) {
            ?>
              <td><?php $mk_ke = 1;
                  while ($row_noKamis = mysqli_fetch_assoc($dataNoKamis)) {
                    echo $mk_ke . "<br>";
                    $mk_ke++;
                  } ?></td>
              <td><?php while ($row_Kamis = mysqli_fetch_assoc($dataKamis)) {
                    echo $row_Kamis['nama_matakuliah'] . "<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_dosenKamis = mysqli_fetch_assoc($dataDosenKamis)) {
                    echo $row_dosenKamis['nama_dosen'] . "<br>";
                  } ?></td>
              <td><?php while ($row_spKamis = mysqli_fetch_assoc($dataSPKamis)) {
                    echo "a / b / c<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_verKamis = mysqli_fetch_assoc($dataVerKamis)) {
                    echo "Sesuai / Tidak<br>";
                  } ?></td>
              <td></td>
              <td></td>
              <td></td>
            <?php
            } ?>
        <?php }
        } ?>
      </tr>
      <tr>
        <th scope="row">Jumat</th>
        <?php $Jumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal JOIN kelas ON jadwal.id_kelas=kelas.id_kelas JOIN prodi ON kelas.id_prodi=prodi.id_prodi WHERE prodi.id_prodi='$id_prodi' AND jadwal.hari='Jumat'");
        if (mysqli_num_rows($Jumat) > 0) {
          while ($row_Jumat = mysqli_fetch_assoc($Jumat)) { ?>
            <td>
              <?php $date = date_create($row_Jumat['tgl_masuk']);
              echo date_format($date, 'd M Y'); ?></td>
            <?php $hari_Jumat = $row_Jumat['hari'];
            $dataJumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Jumat'");
            $dataNoJumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Jumat'");
            $dataDosenJumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE jadwal.hari='$hari_Jumat'");
            $dataSPJumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Jumat'");
            $dataVerJumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN mata_kuliah ON jadwal.id_mk=mata_kuliah.id_mk WHERE jadwal.hari='$hari_Jumat'");
            if (mysqli_num_rows($dataJumat) > 0) {
            ?>
              <td><?php $mk_ke = 1;
                  while ($row_noJumat = mysqli_fetch_assoc($dataNoJumat)) {
                    echo $mk_ke . "<br>";
                    $mk_ke++;
                  } ?></td>
              <td><?php while ($row_Jumat = mysqli_fetch_assoc($dataJumat)) {
                    echo $row_Jumat['nama_matakuliah'] . "<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_dosenJumat = mysqli_fetch_assoc($dataDosenJumat)) {
                    echo $row_dosenJumat['nama_dosen'] . "<br>";
                  } ?></td>
              <td><?php while ($row_spJumat = mysqli_fetch_assoc($dataSPJumat)) {
                    echo "a / b / c<br>";
                  } ?></td>
              <td></td>
              <td><?php while ($row_verJumat = mysqli_fetch_assoc($dataVerJumat)) {
                    echo "Sesuai / Tidak<br>";
                  } ?></td>
              <td></td>
              <td></td>
              <td></td>
            <?php
            } ?>
        <?php }
        } ?>
      </tr>
      <tr>
        <td colspan="9" style="border-bottom: 0;"></td>
        <td colspan="3" style="text-align: left;">Direkap: Admin<br>Tanggal:<br><br><?= $_SESSION['data-user']['username'] ?></td>
      </tr>
      <tr>
        <td colspan="9"></td>
        <td colspan="3" style="text-align: left;">Diverifikasi dan Disetujui Ka. Prodi D3 <?= $dataAll['nama_prodi'] ?><br><br>
          <?php $kaprodi = mysqli_query($conn, "SELECT * FROM dosen WHERE nip_dosen='$kepro'");
          if (mysqli_num_rows($kaprodi) > 0) {
            $row_kaprodi = mysqli_fetch_assoc($kaprodi);
            echo $row_kaprodi['nama_dosen'];
          } ?></td>
      </tr>
    <?php $no++;
    } ?>
  </tbody>
</table>