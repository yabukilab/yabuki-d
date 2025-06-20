<?php
// DB接続情報
$host = 'localhost';        // データベースサーバ（通常は localhost）
$dbname = 'userdb';         // 使用するデータベース名
$user = 'your_username';    // データベースのユーザー名
$pass = 'your_password';    // パスワード

try {
    // DSN（接続文字列）
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    // PDOインスタンスの生成
    $pdo = new PDO($dsn, $user, $pass);

    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    </div> <!-- ← ここで .container 終了 -->

  <footer>
    &copy; 2025 yabuki lab
  </footer>

</body>
</html>

