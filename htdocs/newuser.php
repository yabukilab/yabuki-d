<?php
// --- データベース接続設定 ---
// ご自身の環境に合わせて変更してください
$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser = isset($_SERVER['MYSQL_USER'])     ? $_SERVER['MYSQL_USER']     : 'testuser';
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass';
$dbName = isset($_SERVER['MYSQL_DB'])       ? $_SERVER['MYSQL_DB']       : 'userdb';

// DSNとPDOオプション
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // DSN（接続文字列）を修正
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

    // 接続成功メッセージ（本番ではコメントアウト推奨）
    // echo "データベースに接続しました";
} catch (PDOException $e) {
    // 接続失敗時の処理
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>新規登録</title>
  <link rel="stylesheet" href="newuserstyle.css" />
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <h2>登録が完了しました！</h2>
    <?php else: ?>
      <h2>新規登録</h2>
      <form action="register.php" method="post">
        <input type="text" name="userid" placeholder="ID（20文字まで）" maxlength="20" required value="<?= htmlspecialchars($userid ?? '') ?>" />
        <input type="password" name="password" placeholder="パスワード（36文字まで）" maxlength="36" required />
        <input type="password" name="password_confirm" placeholder="パスワード確認" maxlength="36" required />
        <?php if (!empty($error)): ?>
          <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit">登録する</button>
      </form>
    <?php endif; ?>
  </div>

<footer>© 2025 yabuki lab</footer> 
</body>
</html>
