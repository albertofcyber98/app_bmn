<?php
session_start();
require './function/function_signin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</head>

<body class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body py-4 ">
            <div class="row mx-3">
              <h3 class="mb-3">Sign in</h3>
            </div>
            <form action="" method="post">
              <div class="row mb-4 mx-3">
                <label class="form-label col-form-label-lg" for="typeEmailX-2">Username</label>
                <div>
                  <input type="text" id="typeEmailX-2" name="username" required class="form-control form-control-lg" />
                </div>
              </div>
              <div class="row mb-4 mx-3">
                <label class="col-form-label-lg form-label" for="typePasswordX-2">Password</label>
                <div>
                  <input type="password" id="typePasswordX-2" name="password" required class="form-control form-control-lg" />
                </div>
              </div>
              <div class="row mx-3">
                <div class="text-center">
                  <button class="btn btn-primary btn-lg" name="submit_signin" type="submit">Sign In</button>
                </div>
              </div>
            </form>
            <div class="row mx-3 mt-4">
              <p>Belum memiliki akun ? <a href="signup.html">Buat Akun</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php
  if (isset($_POST['submit_signin'])) {
    $username = $_POST['username'];
    if (signin($_POST) === true) {
      $_SESSION['username'] = $username;
      echo '
                    <script type="text/javascript">
                        swal({
                            title: "Berhasil",
                            text: "Berhasil Signin",
                            icon: "success",
                            showConfirmButton: true,
                        }).then(function(isConfirm){
                            if(isConfirm){
                                window.location.replace("index.php");
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
                            text: "Username dan Password Salah",
                            icon: "error",
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
    }
  }
  ?>
</body>

</html>