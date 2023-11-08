<?php
require_once("common.php");
session_start();

// 削除対象のデータが検知できない場合、エラー画面に遷移
if(!isset($_POST['cart_id']) || !isset($_POST['deleteButton'])){
  header('Location: ../error.php');
  exit;
}

// 削除ボタンを押すと動作
try {
  if (isset($_POST['deleteButton'])) {
      // 削除対象情報の定義
      $cartID = $_POST['cart_id'];
      $user_id = $_SESSION['user_id'];

      // 削除対象レコードを削除
      $stmt = $pdo->prepare("DELETE FROM reservation WHERE ID = ? AND customerID = ?");
      $stmt->execute([$cartID, $user_id]);
      $_SESSION['action_message'] = "対象商品を削除しました";
      header('Location: ../cart.php');
      exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}