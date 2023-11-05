<?php
require_once("common.php");

// クリックした商品情報を定義
$ID = $_GET["content"];

// 詳細情報が表示されるようセレクト
$query = "SELECT * FROM vegetable WHERE ID = $ID";  
$stmt = $pdo->prepare($query);
$stmt->execute();
$vegetablesdata = $stmt->fetchAll();
