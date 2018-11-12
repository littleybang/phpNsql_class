<?php
require __DIR__.'/__connect_db.php';

$result = [
    'success' => false,
    'resultCode' => 400,
    'errorMsg' => '用戶沒有登入',
];

$from_me = true; // 給被 included 的 php 檔使用

if(! isset($_SESSION['user'])){
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // 讀取個人資料
        require __DIR__. '/me_read.php';
        exit;
    case 'PUT':
        // 修改個人資料
        require __DIR__. '/me_edit.php';
        exit;
    default:
        $result['resultCode'] = 401;
        $result['errorMsg'] = '錯誤的 HTTP method';
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);





