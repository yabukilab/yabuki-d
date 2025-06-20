<?php
// --- データベース接続設定 ---
// ご自身の環境に合わせて変更してください
$dbServer = isset($_ENV['MYSQL_SERVER'])    ? $_ENV['MYSQL_SERVER']      : '127.0.0.1';
$dbUser = isset($_SERVER['MYSQL_USER'])     ? $_SERVER['MYSQL_USER']     : 'testuser';
$dbPass = isset($_SERVER['MYSQL_PASSWORD']) ? $_SERVER['MYSQL_PASSWORD'] : 'pass';
$dbName = isset($_SERVER['MYSQL_DB'])       ? $_SERVER['MYSQL_DB']       : 'worddb';

// DSNとPDOオプション
$dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// 変数の初期化
$search_keyword_display = '';
$results_html = '';

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

    if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
        $search_keyword = trim($_GET['q']);
        $search_keyword_display = htmlspecialchars($search_keyword, ENT_QUOTES, 'UTF-8');

        // SQLクエリの準備
        $sql = "SELECT word, translation, part FROM wordtable WHERE word LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['%' . $search_keyword . '%']);
        $results = $stmt->fetchAll();

        if ($results) {
            foreach ($results as $row) {
                // style.cssのクラス定義に合わせてHTMLを生成
                $results_html .= '<div class="result-item">';
                $results_html .= '<h3>' . htmlspecialchars($row['word'], ENT_QUOTES, 'UTF-8') . '</h3>';

                // 品詞データがあれば表示
                if (!empty($row['part_of_speech'])) {
                    $results_html .= '<p class="type">' . htmlspecialchars($row['part'], ENT_QUOTES, 'UTF-8') . '</p>';
                }

                // 日本語訳
                $results_html .= '<p class="meaning">' . htmlspecialchars($row['translation'], ENT_QUOTES, 'UTF-8') . '</p>';
                
                 // --- メモ機能追加部分 ---
                if (isset($_SESSION['user_id'])) {
                    // 既存メモ取得
                    $memo_stmt = $pdo->prepare("SELECT memo FROM memos WHERE user_id = ? AND word_id = ?");
                    $memo_stmt->execute([$_SESSION['user_id'], $word_id]);
                    $memo_row = $memo_stmt->fetch();
                    $memo_val = $memo_row ? htmlspecialchars($memo_row['memo'], ENT_QUOTES, 'UTF-8') : '';

                    $results_html .= '<form method="post" action="save_memo.php" style="margin-top:1em;">';
                    $results_html .= '<input type="hidden" name="word_id" value="' . $word_id . '">';
                    $results_html .= '<input type="hidden" name="term" value="' . htmlspecialchars($search_keyword, ENT_QUOTES, 'UTF-8') . '">';
                    $results_html .= '<label>メモ:</label><br>';
                    $results_html .= '<textarea name="memo" rows="2" style="width:98%;">' . $memo_val . '</textarea><br>';
                    $results_html .= '<button type="submit">メモを保存</button>';
                    $results_html .= '</form>';
                } else {
                    $results_html .= '<div style="margin-top:1em;color:#888;">※メモ機能はログイン後に利用できます</div>';
                }
                // --- メモ機能ここまで ---

                $results_html .= '</div>';
            }
        } else {
            $results_html = '<p class="not-found-message">該当する単語は見つかりませんでした。</p>';
        }
    } else {
        $results_html = '<p class="initial-message">検索キーワードを入力してください。</p>';
    }

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $results_html = '<p class="error-message">データベースへの接続に失敗しました。</p>';
    echo '<p class="error-message">データベースエラー: ' . htmlspecialchars($e->getMessage()) . '</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果 - フランス語辞書</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>フランス語辞書</h1>
    </header>

    <main>
        <section id="search-query-display">
            <?php if (!empty($search_keyword_display)): ?>
                <h2>"<span><?php echo $search_keyword_display; ?></span>" の検索結果</h2>
            <?php endif; ?>
        </section>

        <section id="results-container">
            <?php echo $results_html; ?>
        </section>

        <a href="search.php" class="back-link">新しい単語を検索する</a>
    </main>

    <footer>
        <p>© 2025 yabuki lab</p>
    </footer>
</body>
</html>