<?php
require_once("common.php");

// ユーザー情報の定義
$user_id = $_SESSION['user_id'];

// 購入した商品情報を抽出
$query = 
"SELECT 
  vegetable.ID, vegetable.varieties_name, vegetable.price, vegetable.img, history.created_at
FROM history AS history
  INNER JOIN customers AS customer
    ON history.customerID = customer.ID
  INNER JOIN vegetable AS vegetable
    ON history.vegetableID = vegetable.ID
  WHERE customer.ID = $user_id
  ORDER BY history.ID desc";
$stmt = $pdo->prepare($query);
$stmt->execute();
$cartsdata = $stmt->fetchAll();

// カート内の合計金額を表示
$totalPrice = 0;
foreach ($cartsdata as $cartsprice) {
    $totalPrice += (int)$cartsprice['price'];
}