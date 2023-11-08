<?php
session_start();
// ログアウトボタンを押すと、フォームで来てセッション削除
session_unset();
$_SESSION['action_message'] = 'ログアウトしました';
header('Location: ../index.php');
exit;