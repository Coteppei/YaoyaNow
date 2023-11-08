<?php
require_once("./back_end/header_controller.php");
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
<p class="action-message mb-2">
    <?php if(isset($action_message)){echo $action_message;} ?>
</p>
