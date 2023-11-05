<?php
require_once("common.php");
session_start();

// 正常に入力データが届いていない場合、エラー画面に遷移
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['loginButton'])){
  header('Location: ../error.php');
  exit;
}

// ログインボタンを押すと作動
try {
  if (isset($_POST['loginButton'])) {
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    $query = "SELECT ID, user_name, password FROM customers WHERE user_name = ? AND email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $email, PDO::PARAM_STR);
    $stmt->execute();
    $customer = $stmt->fetch();
    
    if ($customer && password_verify($password, $customer['password'])) {
      $_SESSION['user_id'] = $customer['ID'];
      $_SESSION['user_name'] = $customer['user_name'];
      $_SESSION['login_message'] = 'ログインに成功しました';
      header('Location: ../index.php');
      exit;
    } else {
      $_SESSION['error_message'] = 'ログインに失敗しました。';
      header('Location: ../login.php');
      exit;
    }
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}