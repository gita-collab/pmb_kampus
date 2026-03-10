<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!='mahasiswa'){
    header("Location: ../auth/login.php");
    exit;
}

include "../config.php";

$email = $_SESSION['user']['email'];

// Ambil data mahasiswa
$q = mysqli_query($conn,"SELECT * FROM calon_mahasiswa WHERE email='$email' LIMIT 1");
$mhs = mysqli_fetch_assoc($q);

if(!$mhs) die("Data mahasiswa tidak ditemukan!");

// Cek status lulus
if(($mhs['status_test'] ?? '') != 'Lulus'){
    die("Akses ditolak: Anda belum lulus ujian.");
}

// Cek sudah daftar ulang
$check = mysqli_query($conn, "SELECT * FROM daftar_ulang WHERE email='$email' LIMIT 1");
$udah_daftar = mysqli_num_rows($check) > 0;

if(isset($_POST['submit']) && !$udah_daftar){

    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);
    $phone         = mysqli_real_escape_string($conn, $_POST['phone']);
    $phone_ortu    = mysqli_real_escape_string($conn, $_POST['phone_ortu']);

    // ===== GENERATE NIM =====
    $tahun = substr(date('Y'), -3);
    $kode_prodi = [
        'Teknik Informatika' => '1101',
        'Sistem Informasi'   => '1102',
        'Manajemen'          => '2101',
        'Akuntansi'          => '2102'
    ];
    $kp = $kode_prodi[$mhs['prodi']] ?? '0000';
    $urut = rand(100,999);
    $nim = $tahun.$kp.$urut;

    // ===== SIMPAN DAFTAR ULANG =====
    $sql = "INSERT INTO daftar_ulang 
        (nama, email, nim, prodi, jenis_kelamin, alamat, phone, phone_ortu, nilai, status, tanggal)
        VALUES (
            '".mysqli_real_escape_string($conn,$mhs['nama'])."',
            '".mysqli_real_escape_string($conn,$mhs['email'])."',
            '$nim',
            '".mysqli_real_escape_string($conn,$mhs['prodi'])."',
            '$jenis_kelamin',
            '$alamat',
            '$phone',
            '$phone_ortu',
            '".$mhs['nilai_test']."',
            'LULUS',
            NOW()
        )";

    if(mysqli_query($conn, $sql)){
        mysqli_query($conn, "UPDATE calon_mahasiswa SET nim='$nim' WHERE email='$email'");
        header("Location: dashboard.php");
        exit;
    } else {
        die("Gagal menyimpan data: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ulang Mahasiswa</title>

<style>
body{
background:#f5f7fb;
font-family:'Poppins',sans-serif;
display:flex;
justify-content:center;
padding:60px 20px;
min-height:100vh;
}

.card{
background:#fff;
width:100%;
max-width:680px;
padding:45px 40px;
border-radius:24px;
box-shadow:0 20px 50px rgba(0,0,0,0.08);
}

.header{
text-align:center;
margin-bottom:35px;
}

.header h2{
font-weight:600;
font-size:26px;
color:#1e3a8a;
}

.form-group{
margin-bottom:22px;
}

.form-group label{
display:block;
margin-bottom:6px;
}

input,textarea,select{
width:100%;
padding:14px 16px;
border-radius:14px;
border:1px solid #d1d5db;
font-size:14px;
}

textarea{
min-height:100px;
resize:vertical;
}

button{
width:100%;
margin-top:22px;
padding:16px;
border-radius:16px;
background:linear-gradient(135deg,#4338ca,#1e3a8a);
color:#fff;
border:none;
font-size:16px;
cursor:pointer;
}

.back{
display:block;
text-align:center;
margin-top:18px;
text-decoration:none;
color:#4338ca;
font-size:14px;
}

.disabled-msg{
text-align:center;
padding:14px 0;
background:#d1fae5;
color:#065f46;
border-radius:12px;
margin-bottom:20px;
}
</style>

</head>
<body>

<div class="card">

<div class="header">
<h2>Form Daftar Ulang</h2>
</div>

<?php if($udah_daftar): ?>
<div class="disabled-msg">
Anda sudah melakukan daftar ulang. ✅<br>
NIM Anda: <?= htmlspecialchars($mhs['nim']) ?>
</div>
<?php endif; ?>

<form method="post">

<div class="form-group">
<label>Nama Lengkap</label>
<input value="<?= htmlspecialchars($mhs['nama']) ?>" disabled>
</div>

<div class="form-group">
<label>Program Studi</label>
<input value="<?= htmlspecialchars($mhs['prodi']) ?>" disabled>
</div>

<div class="form-group">
<label>Jenis Kelamin</label>
<select name="jenis_kelamin" required <?= $udah_daftar?'disabled':'' ?>>
<option value="">-- Pilih Jenis Kelamin --</option>
<option value="Laki-laki">Laki-laki</option>
<option value="Perempuan">Perempuan</option>
</select>
</div>

<div class="form-group">
<label>Alamat Lengkap</label>
<textarea name="alamat" required <?= $udah_daftar?'disabled':'' ?>></textarea>
</div>

<div class="form-group">
<label>No HP Mahasiswa</label>
<input type="text" name="phone" required <?= $udah_daftar?'disabled':'' ?>>
</div>

<div class="form-group">
<label>No HP Orang Tua / Wali</label>
<input type="text" name="phone_ortu" required <?= $udah_daftar?'disabled':'' ?>>
</div>

<?php if(!$udah_daftar): ?>
<button name="submit">Simpan Daftar Ulang</button>
<?php endif; ?>

</form>

<a href="dashboard.php" class="back">← Kembali ke Dashboard</a>

</div>

</body>
</html>