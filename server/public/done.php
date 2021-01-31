<?php

// 設定ファイルと関数ファイルを読み込む
require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

// DBに接続
$dbh = connectDb();

$sql = "update tasks set status = 'done' where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// index.phpに戻る
header('Location: index.php');
exit;
?>