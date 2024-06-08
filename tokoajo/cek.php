<?php
// Jika Sudah Login
if(isset($_SESSION['log'])){
    
} else {
    header('location:login.php');
};

?>