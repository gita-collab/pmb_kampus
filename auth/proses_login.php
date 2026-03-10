<?php
include 'config.php';

$email = $_POST['email'];
$password = $_POST['password'];

// cek user
$q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($q);

if(!$user){
  die("Email tidak terdaftar");
}

// validasi password
if(!password_verify($password,$user['password'])){
  die("Password salah");
}

// ================= LOGIN MAHASISWA =================
if(isset($_POST['login_maba'])){
  if($user['role']!='maba'){
    die("Bukan akun mahasiswa");
  }
  $_SESSION['user']=$user;
  header("Location: dashboard_maba.php");
}

// ================= LOGIN ADMIN =================
if(isset($_POST['login_admin'])){
  if($user['role']!='admin'){
    die("Bukan akun admin");
  }
  $_SESSION['admin']=$user;
  header("Location: dashboard_admin.php");
}
