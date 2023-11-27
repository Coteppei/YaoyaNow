<?php
require_once("./back_end/get_datail_data.php");
session_start();
$_SESSION['vegetablesdata'] = $vegetablesdata[0]['ID'];
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

    <main>
        <div class="mt-4">
            <h1 class="mb-5">詳細情報</h1>
            <div class="detail-set mt-5">
                <div class="PC-detail-img">
                    <img class="detail-img" src="./img/<?php if(isset($vegetablesdata[0]['img'])){echo $vegetablesdata[0]['img'] . '?v=' . $version;}?>" alt="商品画像">
                </div>
                <div class="detail-text SP-detail-text">
                    <h2>
                        <?php echo htmlspecialchars($vegetablesdata[0]['varieties_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </h2>
                    <p>
                        品種：<span><?php echo htmlspecialchars($vegetablesdata[0]['types_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </p>
                    <p>
                        値段：￥<span><?php echo htmlspecialchars($vegetablesdata[0]['price'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </p>
                    <p>
                        在庫数：<span><?php echo htmlspecialchars($vegetablesdata[0]['stock_quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </p>
                    <?php if(isset($user_name)):?>
                        <form method="post" action="./back_end/insert_reservation.php">
                            <div class="detail-count-button">
                                <button type="button" class="count-button-size" onclick="decreaseCount(<?php echo $vegetablesdata['0']['ID']; ?>)">-</button>
                                <span id="buyCount_<?php echo $vegetablesdata['0']['ID']; ?>" class="count-display-size mr-2 ml-2">1</span>
                                <button type="button" class="count-button-size" onclick="increaseCount(<?php echo $vegetablesdata['0']['ID']; ?>)">+</button>
                            </div>
                            <input type="hidden" name="vegetable_id" value="<?php echo $vegetablesdata['0']['ID']; ?>">
                            <input type="hidden" name="buyCount" id="buyCountInput_<?php echo $vegetablesdata['0']['ID']; ?>" value="1">
                            <button class="btn btn-primary ml-2" name="cartButton">カートに追加</button>
                        </form>
                    <?php endif;?>
                    <h2 class="mt-5">商品の説明</h2>
                    <p><?php echo nl2br(htmlspecialchars($vegetablesdata[0]['details'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            </div>
        </div>                           
    </main>
    <?php
    include('./front_end_common/footer.php');
    ?>    
</body>
</html>