<?php
require_once("common.php");
session_start();

// 1ページに表示する画像の数を定義
define('MAX', 8);

// 野菜テーブルの画像の総数をカウント
$queryTotal = "SELECT COUNT(*) AS total FROM vegetable";
$stmtTotal = $pdo->prepare($queryTotal);
$stmtTotal->execute();
$total = $stmtTotal->fetchColumn();

// 総ページ数を算出
$total_page = ceil($total / MAX);

// 現在ページ情報の取得
if (isset($_GET['page'])) {
  // ページが指定されているとき
  $currentPage = $_GET['page'];
} else {  
  // ページが指定されていない場合は1ページ目を表示 
  $currentPage = 1;
}

// 現在のページ番号を取得する
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// ページ数が1未満の場合は1に、ページ数が総ページ数を超える場合は総ページ数に制限する
$page = max(1, min($page, $total_page));

// 表示する画像のデータを取得する
$offset = ($page - 1) * MAX;
$queryImages = "SELECT * FROM vegetable LIMIT :offset, :max";
$stmtImages = $pdo->prepare($queryImages);
$stmtImages->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmtImages->bindValue(':max', MAX, PDO::PARAM_INT);
$stmtImages->execute();
$vegetablesdata = $stmtImages->fetchAll();
