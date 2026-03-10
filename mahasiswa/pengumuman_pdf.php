<?php
session_start();
include '../config.php';
require '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'mahasiswa'){
    header("Location: ../auth/login.php");
    exit;
}

$email = $_SESSION['user']['email'];

// Ambil data mahasiswa
$stmt = mysqli_prepare($conn, "SELECT * FROM calon_mahasiswa WHERE email=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$mhs = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

// Cek daftar ulang
$stmt2 = mysqli_prepare($conn, "SELECT * FROM daftar_ulang WHERE email=? LIMIT 1");
mysqli_stmt_bind_param($stmt2, "s", $email);
mysqli_stmt_execute($stmt2);
$res2 = mysqli_stmt_get_result($stmt2);
$udah_daftar = mysqli_num_rows($res2) > 0;
mysqli_stmt_close($stmt2);

// NIM dan nilai
$nim = $udah_daftar ? $mhs['nim'] : 'Belum tersedia';
$nilai_test = $mhs['nilai_test'] ?? 0;
$tahun_masuk = date('Y');
$is_lulus = $nilai_test >= 75;

// HTML Pengumuman
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: white;
    padding: 20px;
}

.container {
    max-width: 100%;
    margin: auto;
    background: white;
}

.header {
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #1e3a8a;
    padding-bottom: 10px;
}

.header h2 {
    margin: 0;
    color: #1e3a8a;
    font-size: 18px;
}

.header p {
    margin: 5px 0 0 0;
    color: #555;
    font-size: 12px;
}

.status-box {
    text-align: center;
    margin: 15px 0;
    padding: 12px;
    border-radius: 6px;
    font-weight: bold;
    color: white;
    background-color: '.($is_lulus ? '#28a745' : '#dc3545').';
    font-size: 13px;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    margin: 15px 0;
}

.info-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.info-table td.label {
    background: #1e3a8a;
    color: #fff;
    font-weight: bold;
    width: 35%;
}

.info-table td.value {
    background: #f8f9fa;
    color: #333;
}

.signature-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

.signature {
    text-align: right;
    width: 220px;
}

.signature-label {
    font-weight: bold;
    font-size: 12px;
    margin-bottom: 50px;
}

.signature-box {
    border-top: 1px solid #000;
    padding-top: 6px;
    font-size: 10px;
}

.footer {
    font-size: 9px;
    text-align: center;
    margin-top: 15px;
    color: #777;
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

@page {
    size: A5 portrait;
    margin: 10px;
}

@media print {
    body {
        padding: 0;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>UNIVERSITAS SATMATA</h2>
        <p>Pengumuman Hasil Seleksi Mahasiswa Baru</p>
    </div>

    <div class="status-box">'.($is_lulus ? '✅ SELAMAT! ANDA DINYATAKAN LULUS' : '❌ MOHON MAAF, ANDA BELUM LULUS').'</div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="value">'.htmlspecialchars($mhs['nama']).'</td>
        </tr>
        <tr>
            <td class="label">Prodi</td>
            <td class="value">'.htmlspecialchars($mhs['prodi']).'</td>
        </tr>
        <tr>
            <td class="label">NIM</td>
            <td class="value">'.$nim.'</td>
        </tr>
        <tr>
            <td class="label">Tahun Masuk</td>
            <td class="value">'.$tahun_masuk.'</td>
        </tr>
    </table>

    <div class="signature-wrapper">
        <div class="signature">
            <div class="signature-label">Panitia Penerimaan Mahasiswa Baru</div>
            <div class="signature-box">(Tanda Tangan & Cap)</div>
        </div>
    </div>

    <div class="footer">
        Dokumen resmi Universitas Satmata | '.date('d F Y').'
    </div>
</div>
</body>
</html>
';

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array(
    'isPhpEnabled' => false,
    'isRemoteEnabled' => false,
    'defaultFont' => 'Arial',
    'dpi' => 96
));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();

$dompdf->stream('Pengumuman_'.$mhs['nama'].'.pdf', array('Attachment' => false));
?>