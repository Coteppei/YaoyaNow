<?php
require_once("common.php");
session_start();

// 正常に入力データが届いていない場合、エラー画面に遷移
if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])) {
  header('Location: ../error.php');
  exit;
}

// 登録ボタンを押すと作動
try {
  if (isset($_POST['registerButton'])) {
    // 入力情報の定義
    $user_name = $_POST['username'];
    $email = $_POST['email'];
    // ユーザー名とメールアドレスが両方とも既に登録されているか確認
    $check_stmt = $pdo->prepare("SELECT ID FROM customers WHERE user_name = ? AND email = ?");
    $check_stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $check_stmt->bindValue(2, $email, PDO::PARAM_STR);
    $check_stmt->execute();
    $existing_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        // 既に同じユーザー名とメールアドレスの組み合わせが存在する場合の処理
        $_SESSION['error_signUp'] = 'このユーザーは既に登録されています。</br>別の情報を入力してください。';
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
        $_SESSION['login_message'] = 'ログインに成功しました';
        header('Location: ../index.php');
        exit;
    }
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
}
