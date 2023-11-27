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
                <li class="hover">
                    <a href="detail.php?content=<?php echo $vegetable['ID']; ?>">
                        <img src="./img/<?php if(isset($vegetable['img'])){echo $vegetable['img'] . '?v=' . $version;}?>" alt="商品画像">
                        <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($vegetable['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <p class="price-display">¥<?php echo htmlspecialchars($vegetable['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <?php if(isset($user_name)):?>
                        <form method="POST" action="./back_end/insert_reservation.php">
                            <div class="count-button mb-3">
                                <button type="button" class="count-button-size" onclick="decreaseCount(<?php echo $vegetable['ID']; ?>)">-</button>
                                <span id="buyCount_<?php echo $vegetable['ID']; ?>" class="count-display-size mr-2 ml-2">1</span>
                                <button type="button" class="count-button-size" onclick="increaseCount(<?php echo $vegetable['ID']; ?>)">+</button>
                            </div>
                            <input type="hidden" name="vegetable_id" value="<?php echo $vegetable['ID']; ?>">
                            <input type="hidden" name="buyCount" id="buyCountInput_<?php echo $vegetable['ID']; ?>" value="1">
                            <button class="btn btn-primary mb-3" name="cartButton">カートに追加</button>
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
