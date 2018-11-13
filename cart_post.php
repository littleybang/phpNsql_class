<?php
if(! isset($from_cart)){
    $result['error'] = '請從cart.php訪問';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 需要兩個參數: sid(必要), qty(如果沒有就是預設的1)

if(empty($body['sid'])){
    $result['error'] = '沒有產品sid';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$sid = $body['sid'];
$qty = empty($body['qty']) ? 1 : intval($body['qty']);

//資料庫裡有沒有這個產品，而且產品必須是要上架的狀態
$sql = "SELECT * FROM `products` WHERE `sid`=? AND `on_sale`=1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$sid]);

if($stmt->rowCount()!=1){
    $result['error'] = '沒有這個產品';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
//加入購物車
$_SESSION['cart'][$sid] = $qty;

$result['success'] = true;
$result['resultCode'] = 200;
$result['cart'] = $_SESSION['cart'];



echo json_encode($result, JSON_UNESCAPED_UNICODE);

