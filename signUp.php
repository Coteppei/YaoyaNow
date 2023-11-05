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
        <form method="post" action="./back_end/account_register.php">
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