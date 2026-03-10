<?php
include '../config.php';
$id = $_GET['id'] ?? '';
if($id){
    mysqli_query($conn,"DELETE FROM calon_mahasiswa WHERE id='$id'");
}
header("Location: admin_pendaftaran.php");
exit;
