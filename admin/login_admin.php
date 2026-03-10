<?php
session_start();
include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* =========================
   BUAT ADMIN OTOMATIS (SEKALI SAJA)
========================= */
$fullname = "Admin PMB";
$email    = "admin@usat.ac.id";
$password = "Admin221423!";
$role     = "admin";

// cek admin sudah ada atau belum
$cek = $conn->prepare("SELECT id FROM users WHERE email=? AND role='admin'");
$cek->bind_param("s", $email);
$cek->execute();
$cek->store_result();

if ($cek->num_rows == 0) {
    // jika belum ada → buat admin
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $conn->prepare(
        "INSERT INTO users (fullname, email, password, role) VALUES (?,?,?,?)"
    );
    $insert->bind_param("ssss", $fullname, $email, $hash, $role);
    $insert->execute();
}

/* =========================
   PROSES LOGIN
========================= */
$error = "";

if (isset($_POST['login'])) {
    $email_input    = $_POST['email'];
    $password_input = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password_input, $admin['password'])) {
            $_SESSION['admin'] = [
                'id'       => $admin['id'],
                'fullname' => $admin['fullname'],
                'email'    => $admin['email'],
                'role'     => $admin['role']
            ];
            header("Location: dashboard_admin.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email admin tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{
    min-height:100vh;
    background:#f4f6fb;
    display:flex;
    justify-content:center;
    align-items:center;
}
.wrapper{
    width:1100px;
    min-height:600px;
    background:#fff;
    border-radius:22px;
    box-shadow:0 30px 70px rgba(0,0,0,.15);
    display:grid;                           
    grid-template-columns:1fr 1.35fr;
    overflow:hidden;
}
.left{
    padding:64px 60px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}
.brand{
   display:flex;
   align-items:center;
   gap:14px;
   margin-bottom:44px;
}
.brand img{
    width:52px;
    height:52px;
    border-radius:50%;
    object-fit:cover;
}
.brand span{
    font-size:18px;
    font-weight:700;
    color:#000;
}
h2{
    font-size:30px;
    font-weight:700;
    color:#1e3a8a;
    margin-bottom:10px;
}
.desc{
    font-size:14px;
    color:#6b7280;
    line-height:1.7;
    margin-bottom:30px;
    max-width:360px;
}
.error{
    background:#fee2e2;
    color:#b91c1c;
    padding:12px;
    border-radius:10px;
    font-size:14px;
    margin-bottom:16px;
}
.form-group{margin-bottom:18px}
.form-group label{
    font-size:13px;
    font-weight:500;
    color:#374151;
    margin-bottom:6px;
    display:block;
}
input{
    width:100%;
    padding:14px 16px;
    border-radius:12px;
    border:1px solid #d1d5db;
    font-size:14px;
}
input:focus{
    outline:none;
    border-color:#2563eb;
}
button{
    width:100%;
    padding:14px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:14px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    margin-bottom:14px;
}
button:hover{background:#1e40af}

/* RIGHT IMAGE */
.right{
    min-height:600px;
    background:
        linear-gradient(rgba(30,58,138,.35), rgba(30,58,138,.45)),
        url("https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1400&q=80");
    background-size:cover;
    background-position:center;
}
@media(max-width:900px){
    .wrapper{width:94%;grid-template-columns:1fr}
    .right{min-height:260px}
}
</style>
</head>

<body>

<div class="wrapper">

    <div class="left">
        <div class="brand">
            <img src="../assets/usat.jpg" alt="Logo">
            <span>Universitas Satmata</span>
        </div>

        <h2>Login Admin</h2>
        <p class="desc">
            Silakan masuk menggunakan akun admin untuk mengelola sistem PMB Universitas Satmata.
        </p>

        <?php if($error != ""): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login">Login</button>
        </form>
    </div>

    <div class="right"></div>

</div>

</body>
</html>
