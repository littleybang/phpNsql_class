<?php
require __DIR__.'/__connect_db.php';

//HTTP header
//設定MIME (https://developer.mozilla.org/zh-CN/docs/Web/HTTP/Basics_of_HTTP/MIME_types)
header('Content-Type: application/json' );

if(! isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

//判斷http的方法
$method = $_SERVER['REQUEST_METHOD'];

$result = [
    'success' => false,
    'resultCode' => 400,
    'error' => '',
    'method' => $method,
    'cart' => null,
];

$from_cart = true; //用來判斷是不是從這個檔案進來的

//取得http body 資料並解析成原生php陣列
$body = file_get_contents('php://input');
$body = json_decode($body, true);

//依據不同的方法做Require
switch ($method){
    case 'GET':
        require __DIR__.'/cart_get.php';
        exit;
    case 'POST':
        require __DIR__.'/cart_post.php';
        exit;
    case 'PUT':
        require __DIR__.'/cart_put.php';
        exit;
    case 'DELETE':
        require __DIR__.'/cart_delete.php';
        exit;
}