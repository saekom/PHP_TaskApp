<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

// DBに接続
$dbh = connectDb();

$sql = "delete from tasks where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// index.phpに戻る
header('Location: index.php');
exit;

?>