<?php
require './function/function_barang.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
$username = $_SESSION['username'];
$barangs = query_data("SELECT*FROM data_barang");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barang</title>

  <?php
  require './views/link.php';
  ?>
</head>

<body>
  <!-- Nav Sidebar -->
  <?php
  $page = 4;
  require './views/sidebar.php';
  ?>

  <!-- Main Content -->
  <main class="content">
    <?php
    require './views/navbar.php';
    ?>

    <section class="p-3">
      <div class="header">
        <h3>Barang</h3>
        <p>Tabel data barang</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <div class="mb-4 mt-2">
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#daftar-data">Tambah data</button>
            </div>
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center">No</th>
                  <th class="align-middle">Nama Barang</th>
                  <th class="align-middle">Jumlah Barang</th>
                  <th class="align-middle">Merk Barang</th>
                  <th class="align-middle">Satuan Barang</th>
                  <th class="align-middle">Ruangan</th>
                  <th class="align-middle">Foto</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($barangs === []) {
                ?>
                  <tr>
                    <td colspan="7" class="text-center">Data kosong</td>
                  </tr>
                <?php
                } else {
                ?>
                  <?php
                  $no = 1;
                  foreach ($barangs as $barang) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $no ?></td>
                      <td class="align-middle"><?= $barang['nama_barang'] ?></td>
                      <td class="align-middle"><?= $barang['jumlah_barang'] ?></td>
                      <td class="align-middle"><?= $barang['merk_barang'] ?></td>
                      <td class="align-middle"><?= $barang['satuan_barang'] ?></td>
                      <td class="align-middle"><?= $barang['ruangan'] ?></td>
                      <td class="align-middle">
                        <button class="btn btn-sm btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#modalSee<?= $barang['id']; ?>">Foto</button>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $barang['id']; ?>">Ubah</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $barang['id']; ?>">Hapus</button>
                      </td>
                      <div class="modal fade" id="modalSee<?= $barang['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Foto</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $barang['id'];
                                $edits = query_data("SELECT * FROM data_barang WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <div class="text-center">
                                    <img src="img/<?= $edit['foto'] ?>" width="450px" alt="foto-barang">
                                  </div>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Tutup</button>
                                  </div>
                                <?php
                                endforeach
                                ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $barang['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $barang['id'];
                                $edits = query_data("SELECT * FROM data_barang WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                  <input type="hidden" name="foto" value="<?= $edit['foto']; ?>">
                                  <p>Yakin untuk menghapus data ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="delete_barang" class="btn btn-danger ml-2">Hapus</button>
                                  </div>
                                <?php
                                endforeach
                                ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Hapus -->
                      <!-- Modal Edit -->
                      <div class="modal fade" id="modalEdit<?= $barang['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Ubah Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="#" enctype="multipart/form-data" method="POST" autocomplete="off">
                                <?php
                                $id = $barang['id'];
                                $edits = query_data("SELECT * FROM data_barang WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" class="form-control" name="id" value="<?= $edit['id']; ?>">
                                  <input type="hidden" class="form-control" name="fileLama" value="<?= $edit['foto']; ?>">
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Nama Barang</label>
                                    <div class="col-8">
                                      <input type="text" class="form-control" name="nama_barang" value="<?= $edit['nama_barang'] ?>" placeholder="Nama Barang">
                                    </div>
                                  </div>
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Jumlah Barang</label>
                                    <div class="col-8">
                                      <input type="number" class="form-control" name="jumlah_barang" value="<?= $edit['jumlah_barang'] ?>" placeholder="0">
                                    </div>
                                  </div>
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Merk Barang</label>
                                    <div class="col-8">
                                      <input type="text" class="form-control" name="merk_barang" value="<?= $edit['merk_barang'] ?>" placeholder="Merk Barang">
                                    </div>
                                  </div>
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Satuan Barang</label>
                                    <div class="col-8">
                                      <select name="satuan_barang" id="" class="form-control">
                                        <?php
                                        if ($edit['satuan_barang'] == 'Unit') {
                                        ?>
                                          <option value="Unit">Unit</option>
                                          <option value="Buah">Buah</option>
                                          <option value="M2">M2</option>
                                        <?php
                                        } elseif ($edit['satuan_barang'] == 'Buah') {
                                        ?>
                                          <option value="Buah">Buah</option>
                                          <option value="Unit">Unit</option>
                                          <option value="M2">M2</option>
                                        <?php
                                        } else if ($edit['satuan_barang'] == 'M2') {
                                        ?>
                                          <option value="M2">M2</option>
                                          <option value="Unit">Unit</option>
                                          <option value="Buah">Buah</option>
                                        <?php
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Ruangan</label>
                                    <div class="col-8">
                                      <input type="text" class="form-control" name="ruangan" value="<?= $edit['ruangan'] ?>" placeholder="Ruangan">
                                    </div>
                                  </div>
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Upload Foto</label>
                                    <div class="col-8">
                                      <input type="file" class="form-control" name="foto">
                                    </div>
                                  </div>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="update_barang" class="text-white btn btn-info ml-2">Ubah</button>
                                  </div>
                                <?php endforeach ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Edit -->
                    </tr>
                  <?php
                    $no++;
                  endforeach;
                  ?>
                <?php
                }
                ?>
              </tbody>
              <div class="modal modal-custom fade" id="daftar-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="#" enctype="multipart/form-data" autocomplete="off" id="daftarForm">
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Nama Barang</label>
                          <div class="col-8">
                            <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Jumlah Barang</label>
                          <div class="col-8">
                            <input type="number" class="form-control" name="jumlah_barang" placeholder="0">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Merk Barang</label>
                          <div class="col-8">
                            <input type="text" class="form-control" name="merk_barang" placeholder="Merk Barang">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Satuan Barang</label>
                          <div class="col-8">
                            <select name="satuan_barang" id="" class="form-control">
                              <option selected>--Pilih--</option>
                              <option value="Unit">Unit</option>
                              <option value="Buah">Buah</option>
                              <option value="M2">M2</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Ruangan</label>
                          <div class="col-8">
                            <input type="text" class="form-control" name="ruangan" placeholder="Ruangan">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Upload Foto</label>
                          <div class="col-8">
                            <input type="file" class="form-control" name="foto" required>
                          </div>
                        </div>
                        <div class="text-center mt-3 mb-2">
                          <button type="submit" name="add" class="btn btn-primary">Tambah</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
  require './views/script.php';
  if (isset($_POST['add'])) {
    if (add_barang($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil ditambahkan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    } else {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Gagal",
                      text: "Gagal ditambahkan",
                      icon: "error",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['update_barang'])) {
    if (update_barang($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil diubah",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    } else {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Gagal",
                      text: "Gagal diubah",
                      icon: "error",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['delete_barang'])) {
    if (delete_barang($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil dihapus",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    } else {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Gagal",
                      text: "Gagal dihapus",
                      icon: "error",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("barang.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  ?>
</body>

</html>