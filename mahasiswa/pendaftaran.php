<?php
session_start();
include '../config.php'; // pastikan $conn ada di config.php

if(isset($_POST['daftar'])){
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $school = $_POST['school_level'];
    $prodi = $_POST['prodi'];

    // Upload foto
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = 'foto_'.time().'.'.$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/'.$foto);
    } else {
        $foto = 'default.png';
    }

    // Nomor ujian otomatis
    $nomor_test = 'PMB'.date('Y').rand(1000,9999);

    // Simpan ke database
    mysqli_query($conn,"
        INSERT INTO calon_mahasiswa
        (nama,email,phone,school_level,prodi,foto,tanggal_daftar,nomor_test)
        VALUES ('$nama','$email','$phone','$school','$prodi','$foto',CURDATE(),'$nomor_test')
    ");

    $_SESSION['nomor_test'] = $nomor_test;
    $_SESSION['user_email'] = $email; // untuk login otomatis
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pendaftaran PMB</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f0f4f8;display:flex;justify-content:center;padding:50px 20px;}
.card{background:#fff;padding:40px 30px;border-radius:20px;box-shadow:0 15px 30px rgba(0,0,0,0.1);max-width:500px;width:100%;}
.card h2{text-align:center;color:#2563eb;margin-bottom:20px;}
.card form{display:flex;flex-direction:column;gap:15px;}
.card input, .card select, .card button{padding:12px 15px;border-radius:8px;border:1px solid #ccc;font-size:14px;}
.card input[type="file"]{padding:5px;}
.card button{background:#10b981;color:#fff;font-weight:600;border:none;cursor:pointer;transition:0.3s;}
.card button:hover{background:#059669;}
.success{background:#d1fae5;padding:12px 15px;border-radius:8px;margin-bottom:15px;color:#065f46;font-weight:600;text-align:center;}
#preview{width:120px;height:120px;border-radius:50%;margin:10px auto;display:block;object-fit:cover;border:2px solid #2563eb;}
</style>
</head>
<body>

<div class="card">
    <h2>Pendaftaran PMB</h2>

    <?php 
    if(isset($_SESSION['nomor_test'])){
        echo "<div class='success'>
              Pendaftaran sukses! Nomor ujian Anda: <b>{$_SESSION['nomor_test']}</b>
              </div>";
        unset($_SESSION['nomor_test']);
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <img id="preview" src="../uploads/default.png" alt="Preview Foto">
        <input name="nama" placeholder="Nama Lengkap" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="phone" placeholder="No HP" required>
        <select name="school_level" required>
            <option value="">Pilih Sekolah</option>
            <option value="SMA">SMA</option>
            <option value="SMK">SMK</option>
        </select>
        <input name="prodi" placeholder="Program Studi" required>
        <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)">
        <button name="daftar">Daftar Sekarang</button>
    </form>
</div>

<script>
function previewFoto(event){
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</body>
</html>
