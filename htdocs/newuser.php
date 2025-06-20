<?php
// 登録処理（POST時）
$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = $_POST["userid"] ?? "";
    $password = $_POST["password"] ?? "";
    $password_confirm = $_POST["password_confirm"] ?? "";

    // ダミーの既存ID（実際はDBで確認）
    $usedIds = ["user1", "testuser", "admin"];

    // バリデーション
    if (in_array($userid, $usedIds)) {
        $error = "※このIDは既に使われています";
    } elseif ($password !== $password_confirm) {
        $error = "※パスワードが一致しません";
    } else {
        // 登録成功（実際はDB保存）
        $success = true;
    }
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
  <footer>
      &copy;  2025 yabuki lab
  </footer>
  </body>
</html>
