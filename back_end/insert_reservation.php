<?php
require_once("common.php");
session_start();

// カートに追加ボタンを押すと作動
try {
    if (isset($_POST['cartButton'])) {
        $customerID = $_SESSION['user_id'];
        if (isset($_POST['vegetable_id'])) {
            $vegetableID = $_POST['vegetable_id'];
        } elseif (isset($_SESSION['vegetablesdata'])) {
            $vegetableID = $_SESSION['vegetablesdata'];
        }
        $orderQuantity = 1;
        $stmt = $pdo->prepare("INSERT INTO reservation (customerID, vegetableID, order_quantity)VALUES (?, ?, ?)");
        $stmt->execute([$customerID, $vegetableID, $orderQuantity]);
        $_SESSION['cart_message'] = "商品をカートに入れました。";
        header('Location: ../index.php');
        exit;
    }
} catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
}
