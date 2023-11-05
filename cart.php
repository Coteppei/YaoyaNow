<?php
session_start();
// 未ログイン時にアクセスがあった場合、強制的に商品一覧画面に遷移
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])){
    header('Location: ./index.php');
    exit;
}
require_once("./back_end/get_cart_data.php");
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

    <h1 class="mb-5 mt-5">カート一覧</h1>
    <div class="d-flex justify-content-center text-center">
        <?php if($totalPrice === 0):?>
            <p class="text-danger font-weight-bold">カートに商品がありません</p>
        <?php else:?>
            <p class = "total-price">小計：¥<?php echo $totalPrice?></p>
            <form action="./back_end/insert_history.php" method="post" onsubmit="return checkPurchase()">
                <button class="btn btn-primary ml-5" name="purchaseButton">購入を確定する</button>
            </form>
        <?php endif?>
    </div>
    <div id="top" class="wrapper">
        <ul class="product-list">
            <?php foreach ($cartsdata as $cartdata): ?>
                <li class="hover">
                    <a href="detail.php?content=<?php echo $cartdata['ID']; ?>">
                        <img src="./img/<?php if(isset($cartdata['img'])){echo $cartdata['img'] . '?v=' . $version;} ?>" alt="商品画像">
                        <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($cartdata['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                        <p>¥<?php echo htmlspecialchars($cartdata['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <form method="post" action="./back_end/delete_reservation.php" onsubmit="return checkDelete()">
                        <input type="hidden" name="cart_id" value="<?php echo $cartdata['cartID']; ?>">
                        <button class="btn btn-primary mb-3" name="deleteButton">カートから削除</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>