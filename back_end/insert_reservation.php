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

        // 変数定義
        $stockQuantity = $_POST['stock_quantity'];  // 現時点での在庫数
        $buyCount = $_POST['buyCount'];             // 注文入力値

        // 注文数の入力値受け取り
        if ($stockQuantity > 9 && $buyCount >= 1 && $buyCount <= 9) {
            // 在庫が9個以上の時、1から9個までの注文が可能。
            $orderQuantity = $buyCount;
        } elseif ($buyCount <= $stockQuantity && $buyCount >= 1 && $buyCount <= 9) {
            // 在庫が1個以上9個未満の時、在庫数分注文が可能。
            $orderQuantity = $buyCount;
        } else {
            // それ以外の数字と文字列全種は許可しない。
            header('Location: ../error.php');
            exit;
        }

        // 既に登録されたデータの場合、注文個数を更新。
        $checkStmt = $pdo->prepare("SELECT * FROM reservation WHERE customerID = ? AND vegetableID = ?");
        $checkStmt->execute([$customerID, $vegetableID]);
        $existTable = $checkStmt->fetch(PDO::FETCH_ASSOC);

        // 注文個数とカートに追加した個数が在庫の数を超過していた場合、エラー表示にする。
        $errorConfirmation = $pdo->prepare("SELECT * FROM vegetable WHERE ID = ?");
        $errorConfirmation->execute([$vegetableID]);
        $errorConfirmationStmt = $errorConfirmation->fetch(PDO::FETCH_ASSOC);
        
        // 既に注文されている商品の数が在庫の数を超過している場合インサートされず、エラー画面に遷移(異常操作対応)。
        if ($existTable) {
            if($errorConfirmationStmt['stock_quantity']  < $_POST['buyCount'] + $existTable['order_quantity']) {
                header('Location: ../error.php');
                exit;
            }
        } elseif ($errorConfirmationStmt['stock_quantity'] < $_POST['buyCount']) {
            header('Location: ../error.php');
            exit;
        }
        
        if ($existTable) {
            // 既に注文した商品がカートに入れられた場合、購入数を更新する。
            $stmt = $pdo->prepare(
                "UPDATE reservation SET order_quantity = order_quantity + ?, updated_at = NOW() 
                WHERE customerID = ? AND vegetableID = ?");
            $stmt->execute([$orderQuantity, $customerID, $vegetableID]);
        } else {
            // 注文前だった場合、新しく野菜商品レコードを登録。
            $stmt = $pdo->prepare("INSERT INTO reservation (customerID, vegetableID, order_quantity) VALUES (?, ?, ?)");
            $stmt->execute([$customerID, $vegetableID, $orderQuantity]);
        }
        $_SESSION['action_message'] = "商品をカートに追加しました。";
        // リダイレクト先が元いる場所を指定。
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
}
