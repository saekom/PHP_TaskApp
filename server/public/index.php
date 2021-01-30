<?php

// 設定ファイルと関数ファイルを読み込む
require_once('config.php');
require_once('functions.php');

// DBに接続
$dbh = connectDb(); // 特にエラー表示がなければOK

$sql = 'select * from tasks';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>タスク管理</title>
</head>
<body>
	<h1>タスク管理アプリ</h1>

	<h2>未完了タスク</h2>
	<ul>
		<?php foreach($tasks as $task): ?>
		<?php if($task['status'] == 'notyet'): ?>
			<li>
				<?php echo h($task['title']); ?>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<hr>

	<h2>完了したタスク</h2>

</body>
</html>