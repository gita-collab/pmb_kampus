<?php
require '../config.php';

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT jenis_kelamin, tanggal_lahir, asal_sekolah,
           alamat, prodi, foto, profil_lengkap
    FROM calon_mahasiswa
    WHERE user_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

$profilLengkap = true;

foreach (['jenis_kelamin','tanggal_lahir','asal_sekolah','alamat','prodi','foto'] as $field) {
    if (empty($data[$field])) {
        $profilLengkap = false;
        break;
    }
}

/* Update flag otomatis */
if ($profilLengkap && $data['profil_lengkap'] == 0) {
    $conn->query("
        UPDATE calon_mahasiswa
        SET profil_lengkap = 1
        WHERE user_id = $user_id
    ");
}
