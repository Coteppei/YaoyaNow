<?php
require_once("common.php");
session_start();

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

    // カートデータは購入済みになるため削除
    $delete_stmt = $pdo->prepare("DELETE FROM reservation");
    $insert_stmt->execute();
    $delete_stmt->execute();
    $_SESSION['action_message'] = "購入を確定しました。";
    header('Location: ../history.php');
    exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
