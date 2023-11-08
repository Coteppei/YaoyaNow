<?php
session_start();
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
        <h1 class="mt-5">ログイン</h1>
        <form method="post" action="./back_end/account_login.php">
            <div class="mt-5">
                <label for="username">ユーザー名:</label>
                <input type="text" name="username" required>
            </div>
            <div class="mt-4">
                <label for="password">パスワード:</label>
                <input type="password" name="password" required>
            </div>
            <div class="mt-4" style="margin-right: 30px;">
                <label for="email">メールアドレス:</label>
                <input type="email" name="email" required>
            </div>
            <input type="submit" class="btn btn-primary mt-4" name="loginButton" value="ログイン">
        </form>
        <div class="mt-4 mb-5">
            <a href="./signUp.php" class="loginlink mt-4">アカウント新規登録はこちら</a>
        </div>
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>
</body>
</html>