<?php
require __DIR__.'/__connect_db.php';

$result = [
    'success' => false,
    'resultCode' => 400,
    'errorMsg' => '註冊資料不足',
    'postData' => '',
];

if(
    !empty($_POST['email']) and
    !empty($_POST['password'])
){
    $result['postData'] = $_POST;

    // 要自己做資料的檢查

    $sql = "SELECT `id`, `email`, `mobile`, `address`, `birthday`,`nickname` 
        FROM `members` WHERE `email`=? AND `password`=?";

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['email'],
            sha1($_POST['password']),
        ]);
        if($stmt->rowCount()==1){
            // 記錄到 session
            $_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['success'] = true;
            $result['resultCode'] = 200;
            $result['errorMsg'] = '';

            // 丟回 client
            $result['user'] = $_SESSION['user'];
        } else{
            $result['resultCode'] = 404;
            $result['errorMsg'] = '帳號或密碼錯誤';
        }

    }catch (PDOException $ex){
    $result['resultCode'] = 402;
    $result['errorMsg'] = $ex->getMessage();
}

}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
