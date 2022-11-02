<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Mahasiswa";
$_SESSION['page-url'] = "mahasiswa";
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

        <div class="row">
          <?php if ($_SESSION['data-user']['role'] == 1) { ?>
            <div class="col-lg-4">
              <div class="card border-0 shadow">
                <div class="card-body text-center">
                  <h4>Tambah Mahasiswa</h4>
                  <form action="" method="post">
                    <div class="mb-3 mt-4">
                      <label for="nim" class="form-label">NIM</label>
                      <input type="number" name="nim" class="form-control" id="nim" placeholder="NIM" required>
                    </div>
                    <div class="mb-3 mt-4">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                    </div>
                    <div class="mb-3">
                      <label for="tempat-lahir" class="form-label">Tempat Lahir</label>
                      <input type="text" name="tempat-lahir" class="form-control" id="tempat-lahir" placeholder="Tempat Lahir" required>
                    </div>
                    <div class="mb-3">
                      <label for="tgl-lahir" class="form-label">Tgl Lahir</label>
                      <input type="date" name="tgl-lahir" class="form-control" id="tgl-lahir" placeholder="Tgl Lahir" required>
                    </div>
                    <div class="mb-3">
                      <label for="agama" class="form-label">Agama</label>
                      <select name="agama" class="form-select" aria-label="Default select example" required>
                        <option selected value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Kristen Katolik">Kristen Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" required>
                    </div>
                    <div class="mb-3">
                      <label for="no-hp" class="form-label">No. Handphone</label>
                      <input type="number" name="no-hp" class="form-control" id="no-hp" placeholder="No. Handphone" required>
                    </div>
                    <div class="mb-3">
                      <label for="prodi" class="form-label">Program Studi</label>
                      <select name="prodi" class="form-select" aria-label="Default select example" required>
                        <option selected value="">Pilih Program Studi</option>
                        <?php foreach ($prodi as $row_pro) : ?>
                          <option value="<?= $row_pro['id_prodi'] ?>"><?= $row_pro['nama_prodi'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <button type="submit" name="tambah-mahasiswa" class="btn btn-primary text-white">Tambah</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
            <?php }
          if ($_SESSION['data-user']['role'] == 2) { ?>
              <div class="col-lg-12">
              <?php } ?>
              <div class="card border-0 shadow">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-borderless text-center">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">NIM</th>
                          <th scope="col">Nama</th>
                          <th scope="col">TTL</th>
                          <th scope="col">Agama</th>
                          <th scope="col">Alamat</th>
                          <th scope="col">No. Handphone</th>
                          <th scope="col">Program Studi</th>
                          <th scope="col">Jurusan</th>
                          <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                            <th scope="col" colspan="2">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody id="search-data">
                        <?php if (mysqli_num_rows($mahasiswa) == 0) { ?>
                          <tr class="text-center">
                            <th scope="row" colspan="11">Belum ada data mahasiswa</th>
                          </tr>
                          <?php } else if (mysqli_num_rows($mahasiswa) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($mahasiswa)) { ?>
                            <tr>
                              <th scope="row"><?= $no; ?></th>
                              <td><?= $row['nim_mhs'] ?></td>
                              <td><?= $row['nama_mhs'] ?></td>
                              <?php $date = date_create($row['tanggal_lahir']);
                              $date = date_format($date, 'd M Y'); ?>
                              <td><?= $row['tempat_lahir'] . ", " . $date ?></td>
                              <td><?= $row['agama'] ?></td>
                              <td><?= $row['alamat'] ?></td>
                              <td><?= $row['no_hp'] ?></td>
                              <td><?= $row['nama_prodi'] ?></td>
                              <td><?= $row['nama_jurusan'] ?></td>
                              <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                <td>
                                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['nim_mhs'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row['nim_mhs'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row['nama_mhs'] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                          <div class="modal-body text-center">
                                            <div class="mb-3 mt-4">
                                              <label for="nim" class="form-label">NIM</label>
                                              <input type="number" name="nim" value="<?= $row['nim_mhs'] ?>" class="form-control" id="nim" placeholder="NIM" required>
                                            </div>
                                            <div class="mb-3 mt-4">
                                              <label for="nama" class="form-label">Nama</label>
                                              <input type="text" name="nama" value="<?= $row['nama_mhs'] ?>" class="form-control" id="nama" placeholder="Nama" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="tempat-lahir" class="form-label">Tempat Lahir</label>
                                              <input type="text" name="tempat-lahir" value="<?= $row['tempat_lahir'] ?>" class="form-control" id="tempat-lahir" placeholder="Tempat Lahir" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="tgl-lahir" class="form-label">Tgl Lahir</label>
                                              <input type="date" name="tgl-lahir" value="<?= $row['tgl_lahir'] ?>" class="form-control" id="tgl-lahir" placeholder="Tgl Lahir" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="agama" class="form-label">Agama</label>
                                              <select name="agama" class="form-select" aria-label="Default select example" required>
                                                <option selected value="">Pilih Agama</option>
                                                <option value="Islam">Laki-Laki</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Kristen Katolik">Kristen Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="alamat" class="form-label">Alamat</label>
                                              <input type="text" name="alamat" value="<?= $row['alamat'] ?>" class="form-control" id="alamat" placeholder="Alamat" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="no-hp" class="form-label">No. Handphone</label>
                                              <input type="number" name="no-hp" value="<?= $row['no_hp'] ?>" class="form-control" id="no-hp" placeholder="No. Handphone" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="prodi" class="form-label">Program Studi</label>
                                              <select name="prodi" class="form-select" aria-label="Default select example" required>
                                                <option selected value="">Pilih Program Studi</option>
                                                <?php foreach ($prodi as $row_pro) : ?>
                                                  <option value="<?= $row_pro['id_prodi'] ?>"><?= $row_pro['nama_prodi'] ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center">
                                            <input type="hidden" name="nimOld" value="<?= $row['nim_mhs'] ?>">
                                            <input type="hidden" name="namaOld" value="<?= $row['nama_mhs'] ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-mahasiswa" class="btn btn-warning">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['nim_mhs'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row['nim_mhs'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row['nama_mhs'] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus data dari <?= $row['nama_mhs'] ?>?
                                        </div>
                                        <form action="" method="post">
                                          <div class="modal-footer justify-content-center">
                                            <input type="hidden" name="nimOld" value="<?= $row['nim_mhs'] ?>">
                                            <input type="hidden" name="namaOld" value="<?= $row['nama_mhs'] ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="hapus-mahasiswa" class="btn btn-danger">Hapus</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              <?php } ?>
                            </tr>
                        <?php $no++;
                          }
                        } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php if ($total_role2 > $data_role2) { ?>
                    <div class="d-flex justify-content-between mt-4 flex-wrap">
                      <p class="text-muted">Showing 1 to <?= $data_role2 ?> of <?= $total_role2 ?> entries</p>
                      <nav class="ml-auto">
                        <ul class="pagination separated pagination-info">
                          <?php if (isset($page_role2)) {
                            if (isset($total_page_role2)) {
                              if ($page_role2 > 1) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?= $page_role2 - 1; ?>/" class="btn btn-primary text-white btn-sm rounded-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5zM10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                  </a>
                                </li>
                                <?php endif;
                              for ($i = 1; $i <= $total_page_role2; $i++) : if ($i <= 4) : if ($i == $page_role2) : ?>
                                    <li class="page-item active">
                                      <a href="<?= $_SESSION['page-url'] ?>?page=<?= $i; ?>/" class="btn btn-primary text-white btn-sm rounded-0"><?= $i; ?></a>
                                    </li>
                                  <?php else : ?>
                                    <li class="page-item">
                                      <a href="<?= $_SESSION['page-url'] ?>?page=<?= $i; ?>/" class="btn btn-outline-primary btn-sm rounded-0"><?= $i ?></a>
                                    </li>
                                <?php endif;
                                endif;
                              endfor;
                              if ($total_page_role2 >= 4) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?php if ($page_role2 > 4) {
                                                                                echo $page_role2;
                                                                              } else if ($page_role2 <= 4) {
                                                                                echo '5';
                                                                              } ?>/" class="btn btn-<?php if ($page_role2 <= 4) {
                                                                                                      echo 'outline-';
                                                                                                    } ?>primary btn-sm rounded-0"><?php if ($page_role2 > 4) {
                                                                                                                                    echo $page_role2;
                                                                                                                                  } else if ($page_role2 <= 4) {
                                                                                                                                    echo '5';
                                                                                                                                  } ?></a>
                                </li>
                              <?php endif;
                              if ($page_role2 < $total_page_role2 && $total_page_role2 >= 4) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?= $page_role2 + 1; ?>/" class="btn btn-primary text-white btn-sm rounded-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8zm-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5z" />
                                    </svg>
                                  </a>
                                </li>
                          <?php endif;
                            }
                          } ?>
                        </ul>
                      </nav>
                    </div>
                  <?php } ?>
                </div>
              </div>
              </div>
            </div>

        </div>
        <!--//container-fluid-->
      </div>
      <!--//app-content-->


      <?php require_once("../resources/footer-dash.php"); ?>

</body>

</html>