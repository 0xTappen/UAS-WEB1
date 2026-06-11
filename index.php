<?php
session_start();

if (isset($_SESSION['npm'])) {
    header('Location: beranda.php');
    exit;
}

$pesanError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guest'])) {
        $_SESSION['npm'] = 'guest';
        $_SESSION['nama'] = 'Guest User';
        $_SESSION['guest'] = true;
        header('Location: beranda.php');
        exit;
    }

    require __DIR__ . '/config.php';

    $npm = trim($_POST['npm'] ?? '');
    $passwordLogin = trim($_POST['password'] ?? '');

    if ($npm === '' || $passwordLogin === '') {
        $pesanError = 'NPM dan Password wajib diisi.';
    } else {
        $query = mysqli_prepare($koneksi, 'SELECT npm, nama FROM mahasiswa WHERE npm = ? AND password = ? LIMIT 1');
        mysqli_stmt_bind_param($query, 'ss', $npm, $passwordLogin);
        mysqli_stmt_execute($query);
        $hasil = mysqli_stmt_get_result($query);
        $mahasiswa = mysqli_fetch_assoc($hasil);

        if ($mahasiswa) {
            $_SESSION['npm'] = $mahasiswa['npm'];
            $_SESSION['nama'] = $mahasiswa['nama'];
            unset($_SESSION['guest']);
            header('Location: beranda.php');
            exit;
        }

        $pesanError = 'Login gagal. Pastikan NPM dan Password sesuai database.';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Universitas Teknokrat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="login-panel spada-login-panel">
            <div class="spada-brand">
                <img src="UNIVERSITASTEKNOKRAT.png" alt="Sistem Pembelajaran dalam Jaringan">
                <div>
                    <h1>Universitas Teknokrat<br>Indonesia</h1>
                    <p>Sistem Pembelajaran Daring</p>
                </div>
            </div>

            <?php if ($pesanError !== '') : ?>
                <div class="alert"><?php echo htmlspecialchars($pesanError); ?></div>
            <?php endif; ?>

            <form method="post" autocomplete="off">
                <input type="text" id="npm" name="npm" placeholder="Username" required autofocus>

                <input type="password" id="password" name="password" placeholder="Password" required>

                <button type="submit">Log in</button>
            </form>
            <a class="lost-password" href="#">Lost password?</a>
            <form method="post" class="guest-form">
                <button class="guest-button" type="submit" name="guest" value="1">Access as a guest</button>
            </form>
            <a class="cookies-notice" href="#">Cookies notice</a>
        </section>
    </main>
</body>
</html>
