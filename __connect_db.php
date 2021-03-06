<?php
$db_host = 'localhost';
$db_name = 'ec_example';
$db_user = 'root';
$db_pass = '';

$dsn = sprintf('mysql:dbname=%s;host=%s', $db_name, $db_host);

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);

    // 連線使用的編碼設定
    $pdo->query("SET NAMES utf8");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
    echo 'Connection failed:'. $ex->getMessage();
}

// 因為要登入所以要用到session，基本上會用到資料庫的都會用到
if(!isset($_SESSION)){
    session_start();
};

