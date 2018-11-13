<?php
if(! isset($from_cart)){
    $result['error'] = '請從cart.php訪問';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

if($body===null){
    $result['error'] = '輸入的json格式錯誤';
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 需要兩個參數: sid(必要), all

if(empty($body['sid'])){
    if(empty($body['all'])){  //沒有sid也沒有all
        $result['error'] = '參數不足';
        $result['resultCode'] = 431;
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }else{ //沒有sid但是有all
        $_SESSION['cart'] = []; //清除所有項目
        $result['success'] = true;
        $result['resultCode'] = 201;
        $result['cart'] = [];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
}else{
    //有sid, 就不判斷all
    $sid = $body['sid'];
    //如果沒有該項目
    if(! isset($_SESSION['cart'][$sid])){ //沒有該產品在購物車中
        $result['error'] = '沒有該產品在購物車中';
        $result['resultCode'] = 432;
        $result['cart'] = $_SESSION['cart'];
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }else{  //購物車裡面有該產品，就做刪除動作
        unset($_SESSION['cart'][$sid]);
        $result['success'] = true;
        $result['resultCode'] = 200;
        $result['cart'] = $_SESSION['cart'];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}


