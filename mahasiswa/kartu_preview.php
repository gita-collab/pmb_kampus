<?php
session_start();
include '../config.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'mahasiswa'){
    header("Location: ../auth/login.php");
    exit;
}

$email = $_SESSION['user']['email'];

// Ambil data mahasiswa
$stmt = mysqli_prepare($conn, "SELECT * FROM calon_mahasiswa WHERE email=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$mhs = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Cek daftar ulang
$stmt2 = mysqli_prepare($conn, "SELECT * FROM daftar_ulang WHERE email=? LIMIT 1");
mysqli_stmt_bind_param($stmt2, "s", $email);
mysqli_stmt_execute($stmt2);
$res2 = mysqli_stmt_get_result($stmt2);
$udah_daftar = mysqli_num_rows($res2) > 0;
mysqli_stmt_close($stmt2);

// Tampilkan NIM hanya jika daftar ulang
$nim = $udah_daftar ? $mhs['nim'] : 'Belum tersedia';
$tahun_masuk = date('Y');

// Status lulus
$is_lulus = $mhs['status_test'] == 'Lulus';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Preview Kartu Mahasiswa & Pengumuman</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f3f4f6;margin:0;padding:0;}
.wrapper{display:flex;flex-direction:column;align-items:center;gap:40px;padding:20px;}
.card, .announcement{width:380px;background:#fff;border-radius:16px;box-shadow:0 15px 35px rgba(0,0,0,.15);overflow:hidden;padding:0;}
.header{background:#1e3a8a;color:#fff;padding:12px 16px;display:flex;align-items:center;gap:12px;}
.header img{width:42px;height:42px;border-radius:50%;object-fit:cover;background:#fff;padding:3px;border:2px solid #fff;}
.header h3{font-size:14px;margin:0;}
.content{display:flex;padding:16px;gap:16px;}
.photo img{width:90px;height:110px;border-radius:10px;object-fit:cover;border:2px solid #1e3a8a;}
.data{text-align:left;font-size:13px;}
.data h4{margin:0 0 6px;font-size:15px;}
.data p{margin:4px 0;}
.btn{margin:10px 0;padding:12px 28px;background:#1e3a8a;color:#fff;border:none;border-radius:12px;font-weight:600;cursor:pointer;display:inline-block;text-decoration:none;}
.status-box{text-align:center;margin:15px 0;padding:12px;border-radius:6px;font-weight:bold;color:white;background-color:#28a745;}
.status-box.no{background-color:#dc3545;}
.info-table{width:100%;border-collapse:collapse;font-size:13px;margin:10px 0;}
.info-table td{padding:8px;border:1px solid #ddd;}
.info-table td.label{background:#1e3a8a;color:#fff;font-weight:bold;width:40%;}
.info-table td.value{background:#f8f9fa;}
.signature{text-align:right;margin-top:30px;}
.signature-box{margin-top:60px;border-top:1px solid #000;width:180px;display:inline-block;padding-top:3px;text-align:center;}
</style>
</head>
<body>
<div class="wrapper">

    <!-- PENGUMUMAN KELULUSAN -->
    <div class="announcement">
        <div class="header">
            <img src="../assets/usat.jpg" alt="Logo">
            <h3>UNIVERSITAS SATMATA</h3>
        </div>
        <div class="content" style="flex-direction:column;">
            <div class="status-box <?= $is_lulus?'':'no' ?>">
                <?= $is_lulus ? '✅ SELAMAT! ANDA DINYATAKAN LULUS' : '❌ MOHON MAAF, ANDA BELUM LULUS' ?>
            </div>
            <table class="info-table">
                <tr><td class="label">Nama Lengkap</td><td class="value"><?= htmlspecialchars($mhs['nama']) ?></td></tr>
                <tr><td class="label">Prodi</td><td class="value"><?= htmlspecialchars($mhs['prodi']) ?></td></tr>
                <tr><td class="label">Nilai Test</td><td class="value"><?= $mhs['nilai'] ?? '-' ?> / 100</td></tr>
                <tr><td class="label">NIM</td><td class="value"><?= $nim ?></td></tr>
                <tr><td class="label">Tahun Masuk</td><td class="value"><?= $tahun_masuk ?></td></tr>
            </table>
            <div class="signature">
                <strong>Panitia Penerimaan Mahasiswa Baru</strong>
                <div class="signature-box">(Tanda Tangan & Cap)</div>
            </div>
        </div>
        <a href="pengumuman_pdf.php" class="btn">Cetak PDF Pengumuman Kelulusan</a>
    </div>

</div>
</body>
</html>
