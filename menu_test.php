<?php
require __DIR__.'/__connect_db.php';

$sql = "SELECT * FROM `categories`";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$m_data = [];
foreach ($data as $v){
    //如果是第一層選單，就放到
    if ($v['parent_sid']==0){
        $m_data[$v['sid']] = $v;
    }
}
foreach ($data as $v) {
    //如果是第二層選單
    if (isset($m_data[$v['parent_sid']])) {
        $m_data[$v['parent_sid']]['children'][] = $v;
    }
}

//用資料庫分類
//print_r($m_data);

//用ajax做
$result = [
    'success'=>true,
    'data'=>$m_data,
];
echo json_encode($result, JSON_UNESCAPED_UNICODE);

