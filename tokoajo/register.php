<?php
require 'function.php';

function showAlert($type, $message) {
    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
          </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - Toko Ajo Lpn</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<style>
    .inputsalah {
    border-color: #dc3545 !important;
    }
</style>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4"><i class="fa-solid fa-user-plus"></i> Buat Akun</h3></div>
                                
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $username = $_POST['username'];
                                    $password = $_POST['password'];
                                    $konfirmasipassword = $_POST['confirmPassword'];

                                    // Cek apakah username sudah ada
                                    $sqlcheckusername = "SELECT username FROM user WHERE username=?";
                                    $stmtcheckusername = $koneksi->prepare($sqlcheckusername);
                                    $stmtcheckusername->bind_param("s", $username);
                                    $stmtcheckusername->execute();
                                    $stmtcheckusername->store_result();

                                    if ($stmtcheckusername->num_rows > 0) {
                                        showAlert("danger", "Username sudah ada.");
                                        $usernamesalah = "inputsalah";
                                        $passwordsalah = "";
                                    } else {
                                        // Jika username belum ada, lanjutkan ke validasi password
                                        $usernamesalah = "";
                                        if ($password !== $konfirmasipassword) {
                                            showAlert("danger", "Password dan konfirmasi password tidak sama.");
                                            $passwordsalah = "inputsalah";
                                        } else {
                                            // Tambahkan user baru
                                            $sqlinsertuser = "INSERT INTO user (username, password) VALUES (?, ?)";
                                            $stmtinsertuser = $koneksi->prepare($sqlinsertuser);
                                            if (!$stmtinsertuser) {
                                                die('Error: ' . $koneksi->error);
                                            }
                                            $stmtinsertuser->bind_param("ss", $username, $konfirmasipassword);

                                            if ($stmtinsertuser->execute()) {
                                                echo "<script type='text/javascript'>
                                                        window.location.href = 'login.php?success=1';
                                                    </script>";
                                            } else {
                                                showAlert("danger", "Error: " . $sqlinsertuser . "<br>" . $koneksi->error);
                                            }
                                        }
                                    }

                                    $stmtcheckusername->close();
                                    if (isset($stmtinsertuser)) {
                                        $stmtinsertuser->close();
                                    }
                                    $koneksi->close();
                                }
                                ?>

                                <div class="card-body">
                                    <form method="post">
                                    <div class="form-floating mb-4">
                                                <input class="form-control <?= $usernamesalah ?>" name="username" id="inputUsername" type="text" placeholder="Username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required/>
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input class="form-control <?= $passwordsalah ?>" name="password" id="inputPassword" type="password" placeholder="Password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input class="form-control <?= $passwordsalah ?>" name="confirmPassword" id="inputPassword" type="password" placeholder="confirmPassword" required/>
                                                <label for="inputPassword">Konfirmasi Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" id="data-target" name="register" type="submit">Buat Akun</button>
                                                <br><br>
                                            </div>
                                    </form>
                                    <br>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="login.php">Sudah punya akun? Pindah ke login.</a></div>
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
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>
