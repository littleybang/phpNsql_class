<?php
require __DIR__.'/__connect_db.php';

//HTTP header
//設定MIME (https://developer.mozilla.org/zh-CN/docs/Web/HTTP/Basics_of_HTTP/MIME_types)
//header('Content-Type: application/json' );

$result = [
    'success' => false,
    'resultCode' => 400,
    'errorMsg' => '用戶沒有登入',
];

//有登入才可結帳
if(! isset($_SESSION['user'])){
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 購物車內要有商品才可以結帳
if(empty($_SESSION['cart'])){
    $result['errorMsg'] = '購物車是空的';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 限定 post 呼叫
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    $result['errorMsg'] = '請使用 post';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

$keys = array_keys($_SESSION['cart']);

$p_sql = sprintf("SELECT * FROM products WHERE sid IN (%s)",
    implode(',', $keys)
);
$p_stmt = $pdo->query($p_sql);
//**作法一
//$products = $p_stmt->fetchAll(PDO::FETCH_ASSOC);
//
//$total_price = 0; //總價
//foreach($products as $p){
//    $total_price += $p['price'] * $_SESSION['cart'][$p['sid']];
//}

//**作法二
$total_price = 0; //總價
$products = [];
while($r = $p_stmt->fetch(PDO::FETCH_ASSOC)){
    $r['qty'] = $_SESSION['cart'][$r['sid']];
    $products[$r['sid']] = $r;
    $total_price += $r['price'] * $r['qty'];
}

// 寫入訂單 (資料表: orders)
$o_sql = "INSERT INTO `orders`(
    `member_sid`, `amount`, `order_date`
    ) VALUES (?, ?, NOW())";
$o_stmt = $pdo->prepare($o_sql);
$o_stmt->execute([
    $_SESSION['user']['id'],
    $total_price,
]);

$o_sid = $pdo->lastInsertId(); //立刻取得訂單編號

//寫入訂單(資料表: order_details)
$d_sql = "INSERT INTO `order_details`(
        `order_sid`, `product_sid`, `price`, `quantity`
        ) VALUES (?, ?, ?, ?)";
$d_stmt = $pdo->prepare($d_sql);

foreach($keys as $sid){
    $d_stmt->execute([
        $o_sid,
        $sid,
        $products[$sid]['price'],
        $products[$sid]['qty'],
    ]);
}

$result = [
    'success' => true,
    'resultCode' => 200,
    'errorMsg' => '',
];
unset($_SESSION['cart']);  //清空購物車
echo json_encode($result, JSON_UNESCAPED_UNICODE);

