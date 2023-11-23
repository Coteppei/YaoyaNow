<?php
require_once("common.php");
session_start();

// ユーザー情報の定義
$user_id = $_SESSION['user_id'];

// 購入を確定するボタン以外から来た場合はエラー画面に遷移
if (!isset($_POST['purchaseButton'])) {
  header('Location: ../error.php');
  exit;
}

try {
  if ((isset($_POST['purchaseButton']))) {
    // カートデータを購入履歴テーブルにインサート
    $insert_stmt = $pdo->prepare(
      "INSERT INTO history (customerID, vegetableID, order_quantity)
      SELECT customerID, vegetableID, order_quantity FROM reservation");
    $insert_stmt->execute();

    // カートデータは購入済みになるため削除
    $delete_stmt = $pdo->prepare("DELETE FROM reservation WHERE customerID = :user_id");
    $delete_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $delete_stmt->execute();

    $_SESSION['action_message'] = "購入を確定しました。";
    header('Location: ../history.php');
    exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
