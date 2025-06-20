<?php
// ログイン処理（POST時）
$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid = $_POST["userid"] ?? "";
    $password = $_POST["password"] ?? "";

    // ダミーユーザー情報（実際はDBで確認）
    $validUsers = [
        "user1" => "pass123",
        "testuser" => "testpass",
        "admin" => "admin123"
    ];

    if (isset($validUsers[$userid]) && $validUsers[$userid] === $password) {
        $success = true;
    } else {
        $error = "※IDまたはパスワードが正しくありません";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン</title>
  <link rel="stylesheet" href="newuserstyle.css" />
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <h2>ログイン成功！</h2>
      <p>ようこそ、<?= htmlspecialchars($userid) ?>さん。</p>
    <?php else: ?>
      <h2>ログイン</h2>
      <form action="login.php" method="post">
        <input type="text" name="userid" placeholder="ID" required value="<?= htmlspecialchars($userid ?? '') ?>" />
        <input type="password" name="password" placeholder="パスワード" required />
        <?php if (!empty($error)): ?>
          <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit">ログイン</button>
      </form>
    <?php endif; ?>
  </div>
  <footer>
      &copy;  2025 yabuki lab
    </footer>
  </body>
</html>
