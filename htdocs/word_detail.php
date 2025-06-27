<?php
session_start();

// --- データベース接続設定 ---
$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser = isset($_SERVER['MYSQL_USER'])     ? $_SERVER['MYSQL_USER']     : 'testuser';
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass';
$dbName = isset($_SERVER['MYSQL_DB'])       ? $_SERVER['MYSQL_DB']       : 'worddb';

$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// ログイン必須
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$word = $part = $translation = $memo_val = '';
$word_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

    // 単語詳細取得
    $stmt = $pdo->prepare("SELECT word, translation, part FROM wordtable WHERE id = ?");
    $stmt->execute([$word_id]);
    $row = $stmt->fetch();
    if ($row) {
        $word = htmlspecialchars($row['word'], ENT_QUOTES, 'UTF-8');
        $part = !empty($row['part']) ? htmlspecialchars($row['part'], ENT_QUOTES, 'UTF-8') : '';
        $translation = htmlspecialchars($row['translation'], ENT_QUOTES, 'UTF-8');
    }

    // メモ取得（ユーザーごと）
    $memo_stmt = $pdo->prepare("SELECT memo FROM memos WHERE user_id = ? AND word_id = ?");
    $memo_stmt->execute([$_SESSION['user_id'], $word_id]);
    $memo_row = $memo_stmt->fetch();
    $memo_val = $memo_row ? htmlspecialchars($memo_row['memo'], ENT_QUOTES, 'UTF-8') : '';

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $error_message = 'データベースへの接続に失敗しました。<br>' . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>単語詳細 - フランス語辞書</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>フランス語辞書</h1>
        <nav>
            <a href="logout.php" style="float:right;">ログアウト</a>
        </nav>
    </header>
    <main>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php elseif ($word): ?>
            <h2><?php echo $word; ?></h2>
            <?php if ($part): ?>
                <p class="type"><?php echo $part; ?></p>
            <?php endif; ?>
            <p class="meaning"><?php echo $translation; ?></p>
            <form method="post" action="save_memo.php" style="margin-top:1em;">
                <input type="hidden" name="word_id" value="<?php echo $word_id; ?>">
                <input type="hidden" name="term" value="<?php echo isset($_GET['q']) ? h($_GET['q']) : ''; ?>">
                <label>メモ:</label><br>
                <textarea name="memo" rows="4" style="width:98%;"><?php echo $memo_val; ?></textarea><br>
                <button type="submit">メモを保存</button>
            </form>
        <?php else: ?>
            <p class="not-found-message">単語が見つかりませんでした。</p>
        <?php endif; ?>
        <a href="results.php?q=<?php echo isset($_GET['q']) ? urlencode($_GET['q']) : ''; ?>" class="back-link">検索結果に戻る</a>
    </main>
    <footer>
        <p>© 2025 yabuki lab</p>
    </footer>
</body>
</html>