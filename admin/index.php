<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <?php
  require './views/link.php';
  ?>
</head>

<body>
  <!-- Nav Sidebar -->
  <?php
  $page = 1;
  require './views/sidebar.php';
  ?>

  <!-- Main Content -->
  <main class="content">
    <?php
    require './views/navbar.php';
    ?>

    <section class="p-3">
      <div class="header">
        <h3>Dashboard</h3>
        <p>Manage data for growth</p>
      </div>

      <div class="information d-flex flex-column gap-5">
        <div class="row px-1 mb-2 gap-5">
          <div class="col-xl-4 col-12 card balance">
            <p>Total Akun Pegawai</p>
            <h2>56 Akun</h2>
          </div>
          <div class="col-xl-4 col-12 card balance">
            <p>Total Barang</p>
            <h2>56 Barang</h2>
          </div>
          <div class="col-xl-4 col-12 card balance">
            <p>Total Barang Pinjam</p>
            <h2>56 Barang</h2>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
  require './views/script.php';
  ?>
</body>

</html>