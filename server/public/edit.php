<?php

// 設定ファイルと関数ファイルを読み込む
require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

// DBに接続
$dbh = connectDb();

$sql = "select * from tasks where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// 結果の取得
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// タスクの編集
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 受け取ったデータ
	$title = $_POST['title'];

	// エラーチェック用の配列
	$errors = array();

	// バリデーション
	if ($title == $post['title']) {
		$errors['title'] = 'タスク名が変更されていません。';
	}

	// エラーが1つもなければレコードを更新
	if (empty($errors)) {
		// DBに接続
		$dbh = connectDb();
		$sql = "update tasks set title = :title, updated_at = now() where id = :id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		header('Location: index.php');
	    exit;
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>編集画面</title>
</head>
<body>
	<h2>タスクの編集</h2>
	<p>
		<form action="" method="POST">
			<input type="text" name="title" value="<?php echo h($post['title']); ?>">
			<input type="submit" value="編集">
			<span style="color:red;"><?php echo h($errors['title']); ?></span>
		</form>
	</p>
</body>
</html>