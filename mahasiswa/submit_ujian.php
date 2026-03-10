<?php
session_start();
include 'config.php';

$jawaban = $_POST['jawaban'];
$benar = 0;

foreach($jawaban as $id=>$j){
  $q = mysqli_query($conn,"SELECT jawaban FROM soal WHERE id=$id");
  $k = mysqli_fetch_assoc($q);
  if($j == $k['jawaban']) $benar++;
}

$total = count($jawaban);
$nilai = ($benar/$total)*100;
$status = $nilai >= 75 ? 'LULUS' : 'TIDAK';

mysqli_query($conn,"
  INSERT INTO hasil_ujian(user_id,nilai,status,tanggal)
  VALUES('{$_SESSION['user']['id']}','$nilai','$status',CURDATE())
");

header("Location: hasil.php");
