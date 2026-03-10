<?php
include '../config.php';

// Ambil filter dari URL jika ada
$filter_prodi = $_GET['prodi'] ?? '';
$filter_sekolah = $_GET['asal_sekolah'] ?? '';

// Build query dinamis
$query = "SELECT * FROM calon_mahasiswa WHERE nilai_test IS NOT NULL";
if($filter_prodi) $query .= " AND prodi='".mysqli_real_escape_string($conn,$filter_prodi)."'";
if($filter_sekolah) $query .= " AND asal_sekolah='".mysqli_real_escape_string($conn,$filter_sekolah)."'";
$query .= " ORDER BY tanggal_test DESC";

$data = mysqli_query($conn,$query);

// Ambil daftar unik Prodi & Asal Sekolah untuk dropdown
$prodi_list = mysqli_query($conn,"SELECT DISTINCT prodi FROM calon_mahasiswa WHERE nilai_test IS NOT NULL ORDER BY prodi ASC");
$sekolah_list = mysqli_query($conn,"SELECT DISTINCT asal_sekolah FROM calon_mahasiswa WHERE nilai_test IS NOT NULL ORDER BY asal_sekolah ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Test - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f5f7fb;color:#1f2937;min-height:100vh}

/* SIDEBAR */
.sidebar{
    width:260px; min-height:100vh; position:fixed;
    background:linear-gradient(180deg,#1e3a8a,#4338ca);
    padding:30px 22px; color:#fff;
}
.sidebar .brand{display:flex;align-items:center;gap:14px;margin-bottom:44px;}
.sidebar img{width:44px;height:44px;border-radius:50%;object-fit:cover;}
.sidebar h3{font-size:16px;font-weight:600;}
.sidebar a{display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:14px;border-radius:14px;color:#e0e7ff;text-decoration:none;font-size:14px;transition:.25s}
.sidebar a i{width:20px;font-size:15px}
.sidebar a.active,.sidebar a:hover{background:rgba(255,255,255,.18);color:#fff}

/* MAIN */
.main{margin-left:260px;width:100%;padding:36px 44px}

/* HEADER */
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
.header h2{font-size:22px;font-weight:600}
/* ========================= RESET ========================= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f5f7fb;
    color: #1f2937;
    min-height: 100vh;
}

/* ========================= SIDEBAR ========================= */
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

/* ========================= MAIN ========================= */
.main {
    margin-left: 260px;
    width: 100%;
    padding: 36px 44px;
}

/* ========================= HEADER ========================= */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.header h2 {
    font-size: 22px;
    font-weight: 600;
}

/* ========================= FILTER ========================= */
.filter-form {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.filter-form select {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    min-width: 180px;
}

.filter-form button {
    padding: 8px 14px;
    background: #1e3a8a;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.filter-form button:hover {
    background: #4338ca;
}

/* ========================= TABLE CARD ========================= */
.table-card {
    background: #fff;
    padding: 22px;
    border-radius: 18px;
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.06);
    overflow-x: auto;
}

.table-card table {
    width: 100%;
    min-width: 900px;
    border-spacing: 0 12px;
}

.table-card th {
    background: #1e3a8a;
    color: #fff;
    padding: 14px;
    text-align: left;
}

.table-card td {
    background: #f1f5f9;
    padding: 14px;
    border-radius: 12px;
    vertical-align: middle;
}

.avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
}

/* ========================= STATUS ========================= */
.status-pass {
    color: #1e40af;
    font-weight: 700;
}

.status-fail {
    color: #c1121f;
    font-weight: 700;
}

.btn-action {
    margin-right: 6px;
}

/* ========================= RESPONSIVE ========================= */
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

    .filter-form {
        flex-direction: column;
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
    <a href="dashboard_admin.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="bank_soal.php"><i class="fa-solid fa-book"></i> Bank Soal</a>
    <a href="admin_pendaftaran.php"><i class="fa-solid fa-user-plus"></i> Pendaftaran</a>
    <a href="hasil_test_admin.php" class="active"><i class="fa-solid fa-clipboard-list"></i> Hasil Test</a>
    <a href="daftar_ulang_admin.php"><i class="fa-solid fa-id-card"></i> Daftar Ulang</a>
    <a href="logout_admin.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">
    <div class="header">
        <h2>Hasil Test Peserta</h2>
    </div>

    <!-- FILTER -->
    <form class="filter-form" method="GET">
        <select name="prodi">
            <option value="">-- Filter Prodi --</option>
            <?php while($p=mysqli_fetch_assoc($prodi_list)): ?>
                <option value="<?= htmlspecialchars($p['prodi']); ?>" <?= $filter_prodi==$p['prodi']?'selected':'' ?>>
                    <?= htmlspecialchars($p['prodi']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="asal_sekolah">
            <option value="">-- Filter Asal Sekolah --</option>
            <?php while($s=mysqli_fetch_assoc($sekolah_list)): ?>
                <option value="<?= htmlspecialchars($s['asal_sekolah']); ?>" <?= $filter_sekolah==$s['asal_sekolah']?'selected':'' ?>>
                    <?= htmlspecialchars($s['asal_sekolah']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit"><i class="fa-solid fa-filter"></i> Filter</button>
    </form>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Phone</th>
                    <th>Asal Sekolah</th>
                    <th>Prodi</th>
                    <th>No Test</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($data)==0){ ?>
                <tr>
                    <td colspan="9" style="text-align:center;background:#fef9c3">Belum ada peserta test</td>
                </tr>
                <?php } ?>

                <?php while($row=mysqli_fetch_assoc($data)):
                    $foto = !empty($row['foto']) && file_exists('../assets/foto_mhs/'.$row['foto']) ? $row['foto'] : 'default.png';
                    $nilai = $row['nilai_test'] ?? 0;
                ?>
                <tr>
                    <td><img class="avatar" src="../assets/foto_mhs/<?= htmlspecialchars($foto); ?>"></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_kelamin'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['asal_sekolah']); ?></td>
                    <td><?= htmlspecialchars($row['prodi']); ?></td>
                    <td><?= htmlspecialchars($row['nomor_test']); ?></td>
                    <td><b><?= htmlspecialchars($nilai); ?></b></td>
                    <td class="<?= ($row['status_test']??'')=='LULUS'?'status-pass':'status-fail'; ?>">
                        <?= htmlspecialchars($row['status_test']??''); ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
