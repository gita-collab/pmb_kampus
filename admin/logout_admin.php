<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout</title>
<style>
/* ===== BASIC RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* ===== BODY STYLE ===== */
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    overflow: hidden;
}

/* ===== CONTAINER ===== */
.logout-container {
    text-align: center;
    background: rgba(255,255,255,0.1);
    padding: 40px 60px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    animation: fadeOut 2s forwards;
}

/* ===== MESSAGE ===== */
.logout-container h1 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.logout-container p {
    font-size: 1rem;
    opacity: 0.9;
}

/* ===== ANIMATION ===== */
@keyframes fadeOut {
    0% {
        opacity: 1;
        transform: translateY(0);
    }
    70% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(-50px);
    }
}
</style>
<script>
// Redirect setelah 2 detik (sama dengan durasi animasi)
setTimeout(() => {
    window.location.href = '../index.php';
}, 2000);
</script>
</head>
<body>
<div class="logout-container">
    <h1>Berhasil Logout!</h1>
    <p>Mengalihkan ke halaman utama...</p>
</div>
</body>
</html>
