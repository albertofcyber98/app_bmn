<?php
require './function/function_signup.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</head>

<body class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong mb-5" style="border-radius: 1rem;">
          <div class="card-body py-4">
            <div class="row mx-3">
              <h3 class="mb-3">Sign up</h3>
              <p>Silahkan isi data dengan benar</p>
            </div>
            <form action="" method="post">
              <div class="row mb-2 mx-3">
                <label class="form-label " for="typeEmailX-2">Username</label>
                <div>
                  <input type="text" id="typeEmailX-2" class="form-control" name="username" />
                </div>
              </div>
              <div class="row mb-2 mx-3">
                <label class="form-label " for="typeEmailX-2">NIP</label>
                <div>
                  <input type="text" id="typeEmailX-2" class="form-control" name="nip" />
                </div>
              </div>
              <div class="row mb-2 mx-3">
                <label class="form-label " for="typeEmailX-2">Nama Pegawai</label>
                <div>
                  <input type="text" id="typeEmailX-2" class="form-control" name="nama" />
                </div>
              </div>
              <div class="row mb-2 mx-3">
                <label class="form-label " for="typeEmailX-2">Jenis Kelamin</label>
                <div class="d-flex">
                  <input type="radio" name="jenis_kelamin" value="L" id="Laki-laki">
                  <label for="Laki-laki">Laki-laki</label>
                </div>
                <div class="d-flex">
                  <input type="radio" name="jenis_kelamin" value="P" id="Perempuan">
                  <label for="Perempuan">Perempuan</label>
                </div>
              </div>
              <div class="row mb-2 mx-3">
                <label class="form-label " for="typeEmailX-2">No Whatsapp</label>
                <div>
                  <input type="text" id="typeEmailX-2" class="form-control" name="no_telpon" placeholder="+6282187298374" />
                </div>
              </div>
              <div class="row mb-4 mx-3">
                <label class=" form-label" for="typePasswordX-2">Password</label>
                <div>
                  <input type="password" id="typePasswordX-2" name="password" class="form-control" />
                </div>
              </div>
              <div class="row mb-4 mx-3">
                <label class=" form-label" for="typePasswordX-2">Ulangi Password</label>
                <div>
                  <input type="password" id="typePasswordX-2" name="repassword" class="form-control" />
                </div>
              </div>
              <div class="row mx-3">
                <div class="text-center">
                  <button class="btn btn-primary" name="submit" type="submit">Sign Up</button>
                </div>
              </div>
            </form>
            <div class="row mx-3 mt-4">
              <p>Sudah memiliki akun ? <a href="signin.php">Masuk</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php
  if (isset($_POST['submit'])) {
    $kondisi_username = $_POST['username'];
    $query = mysqli_query($conn, "SELECT*FROM data_pegawai WHERE username='$kondisi_username'");
    $result = mysqli_num_rows($query);
    if ($_POST['password'] !== $_POST['repassword']) {
      echo '
            <script type="text/javascript">
                swal({
                    title: "Gagal",
                    text: "Password dan repassword tidak sama",
                    icon: "error",
                    showConfirmButton: true,
                }).then(function(isConfirm){
                    if(isConfirm){
                        window.location.replace("signup.php");
                    }else{
                        //if no clicked => do something else
                    }
                });
            </script>
        ';
    } else if ($result === 0) {
      if (signup($_POST) > 0) {
        echo '
              <script type="text/javascript">
                  swal({
                      title: "Berhasil",
                      text: "Berhasil terdaftar, tunggu hingga terkonfirmasi admin",
                      icon: "success",
                      showConfirmButton: true,
                  }).then(function(isConfirm){
                      if(isConfirm){
                          window.location.replace("signin.php");
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
                          window.location.replace("signup.php");
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
                        window.location.replace("signup.php");
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