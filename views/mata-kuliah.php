<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Mata Kuliah";
$_SESSION['page-url'] = "mata-kuliah";
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
                  <h4>Tambah Mata Kuliah</h4>
                  <form action="" method="post">
                    <div class="mb-3 mt-4">
                      <label for="nidn" class="form-label">Dosen</label>
                      <select name="nidn" class="form-select" aria-label="Default select example" required>
                        <option selected value="">Pilih Dosen</option>
                        <?php foreach ($selectDosen as $row_dos) : ?>
                          <option value="<?= $row_dos['nidn_dosen'] ?>"><?= $row_dos['nama_dosen'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama Mata Kuliah</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Mata Kuliah" required>
                    </div>
                    <div class="mb-3">
                      <label for="sks" class="form-label">SKS</label>
                      <input type="number" name="sks" class="form-control" id="sks" placeholder="SKS" required>
                    </div>
                    <button type="submit" name="tambah-mk" class="btn btn-primary text-white">Tambah</button>
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
                    <table class="table table-striped table-borderless">
                      <thead class="text-center">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Mata Kuliah</th>
                          <th scope="col">Dosen Pengajar</th>
                          <th scope="col">SKS</th>
                          <?php if ($_SESSION['data-user']['role'] <= 2) { ?>
                            <th scope="col" colspan="3">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody id="search-data">
                        <?php if (mysqli_num_rows($mata_kuliah) == 0) { ?>
                          <tr class="text-center">
                            <th scope="row" colspan="7">Belum ada data mata kuliah</th>
                          </tr>
                          <?php } else if (mysqli_num_rows($mata_kuliah) > 0) {
                          $no = 1;
                          while ($row = mysqli_fetch_assoc($mata_kuliah)) { ?>
                            <tr>
                              <th scope="row"><?= $no; ?></th>
                              <td><?= $row['nama_matakuliah'] ?></td>
                              <td><?= $row['nama_dosen'] ?> <small class="text-success">(<?= $row['nidn_dosen'] ?>)</small></td>
                              <td><?= $row['sks'] ?></td>
                              <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                <td>
                                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['id_mk'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                  </button>
                                  <div class="modal fade" id="ubah<?= $row['id_mk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row['nama_matakuliah'] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="" method="post">
                                          <div class="modal-body text-center">
                                            <div class="mb-3 mt-4">
                                              <label for="nidn" class="form-label">Dosen</label>
                                              <select name="nidn" class="form-select" aria-label="Default select example" required>
                                                <option selected value="">Pilih Dosen</option>
                                                <?php foreach ($selectDosen as $row_dos) : ?>
                                                  <option value="<?= $row_dos['nidn_dosen'] ?>"><?= $row_dos['nama_dosen'] ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="nama" class="form-label">Nama Mata Kuliah</label>
                                              <input type="text" name="nama" value="<?= $row['nama_matakuliah'] ?>" class="form-control" id="nama" placeholder="Nama Mata Kuliah" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="sks" class="form-label">SKS</label>
                                              <input type="number" name="sks" value="<?= $row['sks'] ?>" class="form-control" id="sks" placeholder="SKS" required>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-center">
                                            <input type="hidden" name="id-mk" value="<?= $row['id_mk'] ?>">
                                            <input type="hidden" name="namaOld" value="<?= $row['nama_matakuliah'] ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="ubah-mk" class="btn btn-warning">Ubah</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id_mk'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                  </button>
                                  <div class="modal fade" id="hapus<?= $row['id_mk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row['nama_matakuliah'] ?></h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                          Anda yakin ingin menghapus data dari <?= $row['nama_matakuliah'] ?>?
                                        </div>
                                        <form action="" method="post">
                                          <div class="modal-footer justify-content-center">
                                            <input type="hidden" name="id-mk" value="<?= $row['id_mk'] ?>">
                                            <input type="hidden" name="namaOld" value="<?= $row['nama_matakuliah'] ?>">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="hapus-mk" class="btn btn-danger">Hapus</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              <?php }
                              if ($_SESSION['data-user']['role'] <= 2) { ?>
                                <td>
                                  <form action="" method="post">
                                    <input type="hidden" name="id-mk" value="<?= $row['id_mk'] ?>">
                                    <input type="hidden" name="nama-mk" value="<?= $row['nama_matakuliah'] ?>">
                                    <button type="submit" name="buat-jadwal" class="btn btn-primary text-white">
                                      Jadwal <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                      </svg>
                                    </button>
                                  </form>
                                </td>
                              <?php } ?>
                            </tr>
                        <?php $no++;
                          }
                        } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php if ($total_role3 > $data_role3) { ?>
                    <div class="d-flex justify-content-between mt-4 flex-wrap">
                      <p class="text-muted">Showing 1 to <?= $data_role3 ?> of <?= $total_role3 ?> entries</p>
                      <nav class="ml-auto">
                        <ul class="pagination separated pagination-info">
                          <?php if (isset($page_role3)) {
                            if (isset($total_page_role3)) {
                              if ($page_role3 > 1) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?= $page_role3 - 1; ?>/" class="btn btn-primary text-white btn-sm rounded-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5zM10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                  </a>
                                </li>
                                <?php endif;
                              for ($i = 1; $i <= $total_page_role3; $i++) : if ($i <= 4) : if ($i == $page_role3) : ?>
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
                              if ($total_page_role3 >= 4) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?php if ($page_role3 > 4) {
                                                                                echo $page_role3;
                                                                              } else if ($page_role3 <= 4) {
                                                                                echo '5';
                                                                              } ?>/" class="btn btn-<?php if ($page_role3 <= 4) {
                                                                                                      echo 'outline-';
                                                                                                    } ?>primary btn-sm rounded-0"><?php if ($page_role3 > 4) {
                                                                                                                                    echo $page_role3;
                                                                                                                                  } else if ($page_role3 <= 4) {
                                                                                                                                    echo '5';
                                                                                                                                  } ?></a>
                                </li>
                              <?php endif;
                              if ($page_role3 < $total_page_role3 && $total_page_role3 >= 4) : ?>
                                <li class="page-item">
                                  <a href="<?= $_SESSION['page-url'] ?>?page=<?= $page_role3 + 1; ?>/" class="btn btn-primary text-white btn-sm rounded-0">
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