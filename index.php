<?php
require_once("./back_end/get_index_data.php");
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

    <h1 class="mt-5">商品一覧</h1>
    <form method="GET">
        <div class="search mt-4">
            <input type="text" name="search" id="search" class="mr-3" placeholder="商品名、品種で検索">
            <button type="submit" class="search-button pr-2 pl-2">検索</button>
        </div>
    </form>
    <?php if(isset($_GET['search'])):?>
        <p class="search-word mt-3">検索ワード：<?php echo $_GET['search'];?></p>
    <?php endif?>
    <?php if($total == 0):?>
        <p class="action-message mt-5">検索がヒットしませんでした。</p>
    <?php endif?>
    <div id="top" class="wrapper">
        <ul class="product-list">
            <?php foreach ($vegetablesdata as $vegetable): ?>
                <?php 
                // 野菜テーブルの主IDとカートテーブルの野菜IDが一致すると在庫数を取得。
                if(isset($_SESSION['user_id'])) {
                    $vegetableIDInCart = false;
                    foreach ($cartOrder as $order) {
                        if ($order['vegetableID'] == $vegetable['ID']) {
                            $vegetableIDInCart = true;
                            break;
                        }
                    }
                } 
                ?>
                <li class="hover">
                    <a href="detail.php?content=<?php echo $vegetable['ID']; ?>" class="link-color">
                        <div class="stock-alert">
                            <?php if($vegetable['stock_quantity'] <= 9 && $vegetable['stock_quantity'] > 0):?>
                                <p class="stock-message text-danger">残り<?php echo $vegetable['stock_quantity'] ?>点です。</p>
                            <?php elseif($vegetable['stock_quantity'] == 0):?>
                                <p class="stock-out-message text-danger">SOLD OUT</p>
                            <?php endif?>
                            <div class="<?php if($vegetable['stock_quantity'] == 0){echo 'gray-out';} ?>">
                                <img src="./img/<?php if(isset($vegetable['img'])){echo $vegetable['img'] . '?v=' . $version;}?>"  alt="商品画像">
                            </div>
                        </div>
                        <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($vegetable['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <p class="price-display">¥<?php echo htmlspecialchars($vegetable['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <?php if(isset($user_name)):?>
                        <form method="POST" action="./back_end/insert_reservation.php">
                            <div class="count-button mb-3">
                                <button type="button" class="count-button-size" onclick="decreaseCount(<?php echo $vegetable['ID']; ?>)">-</button>
                                <span id="buyCount_<?php echo $vegetable['ID']; ?>" class="count-display-size mr-2 ml-2">1</span>
                                <?php if($vegetableIDInCart): ?>                                   
                                    <button type="button" class="count-button-size" onclick="increaseCount(<?php echo $vegetable['ID']; ?>, <?php echo (int)$vegetable['stock_quantity'] - (int)$order['order_quantity']; ?>)">+</button>
                                <?php else: ?>
                                    <button type="button" class="count-button-size" onclick="increaseCount(<?php echo $vegetable['ID']; ?>, <?php echo $vegetable['stock_quantity']; ?>)">+</button>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="vegetable_id" value="<?php echo $vegetable['ID']; ?>">
                            <input type="hidden" name="buyCount" id="buyCountInput_<?php echo $vegetable['ID']; ?>" value="1">
                            <input type="hidden" id="stock_quantity" name="stock_quantity" value="<?php echo $vegetable["stock_quantity"]; ?>">
                            <?php if($vegetable["stock_quantity"] <= 0): ?>
                                <button class="btn mb-3" name="cartButton" disabled>入荷待ちです</button>
                            <?php elseif($vegetableIDInCart && $vegetable["stock_quantity"] - $order['order_quantity'] <= 0): ?>
                                <button class="btn mb-3" name="cartButton" disabled>入荷待ちです</button>
                            <?php else: ?>
                                <button class="btn btn-primary mb-3" name="cartButton">カートに追加</button>
                            <?php endif;?>
                        </form>
                    <?php endif;?>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- ページングの表示 -->
        <?php
        include('./front_end_common/pagenation.php');
        ?> 
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>
