<?php
include '../config.php';

$error = "";
$success = "";

if(isset($_POST['daftar'])){
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $hp     = mysqli_real_escape_string($conn, $_POST['hp']);
    $asal   = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $prodi  = mysqli_real_escape_string($conn, $_POST['jurusan']);

    // CEK EMAIL
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($cek) > 0){
        $error = "Email sudah terdaftar!";
    }else{
        // USERS (LOGIN)
        mysqli_query($conn, "
            INSERT INTO users (fullname, email, password, role)
            VALUES ('$nama', '$email', '$pass', 'mahasiswa')
        ");

        // DATA PMB
        mysqli_query($conn, "
            INSERT INTO calon_mahasiswa
            (nama, email, phone, asal_sekolah, prodi, alamat, tanggal_daftar)
            VALUES
            ('$nama', '$email', '$hp', '$asal', '$prodi', '$alamat', CURDATE())
        ");

        $success = "Registrasi berhasil! Silakan login.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi Mahasiswa | Universitas Satmata</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* RESET & BODY */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    min-height:100vh;
    background:#f4f6fb;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.card{
    width:720px;
    max-width:100%;
    background:#fff;
    border-radius:24px;
    box-shadow:0 30px 70px rgba(0,0,0,.15);
    display:flex;
    flex-direction:column;
    overflow:hidden;
    padding:40px;
}

/* BRAND */
.brand{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:30px;
}
.brand img{
    width:60px;
    height:60px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #2563eb;
    padding:3px;
}
.brand span{
    font-size:20px;
    font-weight:700;
    color:#1e3a8a;
}

/* TITLE & DESC */
h2{
    font-size:28px;
    font-weight:700;
    color:#1e3a8a;
    margin-bottom:8px;
}
.desc{
    font-size:15px;
    color:#6b7280;
    line-height:1.6;
    margin-bottom:28px;
}

/* ALERT */
.error, .success{
    padding:12px 14px;
    border-radius:12px;
    font-size:14px;
    margin-bottom:20px;
}
.error{background:#fee2e2;color:#b91c1c;}
.success{background:#dcfce7;color:#166534;}

/* FORM */
.form-group{margin-bottom:18px;}
.form-group label{
    display:block;
    font-size:13px;
    font-weight:500;
    color:#374151;
    margin-bottom:6px;
}
input, select, textarea{
    width:100%;
    padding:14px 16px;
    font-size:14px;
    border-radius:12px;
    border:1px solid #d1d5db;
    transition:0.3s;
}
input:focus, select:focus, textarea:focus{
    outline:none;
    border-color:#2563eb;
}
textarea{resize:none;height:95px;}

/* BUTTON */
button{
    width:100%;
    padding:16px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:14px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:16px;
    transition:0.3s;
}
button:hover{background:#1e40af}

/* LINKS */
.links{
    margin-top:18px;
    font-size:14px;
    line-height:1.8;
}
.links a{
    color:#2563eb;
    text-decoration:none;
    font-weight:500;
}
.admin-btn{
    display:inline-block;
    padding:10px 22px;
    background:#dc2626;
    color:#fff;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    margin-top:12px;
    transition:0.3s;
}
.admin-btn:hover{opacity:0.85}

/* RESPONSIVE */
@media(max-width:720px){
    .card{width:100%;padding:20px;}
    .brand img{width:50px;height:50px;}
    .brand span{font-size:18px;}
    h2{font-size:24px;}
}
</style>
</head>
<body>

<div class="card">
    <div class="brand">
        <img src="../assets/usat.jpg" alt="Logo Universitas Satmata">
        <span>Universitas Satmata</span>
    </div>

    <h2>Registrasi Mahasiswa Baru</h2>
    <p class="desc">Silakan isi form di bawah untuk mendaftar sebagai mahasiswa baru Universitas Satmata.</p>

    <?php if($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input name="nama" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>No. HP</label>
            <input name="hp" required>
        </div>

        <div class="form-group">
            <label>Asal Sekolah</label>
            <input name="asal_sekolah" required>
        </div>

        <div class="form-group">
            <label>Program Studi</label>
            <select name="jurusan">
                <option>Informatika</option>
                <option>Manajemen</option>
                <option>Akuntansi</option>
            </select>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" required></textarea>
        </div>

        <button name="daftar">Daftar Sekarang</button>
    </form>

    <div class="links">
        Sudah punya akun? <a href="login.php">Login</a><br>
        <a href="../index.php">← Kembali ke Beranda</a><br>
    </div>
</div>

</body>
</html>
