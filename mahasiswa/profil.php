<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='mahasiswa'){
    header("Location: ../auth/login.php");
    exit;
}

include "../config.php";
$email = $_SESSION['user']['email'];

/* ===== SIMPAN PROFIL ===== */
if(isset($_POST['simpan'])){
    $nama   = $_POST['nama'];
    $jk     = $_POST['jenis_kelamin'];
    $tgl    = $_POST['tanggal_lahir'];
    $asal   = $_POST['asal_sekolah'];

    if(!empty($_FILES['foto']['name'])){
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $foto = "mhs_".time().".".$ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/foto_mhs/".$foto);

        mysqli_query($conn,"UPDATE calon_mahasiswa 
            SET nama='$nama', jenis_kelamin='$jk', tanggal_lahir='$tgl', asal_sekolah='$asal', foto='$foto'
            WHERE email='$email'");
    } else {
        mysqli_query($conn,"UPDATE calon_mahasiswa 
            SET nama='$nama', jenis_kelamin='$jk', tanggal_lahir='$tgl', asal_sekolah='$asal'
            WHERE email='$email'");
    }

    header("Location: profil.php");
    exit;
}

/* ===== DATA ===== */
$q = mysqli_query($conn,"SELECT * FROM calon_mahasiswa WHERE email='$email' LIMIT 1");
$m = mysqli_fetch_assoc($q);

$foto = !empty($m['foto']) ? "../assets/foto_mhs/".$m['foto'] : "../assets/foto_mhs/default.jpg";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Mahasiswa</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box}
body{
    background:#f5f7fb;
    font-family:'Poppins',sans-serif;
    padding:40px
}

/* ===== TOP BAR (DIPERBAIKI DI SINI SAJA) ===== */
.topbar{
    max-width:920px;
    margin:0 auto 26px;
    display:flex;
    justify-content:space-between;
    align-items:center
}
.brand{
    display:flex;
    align-items:center;
    gap:12px
}
.brand img{
    width:46px;
    height:46px;
    border-radius:50%;
    object-fit:cover
}
.brand span{
    font-weight:600;
    font-size:15px;
    color:#1e3a8a
}
.logout{
    padding:10px 22px;
    border-radius:12px;
    background:#dc2626;
    color:#fff;
    text-decoration:none;
    font-size:14px
}

/* ===== CARD ===== */
.card{
    max-width:920px;
    margin:auto;
    background:#fff;
    padding:42px;
    border-radius:24px;
    box-shadow:0 18px 40px rgba(0,0,0,.08)
}
.card h2{
    font-size:22px;
    font-weight:600;
    margin-bottom:32px
}

/* FOTO */
.photo-center{
    text-align:center;
    margin-bottom:34px
}
.photo-center img{
    width:160px;
    height:200px;
    object-fit:cover;
    border-radius:20px;
    border:4px solid #4338ca;
    margin-bottom:10px
}
.photo-center div{
    font-weight:600;
    color:#374151
}

/* FORM */
.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:22px;
    margin-bottom:22px
}
.form-group{
    display:flex;
    flex-direction:column
}
.form-group.full{
    grid-column:1/3
}
.form-group label{
    font-size:13px;
    color:#6b7280;
    margin-bottom:6px
}
.form-group input,
.form-group select{
    padding:12px 14px;
    border-radius:12px;
    border:1px solid #d1d5db
}

/* UPLOAD */
.upload-box{
    margin-top:28px;
    padding:20px;
    border:2px dashed #c7d2fe;
    border-radius:16px;
    background:#f8faff
}
.upload-box label{
    font-size:13px;
    color:#4338ca;
    font-weight:500
}

/* ACTION */
.actions{
    display:flex;
    justify-content:space-between;
    margin-top:36px
}
.actions button{
    padding:12px 40px;
    border-radius:14px;
    background:linear-gradient(135deg,#4338ca,#1e3a8a);
    color:#fff;
    border:none;
    cursor:pointer
}
.back{
    color:#4338ca;
    text-decoration:none;
    font-size:14px;
    align-self:center
}
</style>
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="brand">
        <img src="../assets/usat.jpg" alt="Universitas Satmata">
        <span>Universitas Satmata</span>
    </div>
    <a href="../auth/logout.php" class="logout">Logout</a>
</div>

<!-- CARD -->
<div class="card">
<h2>Profil Mahasiswa</h2>

<form method="POST" enctype="multipart/form-data">

<div class="photo-center">
    <img src="<?= $foto ?>">
    <div><?= htmlspecialchars($m['nama']) ?></div>
</div>

<div class="form-grid">

    <div class="form-group full">
        <label>Nama Lengkap</label>
        <input name="nama" value="<?= htmlspecialchars($m['nama']) ?>" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input value="<?= $m['email'] ?>" disabled>
    </div>

    <div class="form-group">
        <label>Program Studi</label>
        <input value="<?= $m['prodi'] ?>" disabled>
    </div>

    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin">
            <option value="">- Pilih -</option>
            <option <?= $m['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
            <option <?= $m['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
        </select>
    </div>

    <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="<?= $m['tanggal_lahir'] ?>">
    </div>

    <div class="form-group full">
        <label>Asal Sekolah</label>
        <input name="asal_sekolah" value="<?= $m['asal_sekolah'] ?>">
    </div>

</div>

<div class="upload-box">
    <label>Upload Foto Profil (JPG / PNG)</label><br><br>
    <input type="file" name="foto">
</div>

<div class="actions">
    <a class="back" href="dashboard.php">← Kembali</a>
    <button name="simpan">Simpan</button>
</div>

</form>
</div>

</body>
</html>
