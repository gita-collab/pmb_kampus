<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='mahasiswa'){
    header("Location: ../auth/login.php");
    exit;
}

include "../config.php";

$email = $_SESSION['user']['email'];
$q = mysqli_query($conn,"SELECT * FROM calon_mahasiswa WHERE email='$email' LIMIT 1");
$mhs = mysqli_fetch_assoc($q);

/* ===== DATA ===== */
$nama   = $mhs['nama'];
$prodi  = $mhs['prodi'];
$status = $mhs['status_test'] ?: 'Belum';
$nomor_test = $mhs['nomor_test'];

/* ===== CEK PROFIL LENGKAP ===== */
$profil_lengkap = true;
$wajib = ['nama','prodi','alamat','phone','tanggal_lahir','foto'];

foreach($wajib as $f){
    if(empty($mhs[$f])){
        $profil_lengkap = false;
        break;
    }
}

/* ===== GENERATE NOMOR TEST ===== */
if(empty($nomor_test)){
    $nomor_test = "USAT-".date('Y')."-".rand(100000,999999);
    mysqli_query($conn,"UPDATE calon_mahasiswa SET nomor_test='$nomor_test' WHERE email='$email'");
}

/* ===== DAFTAR ULANG ===== */
$cek = mysqli_query($conn,"SELECT * FROM daftar_ulang WHERE email='$email' LIMIT 1");
$udah_daftar = mysqli_num_rows($cek) > 0;
$nim = $udah_daftar ? $mhs['nim'] : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Mahasiswa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#f5f7fb;display:flex;color:#1f2937;min-height:100vh;}
.sidebar{width:260px;min-height:100vh;position:fixed;background:linear-gradient(180deg,#1e3a8a,#4338ca);padding:30px 22px;color:#fff;}
.sidebar .brand{display:flex;align-items:center;gap:14px;margin-bottom:44px;}
.sidebar img{width:44px;height:44px;border-radius:50%;object-fit:cover;}
.sidebar h3{font-size:16px;font-weight:600;}
.sidebar a{display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:14px;border-radius:14px;color:#e0e7ff;text-decoration:none;font-size:14px;transition:.25s;}
.sidebar a.active,.sidebar a:hover{background:rgba(255,255,255,.18);color:#fff;}
.main{margin-left:260px;width:100%;padding:36px 44px;}
.header{background:#fff;padding:28px 34px;border-radius:22px;box-shadow:0 14px 34px rgba(0,0,0,.06);margin-bottom:32px;}
.header h2{font-size:22px;font-weight:600;}
.header p{font-size:14px;color:#6b7280;}
.info{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;margin-bottom:40px;}
.info-card{background:#fff;padding:26px 24px;border-radius:18px;box-shadow:0 12px 26px rgba(0,0,0,.05);}
.info-card h4{font-size:13px;color:#6b7280;}
.info-card p{font-size:20px;font-weight:600;}
.menu{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:30px;}
.card{background:#fff;padding:34px 30px;border-radius:22px;box-shadow:0 16px 36px rgba(0,0,0,.06);text-align:center;display:flex;flex-direction:column;}
.card i{font-size:44px;color:#4338ca;margin-bottom:14px;}
.card a,.card button{margin-top:auto;padding:12px 38px;border-radius:14px;border:none;color:#fff;background:linear-gradient(135deg,#4338ca,#1e3a8a);}
.card button{background:#9ca3af;}
.card.disabled{opacity:.6;}
.success{color:#16a34a;font-weight:600;}
.danger{color:#dc2626;font-weight:600;}
.alert{background:#fef3c7;color:#92400e;padding:16px 20px;border-radius:16px;margin-bottom:28px;}

.card.ujian-masuk .nomor-test{
    margin:14px 0 22px;
    font-size:18px;
    font-weight:700;
    color:#22c55e;
    background:#ecfdf5;
    padding:10px 18px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(34,197,94,.25);
}
</style>
</head>

<body>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/usat.jpg">
        <h3>Universitas Satmata</h3>
    </div>
    <a class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="profil.php"><i class="fa-solid fa-user"></i> Profil</a>
    <a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">

<?php if(!$profil_lengkap): ?>
<div class="alert">
    ⚠️ <b>Profil belum lengkap.</b> Silakan lengkapi data diri sebelum mengikuti ujian.
</div>
<?php endif; ?>

<div class="header">
    <h2>Selamat Datang, <?= htmlspecialchars($nama) ?> 👋</h2>
    <p><?= htmlspecialchars($prodi) ?></p>
</div>

<div class="info">
    <div class="info-card"><h4>Nomor Test</h4><p><?= $nomor_test ?></p></div>
    <div class="info-card"><h4>Status</h4><p><?= $status ?></p></div>
    <div class="info-card"><h4>Ujian</h4><p><?= $status=='Belum'?'Belum':'Sudah' ?></p></div>
</div>

<div class="menu">

    <!-- HASIL TEST -->
    <div class="card">
        <i class="fa-solid fa-chart-column"></i>
        <h3>Hasil Test</h3>

        <?php if($status=='Lulus'): ?>
            <p class="success" style="margin-top:10px;">🎉 LULUS</p>
            <p style="font-size:14px;margin-top:10px;">
                Anda dinyatakan <b>lulus ujian masuk</b>.  
                Silakan lanjut ke tahap <b>Daftar Ulang</b>.
            </p>
        <?php elseif($status=='Tidak Lulus'): ?>
            <p class="danger" style="margin-top:10px;">❌ TIDAK LULUS</p>
            <p style="font-size:14px;margin-top:10px;">
                Anda belum lulus.  
                Silakan pantau informasi gelombang berikutnya.
            </p>
        <?php else: ?>
            <p style="font-weight:600;margin-top:10px;">⏳ Belum Dikerjakan</p>
            <p style="font-size:14px;margin-top:10px;">
                Silakan menuju menu <b>Ujian Masuk</b> untuk memulai ujian.
            </p>
        <?php endif; ?>
    </div>

    <!-- UJIAN MASUK -->
    <div class="card ujian-masuk <?= (!$profil_lengkap || $status!='Belum')?'disabled':'' ?>">
        <i class="fa-solid fa-file-pen"></i>
        <h3>Ujian Masuk</h3>

        <div class="nomor-test">Nomor Test: <?= $nomor_test ?></div>

        <?php if(!$profil_lengkap): ?>
            <button disabled>Lengkapi Profil</button>
        <?php elseif($status=='Belum'): ?>
            <a href="../auth/login_ujian.php?nomor_test=<?= $nomor_test ?>">Mulai Ujian</a>
        <?php else: ?>
            <button disabled>Terkunci</button>
        <?php endif; ?>
    </div>

    <?php if($status=='Lulus'): ?>
    <div class="card <?= $udah_daftar?'disabled':'' ?>">
        <i class="fa-solid fa-clipboard-check"></i>
        <h3>Daftar Ulang</h3>
        <?= $udah_daftar ? '<button disabled>Sudah Daftar Ulang</button>' : '<a href="daftar_ulang.php">Daftar Ulang</a>' ?>
    </div>

        <?php if($udah_daftar): ?>
        <div class="card">
            <i class="fa-solid fa-id-card"></i>
            <h3>Kartu Mahasiswa</h3>
            <p>NIM: <?= $nim ?></p>
            <a href="kartu_preview.php">Lihat Kartu</a>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

<footer style="margin-top:70px;text-align:center;color:#6b7280;font-size:13px">
© <?= date('Y') ?> Universitas Satmata
</footer>

</div>
</body>
</html>
