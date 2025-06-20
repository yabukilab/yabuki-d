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

header('Location: results.php?term=' . urlencode($_GET['term'] ?? ''));
exit();