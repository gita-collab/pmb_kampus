<?php
include '../config.php';

$id = $_POST['id'] ?? '';
$nama = $_POST['nama'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$jk = $_POST['jenis_kelamin'];
$asal_sekolah = $_POST['asal_sekolah'];
$prodi = $_POST['prodi'];

/* Cek upload foto */
if(isset($_FILES['foto']) && $_FILES['foto']['name']){
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = 'foto_'.time().'.'.$ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/'.$filename);
    $foto_sql = ", foto='$filename'";
}else{
    $foto_sql = "";
}

mysqli_query($conn, "UPDATE calon_mahasiswa SET 
    nama='$nama',
    email='$email',
    phone='$phone',
    jenis_kelamin='$jk',
    asal_sekolah='$asal_sekolah',
    prodi='$prodi'
    $foto_sql
    WHERE id='$id'
");

header("Location: edit_pendaftar.php?id=$id&msg=Data berhasil diperbarui!");
exit;
