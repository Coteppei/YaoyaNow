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
      $orderQuantity = $_POST['buyCount'];

      // 登録されてる商品の個数を確認
      $checkStmt = $pdo->prepare("SELECT * FROM reservation WHERE ID = ? AND customerID = ?");
      $checkStmt->execute([$cartID, $user_id]);
      $existTable = $checkStmt->fetch(PDO::FETCH_ASSOC);

      // 削除処理or注文数を減らす処理実行
      if ($existTable['order_quantity'] <= $orderQuantity) {
        // 注文数とカートから外した数が同じの時、カートテーブルから削除する。
        $stmt = $pdo->prepare("DELETE FROM reservation WHERE ID = ? AND customerID = ?");
        $stmt->execute([$cartID, $user_id]);
        $_SESSION['action_message'] = "対象商品を削除しました";
      } else {
        // 注文数とカートから外した数が違うとき、注文数を減らす。
        $stmt = $pdo->prepare(
          "UPDATE reservation SET order_quantity = order_quantity - ?, updated_at = NOW() 
          WHERE ID = ? AND customerID = ?");
        $stmt->execute([$orderQuantity, $cartID, $user_id]);
        $_SESSION['action_message'] = "対象商品の注文数を" . $orderQuantity . "件減らしました。";
      }
      header('Location: ../cart.php');
      exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
