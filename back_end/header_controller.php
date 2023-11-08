<?php
// ログイン有無による遷移先の変数定義
if (isset($_SESSION['user_id'])) { // ログイン時
    // ログアウト実行ボタン定義
    $logset = './back_end/account_logout.php';
    $logAlert = 'onclick="return checkLogout()"';
    $logpng = 'eno_jagaimo.png';
    $logMessage = 'ログアウト';
    // カート画面への遷移ボタンの定義
    $cartJudge = 'cart.php';
    $cartJudgepng = 'eno_ninnzinn.png';
    $cartJudgeMessage = '現在のカート';
} else {  // ログアウト時
    // ログイン画面へ遷移ボタンの定義
    $logset = 'login.php';
    $logpng = 'eno_kabotya.png';
    $logMessage = 'ログイン';
    // 新規登録画面への遷移ボタンの定義
    $cartJudge = 'signUp.php';
    $cartJudgepng = 'eno_sayaenndou.png';
    $cartJudgeMessage = '新規登録';
}

// ユーザー名を常時表示
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];     
}

// 各操作確定時メッセージを表示
if(isset($_SESSION['action_message'])) {
  $action_message = $_SESSION['action_message'];
  unset($_SESSION['action_message']);
} 
