<?php
include '../config.php';

// STATISTIK
$total_pendaftar    = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM calon_mahasiswa"));
$lulus              = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM calon_mahasiswa WHERE status_test='Lulus'"));
$gagal              = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM calon_mahasiswa WHERE status_test='Tidak Lulus'"));
$total_daftar_ulang = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM calon_mahasiswa WHERE nim IS NOT NULL"));
$total_soal         = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM soal"));

// DATA PENDAFTAR
$data = mysqli_query($conn,"SELECT * FROM calon_mahasiswa ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin PMB</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f5f7fb;
    display: flex;
    color: #1f2937;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    min-height: 100vh;
    position: fixed;
    background: linear-gradient(180deg, #1e3a8a, #4338ca);
    padding: 30px 22px;
    color: #fff;
}

.sidebar .brand {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 44px;
}

.sidebar img {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
}

.sidebar h3 {
    font-size: 16px;
    font-weight: 600;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    margin-bottom: 14px;
    border-radius: 14px;
    color: #e0e7ff;
    text-decoration: none;
    font-size: 14px;
    transition: 0.25s;
}

.sidebar a i {
    width: 20px;
    font-size: 15px;
}

.sidebar a.active,
.sidebar a:hover {
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
}

/* ===== MAIN CONTENT ===== */
.main {
    margin-left: 260px;
    width: 100%;
    padding: 36px 44px;
}

/* ===== HEADER ===== */
.header {
    background: #fff;
    padding: 28px 34px;
    border-radius: 22px;
    box-shadow: 0 14px 34px rgba(0, 0, 0, 0.06);
    margin-bottom: 32px;
}

.header h2 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 6px;
}

.header p {
    font-size: 14px;
    color: #6b7280;
}

/* ===== INFO CARDS ===== */
.info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.info-card {
    padding: 26px 24px;
    border-radius: 18px;
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
}

.info-card h4 {
    font-size: 13px;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.9);
}

.info-card p {
    font-size: 22px;
    font-weight: 600;
    color: inherit; /* Sesuaikan dengan color card */
}

/* Warna statistik */
.bg-pendaftar { background: #ef4444; color: white; }       /* Merah */
.bg-lulus { background: #f59e0b; color: white; }           /* Kuning/Orange */
.bg-gagal { background: #6b7280; color: white; }           /* Abu Gelap */
.bg-soal { background: #3b82f6; color: white; }            /* Biru */
.bg-daftar-ulang { background: #16a34a; color: white; }    /* Hijau */

/* ===== TABLE CARD ===== */
.table-card {
    background: #fff;
    padding: 24px;
    border-radius: 22px;
    box-shadow: 0 14px 34px rgba(0, 0, 0, 0.06);
}

.table-card h5 {
    margin-bottom: 20px;
    font-weight: 600;
    color: #1e3a8a;
}

.table-card table {
    width: 100%;
    border-collapse: collapse;
}

.table-card th {
    background: #e0f2fe;
    color: #1e3a8a;
    padding: 10px;
}

.table-card td {
    padding: 10px;
    text-align: center;
}

.table-card tbody tr:hover {
    background: #f3f4f6;
}

/* ===== FOOTER ===== */
footer {
    margin: 70px 0 20px;
    text-align: center;
    font-size: 13px;
    color: #6b7280;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    .main {
        margin-left: 0;
        padding: 26px;
    }
}

</style>
</head>

<body>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/usat.jpg" alt="Logo">
        <h3>Universitas Satmata</h3>
    </div>
    <a href="dashboard_admin.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="bank_soal.php"><i class="fa-solid fa-book"></i> Bank Soal</a>
    <a href="admin_pendaftaran.php"><i class="fa-solid fa-user-plus"></i> Pendaftaran</a>
    <a href="hasil_test_admin.php"><i class="fa-solid fa-clipboard-list"></i> Hasil Test</a>
    <a href="daftar_ulang_admin.php"><i class="fa-solid fa-id-card"></i> Daftar Ulang</a>
    <a href="logout_admin.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">

<div class="header">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang di panel admin PMB</p>
</div>

<div class="info">
    <div class="info-card bg-pendaftar"><h4>Total Pendaftar</h4><p><?= $total_pendaftar ?></p></div>
    <div class="info-card bg-lulus"><h4>Lulus Test</h4><p><?= $lulus ?></p></div>
    <div class="info-card bg-gagal"><h4>Tidak Lulus</h4><p><?= $gagal ?></p></div>
    <div class="info-card bg-soal"><h4>Total Soal</h4><p><?= $total_soal ?></p></div>
    <div class="info-card bg-daftar-ulang"><h4>Daftar Ulang</h4><p><?= $total_daftar_ulang ?></p></div>
</div>

<div class="table-card">
    <h5>Data Calon Mahasiswa Baru</h5>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
                <th>Prodi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row=mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['jenis_kelamin'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['prodi']) ?></td>
                <td><?= htmlspecialchars($row['status_test']) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<footer>© <?= date('Y') ?> Universitas Satmata</footer>

</div>
</body>
</html>
