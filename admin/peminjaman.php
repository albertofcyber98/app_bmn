<?php
require './function/function_peminjaman.php';
require './function/function_global.php';
require  './function/send.php';
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
date_default_timezone_set("Asia/Makassar");
$username = $_SESSION['username'];
$permohonans = query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
data_pegawai.nama as nama, 
data_pegawai.nip as nip, 
data_peminjaman.id as id, 
data_peminjaman.jumlah as jumlah,
data_peminjaman.status as status,
data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
ON data_peminjaman.id_barang=data_barang.id INNER JOIN data_pegawai 
ON data_peminjaman.username=data_pegawai.username WHERE data_peminjaman.permohonan_peminjaman ='Pending'");

$pengembalians = query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
data_peminjaman.id as id, 
data_pegawai.nama as nama, 
data_pegawai.nip as nip, 
data_pegawai.username as username, 
data_peminjaman.jumlah as jumlah,
data_peminjaman.pesan as pesan,
data_peminjaman.status as status,
data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
ON data_peminjaman.id_barang=data_barang.id INNER JOIN data_pegawai 
ON data_peminjaman.username=data_pegawai.username WHERE data_peminjaman.permohonan_peminjaman ='Ya' AND data_peminjaman.pengembalian ='Pending'");

$riwayats = query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
data_peminjaman.id as id, 
data_pegawai.nama as nama, 
data_pegawai.nip as nip, 
data_peminjaman.jumlah as jumlah,
data_peminjaman.status as status,
data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
ON data_peminjaman.id_barang=data_barang.id INNER JOIN data_pegawai 
ON data_peminjaman.username=data_pegawai.username WHERE data_peminjaman.permohonan_peminjaman ='Ya' AND data_peminjaman.pengembalian ='Ya'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peminjaman</title>

  <?php
  require './views/link.php';
  ?>
</head>

<body>
  <!-- Nav Sidebar -->
  <?php
  $page = 5;
  require './views/sidebar.php';
  ?>

  <!-- Main Content -->
  <main class="content">
    <?php
    require './views/navbar.php';
    ?>

    <section class="p-3">
      <div class="header">
        <h3>Permohonan Peminjaman</h3>
        <p>Tabel data permohonan peminjaman</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="align-middle">NIP Pegawai</th>
                  <th class="align-middle">Nama Pegawai</th>
                  <th class="align-middle">Nama Barang</th>
                  <th class="align-middle">Jumlah</th>
                  <th class="align-middle">Tanggal Peminjaman</th>
                  <th class="align-middle">Tanggal Pengembalian</th>
                  <th class="align-middle">Keterangan</th>
                  <th class="text-center align-middle">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($permohonans === []) {
                ?>
                  <tr>
                    <td class="text-center" colspan="9">Data kosong</td>
                  </tr>
                  <?php
                } else {
                  $no = 1;
                  foreach ($permohonans as $permohonan) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $no ?></td>
                      <td class="align-middle"><?= $permohonan['nip'] ?></td>
                      <td class="align-middle"><?= $permohonan['nama'] ?></td>
                      <td class="align-middle"><?= $permohonan['nama_barang'] ?></td>
                      <td class="align-middle text-center"><?= $permohonan['jumlah'] ?></td>
                      <td class="align-middle"><?= format_tanggal($permohonan['tanggal_peminjaman']) ?></td>
                      <td class="align-middle"><?= format_tanggal($permohonan['tanggal_pengembalian']) ?></td>
                      <td class="align-middle"><?= $permohonan['status'] ?></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $permohonan['id']; ?>">Setujui</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $permohonan['id']; ?>">Hapus</button>
                      </td>
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $permohonan['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $permohonan['id'];
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
                      <div class="modal fade" id="modalEdit<?= $permohonan['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Setujui Peminjaman</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $permohonan['id'];
                                $edits = query_data("SELECT * FROM data_peminjaman WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                  <p>Yakin untuk menyetujui peminjaman ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="update_permohonan" class="btn btn-info ml-2 text-white">Setujui</button>
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
                    $no++;
                  endforeach;
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
        <h3>Permohonan Pengembalian</h3>
        <p>Tabel data permohonan pengembalian</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="align-middle">NIP Pegawai</th>
                  <th class="align-middle">Nama Pegawai</th>
                  <th class="align-middle">Nama Barang</th>
                  <th class="align-middle">Jumlah</th>
                  <th class="align-middle">Tanggal Peminjaman</th>
                  <th class="align-middle">Tanggal Pengembalian</th>
                  <th class="align-middle">Keterangan</th>
                  <th class="align-middle text-center">Kirim pesan</th>
                  <th class="text-center align-middle">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($pengembalians === []) {
                ?>
                  <tr>
                    <td class="text-center" colspan="9">Data kosong</td>
                  </tr>
                  <?php
                } else {
                  $nos = 1;
                  foreach ($pengembalians as $pengembalian) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $nos ?></td>
                      <td class="align-middle"><?= $pengembalian['nip'] ?></td>
                      <td class="align-middle"><?= $pengembalian['nama'] ?></td>
                      <td class="align-middle"><?= $pengembalian['nama_barang'] ?></td>
                      <td class="align-middle text-center"><?= $pengembalian['jumlah'] ?></td>
                      <td class="align-middle"><?= format_tanggal($pengembalian['tanggal_peminjaman']) ?></td>
                      <td class="align-middle"><?= format_tanggal($pengembalian['tanggal_pengembalian']) ?></td>
                      <td class="align-middle"><?= $pengembalian['status'] ?></td>
                      <td class="align-middle text-center">
                        <?php
                        $dateNow = date('Y-m-d');
                        if ($pengembalian['tanggal_pengembalian'] == $pengembalian['pesan'] && $pengembalian['pesan'] == $dateNow) {
                        ?>
                          <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalKirim<?= $pengembalian['id']; ?>">Kirim pesan</button>
                        <?php
                        } elseif ($pengembalian['pesan'] == $dateNow) {
                        ?>
                          <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalKirim<?= $pengembalian['id']; ?>">Kirim pesan</button>
                        <?php
                        } else if ($pengembalian['pesan'] > $dateNow) {
                        ?>
                        <?php
                        }
                        ?>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalEditPengembalian<?= $pengembalian['id']; ?>">Setujui</button>
                        <!-- <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $pengembalian['id']; ?>">Hapus</button> -->
                      </td>
                      <!-- Modal Kirim-->
                      <div class="modal fade" id="modalKirim<?= $pengembalian['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Kirim pesan</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $pengembalian['id'];
                                $edits = query_data("SELECT data_peminjaman.tanggal_peminjaman as tanggal_peminjaman,
                                              data_peminjaman.tanggal_pengembalian as tanggal_pengembalian, 
                                              data_peminjaman.id as id, 
                                              data_pegawai.nama as nama, 
                                              data_pegawai.no_telpon as no_telpon, 
                                              data_peminjaman.jumlah as jumlah,
                                              data_peminjaman.pesan as pesan,
                                              data_peminjaman.status as status,
                                              data_barang.nama_barang as nama_barang FROM data_peminjaman INNER JOIN data_barang
                                              ON data_peminjaman.id_barang=data_barang.id INNER JOIN data_pegawai 
                                              ON data_peminjaman.username=data_pegawai.username WHERE data_peminjaman.id=$id");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="no_telpon" value="<?= $edit['no_telpon']; ?>">
                                  <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                  <input type="hidden" name="nama" value="<?= $edit['nama']; ?>">
                                  <p>Mengirim pesan ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="kirim" class="btn btn-warning text-white ml-2">Kirim</button>
                                  </div>
                                <?php
                                endforeach
                                ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Modal Kirim -->
                      <!-- Modal Hapus-->
                      <div class="modal fade" id="modalHapus<?= $permohonan['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $permohonan['id'];
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
                      <div class="modal fade" id="modalEditPengembalian<?= $pengembalian['id']; ?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Setujui Pengembalian</h5>
                              <button type="button" data-bs-dismiss="modal" class="btn-close"></button>
                            </div>
                            <div class="modal-body">
                              <form role="form" action="" method="POST" autocomplete="off">
                                <?php
                                $id = $pengembalian['id'];
                                $edits = query_data("SELECT * FROM data_peminjaman WHERE id='$id'");
                                foreach ($edits as $edit) :
                                ?>
                                  <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                                  <p>Yakin untuk menyetujui pengembalian ?</p>
                                  <div class="flex text-center mt-4 mb-3">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="update_pengembalian" class="btn btn-info ml-2 text-white">Setujui</button>
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
        <h3>Riwayat Peminjaman</h3>
        <p>Tabel data riwayat peminjaman</p>
      </div>

      <div class="information-table d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col table-responsive">
            <table class="table table-hover table-bordered border-primary">
              <thead class="table-primary">
                <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="align-middle">NIP Pegawai</th>
                  <th class="align-middle">Nama Pegawai</th>
                  <th class="align-middle">Nama Barang</th>
                  <th class="align-middle">Jumlah</th>
                  <th class="align-middle">Tanggal Peminjaman</th>
                  <th class="align-middle">Tanggal Pengembalian</th>
                  <th class="align-middle">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($riwayats === []) {
                ?>
                  <tr>
                    <td class="text-center" colspan="9">Data kosong</td>
                  </tr>
                  <?php
                } else {
                  $noss = 1;
                  foreach ($riwayats as $riwayat) :
                  ?>
                    <tr>
                      <td class="align-middle text-center"><?= $noss ?></td>
                      <td class="align-middle"><?= $riwayat['nip'] ?></td>
                      <td class="align-middle"><?= $riwayat['nama'] ?></td>
                      <td class="align-middle"><?= $riwayat['nama_barang'] ?></td>
                      <td class="align-middle text-center"><?= $riwayat['jumlah'] ?></td>
                      <td class="align-middle"><?= format_tanggal($riwayat['tanggal_peminjaman']) ?></td>
                      <td class="align-middle"><?= format_tanggal($riwayat['tanggal_pengembalian']) ?></td>
                      <td class="align-middle"><?= $riwayat['status'] ?></td>
                    </tr>
                <?php
                    $noss++;
                  endforeach;
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
  if (isset($_POST['update_pengembalian'])) {
    if (setujui_pengembalian($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil ditambahkan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("peminjaman.php");
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
                          window.location.replace("peminjaman.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['update_permohonan'])) {
    if (setujui_permohonan($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil ditambahkan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("peminjaman.php");
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
                          window.location.replace("peminjaman.php");
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
                          window.location.replace("peminjaman.php");
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
                          window.location.replace("peminjaman.php");
                      }else{
                          //if no clicked => do something else
                      }
                  });
              </script>
          ';
    }
  }
  if (isset($_POST['kirim'])) {
    if (send($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil mengirim pesan",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("peminjaman.php");
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
                      text: "Gagal mengirim pesan",
                      icon: "error",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("peminjaman.php");
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