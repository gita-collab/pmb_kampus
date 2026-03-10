<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pmb";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Koneksi gagal");
}
?>
