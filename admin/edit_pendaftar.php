<?php
include '../config.php';
$id = $_GET['id'] ?? '';

if(!$id){
    header("Location: admin_pendaftaran.php");
    exit;
}

$q = mysqli_query($conn,"SELECT * FROM calon_mahasiswa WHERE id='$id'");
$pendaftar = mysqli_fetch_assoc($q);

if(!$pendaftar){
    echo "Data tidak ditemukan!";
    exit;
}
$msg = $_GET['msg'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pendaftar - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#fde7e1;font-family:'Poppins',sans-serif;padding:40px}
.card{background:#fff;padding:24px;border-radius:18px;max-width:700px;margin:auto;box-shadow:0 12px 26px rgba(0,0,0,.05);}
input, select{width:100%;padding:10px;margin-bottom:14px;border-radius:8px;border:1px solid #cbd5e1;}
button{background:#ef4444;color:#fff;padding:10px 20px;border:none;border-radius:12px;cursor:pointer;}
button:hover{opacity:.9;}
.btn-back{margin-bottom:16px;padding:8px 18px;border-radius:10px;background:#6b7280;color:#fff;text-decoration:none;display:inline-block;}
.alert{background:#d1fae5;color:#065f46;padding:12px 16px;border-radius:12px;margin-bottom:16px;}
</style>
</head>

<body>

<div class="card">
<a href="admin_pendaftaran.php" class="btn-back">← Kembali ke Data Pendaftar</a>

<h4>Edit Pendaftar</h4>

<?php if($msg){ ?>
<div class="alert"><?= htmlspecialchars($msg); ?></div>
<?php } ?>

<form action="proses_edit_pendaftar.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $pendaftar['id']; ?>">

<label>Nama</label>
<input type="text" name="nama" value="<?= htmlspecialchars($pendaftar['nama']); ?>" required>

<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($pendaftar['email']); ?>" required>

<label>Phone</label>
<input type="text" name="phone" value="<?= htmlspecialchars($pendaftar['phone']); ?>" required>

<label>Jenis Kelamin</label>
<select name="jenis_kelamin" required>
    <option value="Laki-laki" <?= $pendaftar['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
    <option value="Perempuan" <?= $pendaftar['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
</select>

<label>Asal Sekolah</label>
<input type="text" name="asal_sekolah" value="<?= htmlspecialchars($pendaftar['asal_sekolah']); ?>" required>

<label>Prodi</label>
<select name="prodi" required>
<option value="Informatika" <?= $pendaftar['prodi']=='Informatika'?'selected':'' ?>>Informatika</option>
<option value="Manajemen" <?= $pendaftar['prodi']=='Manajemen'?'selected':'' ?>>Manajemen</option>
<option value="Akuntansi" <?= $pendaftar['prodi']=='Akuntansi'?'selected':'' ?>>Akuntansi</option>
</select>

<button type="submit">💾 Simpan Perubahan</button>
</form>
</div>

</body>
</html>
