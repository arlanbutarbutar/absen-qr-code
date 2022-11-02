<?php require_once('../controller/script.php');
if ($_SESSION['page-url'] == "dosen") {
  if (isset($_GET['key']) && $_GET['key'] != "") {
    $key = addslashes(trim($_GET['key']));
    $keys = explode(" ", $key);
    $quer = "";
    foreach ($keys as $no => $data) {
      $data = strtolower($data);
      $quer .= "nip_dosen LIKE '%$data%' OR nip_dosen!='$idUser' AND nama_dosen LIKE '%$data%'";
      if ($no + 1 < count($keys)) {
        $quer .= " OR ";
      }
    }
    $query = "SELECT * FROM dosen WHERE nip_dosen!='$idUser' AND $quer ORDER BY nip_dosen ASC LIMIT 100";
    $dosen = mysqli_query($conn, $query);
  }
  if (mysqli_num_rows($dosen) == 0) { ?>
    <tr class="text-center">
      <th scope="row" colspan="8">Belum ada data dosen</th>
    </tr>
    <?php } else if (mysqli_num_rows($dosen) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($dosen)) { ?>
      <tr>
        <th scope="row"><?= $no; ?></th>
        <td><?= $row['nip_dosen'] ?></td>
        <td><?= $row['nama_dosen'] ?></td>
        <td><?= $row['jenis_kelamin'] ?></td>
        <td><?= $row['gelar'] ?></td>
        <td><?= $row['jabatan'] ?></td>
        <td>
          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['nip_dosen'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
            </svg>
          </button>
          <div class="modal fade" id="ubah<?= $row['nip_dosen'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row['nama_dosen'] ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                  <div class="modal-body text-center">
                    <div class="mb-3 mt-4">
                      <label for="nidn" class="form-label">NIP</label>
                      <input type="number" name="nidn" value="<?= $row['nip_dosen'] ?>" class="form-control" id="nidn" placeholder="NIDN" required>
                    </div>
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama Dosen</label>
                      <input type="text" name="nama" value="<?= $row['nama_dosen'] ?>" class="form-control" id="nama" placeholder="Nama Dosen" required>
                    </div>
                    <div class="mb-3">
                      <label for="jenis-kelamin" class="form-label">Jenis Kelamin</label>
                      <select name="jk" class="form-select" aria-label="Default select example" required>
                        <option selected value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="gelar" class="form-label">Gelar</label>
                      <input type="text" name="gelar" value="<?= $row['gelar'] ?>" class="form-control" id="gelar" placeholder="Gelar" required>
                    </div>
                    <div class="mb-3">
                      <label for="jabatan" class="form-label">Jabatan</label>
                      <input type="text" name="jabatan" value="<?= $row['jabatan'] ?>" class="form-control" id="jabatan" placeholder="Jabatan" required>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-center">
                    <input type="hidden" name="nidnOld" value="<?= $row['nip_dosen'] ?>">
                    <input type="hidden" name="namaOld" value="<?= $row['nama_dosen'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="ubah-dosen" class="btn btn-warning">Ubah</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </td>
        <td>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['nip_dosen'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
            </svg>
          </button>
          <div class="modal fade" id="hapus<?= $row['nip_dosen'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row['nama_dosen'] ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                  Anda yakin ingin menghapus data dari <?= $row['nama_dosen'] ?>?
                </div>
                <form action="" method="post">
                  <div class="modal-footer justify-content-center">
                    <input type="hidden" name="nidnOld" value="<?= $row['nip_dosen'] ?>">
                    <input type="hidden" name="namaOld" value="<?= $row['nama_dosen'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus-dosen" class="btn btn-danger">Hapus</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </td>
      </tr>
    <?php $no++;
    }
  }
}
if ($_SESSION['page-url'] == "mahasiswa") {
  if (isset($_GET['key']) && $_GET['key'] != "") {
    $key = addslashes(trim($_GET['key']));
    $keys = explode(" ", $key);
    $quer = "";
    foreach ($keys as $no => $data) {
      $data = strtolower($data);
      $quer .= "mahasiswa.nim_mhs LIKE '%$data%' OR mahasiswa.nama_mhs LIKE '%$data%'";
      if ($no + 1 < count($keys)) {
        $quer .= " OR ";
      }
    }
    $query = "SELECT * FROM mahasiswa JOIN prodi ON mahasiswa.id_prodi=prodi.id_prodi JOIN jurusan ON prodi.id_jurusan=jurusan.id_jurusan WHERE $quer ORDER BY mahasiswa.nim_mhs ASC LIMIT 100";
    $mahasiswa = mysqli_query($conn, $query);
  }
  if (mysqli_num_rows($mahasiswa) == 0) { ?>
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
        <td><?= $row['tempat_lahir'] . ", " . $row['tanggal_lahir'] ?></td>
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
  }
}
if ($_SESSION['page-url'] == "mata-kuliah") {
  if (isset($_GET['key']) && $_GET['key'] != "") {
    $key = addslashes(trim($_GET['key']));
    $keys = explode(" ", $key);
    $quer = "";
    foreach ($keys as $no => $data) {
      $data = strtolower($data);
      $quer .= "mata_kuliah.nip_dosen LIKE '%$data%' OR mata_kuliah.nama_matakuliah LIKE '%$data%'";
      if ($no + 1 < count($keys)) {
        $quer .= " OR ";
      }
    }
    $query = "SELECT * FROM mata_kuliah JOIN dosen ON mata_kuliah.nip_dosen=dosen.nip_dosen WHERE $quer ORDER BY mata_kuliah.id_mk ASC LIMIT 100";
    $mata_kuliah = mysqli_query($conn, $query);
  }
  if (mysqli_num_rows($mata_kuliah) == 0) { ?>
    <tr class="text-center">
      <th scope="row" colspan="7">Belum ada data mata kuliah</th>
    </tr>
    <?php } else if (mysqli_num_rows($mata_kuliah) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($mata_kuliah)) { ?>
      <tr>
        <th scope="row"><?= $no; ?></th>
        <td><?= $row['nama_matakuliah'] ?></td>
        <td><?= $row['nama_dosen'] ?> <small class="text-success">(<?= $row['nip_dosen'] ?>)</small></td>
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
                            <option value="<?= $row_dos['nip_dosen'] ?>"><?= $row_dos['nama_dosen'] ?></option>
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
  }
} ?>