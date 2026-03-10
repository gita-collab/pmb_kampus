<?php
session_start();
require 'config.php';

$isLogin  = isset($_SESSION['user']);
$fullname = $isLogin ? $_SESSION['user']['fullname'] : '';
$status_test = null;

/* =====================
   AMBIL HASIL TEST (TANPA NILAI)
===================== */
if ($isLogin) {
    $user_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("
        SELECT status_test
        FROM calon_mahasiswa
        WHERE user_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    $status_test = $data['status_test'] ?? 'Belum';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PMB 2026 | Universitas Satmata</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f6f8fc;color:#1f2937}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 60px;
    background:#fff;
    box-shadow:0 8px 30px rgba(0,0,0,.05);
}
.brand{display:flex;align-items:center;gap:15px}
.brand img{width:52px;height:52px;border-radius:50%;object-fit:cover}
.brand span{font-size:18px;font-weight:700}
.navbar a{
    margin-left:20px;
    text-decoration:none;
    color:#2563eb;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:transform .2s;
}
.navbar a:hover{
    transform:scale(1.1);
}
.navbar a.admin-only{ /* shrink padding when only icon */
    padding:4px;
}
.navbar strong{margin-right:14px}

/* HERO */
.hero{
    padding:100px 60px;
    display:grid;
    grid-template-columns:1.1fr 1fr;
    gap:60px;
    align-items:center;
}
.hero-text h1{font-size:48px;font-weight:700;margin-bottom:20px}
.hero-text p{font-size:16px;color:#555;line-height:1.7;margin-bottom:35px}
.btn{
    padding:14px 34px;
    background:#2563eb;
    color:#fff;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}
.hero-img img{
    width:100%;
    border-radius:24px;
    box-shadow:0 25px 60px rgba(0,0,0,.15);
}

/* INFO */
.info{padding:80px 60px;background:#fff}
.info h2{text-align:center;font-size:32px;margin-bottom:50px}
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:30px;
}
.card{
    padding:30px;
    border-radius:20px;
    background:#f9fbff;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    transition:.3s;
}
.card:hover{transform:translateY(-6px)}
.card h3{margin-bottom:12px;color:#1e3a8a}
.card p{font-size:14px;color:#555;line-height:1.6}

/* STATUS */
.status-belum{color:#f59e0b;font-weight:600}
.status-lulus{color:#16a34a;font-weight:700}
.status-tidak{color:#dc2626;font-weight:700}

footer{
    text-align:center;
    color:#1e3a8a;
    padding:30px;
    font-size:14px;
}

@media(max-width:900px){
    .hero{grid-template-columns:1fr;text-align:center}
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="brand">
        <img src="assets/usat.jpg">
        <span>Universitas Satmata</span>
    </div>
    <div>
        <?php if($isLogin): ?>
            <strong><?= htmlspecialchars($fullname) ?></strong>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <a href="auth/register.php"><i class="fa-solid fa-user-plus"></i> Daftar</a>
            <a href="admin/login_admin.php" class="admin-only"><i class="fa-solid fa-user"></i></a>
        <?php endif; ?>
    </div>
</div>

<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Penerimaan Mahasiswa Baru 2026</h1>
        <p>
            Universitas Satmata membuka kesempatan bagi generasi muda
            untuk bergabung dalam pendidikan tinggi berkualitas,
            berbasis teknologi dan karakter unggul.
        </p>
        <a href="<?= $isLogin ? 'mahasiswa/dashboard.php' : 'auth/register.php'; ?>" class="btn">
            <?= $isLogin ? 'Masuk Dashboard →' : 'Daftar Sekarang →'; ?>
        </a>
    </div>

    <div class="hero-img">
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f">
    </div>
</section>

<!-- INFO -->
<section class="info">
    <h2>Kenapa Universitas Satmata?</h2>

    <div class="cards">
        <div class="card">
            <h3>🎓 Program Unggulan</h3>
            <p>Program studi relevan dengan kebutuhan industri.</p>
        </div>

        <div class="card">
            <h3>🧪 Fasilitas Lengkap</h3>
            <p>Laboratorium dan sistem ujian berbasis digital.</p>
        </div>

        <div class="card">
            <h3>🌍 Kampus Masa Depan</h3>
            <p>Mengembangkan mahasiswa berdaya saing global.</p>
        </div>

        <!-- HASIL TEST -->
        <?php if($isLogin): ?>
        <div class="card">
            <h3>📊 Hasil Test</h3>

            <?php if($status_test == 'Belum'): ?>
                <p class="status-belum">
                    Tes belum dikerjakan / belum dinilai
                </p>

            <?php elseif($status_test == 'Lulus'): ?>
                <p class="status-lulus">🎉 LULUS</p>
                <p>Silakan lanjut ke tahap berikutnya</p>

            <?php elseif($status_test == 'Tidak Lulus'): ?>
                <p class="status-tidak">❌ TIDAK LULUS</p>
                <p>Terima kasih telah mengikuti seleksi</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<footer>
    © <?= date('Y') ?> Universitas Satmata • PMB Online
</footer>

</body>
</html>
