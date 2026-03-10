<?php
include '../config.php';

/* Ambil ID soal dari URL */
$id = $_GET['id'] ?? '';

if($id == ''){
    header("Location: bank_soal.php");
    exit;
}

/* Ambil data soal dari database */
$q = mysqli_query($conn, "SELECT * FROM soal WHERE id='$id' LIMIT 1");
$soal = mysqli_fetch_assoc($q);

if(!$soal){
    echo "Soal tidak ditemukan!";
    exit;
}

/* Pesan sukses setelah edit */
$msg = '';
if(isset($_GET['msg']) && $_GET['msg'] == 'edit_sukses'){
    $msg = 'Soal berhasil diperbarui!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Soal - Admin</title>
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

/* ===== FORM CARD ===== */
.form-card{
    background:#fff;
    padding:24px 28px;
    border-radius:18px;
    box-shadow:0 12px 26px rgba(0,0,0,.05);
    max-width:900px; /* Lebar diperbesar */
    margin-bottom:40px;
    margin-left:auto;
    margin-right:auto;
}
.form-card h4{
    margin-bottom:20px;
    color:#1e3a8a;
    font-weight:600;
}
.form-card .mb-3{
    margin-bottom:16px;
}
.form-card label{
    display:block;
    font-weight:500;
    margin-bottom:6px;
}
.form-card input, 
.form-card textarea,
.form-card select{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #cbd5e1;
    font-size:14px;
}
.form-card textarea{resize:vertical;}
.form-card button{
    background:#ef4444;
    color:#fff;
    padding:10px 20px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    transition:.3s;
}
.form-card button:hover{opacity:.9}

/* ===== BUTTON KEMBALI ===== */
.btn-back{
    display:inline-block;
    margin-bottom:16px;
    padding:8px 18px;
    border-radius:10px;
    background:#6b7280;
    color:#fff;
    text-decoration:none;
    transition:.3s;
}
.btn-back:hover{opacity:.8}

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
    .form-card{max-width:100%;}
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
    <h2>Edit Soal</h2>
</div>

<?php if($msg != ''): ?>
<div class="alert"><?= $msg; ?></div>
<?php endif; ?>

<div class="form-card">
<a href="bank_soal.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Bank Soal</a>
<h4>Edit Soal</h4>
<form action="proses_edit_soal.php" method="POST">
    <input type="hidden" name="id" value="<?= $soal['id']; ?>">

    <div class="mb-3">
        <label>Prodi</label>
        <select name="prodi">
            <option value="Informatika" <?= $soal['prodi']=='Informatika'?'selected':'' ?>>Informatika</option>
            <option value="Manajemen" <?= $soal['prodi']=='Manajemen'?'selected':'' ?>>Manajemen</option>
            <option value="Akuntansi" <?= $soal['prodi']=='Akuntansi'?'selected':'' ?>>Akuntansi</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Pertanyaan</label>
        <textarea name="pertanyaan" rows="4"><?= htmlspecialchars($soal['pertanyaan']); ?></textarea>
    </div>

    <div class="mb-3">
        <label>Opsi A</label>
        <input type="text" name="opsi_a" value="<?= htmlspecialchars($soal['opsi_a']); ?>">
    </div>
    <div class="mb-3">
        <label>Opsi B</label>
        <input type="text" name="opsi_b" value="<?= htmlspecialchars($soal['opsi_b']); ?>">
    </div>
    <div class="mb-3">
        <label>Opsi C</label>
        <input type="text" name="opsi_c" value="<?= htmlspecialchars($soal['opsi_c']); ?>">
    </div>
    <div class="mb-3">
        <label>Opsi D</label>
        <input type="text" name="opsi_d" value="<?= htmlspecialchars($soal['opsi_d']); ?>">
    </div>

    <div class="mb-3">
        <label>Jawaban</label>
        <select name="jawaban">
            <option value="A" <?= $soal['jawaban']=='A'?'selected':'' ?>>A</option>
            <option value="B" <?= $soal['jawaban']=='B'?'selected':'' ?>>B</option>
            <option value="C" <?= $soal['jawaban']=='C'?'selected':'' ?>>C</option>
            <option value="D" <?= $soal['jawaban']=='D'?'selected':'' ?>>D</option>
        </select>
    </div>

    <button type="submit">Simpan Perubahan</button>
</form>
</div>

<footer>© <?= date('Y') ?> Universitas Satmata</footer>
</div>
</body>
</html>
