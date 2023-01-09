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

        <h1 class="app-page-title"><?= $_SESSION['page-name'] ?></h1>

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

        <div class="row g-4">
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Dosen</h4>
                <div class="stats-figure"><?= $countDosen ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                <a class="app-card-link-mask" href="dosen"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->

          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Mahasiswa</h4>
                <div class="stats-figure"><?= $countMhs ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                <a class="app-card-link-mask" href="mahasiswa"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Mata Kuliah</h4>
                <div class="stats-figure"><?= $countMk ?></div>
              </div>
              <!--//app-card-body-->
              <a class="app-card-link-mask" href="mata-kuliah"></a>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
          <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow h-100">
              <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Absen</h4>
                <div class="stats-figure"><?= $countAbsen ?></div>
              </div>
              <!--//app-card-body-->
              <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                <a class="app-card-link-mask" href="kelola-absen"></a>
              <?php }
              if ($_SESSION['data-user']['role'] == 3) { ?>
                <a class="app-card-link-mask" href="absen"></a>
              <?php } ?>
            </div>
            <!--//app-card-->
          </div>
          <!--//col-->
        </div>
        <!--//row-->

        <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="card border-0 rounded-0 shadow mt-3">
                <div class="card-title">
                  <div class="row">
                    <div class="col-2">
                      <button type="button" class="btn btn-primary shadow rounded-0 text-white" data-bs-toggle="modal" data-bs-target="#Export">
                        Export
                      </button>
                      <div class="modal fade" id="Export" tabindex="-1" aria-labelledby="ExportLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content rounded-0 border-0 shadow">
                            <div class="modal-header border-bottom-0 shadow">
                              <h5 class="modal-title" id="ExportLabel">Export</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="cetak-verifikasi.php" method="post">
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Program Studi</label>
                                  <select name="id-prodi" class="form-select" aria-label="Default select example" required>
                                    <option selected value="">Pilih Program Studi</option>
                                    <?php foreach ($selectProdi as $data_prodi) : ?>
                                      <option value="<?= $data_prodi['id_prodi'] ?>"><?= $data_prodi['nama_prodi'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleFormControlInput1" class="form-label">Ketua Program Studi</label>
                                  <select name="kepro" class="form-select" aria-label="Default select example" required>
                                    <option selected value="">Pilih Ketua Program Studi</option>
                                    <?php foreach ($selectKaProdi as $data_kaprodi) : ?>
                                      <option value="<?= $data_kaprodi['nip_dosen'] ?>"><?= $data_kaprodi['nama_dosen'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                              <div class="modal-footer border-top-0 justify-content-center">
                                <button type="button" class="btn btn-secondary shadow rounded-0 text-white" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="export-value" class="btn btn-primary shadow rounded-0 text-white">Export</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- <button type="button" onclick="window.location.href='cetak-verifikasi'" class="btn btn-primary shadow rounded-0 text-white">Export</button> -->
                    </div>
                    <div class="col-10">
                      <h4 class="mt-3">REALISASI PENGAJARAN DAN VERIFIKASI MATERI KULIAH</h4>
                      <p>Status Pertemuan: a.Sesuai Jadwal, b. Pertukaran, c. Tambahan (dilingkar)*</p>
                    </div>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-striped table-sm table-hover text-center table-bordered">
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
                      if (mysqli_num_rows($verifikasi_mk) == 0) { ?>
                        <tr>
                          <th scope="row" colspan="12">belum ada data</th>
                        </tr>
                      <?php } else if (mysqli_num_rows($verifikasi_mk) > 0) {
                      ?>
                        <tr>
                          <th scope="row">Senin</th>
                          <?php $senin = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal WHERE jadwal.hari='Senin'");
                          if (mysqli_num_rows($senin) > 0) {
                            $row_senin = mysqli_fetch_assoc($senin); ?>
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
                          <?php 
                          } ?>
                        </tr>
                        <tr>
                          <th scope="row">Selasa</th>
                          <?php $selasa = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal WHERE jadwal.hari='Selasa'");
                          if (mysqli_num_rows($selasa) > 0) {
                            $row_selasa = mysqli_fetch_assoc($selasa); ?>
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
                          <?php 
                          } ?>
                        </tr>
                        <tr>
                          <th scope="row">Rabu</th>
                          <?php $Rabu = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal WHERE jadwal.hari='Rabu'");
                          if (mysqli_num_rows($Rabu) > 0) {
                            $row_Rabu = mysqli_fetch_assoc($Rabu); ?>
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
                          <?php 
                          } ?>
                        </tr>
                        <tr>
                          <th scope="row">Kamis</th>
                          <?php $kamis = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal WHERE jadwal.hari='Kamis'");
                          if (mysqli_num_rows($kamis) > 0) {
                            $row_Kamis = mysqli_fetch_assoc($kamis); ?>
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
                          <?php 
                          } ?>
                        </tr>
                        <tr>
                          <th scope="row">Jumat</th>
                          <?php $Jumat = mysqli_query($conn, "SELECT * FROM jadwal JOIN absen ON jadwal.id_jadwal=absen.id_jadwal WHERE jadwal.hari='Jumat'");
                          if (mysqli_num_rows($Jumat) > 0) {
                            $row_Jumat = mysqli_fetch_assoc($Jumat); ?>
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
                          <?php 
                          } ?>
                        </tr>
                        <tr>
                          <td colspan="9" style="border-bottom: 0;"></td>
                          <td colspan="3" style="text-align: left;">Direkap: Admin<br>Tanggal:<br><br><?= $_SESSION['data-user']['username'] ?></td>
                        </tr>
                        <tr>
                          <td colspan="9"></td>
                          <td colspan="3" style="text-align: left;">Diverifikasi dan Disetujui Ka. Prodi _____________<br><br>
                            _________</td>
                        </tr>
                      <?php $no++;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-content-->

    <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>