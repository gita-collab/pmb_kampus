<?php
session_start();
include '../config.php';

// OPTIONAL: proteksi admin
// if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit; }

$alert = '';

if(isset($_POST['simpan'])){
    $pertanyaan = mysqli_real_escape_string($conn,$_POST['pertanyaan']);
    $a          = mysqli_real_escape_string($conn,$_POST['opsi_a']);
    $b          = mysqli_real_escape_string($conn,$_POST['opsi_b']);
    $c          = mysqli_real_escape_string($conn,$_POST['opsi_c']);
    $d          = mysqli_real_escape_string($conn,$_POST['opsi_d']);
    $jawaban    = $_POST['jawaban'];
    $prodi      = mysqli_real_escape_string($conn,$_POST['prodi']);

    $insert = mysqli_query($conn,"INSERT INTO soal
        (pertanyaan,opsi_a,opsi_b,opsi_c,opsi_d,jawaban,prodi)
        VALUES
        ('$pertanyaan','$a','$b','$c','$d','$jawaban','$prodi')
    ");

    if($insert){
        header("Location: bank_soal.php?success=1");
        exit;
    }else{
        $alert = "❌ Gagal menyimpan soal!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Soal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{font-family:'Poppins',sans-serif}
body{background:#f4f6fb}
.card{border-radius:18px; box-shadow:0 10px 25px rgba(0,0,0,.08)}
textarea{resize:vertical}
</style>
</head>

<body>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card p-4">
<h4 class="mb-3 text-primary fw-semibold">➕ Tambah Soal Baru</h4>

<?php if($alert){ ?>
<div class="alert alert-danger"><?= $alert ?></div>
<?php } ?>

<form method="POST">

<label class="fw-medium">Pertanyaan</label>
<textarea name="pertanyaan" rows="4" class="form-control mb-3" required></textarea>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <input type="text" name="opsi_a" class="form-control" placeholder="Pilihan A" required>
    </div>
    <div class="col-md-6">
        <input type="text" name="opsi_b" class="form-control" placeholder="Pilihan B" required>
    </div>
    <div class="col-md-6">
        <input type="text" name="opsi_c" class="form-control" placeholder="Pilihan C" required>
    </div>
    <div class="col-md-6">
        <input type="text" name="opsi_d" class="form-control" placeholder="Pilihan D" required>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <input type="text" name="prodi" class="form-control" placeholder="Program Studi" required>
    </div>
    <div class="col-md-6">
        <select name="jawaban" class="form-select" required>
            <option value="">Jawaban Benar</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="bank_soal.php" class="btn btn-secondary">⬅ Kembali</a>
    <button type="submit" name="simpan" class="btn btn-primary">💾 Simpan Soal</button>
</div>

</form>
</div>

</div>
</div>
</div>

</body>
</html>
