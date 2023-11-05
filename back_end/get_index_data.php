<?php
require_once("common.php");
session_start();
// 野菜テーブルのセレクト
$query = "SELECT * FROM vegetable";
$stmt = $pdo->prepare($query);
$stmt->execute();
$vegetablesdata = $stmt->fetchAll();

// ログイン成功時メッセージ表示
if(isset($_SESSION['login_message'])) {
  $log_message = $_SESSION['login_message'];
  unset($_SESSION['login_message']);
}

// ログアウト成功時時メッセージ表示
if(isset($_SESSION['logout_message'])) {
  $log_message = $_SESSION['logout_message'];
  unset($_SESSION['logout_message']);
}

// カートに入ったことを表示
if(isset($_SESSION['cart_message'])){
  $cart_message = $_SESSION['cart_message'];
  unset($_SESSION['cart_message']);
}
