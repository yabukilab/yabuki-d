<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: index.html'); // ログアウト後の遷移先（トップページなど）
exit();
?>