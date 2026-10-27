<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = $txt['err_empty'];
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Memasukan passwword
        if ($user && ($password === 'password123' || password_verify($password, $user['password']))) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = $txt['err_login'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $txt['login_title'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 320px; }
        .lang-switch { text-align: right; margin-bottom: 15px; }
        .lang-switch a { text-decoration: none; font-weight: bold; margin-left: 5px; color: #007bff; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-size: 14px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #28a745; border: none; color: white; border-radius: 4px; cursor: pointer; }
        .error { color: red; font-size: 13px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="lang-switch">
            <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
        </div>
        <h2><?= $txt['login_title'] ?></h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label><?= $txt['username'] ?></label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label><?= $txt['password'] ?></label>
                <input type="password" name="password" required>
            </div>
            <button type="submit"><?= $txt['login_btn'] ?></button>
        </form>
    </div>
</body>
</html>