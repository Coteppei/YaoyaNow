<?php
require_once("common.php");
session_start();

// 登録ボタンを押すと作動
try {
  if (isset($_POST['registerButton'])) {
    // 入力情報の定義
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 入力情報をユーザー用テーブルにインサート
    $stmt = $pdo->prepare("INSERT INTO customers (user_name, password, email) VALUES (?, ?, ?)");
    $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $hashed_password, PDO::PARAM_STR);
    $stmt->bindValue(3, $email, PDO::PARAM_STR);
    $stmt->execute();

    // ユーザーID、名前情報を取得
    $userID = $pdo->lastInsertId();
    $user_info_stmt = $pdo->prepare("SELECT user_name FROM customers WHERE ID = ?");
    $user_info_stmt->bindValue(1, $userID, PDO::PARAM_INT);
    $user_info_stmt->execute();
    $customer = $user_info_stmt->fetch(PDO::FETCH_ASSOC);   
    $_SESSION['user_id'] = $userID;
    $_SESSION['user_name'] = $customer['user_name'];
    $_SESSION['login_message'] = 'ログインに成功しました';
    header('Location: ../index.php');
    exit;
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
