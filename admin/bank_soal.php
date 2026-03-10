<?php
include '../config.php';

/* PESAN SUKSES/HAPUS */
$msg = '';
if(isset($_GET['msg'])){
    if($_GET['msg'] == 'hapus_sukses') $msg = 'Soal berhasil dihapus!';
    if($_GET['msg'] == 'tambah_sukses') $msg = 'Soal berhasil ditambahkan!';
    if($_GET['msg'] == 'edit_sukses') $msg = 'Soal berhasil diperbarui!';
}

/* FILTER PRODI */
$filter_prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';

if($filter_prodi != ''){
    $data = mysqli_query($conn,"SELECT * FROM soal WHERE prodi='$filter_prodi' ORDER BY id DESC");
}else{
    $data = mysqli_query($conn,"SELECT * FROM soal ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Bank Soal - Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ===== RESET ===== */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f5f7fb;display:flex;color:#1f2937;min-height:100vh}

/* ===== SIDEBAR ===== */
.sidebar{
    width:260px;
    min-height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#1e3a8a,#4338ca);
    padding:30px 22px;
    color:#fff;
}
.sidebar .brand{
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:44px;
}
.sidebar img{
    width:44px;
    height:44px;
    border-radius:50%;
    object-fit:cover;
}
.sidebar h3{font-size:16px;font-weight:600}
.sidebar a{
    display:flex;
    align-items:center;
    gap:14px;
    padding:14px 18px;
    margin-bottom:14px;
    border-radius:14px;
    color:#e0e7ff;
    text-decoration:none;
    font-size:14px;
    transition:.25s
}
.sidebar a i{width:20px;font-size:15px}
.sidebar a.active,
.sidebar a:hover{background:rgba(255,255,255,.18);color:#fff}

/* ===== MAIN ===== */
.main{margin-left:260px;width:100%;padding:36px 44px}

/* ===== HEADER ===== */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:32px;
}
.header h2{font-size:22px;font-weight:600}
.header .btn-logout{background:#16a34a;color:#fff;padding:6px 12px;border-radius:6px;text-decoration:none;transition:.3s}
.header .btn-logout:hover{opacity:.9}

/* ===== ALERT ===== */
.alert{
    padding:12px 16px;
    border-radius:12px;
    margin-bottom:24px;
    background:#d1fae5;
    color:#065f46;
}

/* ===== ACTION ===== */
.action-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
    flex-wrap:wrap;
    gap:12px;
}
.action-bar .btn-add{background:#ef4444;color:#fff;padding:8px 16px;border-radius:12px;text-decoration:none;transition:.3s}
.action-bar .btn-add:hover{opacity:.9}
.action-bar form select{padding:6px 12px;border-radius:6px;border:1px solid #ccc}
.action-bar form button{padding:6px 12px;border-radius:6px;background:#16a34a;color:#fff;border:none;cursor:pointer;transition:.3s}
.action-bar form button:hover{opacity:.9}

/* ===== CARD SOAL ===== */
.soal-card{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 12px 26px rgba(0,0,0,.05);
    margin-bottom:16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    transition:transform .3s,box-shadow .3s;
}
.soal-card:hover{
    transform:translateY(-4px);
    box-shadow:0 16px 36px rgba(0,0,0,.08);
}
.soal-content{
    flex:1;
    min-width:280px;
}
.soal-content .badge-prodi{
    background:#1e40af;
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}
.soal-content p{
    font-weight:500;
    margin-top:6px;
    margin-bottom:6px;
}
.soal-content ul{margin-top:6px;margin-bottom:0;padding-left:18px}
.jawaban{
    width:70px;
    height:70px;
    background:#4338ca;
    color:white;
    font-size:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    margin-left:12px;
    flex-shrink:0;
}
.btn-group{
    display:flex;
    gap:8px;
    margin-left:12px;
    flex-shrink:0;
}
.btn-group a{
    display:flex;
    align-items:center;
    justify-content:center;
    width:45px;
    height:45px;
    border-radius:10px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    font-size:18px;
    transition:.3s;
}
.btn-group a:hover{opacity:.9}

/* ===== FOOTER ===== */
footer{
    margin:70px 0 20px;
    text-align:center;
    font-size:13px;
    color:#6b7280;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
    .sidebar{position:relative;width:100%;height:auto}
    .main{margin-left:0;padding:26px}
    .soal-card{flex-direction:column;align-items:flex-start}
    .jawaban{margin-left:0;margin-top:12px}
    .btn-group{margin-left:0;margin-top:12px}
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
    <a href="bank_soal.php" class="active"><i class="fa-solid fa-book"></i> Bank Soal</a>
    <a href="admin_pendaftaran.php"><i class="fa-solid fa-user-plus"></i> Pendaftaran</a>
    <a href="hasil_test_admin.php"><i class="fa-solid fa-clipboard-list"></i> Hasil Test</a>
    <a href="daftar_ulang_admin.php"><i class="fa-solid fa-id-card"></i> Daftar Ulang</a>
    <a href="logout_admin.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">
<div class="header">
    <h2>Bank Soal</h2>
</div>

<?php if($msg != ''): ?>
<div class="alert"><?= $msg; ?></div>
<?php endif; ?>

<div class="action-bar">
    <a href="tambah_soal.php" class="btn-add"><i class="fa-solid fa-plus"></i> Tambah Soal</a>

    <form method="GET">
        <select name="prodi">
            <option value="">-- Semua Prodi --</option>
            <option value="Informatika" <?= $filter_prodi=='Informatika'?'selected':''; ?>>Informatika</option>
            <option value="Manajemen" <?= $filter_prodi=='Manajemen'?'selected':''; ?>>Manajemen</option>
            <option value="Akuntansi" <?= $filter_prodi=='Akuntansi'?'selected':''; ?>>Akuntansi</option>
        </select>
        <button>Filter</button>
    </form>
</div>

<?php if(mysqli_num_rows($data)==0){ ?>
<div class="alert text-center" style="background:#fef3c7;color:#78350f;">
    Belum ada soal untuk prodi ini
</div>
<?php } ?>

<?php while($row=mysqli_fetch_assoc($data)){ ?>
<div class="soal-card">
    <div class="soal-content">
        <span class="badge-prodi"><?= htmlspecialchars($row['prodi']); ?></span>
        <p><?= htmlspecialchars($row['pertanyaan']); ?></p>
        <ul>
            <li>A: <?= htmlspecialchars($row['opsi_a']); ?></li>
            <li>B: <?= htmlspecialchars($row['opsi_b']); ?></li>
            <li>C: <?= htmlspecialchars($row['opsi_c']); ?></li>
            <li>D: <?= htmlspecialchars($row['opsi_d']); ?></li>
        </ul>
    </div>
    <div class="jawaban"><?= $row['jawaban']; ?></div>
    <div class="btn-group">
        <a href="edit_soal.php?id=<?= $row['id']; ?>" title="Edit"><i class="fa-solid fa-pen"></i></a>
        <a href="hapus_soal.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus soal ini?')" title="Hapus"><i class="fa-solid fa-trash"></i></a>
    </div>
</div>
<?php } ?>

<footer>© <?= date('Y') ?> Universitas Satmata</footer>
</div>
</body>
</html>
