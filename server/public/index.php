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

	// エラーチェック用の配列
	$errors = array();

	// バリデーション
	if ($title == '') {
		$errors['title'] = 'タスク名を入力してください';
	}

	if (empty($errors)) {
		$dbh = connectDb();
		$sql = "insert into tasks (title, created_at,   updated_at) values (:title, now(), now())";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':title', $title);
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
			<input type="text" name="title">
			<input type="submit" value="追加">
			<span style="color: red;"><?php echo h($errors['title']); ?></span>
		</form>
	</p>

	<h2>未完了タスク</h2>
	<ul>
		<?php foreach ($tasks as $task): ?>
		<?php if ($task['status'] == 'notyet'): ?>
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