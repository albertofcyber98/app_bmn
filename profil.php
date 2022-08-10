<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
require './function/function_pegawai.php';
$username = $_SESSION['username'];
$queryResult = mysqli_query($conn, "SELECT*FROM data_pegawai WHERE username='$username'");
$result = mysqli_fetch_assoc($queryResult);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>

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
        <h3>Profil</h3>
        <p>Profil pegawai</p>
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
          <div class="col-9 col-md-8 col-lg-4 col-xl-4">
            <input type="hidden" name="username" value="<?= $username ?>">
            <div class="mt-4">
              <label for="" class="form-label">
                Nama Lengkap
              </label>
              <input type="text" value="<?= $result['nama'] ?>" name="nama" placeholder="<?= $result['nama'] ?>" class="form-control">
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                NIP
              </label>
              <input type="text" value="<?= $result['nip'] ?>" name="nip" placeholder="<?= $result['nip'] ?>" class="form-control">
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                Jenis Kelamin
              </label>
              <div class="row">
                <div>
                  <input <?= $result['jenis_kelamin'] == 'L' ? 'checked' : '' ?> type="radio" name="jenis_kelamin" value="L" id="laki-laki" class="align-items-center">
                  <label for="laki-laki" class="form-label">Laki-laki</label>
                </div>
                <div>
                  <input <?= $result['jenis_kelamin'] == 'P' ? 'checked' : '' ?> type="radio" class="ml-3" name="jenis_kelamin" value="P" id="perempuan">
                  <label for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                Nomor Handphone
              </label>
              <input type="text" value="<?= $result['no_telpon'] ?>" name="no_telpon" placeholder="0831782xxxxx" class="form-control">
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                Jabatan
              </label>
              <input type="text" value="<?= $result['jabatan'] ?>" name="jabatan" placeholder="<?= $result['jabatan'] ?>" class="form-control">
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                Unit Kerja
              </label>
              <input type="text" value="<?= $result['unit_kerja'] ?>" name="unit_kerja" placeholder="<?= $result['unit_kerja'] ?>" class="form-control">
            </div>
            <div class="mt-4">
              <label for="" class="form-label">
                Password
              </label>
              <input type="password" name="password" class="form-control">
            </div>
          </div>
        </div>
        <div class="text-center mt-4">
          <button class="btn btn-info text-white" name="submit_profil" type="submit">Update</button>
        </div>
      </form>
    </section>
  </main>

  <!-- Bootstrap JS -->
  <?php
  require './views/script.php';
  if (isset($_POST['submit_profil'])) {
    if (update_profil($_POST) > 0) {
      echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil diubah",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("profil.php");
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
                          window.location.replace("profil.php");
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