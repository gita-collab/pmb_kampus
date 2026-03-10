<?php
session_start();
include '../config.php';

if(!isset($_SESSION['mhs'])) {
    header("Location: ../auth/login_ujian.php");
    exit;
}

$mhs = $_SESSION['mhs'];
$id_mhs = $mhs['id'];

/* =====================
   HITUNG NILAI DARI DB
   ===================== */

// HITUNG JUMLAH JAWABAN BENAR
$q = mysqli_query($conn, "
    SELECT COUNT(*) AS total_benar
    FROM jawaban j
    JOIN soal s ON j.soal_id = s.id
    WHERE j.mahasiswa_id = '$id_mhs'
      AND j.jawaban = s.jawaban
");

$data = mysqli_fetch_assoc($q);
$total_benar = $data['total_benar'] ?? 0;

// SETIAP SOAL 10 POINT
$nilai = $total_benar * 10;

// STATUS KELULUSAN
$status_lulus = ($nilai >= 75) ? 'Lulus' : 'Tidak Lulus';

/* =====================
   SIMPAN KE DATABASE
   ===================== */
mysqli_query($conn, "
    UPDATE calon_mahasiswa 
    SET nilai_test = '$nilai',
        status_test = '$status_lulus',
        tanggal_test = CURDATE()
    WHERE id = '$id_mhs'
");

/* UPDATE SESSION */
$_SESSION['mhs']['nilai_test'] = $nilai;
$_SESSION['mhs']['status_test'] = $status_lulus;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Ujian</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{
    background:linear-gradient(135deg,#f5f7fb,#e8ecf1);
    padding:60px 20px;
    min-height:100vh;
}
.card{
    background:#fff;
    max-width:500px;
    margin:auto;
    padding:50px 40px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 16px 40px rgba(0,0,0,0.1)
}
.card img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #1e3a8a;
    margin-bottom:20px;
}
.status{
    display:inline-block;
    padding:14px 28px;
    border-radius:12px;
    font-weight:700;
    margin:20px 0;
    color:#fff;
}
.lulus{background:#16a34a}
.tidak{background:#dc2626}
.message{font-size:14px;color:#6b7280}
.message.error{color:#dc2626}
.btn{
    display:inline-block;
    margin-top:32px;
    padding:12px 32px;
    border-radius:12px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    font-weight:600;
}
</style>
</head>

<body>

<div class="card">
    <img src="../assets/foto_mhs/<?= $mhs['foto'] ?: 'default.jpg' ?>">
    <h2><?= htmlspecialchars($mhs['nama']) ?></h2>
    <p><?= htmlspecialchars($mhs['prodi']) ?></p>

    <div class="status <?= ($status_lulus=='Lulus')?'lulus':'tidak' ?>">
        <?= $status_lulus ?>
    </div>

    <?php if($status_lulus != 'Lulus'): ?>
        <p class="message error">
            Anda tidak lulus dan tidak dapat melakukan daftar ulang.
        </p>
    <?php else: ?>
        <p class="message">
            Selamat! Anda dinyatakan lulus dan dapat melakukan daftar ulang.
        </p>
    <?php endif; ?>

    <a href="dashboard.php" class="btn">← Kembali ke Dashboard</a>
</div>

</body>
</html>
