<?php
include '../config.php';

/* ================= TAMBAH MABA MANUAL ================= */
if(isset($_POST['tambah_maba'])){
    $nama   = mysqli_real_escape_string($conn,$_POST['nama']);
    $email  = mysqli_real_escape_string($conn,$_POST['email']);
    $phone  = mysqli_real_escape_string($conn,$_POST['phone']);
    $asal   = mysqli_real_escape_string($conn,$_POST['asal_sekolah']);
    $prodi  = mysqli_real_escape_string($conn,$_POST['prodi']);
    $alamat = mysqli_real_escape_string($conn,$_POST['tempat_tinggal']); // FIX
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn,"
        INSERT INTO calon_mahasiswa 
        (nama,email,phone,asal_sekolah,prodi,alamat,tanggal_daftar)
        VALUES
        ('$nama','$email','$phone','$asal','$prodi','$alamat',CURDATE())
    ");

    mysqli_query($conn,"
        INSERT INTO users (fullname,email,password,role)
        VALUES ('$nama','$email','$password','mahasiswa')
    ");

    echo "<script>
        alert('Mahasiswa baru berhasil ditambahkan');
        location.href='admin_pendaftaran.php';
    </script>";
}

/* ================= FILTER ================= */
$prodi_filter   = $_GET['prodi'] ?? '';
$sekolah_filter = $_GET['asal_sekolah'] ?? '';

$where = [];
if($prodi_filter)   $where[] = "prodi='$prodi_filter'";
if($sekolah_filter) $where[] = "asal_sekolah LIKE '%$sekolah_filter%'";

$query = "SELECT * FROM calon_mahasiswa";
if($where) $query .= " WHERE ".implode(' AND ', $where);
$query .= " ORDER BY id DESC";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pendaftaran - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f5f7fb;color:#1f2937}

/* SIDEBAR */
.sidebar{
    width:260px;min-height:100vh;position:fixed;
    background:linear-gradient(180deg,#1e3a8a,#4338ca);
    padding:30px 22px;color:#fff
}
.sidebar .brand{display:flex;gap:14px;align-items:center;margin-bottom:40px}
.sidebar img{
    width:44px;
    height:44px;
    border-radius:50%; /* LOGO BULAT */
    object-fit:cover;
}
.sidebar a{
    display:flex;gap:14px;align-items:center;
    padding:14px 18px;margin-bottom:12px;
    border-radius:14px;color:#e0e7ff;text-decoration:none
}
.sidebar a.active,.sidebar a:hover{
    background:rgba(255,255,255,.18);color:#fff
}

/* MAIN */
.main{margin-left:260px;padding:36px 40px}
.header h2{font-size:22px;margin-bottom:18px}

/* TOOLBAR */
.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
    gap:12px;
    flex-wrap:wrap;
}

/* FILTER */
.filter-form{
    display:flex;gap:12px;flex-wrap:wrap
}
.filter-form input,.filter-form select{
    padding:10px 14px;border-radius:10px;border:1px solid #cbd5e1
}
.filter-form button{
    background:#1e3a8a;color:#fff;border:none;
    padding:10px 18px;border-radius:10px
}

/* 🔴 TOMBOL TAMBAH MABA SAJA */
.btn-add{
    background:#dc2626; /* MERAH */
    color:#fff;border:none;
    padding:10px 18px;border-radius:10px;
    cursor:pointer;
    font-weight:600
}
.btn-add:hover{
    background:#b91c1c;
}

/* TABLE */
.table-card{
    background:#fff;padding:22px;border-radius:18px;
    box-shadow:0 12px 26px rgba(0,0,0,.06);
    overflow-x:auto
}
table{width:100%;min-width:900px;border-spacing:0 12px}
th{
    background:#1e3a8a;color:#fff;padding:14px;text-align:left
}
td{
    background:#f1f5f9;padding:14px;border-radius:12px
}
.avatar{width:44px;height:44px;border-radius:50%;object-fit:cover}

/* MODAL */
#modalTambah{
    display:none;
    position:fixed;inset:0;
    background:rgba(0,0,0,.5);
    align-items:center;justify-content:center;
    z-index:999
}
/* show modal when class 'active' is added */
#modalTambah.active{
    display:flex;
}
.modal-box{
    background:#fff;max-width:420px;width:100%;
    padding:26px;border-radius:18px
}
.modal-box input,.modal-box select{
    width:100%;padding:12px;margin-bottom:12px;
    border-radius:10px;border:1px solid #cbd5e1
}
.btn-save{background:#2563eb;color:#fff;border:none;padding:10px 18px;border-radius:10px}
.btn-cancel{background:#e5e7eb;border:none;padding:10px 18px;border-radius:10px}

@media(max-width:900px){
    .sidebar{position:relative;width:100%}
    .main{margin-left:0;padding:26px 20px}
}
</style>
</head>

<body>

<div class="sidebar">
    <div class="brand">
        <img src="../assets/usat.jpg">
        <h3>Universitas Satmata</h3>
    </div>
    <a href="dashboard_admin.php">Dashboard</a>
    <a href="bank_soal.php">Bank Soal</a>
    <a class="active">Pendaftaran</a>
    <a href="hasil_test_admin.php">Hasil Test</a>
    <a href="daftar_ulang_admin.php">Daftar Ulang</a>
    <a href="logout_admin.php">Logout</a>
</div>

<div class="main">
    <div class="header">
        <h2>Data Pendaftar</h2>
    </div>

    <div class="toolbar">
        <form class="filter-form">
            <select name="prodi">
                <option value="">-- Prodi --</option>
                <option>Informatika</option>
                <option>Manajemen</option>
                <option>Akuntansi</option>
            </select>
            <input type="text" name="asal_sekolah" placeholder="Asal Sekolah">
            <button>Filter</button>
        </form>

        <button onclick="openModal()" class="btn-add">
            <i class="fa-solid fa-user-plus"></i> Tambah Maba
        </button>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Foto</th><th>Nama</th><th>Email</th><th>Phone</th><th>Jenis Kelamin</th>
                    <th>Asal Sekolah</th><th>Prodi</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row=mysqli_fetch_assoc($data)){ ?>
                <tr>
                    <td><img src="../assets/foto_mhs/<?= $row['foto'] ?: 'default.png' ?>" class="avatar"></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= $row['asal_sekolah'] ?></td>
                    <td><?= $row['prodi'] ?></td>
                    <td><?= $row['tanggal_daftar'] ?></td>
                    <td>
                        <a href="edit_pendaftar.php?id=<?= $row['id'] ?>" style="color:#3b82f6;text-decoration:none;margin-right:10px">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a href="hapus_pendaftar.php?id=<?= $row['id'] ?>" style="color:#dc2626;text-decoration:none" onclick="return confirm('Yakin hapus?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah">
    <div class="modal-box">
        <h3>Tambah Mahasiswa</h3>
        <form method="POST">
            <input name="nama" placeholder="Nama" required>
            <input name="email" type="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password Login" required>
            <input name="phone" placeholder="No HP" required>
            <input name="tempat_tinggal" placeholder="Tempat Tinggal" required>
            <select name="jenis_kelamin" required>
                <option value="">-- Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <input name="asal_sekolah" placeholder="Asal Sekolah" required>
            <select name="prodi" required>
                <option value="">-- Prodi --</option>
                <option>Informatika</option>
                <option>Manajemen</option>
                <option>Akuntansi</option>
            </select>
            <div style="text-align:right">
                <button type="button" onclick="closeModal()" class="btn-cancel">Batal</button>
                <button name="tambah_maba" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(){
    document.getElementById('modalTambah').classList.add('active');
}
function closeModal(){
    document.getElementById('modalTambah').classList.remove('active');
}
</script>

</body>
</html>
