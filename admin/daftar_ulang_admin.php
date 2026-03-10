<?php
include '../config.php';

$data = mysqli_query($conn,"
    SELECT * FROM daftar_ulang
    ORDER BY tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ulang - Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ================= RESET ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    background:#f5f7fb;
    color:#1f2937;
}

/* ================= SIDEBAR ================= */
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
    object-fit:cover; /* DISAMAKAN */
}
.sidebar h3{
    font-size:16px;
    font-weight:600;
}
.sidebar a{
    display:flex;
    align-items:center;
    gap:14px;
    padding:14px 18px;
    margin-bottom:12px;
    border-radius:14px;
    color:#e0e7ff;
    text-decoration:none;
    font-size:14px;
    transition:.25s;
}
.sidebar a i{width:20px;}
.sidebar a.active,
.sidebar a:hover{
    background:rgba(255,255,255,.18);
    color:#fff;
}

/* ================= MAIN ================= */
.main{
    margin-left:260px;
    padding:36px 44px;
}
.header{
    margin-bottom:20px;
}
.header h2{
    font-size:22px;
    font-weight:600;
}

/* ================= TABLE ================= */
.table-card{
    background:#fff;
    padding:24px;
    border-radius:18px;
    box-shadow:0 12px 26px rgba(0,0,0,.06);
    overflow-x:auto;
}
table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
}
th{
    background:#1e3a8a;
    color:#fff;
    padding:14px;
    font-size:14px;
    text-align:left;
}
td{
    background:#ecfdf5;
    padding:14px;
    border-radius:12px;
    font-size:14px;
}

/* ================= STATUS ================= */
.status-pass{
    color:#166534;
    font-weight:700;
}
.status-fail{
    color:#b91c1c;
    font-weight:700;
}

/* ================= RESPONSIVE ================= */
@media(max-width:900px){
    .sidebar{
        position:relative;
        width:100%;
    }
    .main{
        margin-left:0;
        padding:24px;
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
    <a href="hasil_test_admin.php"><i class="fa-solid fa-clipboard-list"></i> Hasil Test</a>
    <a class="active" href="daftar_ulang_admin.php"><i class="fa-solid fa-id-card"></i> Daftar Ulang</a>
    <a href="logout_admin.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">
    <div class="header">
        <h2>Daftar Ulang Mahasiswa</h2>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>NIM</th>
                    <th>No HP Ortu</th>
                    <th>Nilai</th>
                    <th>Prodi</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if(mysqli_num_rows($data)==0): ?>
                <tr>
                    <td colspan="8" style="text-align:center;background:#fef9c3">
                        Belum ada data daftar ulang
                    </td>
                </tr>
            <?php endif; ?>

            <?php while($row=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['jenis_kelamin'] ?? ''; ?></td>
                    <td><?= $row['nim']; ?></td>
                    <td><?= $row['phone_ortu']; ?></td>
                    <td><b><?= $row['nilai']; ?></b></td>
                    <td><?= $row['prodi']; ?></td>
                    <td><?= $row['tanggal']; ?></td>
                    <td class="<?= $row['nilai']>=75?'status-pass':'status-fail'; ?>">
                        <?= $row['nilai']>=75?'LULUS':'TIDAK LULUS'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
