<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi Data Input
    $nim     = trim(htmlspecialchars($_POST['nim'] ?? ''));
    $nama    = trim(htmlspecialchars($_POST['nama'] ?? ''));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $jurusan = trim(htmlspecialchars($_POST['jurusan'] ?? ''));

    // Validasi Percabangan (if-else)
    if (empty($nim) || empty($nama) || empty($email) || empty($jurusan)) {
        $error = $txt['err_empty'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = $txt['err_email'];
    } else {
        $stmt = $pdo->prepare('INSERT INTO mahasiswa (nim, nama, email, jurusan) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nim, $nama, $email, $jurusan]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $txt['add_student'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f8f9fa; }
        .card { background: white; padding: 20px; border-radius: 8px; width: 400px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; color: white; cursor: pointer; text-decoration: none; }
        .btn-save { background: #28a745; }
        .btn-back { background: #6c757d; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <h2><?= $txt['add_student'] ?></h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label><?= $txt['nim'] ?></label>
                <input type="text" name="nim" value="<?= htmlspecialchars($_POST['nim'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['nama'] ?></label>
                <input type="text" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['email'] ?></label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['jurusan'] ?></label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($_POST['jurusan'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-save"><?= $txt['save'] ?></button>
            <a href="index.php" class="btn btn-back"><?= $txt['back'] ?></a>
        </form>
    </div>
</body>
</html>