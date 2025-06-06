<?php
include 'db.php';  // db.phpを読み込むことでデータベース接続を利用

$query = 'SELECT * FROM products';  // 'products' テーブルからデータを取得
$stmt = $pdo->query($query);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品データ</title>
</head>
<body>
    <table>
        <?php foreach ($stmt as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?>, <?= htmlspecialchars($row['name']) ?>, <?= intval($row['price']) ?>, <?= htmlspecialchars($row['stock']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
