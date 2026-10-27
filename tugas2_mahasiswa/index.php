<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM mahasiswa ORDER BY id DESC');
$mahasiswa = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $txt['app_title'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f8f9fa; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 4px; font-size: 14px; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-delete { background: #dc3545; }
        .btn-logout { background: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h2><?= $txt['app_title'] ?></h2>
        <div>
            Bahasa: <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a> | 
            <a href="logout.php" class="btn btn-logout"><?= $txt['logout'] ?></a>
        </div>
    </div>

    <p><a href="create.php" class="btn btn-add">+ <?= $txt['add_student'] ?></a></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th><?= $txt['nim'] ?></th>
                <th><?= $txt['nama'] ?></th>
                <th><?= $txt['email'] ?></th>
                <th><?= $txt['jurusan'] ?></th>
                <th><?= $txt['action'] ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mahasiswa)): ?>
                <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($mahasiswa as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['jurusan']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit"><?= $txt['edit'] ?></a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('<?= $txt['confirm_delete'] ?>')"><?= $txt['delete'] ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>