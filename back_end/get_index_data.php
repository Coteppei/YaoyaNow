<?php
require_once("common.php");
session_start();
// 野菜テーブルのセレクト
$query = "SELECT * FROM vegetable";
$stmt = $pdo->prepare($query);
$stmt->execute();
$vegetablesdata = $stmt->fetchAll();
