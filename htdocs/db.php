<?php
$dsn = 'mysql:host=localhost;dbname=mydb;charset=utf8';  // ローカルのMySQLサーバーを指定
$user = 'testuser';
$password = 'pass';
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('データベース接続失敗: ' . $e->getMessage());
}
?>
