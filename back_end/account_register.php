<?php
require_once("common.php");
session_start();
// 空文字対策
$error_word = "^(\s|　)+$";

// 正常に入力データが届いていない場合、エラー画面に遷移
if (!isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['email']) || empty($_POST['email'])) {
  header('Location: ../error.php');
  exit;
}

// 登録ボタンを押すと作動
try {
  if (isset($_POST['registerButton'])) {
    if (mb_ereg_match($error_word, $_POST['username'])) {  // ユーザー名が半角、全角スペースのみでの入力があった場合、登録不可と判定。 
      $_SESSION['action_message'] = '空文字では登録できません。';
      header('Location: ../signUp.php');
      exit;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {  // 形式がメールアドレスでなかった場合、登録不可と判定。
      $_SESSION['action_message'] = 'メールアドレス形式で入力してください。';
      header('Location: ../signUp.php');
    } else {  // 正常な入力データの場合、各入力情報を定義する。
      $user_name = htmlspecialchars($_POST['username'],ENT_QUOTES, 'UTF-8');
      $email = htmlspecialchars($_POST['email'],ENT_QUOTES, 'UTF-8');
    }
    
    // ユーザー名とメールアドレスが両方とも既に登録されているか確認
    $check_stmt = $pdo->prepare("SELECT ID FROM customers WHERE user_name = ? AND email = ?");
    $check_stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $check_stmt->bindValue(2, $email, PDO::PARAM_STR);
    $check_stmt->execute();
    $existing_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
      // 既に同じユーザー名とメールアドレスの組み合わせが存在する場合の処理
      $_SESSION['action_message'] = 'このユーザーは既に登録されています。</br>別の情報を入力してください。';
      header('Location: ../signUp.php'); 
      exit;
    } else {
      // ユーザー名とメールアドレスが重複しない場合、入力情報をユーザー用テーブルにインサート
      $password = $_POST['password'];
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
      $_SESSION['action_message'] = 'アカウント登録しました。';
      header('Location: ../index.php');
      exit;
    }
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();  
}
