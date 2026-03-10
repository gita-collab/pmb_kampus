<?php
session_start();
include '../config.php';

if(!isset($_SESSION['mhs'])){
    header("Location: ../auth/login_ujian.php");
    exit;
}

$mhs = $_SESSION['mhs'];

/* ================== AMBIL FOTO DARI PROFIL ================== */
$qFoto = mysqli_query($conn,"SELECT foto FROM calon_mahasiswa WHERE id='".$mhs['id']."' LIMIT 1");
$dFoto = mysqli_fetch_assoc($qFoto);
$foto  = (!empty($dFoto['foto'])) ? $dFoto['foto'] : 'default.jpg';

/* ================== AMBIL SOAL ================== */
$result = mysqli_query($conn,"
    SELECT * FROM soal 
    WHERE prodi='".mysqli_real_escape_string($conn,$mhs['prodi'])."' 
    ORDER BY id ASC
");
$soal = [];
while($r = mysqli_fetch_assoc($result)){
    $soal[] = $r;
}

/* ================== TIMER (30 MENIT) ================== */
$durasi = 30; // menit
if(!isset($_SESSION['waktu_selesai'])){
    $_SESSION['waktu_selesai'] = time() + ($durasi * 60);
}
$waktu_selesai = $_SESSION['waktu_selesai'];

/* ================== SUBMIT UJIAN ================== */
if(isset($_POST['submit'])){
    $nilai = 0;

    mysqli_query($conn,"DELETE FROM jawaban WHERE mahasiswa_id='".$mhs['id']."'");

    foreach($soal as $s){
        $jawaban = strtoupper($_POST['jawaban'][$s['id']] ?? '');

        mysqli_query($conn,"
            INSERT INTO jawaban (mahasiswa_id, soal_id, jawaban)
            VALUES ('".$mhs['id']."','".$s['id']."','$jawaban')
        ");

        if($jawaban === strtoupper($s['jawaban'])){
            $nilai += 10;
        }
    }

    $status = ($nilai >= 70) ? 'Lulus' : 'Tidak Lulus';

    // FORMAT NIM: 3 digit tahun + 4 digit prodi + 3 digit random
    $nim = null;
    if($status === 'Lulus'){
        $tahun = date('y'); // contoh: 26
        $kodeProdi = str_pad($mhs['id'] % 10000, 4, '0', STR_PAD_LEFT);
        $acak = rand(100,999);
        $nim = $tahun.$kodeProdi.$acak;
    }

    mysqli_query($conn,"
        UPDATE calon_mahasiswa SET
        nilai_test=$nilai,
        status_test='$status',
        nim='$nim'
        WHERE id='".$mhs['id']."'
    ");

    $_SESSION['mhs']['nilai_test']  = $nilai;
    $_SESSION['mhs']['status_test'] = $status;
    $_SESSION['mhs']['nim']         = $nim;

    unset($_SESSION['waktu_selesai']);

    header("Location: hasil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Ujian <?= htmlspecialchars($mhs['prodi']) ?></title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body{
    background:#f0f4f8;
    font-family:'Poppins',sans-serif;
    padding:30px;
}

/* HEADER */
.header-card{
    background:#fff;
    border-radius:18px;
    padding:20px 26px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
    margin-bottom:30px;
}
.header-left{
    display:flex;
    align-items:center;
    gap:18px;
}
.header-left img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #4338ca;
}
.header-left h4{
    margin:0;
    color:#1e3a8a;
    font-weight:600;
}
.header-left p{
    margin:3px 0 0;
    color:#6b7280;
    font-size:14px;
}
.timer{
    background:#fef3c7;
    color:#b45309;
    font-weight:700;
    padding:12px 22px;
    border-radius:14px;
    font-size:18px;
}

/* SOAL */
h2{
    text-align:center;
    margin-bottom:24px;
    color:#1e3a8a;
}
.card-soal{
    background:#fff;
    padding:22px;
    border-radius:18px;
    box-shadow:0 10px 26px rgba(0,0,0,.08);
    margin-bottom:20px;
}
.card-soal p{
    font-weight:600;
    margin-bottom:14px;
}
.opsi{
    display:flex;
    flex-direction:column;
    gap:10px;
}
.opsi label{
    background:#eef2ff;
    padding:12px 16px;
    border-radius:12px;
    cursor:pointer;
}
.opsi input{
    margin-right:10px;
}

/* BUTTON */
.submit-btn{
    display:block;
    margin:34px auto 0;
    padding:14px 34px;
    background:linear-gradient(135deg,#4338ca,#1e3a8a);
    color:#fff;
    border:none;
    border-radius:16px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}
</style>

<script>
let endTime = <?= $waktu_selesai ?> * 1000;

function countdown(){
    let now = new Date().getTime();
    let diff = endTime - now;

    if(diff <= 0){
        document.getElementById('timer').innerHTML = "Waktu Habis";
        document.getElementById('ujianForm').submit();
        return;
    }

    let m = Math.floor(diff / (1000*60));
    let s = Math.floor((diff % (1000*60)) / 1000);

    document.getElementById('timer').innerHTML = m + " : " + (s < 10 ? "0"+s : s);
    setTimeout(countdown,1000);
}
</script>
</head>

<body onload="countdown()">

<div class="header-card">
    <div class="header-left">
        <img src="../assets/foto_mhs/<?= htmlspecialchars($foto) ?>"
             onerror="this.src='../assets/foto_mhs/default.jpg'">
        <div>
            <h4><?= htmlspecialchars($mhs['nama']) ?></h4>
            <p><?= htmlspecialchars($mhs['prodi']) ?></p>
        </div>
    </div>
    <div class="timer" id="timer">--</div>
</div>

<h2>Soal Ujian</h2>

<form id="ujianForm" method="POST">
<?php foreach($soal as $s): ?>
<div class="card-soal">
    <p><?= htmlspecialchars($s['pertanyaan']) ?></p>
    <div class="opsi">
        <label><input type="radio" name="jawaban[<?= $s['id'] ?>]" value="A" required> <?= htmlspecialchars($s['opsi_a']) ?></label>
        <label><input type="radio" name="jawaban[<?= $s['id'] ?>]" value="B"> <?= htmlspecialchars($s['opsi_b']) ?></label>
        <label><input type="radio" name="jawaban[<?= $s['id'] ?>]" value="C"> <?= htmlspecialchars($s['opsi_c']) ?></label>
        <label><input type="radio" name="jawaban[<?= $s['id'] ?>]" value="D"> <?= htmlspecialchars($s['opsi_d']) ?></label>
    </div>
</div>
<?php endforeach; ?>

<button class="submit-btn" name="submit">Submit Jawaban</button>
</form>

</body>
</html>
