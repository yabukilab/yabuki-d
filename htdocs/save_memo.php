<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$word_id = $_POST['word_id'] ?? null;
$memo = $_POST['memo'] ?? '';
$term = $_POST['term'] ?? ''; // ← ここを修正

if ($word_id !== null) {
    $stmt = $pdo->prepare("
        INSERT INTO memos (user_id, word_id, memo)
        VALUES (:user_id, :word_id, :memo)
        ON DUPLICATE KEY UPDATE memo = :memo2
    ");
    $stmt->execute([
        ':user_id' => $user_id,
        ':word_id' => $word_id,
        ':memo' => $memo,
        ':memo2' => $memo
    ]);
}

// 単語詳細ページにリダイレクト
header('Location: word_detail.php?id=' . urlencode($word_id) . (empty($term) ? '' : '&q=' . urlencode($term)));
exit();