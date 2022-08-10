<?php
require './function/function_pegawai.php';
require './function/function_global.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
$username = $_SESSION['username'];
$datas = query_data("SELECT*FROM data_pegawai WHERE status='aktif'");
$data_unactives = query_data("SELECT*FROM data_pegawai WHERE status='tidak aktif'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pegawai</title>

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
        <h3>Akun Pegawai Aktif</h3>
        <p>Tabel data akun pegawai aktif</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center">No</th>
                  <th class="align-middle">NIP</th>
                  <th class="align-middle">Nama</th>
                  <th class="align-middle">Jenis Kelamin</th>
                  <th class="align-middle">No Telpon</th>
                  <th class="align-middle">Jabatan</th>
                  <th class="align-middle">Unit Kerja</th>
                  <th class="align-middle">Username</th>
                  <th class="text-center">Aksi</th>
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
                      <td class="align-middle"><?= $data['nip'] ?></td>
                      <td class="align-middle"><?= $data['nama'] ?></td>
                      <td class="align-middle"><?= $data['jenis_kelamin'] ?></td>
                      <td class="align-middle"><?= $data['no_telpon'] ?></td>
                      <td class="align-middle"><?= $data['jabatan'] ?></td>
                      <td class="align-middle"><?= $data['unit_kerja'] ?></td>
                      <td class="align-middle"><?= $data['username'] ?></td>
                      <td class="text-center">
                        <?php
                        if ($_SESSION['username'] == $data['username']) {
                        ?>
                        <?php
                        } else {
                        ?>
                          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data['username']; ?>">Hapus</button>
                        <?php
                        }
                        ?>
                      </td>
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $data['username']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $username = $data['username'];
                                $edits = query_data("SELECT * FROM data_pegawai WHERE username='$username'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                  <p>Yakin untuk menghapus data ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="delete_pegawai" class="btn btn-danger ml-2">Hapus</button>
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
                    </tr>
                  <?php
                    $no++;
                  endforeach;
                  ?>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <section class="p-3">
      <div class="header">
        <h3>Akun Pegawai Belum Aktif</h3>
        <p>Tabel data akun pegawai belum aktif</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center">No</th>
                  <th class="align-middle">NIP</th>
                  <th class="align-middle">Nama</th>
                  <th class="align-middle">No Telpon</th>
                  <th class="align-middle">Username</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($data_unactives === []) {
                ?>
                  <tr>
                    <td class="text-center" colspan="6">Data kosong</td>
                  </tr>
                  <?php
                } else {
                  $nos = 1;
                  foreach ($data_unactives as $data_unactive) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $nos ?></td>
                      <td class="align-middle"><?= $data_unactive['nip'] ?></td>
                      <td class="align-middle"><?= $data_unactive['nama'] ?></td>
                      <td class="align-middle"><?= $data_unactive['no_telpon'] ?></td>
                      <td class="align-middle"><?= $data_unactive['username'] ?></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalActive<?= $data_unactive['username']; ?>">Aktif</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $data_unactive['username']; ?>">Hapus</button>
                      </td>
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $data_unactive['username']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $username = $data_unactive['username'];
                                $edits = query_data("SELECT * FROM data_pegawai WHERE username='$username'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                  <p>Yakin untuk menghapus data ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="delete_pegawai" class="btn btn-danger ml-2">Hapus</button>
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
                      <div class="modal fade" id="modalActive<?= $data_unactive['username']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Aktifkan akun</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $username = $data_unactive['username'];
                                $edits = query_data("SELECT * FROM data_pegawai WHERE username='$username'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                  <p>Yakin untuk mengaktifkan akun ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="active" class="btn btn-info ml-2 text-white">Aktif</button>
                                  </div>
                                <?php
                                endforeach
                                ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Edit -->
                    </tr>
                  <?php
                    $nos++;
                  endforeach;
                  ?>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
  require './views/script.php';
  if (isset($_POST['active'])) {
    if (active($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil diaktifkan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("pegawai.php");
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
                    text: "Gagal diaktifkan",
                    icon: "error",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("pegawai.php");
                    }else{
                        //if no clicked => do something else
                    }
                });
            </script>
        ';
    }
  }
  if (isset($_POST['delete_pegawai'])) {
    if (delete($_POST) > 0) {
      echo '
            <script type="text/javascript">
                swal({
                    title: "Berhasil",
                    text: "Berhasil dihapus",
                    icon: "success",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("pegawai.php");
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
                        window.location.replace("pegawai.php");
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