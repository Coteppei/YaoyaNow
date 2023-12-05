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
            <p class="total-price text-danger font-weight-bold">カートに商品がありません</p>
        <?php else:?>
            <p class = "total-price">小計：¥<?php echo $totalPrice?></p>
            <?php if($buyFlg): ?>
                <form action="./back_end/insert_history.php" method="POST" onsubmit="return checkPurchase()">
                    <button class="btn btn-primary ml-5" name="purchaseButton">購入を確定する</button>
                </form>
            <?php endif; ?>
        <?php endif;?>
    </div>

    <div id="top" class="wrapper">
        <ul class="product-list">
            <?php foreach ($cartsdata as $cartdata): ?>
                <li class="hover">
                    <a href="detail.php?content=<?php echo $cartdata['ID']; ?>">
                        <div class="stock-alert">
                            <?php if($cartdata['stock_quantity'] == 0): ?>
                                <p class="stock-message text-danger">
                                    在庫がありません。<br>
                                    カートから削除してください。
                                </p>
                                <div class="gray-out">
                            <?php elseif($cartdata['stock_quantity'] - $cartdata['order_quantity'] < 0): ?>
                                <p class="stock-message text-danger">
                                    残り<?php echo $cartdata['stock_quantity']; ?>点です。<br>
                                    注文数を減らしてください。
                                </p>
                                <div class="gray-out">
                            <?php elseif($cartdata['stock_quantity'] <= 9 && $cartdata['stock_quantity'] > 0): ?>
                                <p class="stock-message text-danger">残り<?php echo $cartdata['stock_quantity']; ?>点です。</p>
                                <div>
                            <?php else: ?>
                                <div>
                            <?php endif; ?>
                                <img src="./img/<?php if(isset($cartdata['img'])){echo $cartdata['img'] . '?v=' . $version;} ?>" alt="商品画像">
                            </div>
                        </div>
                            <p class="vagetable-name"><?php echo nl2br(htmlspecialchars($cartdata['varieties_name'], ENT_QUOTES, 'UTF-8')); ?></p>
                            <p>¥<?php echo htmlspecialchars($cartdata['price'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p>注文数：<?php echo htmlspecialchars($cartdata['order_quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <form method="POST" action="./back_end/delete_reservation.php" onsubmit="return checkDelete()">
                        <div class="count-button mb-3">
                            <button type="button" class="count-button-size" onclick="decreaseCount(<?php echo $cartdata['cartID']; ?>)">-</button>
                            <span id="buyCount_<?php echo $cartdata['cartID']; ?>" class="count-display-size mr-2 ml-2">1</span>
                            <button type="button" class="count-button-size" onclick="deleteIncreaseCount(<?php echo $cartdata['cartID']; ?>)">+</button>
                        </div>
                        <input type="hidden" name="cart_id" value="<?php echo $cartdata['cartID']; ?>">
                        <input type="hidden" name="buyCount" id="buyCountInput_<?php echo $cartdata['cartID']; ?>" value="1">
                        <input type="hidden" name="orderQuantity" id="orderQuantity_<?php echo $cartdata['cartID']; ?>" value="<?php echo $cartdata['order_quantity']; ?>">
                        <button class="btn btn-primary mb-3" name="deleteButton">カートから削除</button>
                    </form>
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