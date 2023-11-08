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
    <div id="top" class="wrapper">
        <ul class="product-list">
            <?php foreach ($vegetablesdata as $vegetable): ?>
                <li class="hover">
                    <a href="detail.php?content=<?php echo $vegetable['ID']; ?>">
                        <img src="./img/<?php if(isset($vegetable['img'])){echo $vegetable['img'] . '?v=' . $version;}?>" alt="商品画像">
                        <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($vegetable['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <p>¥<?php echo htmlspecialchars($vegetable['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <?php if(isset($user_name)):?>
                        <form method="post" action="./back_end/insert_reservation.php">
                            <input type="hidden" name="vegetable_id" value="<?php echo $vegetable['ID']; ?>">
                            <button class="btn btn-primary mb-3" name="cartButton">カートに追加</button>
                        </form>
                    <?php endif;?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>
