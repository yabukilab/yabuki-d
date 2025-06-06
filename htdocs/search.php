<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionnaire Français - Recherche</title>
    <link rel="stylesheet" href="searchstyle.css">
</head>
<body>

    <header>
        <h1>Dictionnaire Français</h1>
        <p>フランス語辞書</p>
    </header>

    <main>
        <!-- 
          formタグで検索フォームを作成します。
          action="results.html" : フォーム送信先のページ
          method="GET" : URLに検索語を含めて送信する方法
        -->
        <form class="search-container" action="results.html" method="GET">
            <!-- 
              name="q" を設定することで、URLに ?q=検索語 の形でデータが送られます 
            -->
            <input type="search" id="search-input" name="q" placeholder="フランス語の単語を入力..." required>
            <button type="submit">検索</button>
        </form>
    </main>

    <footer>
        <p>© 2025 yabuki lab</p>
    </footer>

</body>
</html>