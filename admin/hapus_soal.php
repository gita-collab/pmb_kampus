<?php
include '../config.php';

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $q = mysqli_query($conn, "DELETE FROM soal WHERE id='$id'");

    if($q){
        header("Location: bank_soal.php?msg=hapus_sukses");
        exit;
    } else {
        echo "Gagal menghapus soal: " . mysqli_error($conn);
    }
} else {
    echo "ID soal tidak ditemukan!";
}
