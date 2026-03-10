<?php
session_start();
include '../config.php';

$error = "";

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    // CEK PERSETUJUAN
    if(!isset($_POST['agree'])){
        $error = "Anda harus menyetujui Syarat & Ketentuan sebelum login.";
    } else {

        $stmt = mysqli_prepare($conn,
            "SELECT * FROM users WHERE email=? AND role='mahasiswa'"
        );
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user   = mysqli_fetch_assoc($result);

        if($user){
            if(password_verify($pass, $user['password'])){
                $_SESSION['user'] = $user;
                header("Location: ../mahasiswa/dashboard.php");
                exit;
            }else{
                $error = "Password salah!";
            }
        }else{
            $error = "Email belum terdaftar!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Mahasiswa | Universitas Satmata</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

/* PERSETUJUAN */
.policy{
    margin-top:6px;
    font-size:12.5px;
    color:#6b7280;
    line-height:1.6;
}
.policy-wrap{
    display:flex;
    align-items:flex-start;
    gap:10px;
    cursor:pointer;
}
.policy-wrap input{
    margin-top:4px;
}
.policy-wrap span{
    display:block;
}
.policy a{
    color:#2563eb;
    text-decoration:none;
    font-weight:500;
}
.policy a:hover{
    text-decoration:underline;
}

/* LINKS */
.links{
    margin-top:14px;
    font-size:14px;
    line-height:1.9;
}
.links a{
    color:#2563eb;
    text-decoration:none;
    font-weight:500;
}

/* ADMIN BTN */
.admin-btn{
    display:inline-block;
    padding:10px 20px;
    background:#dc2626;
    color:#fff;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}

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
            <img src="../assets/usat.jpg">
            <span>Universitas Satmata</span>
        </div>

        <h2>Login Mahasiswa</h2>
        <p class="desc">
            Silakan masuk untuk mengakses sistem
            Penerimaan Mahasiswa Baru Universitas Satmata.
        </p>

        <?php if($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button name="login">Login</button>

            <!-- PERSETUJUAN WAJIB -->
            <div class="policy">
                <label class="policy-wrap">
                    <input type="checkbox" name="agree" required>
                    <span>
                        Saya menyetujui
                        <a href="#">Syarat & Ketentuan</a>
                        dan
                        <a href="#">Kebijakan Privasi</a>
                        Universitas Satmata.
                        Jika tidak disetujui, akun tidak dapat login.
                    </span>
                </label>
            </div>
        </form>

        <div class="links">
            Belum punya akun? <a href="register.php">Daftar</a><br>
            <a href="../index.php">← Kembali ke Beranda</a><br><br>
        </div>
    </div>

    <div class="right"></div>
</div>

</body>
</html>
