<?php
// ログイン有無による遷移先の変数定義
if(isset($_SESSION['user_id'])){ // ログイン時
    // ログアウト実行ボタン定義
    $logset = './back_end/account_logout.php';
    $logAlert = 'onclick="return checkLogout()"';
    $logpng = 'eno_jagaimo.png';
    $logMessage = 'ログアウト';
    // カート画面への遷移ボタンの定義
    $cartJudge = 'cart.php';
    $cartJudgepng = 'eno_ninnzinn.png';
    $cartJudgeMessage = '現在のカート';
}else{  // ログアウト時
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
if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
    $user_name = $_SESSION['user_name'];     
}
?>
<header class="">
    <div class="top-display">
        <h1>YaoyaNow</h1>
        <p class="large">新鮮な野菜がスグに頼めて届く！</p>
    </div>
    <nav>
        <div class="menu pt-3">
            <a class="menu-width" href="./index.php">
                <img class="header-photo" src="./img/eno_kyabetu.png" alt="ホーム">
                <p class="">ホーム</p>
            </a>
            <a class="menu-width" href="./<?php echo $logset?>" <?php if(isset($logAlert)){echo $logAlert;}?>>
                <img class="header-photo" src="./img/<?php echo $logpng?>" alt="<?php echo $logMessage?>">
                <p class=""><?php echo $logMessage?></p>
            </a>
            <a class="menu-width" href="./<?php echo $cartJudge?>">
                <img class="header-photo" src="./img/<?php echo $cartJudgepng?>" alt="<?php echo $cartJudgeMessage?>">
                <p class=""><?php echo $cartJudgeMessage?></p>
            </a>
            <!-- ログイン時のみ購入履歴画面へ遷移するボタンを表示 -->
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="./history.php">
                    <img class="header-photo" src="./img/eno_burokkori-.png" alt="購入履歴">
                    <p>購入履歴</p>
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<?php if(isset($user_name)): ?>
    <p class="text-center mt-3">ユーザー名：<?php echo $user_name; ?>さん</p>
<?php else:?>
    <p class="text-danger text-center mt-3">ログインしていません</p>
<?php endif;?>

