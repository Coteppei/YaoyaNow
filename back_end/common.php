<?php
// データベース接続
$dsn = 'mysql:dbname=yaoyanow;host=localhost';
$user = 'root';
// 接続確認
try{
  $pdo = new PDO($dsn, $user);
}catch (PDOException $err){
  // 接続失敗の場合はそのまま切るようにする
  echo "データベース接続失敗:";
  exit();
}
return $pdo;
