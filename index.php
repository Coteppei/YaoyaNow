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
        <!-- ページングの表示 -->
        <div class="all-pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?php echo $currentPage - 1; ?>" class="PC-display mr-4">≪前のページへ</a>
                <a href="?page=<?php echo $currentPage - 1; ?>" class="SP-display mr-4">≪前へ</a>
            <?php endif; ?>
            <div class="pagination">
                <?php for ($page = 1; $page <= $total_page; $page++): ?>
                    <?php if ($page == $currentPage): ?>
                        <p><?php echo $page; ?></p>
                    <?php else: ?>
                        <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php if ($currentPage < $total_page): ?>
                <a href="?page=<?php echo $currentPage + 1; ?>" class="PC-display ml-4">次のページへ≫</a>
                <a href="?page=<?php echo $currentPage + 1; ?>" class="SP-display ml-4">次へ≫</a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>
