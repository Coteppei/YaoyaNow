<?php
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
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>