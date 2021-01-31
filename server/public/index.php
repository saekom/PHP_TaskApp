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

// 新規タスク追加
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// フォームに入力されたデータの受け取り
	$title = $_POST['title'];
	$content = $_POST['content'];

	// エラーチェック用の配列
	$errors = array();

	// バリデーション
	if ($title == '') {
		$errors['title'] = 'タイトルを入力してください';
	}

	if ($content == '') {
		$errors['content'] = '内容を入力してください';
	}

	if (empty($errors)) {
		$dbh = connectDb();
		$sql = "insert into tasks (title, content, created_at, updated_at) values (:title, :content, now(), now())";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':content', $content);
		$stmt->execute();

		// index.phpに戻る
		header('Location: index.php');
		exit;
	}
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>タスク管理</title>
</head>
<body>
	<h1>タスク管理アプリ</h1>

	<p>
		<form action="" method="POST">
			<p>
				<span>タイトル</span>
				<input type="text" name="title">
			</p>
			<p>
				<span>内容</span>
				<textarea name="content"></textarea>
			</p>
			<input type="submit" value="追加">
			<span style="color: red;"><?php echo h($errors['title']); ?> <?php echo h($errors['content']); ?></span>
		</form>
	</p>

	<h2>未完了タスク</h2>
	<ul>
		<?php $notyetCount = 0; ?>
		<?php foreach ($tasks as $task): ?>
		<?php if ($task['status'] == 'notyet'): ?>
			<?php $notyetCount++; ?>
			<li>
				<a href="done.php?id=<?php echo h($task['id']); ?>">[完了]</a>
				<a href="edit.php?id=<?php echo h($task['id']); ?>">[編集]</a>
				<a href="delete.php?id=<?php echo h($task['id']); ?>">[削除]</a>
				<b><?php echo h($task['title']); ?></b>: <?php echo h($task['content']); ?>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<p>未完了タスク数：<?php echo $notyetCount; ?></p>

	<hr>

	<h2>完了したタスク</h2>
	<ul>
		<?php $doneCount = 0; ?>
		<?php foreach ($tasks as $task): ?>
		<?php if ($task['status'] == 'done'): ?>
			<?php $doneCount++; ?>
			<li>
				<b><?php echo h($task['title']); ?></b>: <?php echo h($task['content']); ?>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<p>完了タスク数：<?php echo $doneCount; ?></p>

</body>
</html>