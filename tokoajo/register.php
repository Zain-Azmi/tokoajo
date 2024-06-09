<?php
require 'function.php';

function showAlert($type, $message) {
    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
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
                                    $confirmPassword = $_POST['confirmPassword'];
                                
                                    if ($password !== $confirmPassword) {
                                        showAlert("danger", "Password dan konfirmasi password tidak sama.");
                                    } else {
                                        // Cek apakah username sudah ada
                                        $sql = "SELECT username FROM user WHERE username=?";
                                        $stmt = $koneksi->prepare($sql);
                                        $stmt->bind_param("s", $username);
                                        $stmt->execute();
                                        $stmt->store_result();
                                
                                        if ($stmt->num_rows > 0) {
                                            showAlert("danger", "Username sudah ada.");
                                        } else {
                                            // Tambahkan user baru
                                            $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
                                            $stmt = $koneksi->prepare($sql);
                                            $stmt->bind_param("ss", $username, $password);
                                
                                            if ($stmt->execute()) {
                                                echo "<script type='text/javascript'>
                                                        window.location.href = 'login.php?success=1';
                                                    </script>";
                                            } else {
                                                showAlert("danger", "Error: " . $sql . "<br>" . $koneksi->error);
                                            }
                                        }
                                
                                        $stmt->close();
                                        $koneksi->close();
                                    }
                                }
                                ?>

                                <div class="card-body">
                                    <form method="post">
                                    <div class="form-floating mb-4">
                                                <input class="form-control" name="username" id="inputUsername" type="text" placeholder="Username" required/>
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-floating mb-4">
                                                <input class="form-control" name="confirmPassword" id="inputPassword" type="password" placeholder="confirmPassword" required/>
                                                <label for="inputPassword">Konfirmasi Passwrord</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" name="register" type="submit">Buat Akun</button>
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
