<html>
<head>
	<meta charset="utf-8">
	<?php
		echo "<title>トップページ</title>"
	?>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
	/**********************************/
	/*         スレタイエリア         */
	/**********************************/
	echo "<div style=\"border: 1px solid#3399FF;\" class=\"sleti_area\">";

	/**********************************/
	/*            DB諸情報            */
	/*コンテナから見えるホスト名を設定*/
	/*   ホスト名にはmysqlコンテナid  */
	/*         GlobalIPを記入         */
	/* $_SERVER['QUERY_STRING']はparm */
	/**********************************/
	define('DB_DATABASE', 'keijiban_db');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'password');
	define('PDO_DSN', 'mysql:host=b31f1094270f;dbname=' . DB_DATABASE);
	$gip = '3.114.249.132';

	/**************************************/
	/*  Title Table から表示用データ抽出  */
	/*(1) スレタイ総数を取得し繰り返し表示*/
	/*(2) タイトル, 最終更新日, コメント数*/
	/**************************************/

	/**************************************/
	/*                 (1)                */
	/*           タイトル数取得           */
	/*最終行のidを取得するためにはこれしか*/
	/*        なかったんです......        */
	/*              $title_num            */
	/**************************************/
	$sql = 'SELECT id FROM title_table ORDER BY id desc limit 1';

	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "これは何の条件分岐";
			}
			$title_num = $que_res['id'];
			if ($que_res === end($arr)) {
				echo "これは何の条件分岐";
			}
		}
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	/**************************************/
	/*                 (2)                */
	/*      title_tableからデータ抽出     */
	/**************************************/
	$sql = 'SELECT * from title_table';
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "";
			}
			echo "<p class=\"slti\"><a href=\"http://", $gip, "?", $que_res['title_id'], "\" target=\"_blank\">【", $que_res['last_com'], "】 ", $que_res['title'], "</a></p>";
			if ($que_res === end($arr)) {
				echo "";
			}
		}
		
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	echo "</div>";

	/**********************************/
	/*         コメントエリア         */
	/**********************************/
	echo "<div style=\"border: 1px solid #3399FF;\" class=\"comment_area\">";
	echo "<p style=\"margin-top:0; margin-bottom:20px;\">直近のコメへ移動</p>";

	/**************************************/
	/*                 (3)                */
	/*   title_idテーブルからデータ抽出   */
	/**************************************/
	$sql2 = 'SELECT * from '.$_SERVER['QUERY_STRING'];
	echo $sql2;
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql2, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "";
			}
			echo "<p class=\"comment_header\">", $que_res['id'], "：", $que_res['user'], "：", $que_res['date_com'], "</p>";
			echo "<p class=\"comment\">", $que_res['comment'];
			if ($que_res === end($arr)) {
				echo "";
			}
		}
		
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
	echo "</div>";

	/**********************************/
	/*         スレ作成エリア         */
	/**********************************/
	echo "<div style=\"border: 1px solid #3399FF;\" class=\"make_sled_area\">";
	echo "概要";
	echo "</div>";
?>
</body>
</html>
