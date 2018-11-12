<?php
if(! isset($_SESSION['user'])){
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}
$result = [
    'success' => true,
    'resultCode' => 200,
    'errorMsg' => '',
    'data' => $_SESSION['user'],
];

echo json_encode($result, JSON_UNESCAPED_UNICODE);







