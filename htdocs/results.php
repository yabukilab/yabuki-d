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
        $sql = "SELECT french_word, japanese_translation, part_of_speech FROM words WHERE french_word LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['%' . $search_keyword . '%']);
        $results = $stmt->fetchAll();

        if ($results) {
            foreach ($results as $row) {
                // style.cssのクラス定義に合わせてHTMLを生成
                $results_html .= '<div class="result-item">';
                $results_html .= '<h3>' . htmlspecialchars($row['french_word'], ENT_QUOTES, 'UTF-8') . '</h3>';

                // 発音データがあれば表示
                if (!empty($row['pronunciation'])) {
                    $results_html .= '<p class="pronunciation">[' . htmlspecialchars($row['pronunciation'], ENT_QUOTES, 'UTF-8') . ']</p>';
                }

                // 品詞データがあれば表示
                if (!empty($row['part_of_speech'])) {
                    $results_html .= '<p class="type">' . htmlspecialchars($row['part_of_speech'], ENT_QUOTES, 'UTF-8') . '</p>';
                }

                // 日本語訳
                $results_html .= '<p class="meaning">' . htmlspecialchars($row['japanese_translation'], ENT_QUOTES, 'UTF-8') . '</p>';
                
                // 例文データがあれば表示
                if (!empty($row['example_sentence'])) {
                    $results_html .= '<p><strong>例文:</strong> ' . htmlspecialchars($row['example_sentence'], ENT_QUOTES, 'UTF-8') . '</p>';
                }

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