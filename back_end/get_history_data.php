<?php
require_once("common.php");

// ユーザー情報の定義
$user_id = $_SESSION['user_id'];

// 1ページに表示する画像の数を定義
define('MAX', 16);

// ログインユーザーの購入した商品数をカウント
$queryTotal = 
"SELECT 
COUNT(*) AS total
FROM history AS history
  INNER JOIN customers AS customer
    ON history.customerID = customer.ID
  INNER JOIN vegetable AS vegetable
    ON history.vegetableID = vegetable.ID
WHERE customer.ID = $user_id";
$stmtTotal = $pdo->prepare($queryTotal);
$stmtTotal->execute();
$total = $stmtTotal->fetchColumn();

// 総ページ数算出
$total_page = ceil($total / MAX);

// 現在ページ情報の取得
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// ページ数が1未満の場合は1に、ページ数が総ページ数を超える場合は総ページ数に制限する
$currentPage = max(1, min($currentPage, $total_page));

// 購入した商品情報を抽出
$offset = ($currentPage - 1) * MAX;
$query = 
"SELECT 
  vegetable.ID, vegetable.varieties_name, vegetable.price, vegetable.img, history.order_quantity, history.created_at
FROM history AS history
  INNER JOIN customers AS customer
    ON history.customerID = customer.ID
  INNER JOIN vegetable AS vegetable
    ON history.vegetableID = vegetable.ID
WHERE customer.ID = :user_id
ORDER BY history.ID desc
LIMIT :offset, :max";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':max', MAX, PDO::PARAM_INT);
$stmt->execute();
$cartsdata = $stmt->fetchAll();

// カート内の合計金額を表示
$queryAllPrice = 
"SELECT price, order_quantity FROM history AS history
  INNER JOIN customers AS customer
    ON history.customerID = customer.ID
  INNER JOIN vegetable AS vegetable
    ON history.vegetableID = vegetable.ID
WHERE customer.ID = :user_id";
$priceStmt = $pdo->prepare($queryAllPrice);
$priceStmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$priceStmt->execute();
$selPrice = $priceStmt->fetchAll();

$totalPrice = 0;
if($selPrice != NULL) {
  foreach($selPrice as $price)
    $totalPrice += $price['price'] * $price['order_quantity'];
}