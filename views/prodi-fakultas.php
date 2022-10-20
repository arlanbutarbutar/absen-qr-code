<?php require_once("../controller/script.php");
require_once("redirect.php");

$_SESSION['page-name'] = "Prodi & Fakultas";
$_SESSION['page-url'] = "prodi-fakultas";
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

        <div class="accordion" id="accordionExample">
          <div class="accordion-item border-0 shadow">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Program Studi
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row">
                  <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                    <div class="col-lg-4">
                      <div class="card border-0 shadow">
                        <div class="card-body text-center">
                          <h4>Tambah Program Studi</h4>
                          <form action="" method="post">
                            <div class="mb-3 mt-4">
                              <label for="nama" class="form-label">Nama</label>
                              <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                            </div>
                            <div class="mb-3">
                              <label for="fakultas" class="form-label">Fakultas</label>
                              <select name="fakultas" class="form-select" aria-label="Default select example" required>
                                <option selected value="">Pilih Fakultas</option>
                                <?php foreach ($selectFakultas as $row_fak) : ?>
                                  <option value="<?= $row_fak['id_fakultas'] ?>"><?= $row_fak['nama_fakultas'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                            <button type="submit" name="tambah-prodi" class="btn btn-primary text-white">Tambah</button>
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
                                  <th scope="col">Nama Program Studi</th>
                                  <th scope="col">Nama Fakultas</th>
                                  <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                    <th scope="col" colspan="2">Aksi</th>
                                  <?php } ?>
                                </tr>
                              </thead>
                              <tbody id="search-data">
                                <?php if (mysqli_num_rows($prodi) == 0) { ?>
                                  <tr class="text-center">
                                    <th scope="row" colspan="5">Belum ada data program studi</th>
                                  </tr>
                                  <?php } else if (mysqli_num_rows($prodi) > 0) {
                                  $no = 1;
                                  while ($row_prodi = mysqli_fetch_assoc($prodi)) { ?>
                                    <tr>
                                      <th scope="row"><?= $no; ?></th>
                                      <td><?= $row_prodi['nama_prodi'] ?></td>
                                      <td><?= $row_prodi['nama_fakultas'] ?></td>
                                      <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                        <td>
                                          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row_prodi['id_prodi'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                          </button>
                                          <div class="modal fade" id="ubah<?= $row_prodi['id_prodi'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row_prodi['nama_prodi'] ?></h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-body text-center">
                                                    <div class="mb-3 mt-4">
                                                      <label for="nama" class="form-label">Nama</label>
                                                      <input type="text" name="nama" value="<?= $row_prodi['nama_prodi'] ?>" class="form-control" id="nama" placeholder="Nama" required>
                                                    </div>
                                                    <div class="mb-3">
                                                      <label for="fakultas" class="form-label">Fakultas</label>
                                                      <select name="fakultas" class="form-select" aria-label="Default select example" required>
                                                        <option selected value="">Pilih Fakultas</option>
                                                        <?php foreach ($selectFakultas as $row_fak) : ?>
                                                          <option value="<?= $row_fak['id_fakultas'] ?>"><?= $row_fak['nama_fakultas'] ?></option>
                                                        <?php endforeach; ?>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="modal-footer justify-content-center">
                                                    <input type="hidden" name="id-prodi" value="<?= $row_prodi['id_prodi'] ?>">
                                                    <input type="hidden" name="namaOld" value="<?= $row_prodi['nama_prodi'] ?>">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="ubah-prodi" class="btn btn-warning">Ubah</button>
                                                  </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                        </td>
                                        <td>
                                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row_prodi['id_prodi'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>
                                          </button>
                                          <div class="modal fade" id="hapus<?= $row_prodi['id_prodi'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row_prodi['nama_prodi'] ?></h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                  Anda yakin ingin menghapus data dari <?= $row_prodi['nama_prodi'] ?>?
                                                </div>
                                                <form action="" method="post">
                                                  <div class="modal-footer justify-content-center">
                                                    <input type="hidden" name="id-prodi" value="<?= $row_prodi['id_prodi'] ?>">
                                                    <input type="hidden" name="namaOld" value="<?= $row_prodi['nama_prodi'] ?>">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="hapus-prodi" class="btn btn-danger">Hapus</button>
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
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="accordion-item border-0 shadow">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Fakultas
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="row">
                      <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                        <div class="col-lg-4">
                          <div class="card border-0 shadow">
                            <div class="card-body text-center">
                              <h4>Tambah Fakultas</h4>
                              <form action="" method="post">
                                <div class="mb-3 mt-4">
                                  <label for="nama" class="form-label">Nama</label>
                                  <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                                </div>
                                <button type="submit" name="tambah-fakultas" class="btn btn-primary text-white">Tambah</button>
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
                                      <th scope="col">Nama Fakultas</th>
                                      <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                        <th scope="col" colspan="2">Aksi</th>
                                      <?php } ?>
                                    </tr>
                                  </thead>
                                  <tbody id="search-data">
                                    <?php if (mysqli_num_rows($fakultas) == 0) { ?>
                                      <tr class="text-center">
                                        <th scope="row" colspan="4">Belum ada data fakultas</th>
                                      </tr>
                                      <?php } else if (mysqli_num_rows($fakultas) > 0) {
                                      $no = 1;
                                      while ($row_fakultas = mysqli_fetch_assoc($fakultas)) { ?>
                                        <tr>
                                          <th scope="row"><?= $no; ?></th>
                                          <td><?= $row_fakultas['nama_fakultas'] ?></td>
                                          <?php if ($_SESSION['data-user']['role'] == 1) { ?>
                                            <td>
                                              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row_fakultas['id_fakultas'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                              </button>
                                              <div class="modal fade" id="ubah<?= $row_fakultas['id_fakultas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row_fakultas['nama_fakultas'] ?></h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="" method="post">
                                                      <div class="modal-body text-center">
                                                        <div class="mb-3 mt-4">
                                                          <label for="nama" class="form-label">Nama</label>
                                                          <input type="text" name="nama" value="<?= $row_fakultas['nama_fakultas'] ?>" class="form-control" id="nama" placeholder="Nama" required>
                                                        </div>
                                                      </div>
                                                      <div class="modal-footer justify-content-center">
                                                        <input type="hidden" name="id-fakultas" value="<?= $row_fakultas['id_fakultas'] ?>">
                                                        <input type="hidden" name="namaOld" value="<?= $row_fakultas['nama_fakultas'] ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="ubah-fakultas" class="btn btn-warning">Ubah</button>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </td>
                                            <td>
                                              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row_fakultas['id_fakultas'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                              </button>
                                              <div class="modal fade" id="hapus<?= $row_fakultas['id_fakultas'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row_fakultas['nama_fakultas'] ?></h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                      Anda yakin ingin menghapus data dari <?= $row_fakultas['nama_fakultas'] ?>?
                                                    </div>
                                                    <form action="" method="post">
                                                      <div class="modal-footer justify-content-center">
                                                        <input type="hidden" name="id-fakultas" value="<?= $row_fakultas['id_fakultas'] ?>">
                                                        <input type="hidden" name="namaOld" value="<?= $row_fakultas['nama_fakultas'] ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="hapus-fakultas" class="btn btn-danger">Hapus</button>
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
                            </div>
                          </div>
                          </div>
                        </div>
                    </div>
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