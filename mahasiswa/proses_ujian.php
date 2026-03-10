<?php
session_start();
include '../config.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login_ujian.php");
    exit;
}

$email = $_SESSION['user']['email'];

$score = 0;
if($_POST['q1']=='A') $score+=50;
if($_POST['q2']=='A') $score+=50;

$status = $score>=70 ? 'Lulus' : 'Tidak Lulus';

mysqli_query($conn,"
    UPDATE calon_mahasiswa
    SET nilai_test='$score',
        status_test='$status'
    WHERE email='$email'
");

unset($_SESSION['nomor_test']);

header("Location: dashboard.php");
exit;
