<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
require './function/function_permohonan.php';
require './function/function_global.php';
$username = $_SESSION['username'];
$datas = query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
data_peminjaman.id as id, 
data_peminjaman.jumlah as jumlah,
data_peminjaman.permohonan_peminjaman as permohonan_peminjaman,
data_peminjaman.pengembalian as pengembalian,
data_peminjaman.status as status,
data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
ON data_peminjaman.id_barang=data_barang.id WHERE data_peminjaman.username='$username' ORDER BY data_peminjaman.id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Permohonan</title>

  <?php
  require './views/link.php';
  ?>
</head>

<body>
  <!-- Nav Sidebar -->
  <?php
  $page = 3;
  require './views/sidebar.php';
  ?>

  <!-- Main Content -->
  <main class="content">
    <?php
    require './views/navbar.php';
    ?>

    <section class="p-3">
      <div class="header">
        <h3>Permohonan</h3>
        <p>Tabel data permohonan</p>
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
                  <th class="text-center align-middle">No</th>
                  <th class="align-middle">Nama Barang</th>
                  <th class="align-middle">Jumlah</th>
                  <th class="align-middle">Tanggal Peminjaman</th>
                  <th class="align-middle">Tanggal Pengembalian</th>
                  <th class="align-middle">Persetujuan Peminjaman</th>
                  <th class="align-middle">Persetujuan Pengembalian</th>
                  <th class="align-middle">Keterangan</th>
                  <th class="text-center align-middle">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($datas === []) {
                ?>
                  <tr>
                    <td class="text-center" colspan="9">Data kosong</td>
                  </tr>
                  <?php
                } else {
                  $no = 1;
                  foreach ($datas as $data) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $no ?></td>
                      <td class="align-middle"><?= $data['nama_barang'] ?></td>
                      <td class="align-middle text-center"><?= $data['jumlah'] ?></td>
                      <td class="align-middle"><?= format_tanggal($data['tanggal_peminjaman']) ?></td>
                      <td class="align-middle"><?= format_tanggal($data['tanggal_pengembalian']) ?></td>
                      <td class="align-middle"><?= $data['permohonan_peminjaman'] ?></td>
                      <td class="align-middle"><?= $data['pengembalian'] ?></td>
                      <td class="align-middle"><?= $data['status'] ?></td>
                      <td class="text-center">
                        <?php
                        if ($data['pengembalian'] != 'Pending') {
                        ?>
                        <?php
                        } else {
                        ?>
                          <button class="btn btn-sm mt-1 btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id']; ?>">Ubah</button>
                        <?php
                        }
                        if ($data['permohonan_peminjaman'] != 'Pending') {
                        ?>
                        <?php
                        } else {
                        ?>
                          <button class="btn btn-sm mt-1 btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['id']; ?>">Hapus</button>
                        <?php
                        }
                        ?>
                      </td>
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $data['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $data['id'];
                                $edits = query_data("SELECT * FROM data_peminjaman WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                  <p>Yakin untuk menghapus data ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="delete_permohonan" class="btn btn-danger ml-2">Hapus</button>
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
                      <div class="modal fade" id="modalEdit<?= $data['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Ubah Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="#" method="POST" autocomplete="off">
                                <?php
                                $id = $data['id'];
                                $edits = query_data("SELECT * FROM data_peminjaman WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" class="form-control" name="id" value="<?= $edit['id']; ?>">
                                  <div class="form-group row mt-3">
                                    <label class="col-4 col-form-label">Tanggal Pengembalian</label>
                                    <div class="col-8">
                                      <input type="date" class="form-control" name="tanggal_pengembalian" value="<?= $edit['tanggal_pengembalian'] ?>">
                                    </div>
                                  </div>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="update_permohonan" class="text-white btn btn-info ml-2">Ubah</button>
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
                }
                ?>
              </tbody>
              <div class="modal modal-custom fade" id="daftar-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Tambah Data</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="#" enctype="multipart/form-data" autocomplete="off" id="daftarForm">
                        <input type="hidden" name="username" value="<?= $username ?>">
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Nama Barang</label>
                          <div class="col-8">
                            <select name="id_barang" id="" class="form-control">
                              <option selected>--Pilih--</option>
                              <?php
                              $data_barangs = query_data("SELECT*FROM data_barang WHERE jumlah_barang != 0");
                              foreach ($data_barangs as $data_barang) :
                              ?>
                                <option value="<?= $data_barang['id'] ?>"><?= $data_barang['nama_barang'] ?> (<?= $data_barang['jumlah_barang'] ?> <?= $data_barang['satuan_barang'] ?>)</option>
                              <?php
                              endforeach;
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Jumlah barang</label>
                          <div class="col-8">
                            <input type="number" class="form-control" name="jumlah" required placeholder="0">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Tanggal Peminjaman</label>
                          <div class="col-8">
                            <input type="date" class="form-control" name="tanggal_peminjaman" required>
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Tanggal Pengembalian</label>
                          <div class="col-8">
                            <input type="date" class="form-control" name="tanggal_pengembalian" required>
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
    if (add_permohonan($_POST) > 0) {
      echo '
            <script type="text/javascript">
                swal({
                    title: "Berhasil",
                    text: "Berhasil ditambahkan",
                    icon: "success",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("permohonan.php");
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
                    text: "Gagal ditambahkan, melebihi jumlah yang ada",
                    icon: "error",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("permohonan.php");
                    }else{
                        //if no clicked => do something else
                    }
                });
            </script>
        ';
    }
  }
  if (isset($_POST['update_permohonan'])) {
    if (update_permohonan($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil diubah",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("permohonan.php");
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
                          window.location.replace("permohonan.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['delete_permohonan'])) {
    if (delete_permohonan($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil dihapus",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("permohonan.php");
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
                          window.location.replace("permohonan.php");
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