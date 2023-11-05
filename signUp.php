<?php
session_start();
if(isset($_SESSION['error_signUp'])){
    $error_signUp = $_SESSION['error_signUp'];
    unset($_SESSION['error_signUp']);
}
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    include('./front_end_common/layout.php');
    ?>

<body>
    <?php
    include('./front_end_common/header.php');
    ?>

<div class="text-center">
        <h1 class="mt-5">アカウント登録</h1>
        <p class="action-message mb-2">
            <?php if(isset($error_signUp)){echo $error_signUp;}?>
        </p>
        <form method="post" action="./back_end/account_register.php" onsubmit="return checkSignUp()">
            <div class="mt-5">
                <label for="username">ユーザー名:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="mt-4">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="mt-4" style="margin-right: 30px;">
                <label for="email">メールアドレス:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <input type="submit" class="btn btn-primary mt-4" name="registerButton" value="登録">
        </form>
        <div class="mt-4 mb-5">
            <a href="./login.php" class="loginlink mt-4">アカウント登録済みの方はこちら</a>
        </div>
</div>
    <?php
    include('./front_end_common/footer.php');
    ?>
</body>
</html>