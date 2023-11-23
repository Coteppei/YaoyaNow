<?php
require_once("common.php");
session_start();

// カートに追加ボタン以外から来た場合はエラー画面に遷移
if (!isset($_POST['cartButton'])) {
    header('Location: ../error.php');
    exit;
}

try {
    if (isset($_POST['cartButton'])) {
        $customerID = $_SESSION['user_id'];
        if (isset($_POST['vegetable_id'])) {
            $vegetableID = $_POST['vegetable_id'];
        } elseif (isset($_SESSION['vegetablesdata'])) {
            $vegetableID = $_SESSION['vegetablesdata'];
        }
        $orderQuantity = 1;

        // 既に登録されたデータの場合、注文個数を更新。
        $checkStmt = $pdo->prepare("SELECT * FROM reservation WHERE customerID = ? AND vegetableID = ?");
        $checkStmt->execute([$customerID, $vegetableID]);
        $existTable = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existTable) {
            // 既に購入した商品がカートに入れられた場合、購入数を更新する。
            $stmt = $pdo->prepare(
                "UPDATE reservation SET order_quantity = order_quantity + ?, updated_at = NOW() 
                WHERE customerID = ? AND vegetableID = ?");
            $stmt->execute([$orderQuantity, $customerID, $vegetableID]);
        } else {
            // 未購入だった場合、新しく野菜商品レコードを登録。
            $stmt = $pdo->prepare("INSERT INTO reservation (customerID, vegetableID, order_quantity) VALUES (?, ?, ?)");
            $stmt->execute([$customerID, $vegetableID, $orderQuantity]);
        }
        $_SESSION['action_message'] = "商品をカートに追加しました。";
        header('Location: ../index.php');
        exit;
    }
} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
}
