<?php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$word_id = $_POST['word_id'] ?? null;
$term = $_POST['term'] ?? '';

if ($word_id !== null) {
    $stmt = $pdo->prepare("DELETE FROM memos WHERE user_id = ? AND word_id = ?");
    $stmt->execute([$user_id, $word_id]);
}

header('Location: results.php?q=' . urlencode($term));
exit();