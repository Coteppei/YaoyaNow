<?php
require_once("common.php");

// ユーザー情報の定義
$user_id = $_SESSION['user_id'];

// 購入予定の商品情報をセレクト
$query = 
"SELECT 
  vegetable.ID, vegetable.varieties_name, vegetable.price, vegetable.img, reservation.ID AS cartID
FROM reservation AS reservation
  INNER JOIN customers AS customer
    ON reservation.customerID = customer.ID
  INNER JOIN vegetable AS vegetable
    ON reservation.vegetableID = vegetable.ID
  WHERE customer.ID = $user_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$cartsdata = $stmt->fetchAll();

// カート内の合計金額を表示
$totalPrice = 0;
foreach ($cartsdata as $cartsprice) {
    $totalPrice += (int)$cartsprice['price'];
}
