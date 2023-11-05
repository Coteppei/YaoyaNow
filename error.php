<?php
session_start();
// 強制ログアウト
session_unset();
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
    <h1 class="text-danger mt-5 mb-5">
    不正な操作もしくは動作を検知しました。<br>
    恐れ入りますが、再度上記メニューから遷移してください。
    </h1>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>