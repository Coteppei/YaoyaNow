<?php
require_once("common.php");
session_start();

// クリックした商品情報を定義
$ID = $_GET["content"];

// ログイン時のみカートテーブルから対象商品の注文数を取得
if (isset($_SESSION['user_id'])) {
  // ユーザーの情報定義
  $user_id = $_SESSION['user_id'];

  // カートテーブルの注文数を取得 
  $cartQuery = "SELECT order_quantity FROM reservation WHERE customerID = :customerID AND vegetableID = :vegetableID";
  $cartStmt = $pdo->prepare($cartQuery);
  $cartStmt->bindValue(':customerID', $user_id, PDO::PARAM_INT);
  $cartStmt->bindValue(':vegetableID', $ID, PDO::PARAM_INT);
  $cartStmt->execute();
  $cartOrder = $cartStmt->fetchAll();
}

// 詳細情報が表示されるようセレクト
$query = "SELECT * FROM vegetable WHERE ID = $ID";  
$stmt = $pdo->prepare($query);
$stmt->execute();
$vegetablesdata = $stmt->fetchAll();
