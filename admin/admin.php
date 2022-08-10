<?php
require './function/function_admin.php';
require './function/function_global.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
$username = $_SESSION['username'];
$datas = query_data("SELECT*FROM data_admin");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>

  <?php
  require './views/link.php';
  ?>
</head>

<body>
  <!-- Nav Sidebar -->
  <?php
  $page = 2;
  require './views/sidebar.php';
  ?>

  <!-- Main Content -->
  <main class="content">
    <?php
    require './views/navbar.php';
    ?>

    <section class="p-3">
      <div class="header">
        <h3>Akun Admin</h3>
        <p>Tabel data akun admin</p>
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
                  <th class="align-middle">Nama</th>
                  <th class="align-middle">Username</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($datas as $data) :
                ?>
                  <tr>
                    <td class="align-middle text-center"><?= $no ?></td>
                    <td class="align-middle"><?= $data['nama'] ?></td>
                    <td class="align-middle"><?= $data['username'] ?></td>
                    <td class="text-center">
                      <?php
                      if ($_SESSION['username'] == $data['username']) {
                      ?>
                      <?php
                      } else {
                      ?>
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['username']; ?>">Ubah</button>
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
                              $edits = query_data("SELECT * FROM data_admin WHERE username='$username'");
                              foreach ($edits as $edit) :
                              ?>
                                <input type="hidden" name="username" value="<?= $edit['username']; ?>">
                                <p>Yakin untuk menghapus data ?</p>
                                <div class="flex text-center mt-4 mb-3">
                                  <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" name="delete_admin" class="btn btn-danger ml-2">Hapus</button>
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
                    <div class="modal fade" id="modalEdit<?= $data['username']; ?>" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Ubah Data</h5>
                            <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                          </div>
                          <div class="modal-body">
                            <form role="form" action="#" method="POST" autocomplete="off">
                              <?php
                              $username = $data['username'];
                              $edits = query_data("SELECT * FROM data_admin WHERE username='$username'");
                              foreach ($edits as $edit) :
                              ?>
                                <input type="hidden" class="form-control" name="username" value="<?= $edit['username']; ?>">
                                <div class="form-group row mt-3">
                                  <label class="col-4 col-form-label">Password</label>
                                  <div class="col-8">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                  </div>
                                </div>
                                <div class="form-group row mt-3">
                                  <label class="col-4 col-form-label">Nama</label>
                                  <div class="col-8">
                                    <input type="text" class="form-control" name="nama" value="<?= $edit['nama'] ?>" placeholder="Nama">
                                  </div>
                                </div>
                                <div class="flex text-center mt-4 mb-3">
                                  <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" name="update_admin" class="text-white btn btn-info ml-2">Ubah</button>
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
                          <label class="col-4 col-form-label">Username</label>
                          <div class="col-8">
                            <input type="text" class="form-control" name="username" required placeholder="Username">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Password</label>
                          <div class="col-8">
                            <input type="password" class="form-control" name="password" required placeholder="Password">
                          </div>
                        </div>
                        <div class="form-group row mt-3">
                          <label class="col-4 col-form-label">Nama</label>
                          <div class="col-8">
                            <input type="text" class="form-control" name="nama" required placeholder="Nama">
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
    $kondisi_username = $_POST['username'];
    $query = mysqli_query($conn, "SELECT*FROM data_admin WHERE username='$kondisi_username'");
    $result = mysqli_num_rows($query);
    if ($result === 0) {
      if (add_admin($_POST) > 0) {
        echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil ditambahkan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("admin.php");
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
                          window.location.replace("admin.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
      }
    } else {
      echo '
            <script type="text/javascript">
                swal({
                    title: "Gagal",
                    text: "Username sudah terdaftar",
                    icon: "error",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("admin.php");
                    }else{
                        //if no clicked => do something else
                    }
                });
            </script>
        ';
    }
  }
  if (isset($_POST['update_admin'])) {
    if (update_admin($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil diubah",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("admin.php");
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
                          window.location.replace("admin.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['delete_admin'])) {
    if (delete_admin($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil dihapus",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("admin.php");
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
                          window.location.replace("admin.php");
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