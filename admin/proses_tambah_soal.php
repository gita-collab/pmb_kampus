<?php
include '../config.php';

$id         = $_POST['id'] ?? '';
$pertanyaan = $_POST['pertanyaan'];
$a          = $_POST['opsi_a'];
$b          = $_POST['opsi_b'];
$c          = $_POST['opsi_c'];
$d          = $_POST['opsi_d'];
$jawaban    = $_POST['jawaban'];
$prodi      = $_POST['prodi'];

if($id){
    // UPDATE SOAL
    mysqli_query($conn, "UPDATE soal SET
        pertanyaan='$pertanyaan',
        opsi_a='$a',
        opsi_b='$b',
        opsi_c='$c',
        opsi_d='$d',
        jawaban='$jawaban',
        prodi='$prodi'
        WHERE id='$id'
    ");
}else{
    // TAMBAH SOAL BARU
    mysqli_query($conn, "INSERT INTO soal
        (pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban, prodi)
        VALUES
        ('$pertanyaan','$a','$b','$c','$d','$jawaban','$prodi')
    ");
}

// BALIK KE BANK SOAL
header("Location: bank_soal.php?success=1");
exit;
