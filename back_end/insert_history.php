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
    // カートデータを購入履歴テーブルにインサート前に比較
    $select_stmt = $pdo->prepare(
      "SELECT res.order_quantity, veg.stock_quantity
      FROM reservation AS res
      INNER JOIN vegetable AS veg ON res.vegetableID = veg.ID
      WHERE res.customerID = ?");
    $select_stmt->execute([$user_id]);
    $cart_data = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
    // 注文数が在庫より少ないデータ(異常値)がある時、強制的にエラーにする。
    foreach ($cart_data as $item) {
      if ($item['order_quantity'] > $item['stock_quantity']) {
        header('Location: ../error.php');
        exit;
      }
    }

    // カートデータを購入履歴テーブルにインサート
    $insert_stmt = $pdo->prepare(
    "INSERT INTO history (customerID, vegetableID, order_quantity)
    SELECT customerID, vegetableID, order_quantity FROM reservation WHERE customerID = :user_id");
    $insert_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $insert_stmt->execute();


    // 購入した商品分野菜テーブル内の在庫数から減らす
    $update_stmt = $pdo->prepare(
      "UPDATE vegetable AS veg
        INNER JOIN reservation AS res
          ON veg.ID = res.vegetableID
        SET stock_quantity = stock_quantity - order_quantity
      WHERE customerID = ?");
    $update_stmt->execute([$user_id]);

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
