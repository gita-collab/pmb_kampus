<?php
include '../config.php';

/* Pastikan data dikirim via POST */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    /* Ambil data dari form */
    $id         = $_POST['id'] ?? '';
    $prodi      = $_POST['prodi'] ?? '';
    $pertanyaan = $_POST['pertanyaan'] ?? '';
    $opsi_a     = $_POST['opsi_a'] ?? '';
    $opsi_b     = $_POST['opsi_b'] ?? '';
    $opsi_c     = $_POST['opsi_c'] ?? '';
    $opsi_d     = $_POST['opsi_d'] ?? '';
    $jawaban    = $_POST['jawaban'] ?? '';

    /* Validasi sederhana */
    if($id == '' || $prodi == '' || $pertanyaan == '' || $opsi_a == '' || $opsi_b == '' || $opsi_c == '' || $opsi_d == '' || $jawaban == ''){
        echo "Data tidak lengkap!";
        exit;
    }

    /* Escape data untuk keamanan */
    $prodi      = mysqli_real_escape_string($conn, $prodi);
    $pertanyaan = mysqli_real_escape_string($conn, $pertanyaan);
    $opsi_a     = mysqli_real_escape_string($conn, $opsi_a);
    $opsi_b     = mysqli_real_escape_string($conn, $opsi_b);
    $opsi_c     = mysqli_real_escape_string($conn, $opsi_c);
    $opsi_d     = mysqli_real_escape_string($conn, $opsi_d);
    $jawaban    = mysqli_real_escape_string($conn, $jawaban);

    /* Update ke database */
    $sql = "UPDATE soal SET 
                prodi='$prodi',
                pertanyaan='$pertanyaan',
                opsi_a='$opsi_a',
                opsi_b='$opsi_b',
                opsi_c='$opsi_c',
                opsi_d='$opsi_d',
                jawaban='$jawaban'
            WHERE id='$id'";

    if(mysqli_query($conn, $sql)){
        /* Redirect kembali ke halaman edit dengan pesan sukses */
        header("Location: edit_soal.php?id=$id&msg=edit_sukses");
        exit;
    }else{
        echo "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        exit;
    }

}else{
    /* Jika bukan POST, redirect ke bank soal */
    header("Location: bank_soal.php");
    exit;
}
