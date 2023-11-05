<?php
// 購入ボタンを押すと、カートに入っている商品がすべて削除され、履歴テーブルに入る
require_once("common.php");
session_start();

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
    $_SESSION['cart_message'] = "購入を確定しました。";
    header('Location: ../index.php');
    exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
