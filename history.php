<?php
session_start();
// 未ログイン時にアクセスがあった場合、強制的に商品一覧画面に遷移
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])){
    header('Location: ./index.php');
    exit;
}
require_once("./back_end/get_history_data.php");
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

    <h1 class="mb-5 mt-5">購入履歴一覧</h1>
    <div class="d-flex justify-content-center text-center">
        <?php 
        if($totalPrice === 0){
            echo "<p class=\"text-danger font-weight-bold\">購入履歴がありません</p>";
        }else{
            echo "<p class = \"total-price\">小計：¥$totalPrice</p>";
        }
        ?>
    </div>

    <div id="top" class="wrapper">
        <ul class="product-list">
            <?php foreach ($cartsdata as $cartdata):?>
                <li class="hover">
                    <a href="detail.php?content=<?php echo $cartdata['ID']; ?>">
                        <img src="./img/<?php if(isset($cartdata['img'])){echo $cartdata['img'] . '?v=' . $version;} ?>" alt="商品画像">
                        <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($cartdata['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <p>¥<?php echo htmlspecialchars($cartdata['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="history-date text-secondary">購入日：<?php echo htmlspecialchars($cartdata['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- ページリンクの表示 -->
        <?php
        include('./front_end_common/pagenation.php');
        ?> 
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>