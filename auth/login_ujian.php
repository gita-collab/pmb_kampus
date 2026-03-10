<?php
session_start();
include '../config.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $nomor = $_POST['nomor_test'];

    $q = mysqli_query($conn,"SELECT * FROM calon_mahasiswa WHERE email='$email' AND nomor_test='$nomor'");
    if(mysqli_num_rows($q)>0){
        $_SESSION['mhs'] = mysqli_fetch_assoc($q);
        header("Location: ../mahasiswa/ujian.php");
        exit;
    } else {
        $error = "Email / Nomor Test salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Ujian</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f0f4f8;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}
.card{
    background:#fff;
    padding:40px 30px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.1);
    max-width:400px;
    width:100%;
    text-align:center;
}
.card h2{
    color:#2563eb;
    margin-bottom:20px;
}
.card form{
    display:flex;
    flex-direction:column;
    gap:15px;
}
.card input{
    padding:12px 15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
.card button{
    background:#10b981;
    color:#fff;
    font-weight:600;
    border:none;
    cursor:pointer;
    padding:12px 15px;
    border-radius:8px;
    transition:0.3s;
}
.card button:hover{
    background:#059669;
}
.error{
    background:#fee2e2;
    padding:10px 15px;
    border-radius:8px;
    color:#b91c1c;
    margin-bottom:15px;
    font-weight:600;
}
</style>
</head>
<body>

<div class="card">
    <h2>Login Ujian</h2>

    <?php if(isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input name="email" type="email" placeholder="Email" required>
        <input name="nomor_test" placeholder="Nomor Test" required>
        <button name="login">Masuk Ujian</button>
    </form>

    <p style="margin-top:15px;font-size:14px;color:#6b7280;">
        Kembali ke <a href="../mahasiswa/dashboard.php" style="color:#2563eb;text-decoration:none;">Dashboard</a>
    </p>
</div>

</body>
</html>
