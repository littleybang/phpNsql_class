<?php
if(! isset($from_cart)){
    $result['error'] = '請從cart.php訪問';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

$keys = array_keys($_SESSION['cart']);

//購物車裡面要有商品才
if(! empty($keys)){

    $sql = sprintf("SELECT * FROM products WHERE sid IN (%s)",
            implode(',', $keys)
        );
    //echo $sql;
    //exit;
    $stmt = $pdo->query($sql);

    $result = [
        'success' => true,
        'resultCode' => 200,
        'error' => '',
        'method' => $method,
        'cart' => $_SESSION['cart'],
        'cartProducts' => $stmt->fetchAll(PDO::FETCH_ASSOC),
    ];
}else{
    $result = [
        'success' => true,
        'resultCode' => 200,
        'error' => '',
        'method' => $method,
        'cart' => $_SESSION['cart'],
        'cartProducts' => [],
    ];
}


echo json_encode($result, JSON_UNESCAPED_UNICODE);











