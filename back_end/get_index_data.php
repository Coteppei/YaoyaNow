<?php
require_once("common.php");
session_start();

// 検索実行時
if (isset($_GET['search'])) {
  // 検索機能を
  $searchKeyword = trim(mb_convert_kana($_GET['search'], 'aCKV'));
  $html_searchKeyword = "search=" . $_GET['search'] . "&";
} else {
  // 検索がない場合、空で登録
  $searchKeyword = '';
}

// 1ページあたりの商品表示数を定義
define('MAX', 16);

// 野菜テーブルの画像の総数をカウント
// 検索ワードが存在する場合は種類もしくは名前と一致する商品を表示する
$queryTotal = 
"SELECT COUNT(*) AS total FROM vegetable 
WHERE types_name LIKE :searchKeyword 
  OR varieties_name LIKE :searchKeyword 
  OR types_name_kana LIKE :searchKeyword 
  OR varieties_name_kana LIKE :searchKeyword";
$stmtTotal = $pdo->prepare($queryTotal);
$stmtTotal->bindValue(':searchKeyword', '%' . $searchKeyword . '%', PDO::PARAM_STR);
$stmtTotal->execute();
$total = $stmtTotal->fetchColumn();

// 総ページ数を算出
$total_page = ceil($total / MAX);

// 現在ページ情報の取得
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
// ページ数が1未満の場合は1に、ページ数が総ページ数を超える場合は総ページ数に制限する
$currentPage = max(1, min($currentPage, $total_page));
$offset = ($currentPage - 1) * MAX;

// ログイン時のみカートテーブルから注文数を取得
if (isset($_SESSION['user_id'])) {
  // ユーザーの情報定義
  $user_id = $_SESSION['user_id'];

  // カートテーブルの注文数を取得 
  $cartQuery = "SELECT vegetableID, order_quantity FROM reservation WHERE customerID = :customerID";
  $cartStmt = $pdo->prepare($cartQuery);
  $cartStmt->bindValue(':customerID', $user_id, PDO::PARAM_INT);
  $cartStmt->execute();  // クエリを実行する
  $cartOrder = $cartStmt->fetchAll();
}

// 表示する画像のデータを取得する
$query = 
"SELECT * FROM vegetable 
WHERE types_name LIKE :searchKeyword 
  OR varieties_name LIKE :searchKeyword 
  OR types_name_kana LIKE :searchKeyword 
  OR varieties_name_kana LIKE :searchKeyword
LIMIT :offset, :max";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':searchKeyword', '%' . $searchKeyword . '%', PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':max', MAX, PDO::PARAM_INT);
$stmt->execute();
$vegetablesdata = $stmt->fetchAll();
