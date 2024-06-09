<?php
require 'function.php';

// Cek Login
$errorlogin = '';

if (isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari User ke Database
    $cekdatabase = mysqli_query($koneksi,"SELECT * from user WHERE username='$username' AND password='$password'");
    // Hitung Jumlah Data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung>0){
        $_SESSION['log'] = 'True';
        $_SESSION['username'] = $username;
        header('location:index.php');
    } else {
        $errorlogin = 'Username atau Password salah.';
    };
};

if(!isset($_SESSION['log'])){

} else {
    header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Toko Ajo Lpn</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><i class="fa-solid fa-right-to-bracket"></i> Login</h3></div>
                                    <div class="card-body">
                                        <!-- Alert Success -->
                                        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                Akun berhasil dibuat. Sekarang anda dapat login.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php endif; ?>
                                        <!-- Alert Error -->
                                        <?php if ($errorlogin): ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                <strong>Perhatian!</strong> <?= $errorlogin; ?>
                                            </div>
                                        <?php endif; ?>
                                        <form method="post">
                                            <br>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="username" id="inputUsername" type="text" placeholder="Username" required/>
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login" href="index.html">Login</button>
                                                <br><br>
                                            </div>
                                        </form>
                                        <br>
                                    </div>
                                        <div class="card-footer text-center">
                                            <div class="small"><a href="register.php">Belum punya akun?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
