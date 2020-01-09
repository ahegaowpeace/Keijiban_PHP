<html>
<head>
	<meta charset="utf-8">
	<?php
		echo "<title>記事ページ</title>"
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
	$title_id = $_SERVER['QUERY_STRING'];

	/**************************************/
	/*                 (1)                */
        /*  Title Table からスレタイ総数抽出  */
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
        /*  title_tableから更新日時など抽出   */
	/**************************************/
	$sql = 'SELECT * from title_table';
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "";
			}
			echo "<p class=\"slti\"><a href=\"http://", $gip, "/article.php", "?", $que_res['title_id'], "\" target=\"_blank\">【", $que_res['last_com'], "】 ", $que_res['title'], "</a></p>";
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

	/**********************************/
        /*               (1)              */
        /*レンダリング前にINSERT処理を実施*/
        /**********************************/
	$input_name = $_POST['input_name'];
	$input_comment = $_POST['input_comment'];
	$sql = '';

	//リロードの度にINSERTしないようにクエリ変数初期化
	//commentブロックのレンダリング前だから$input_commentがNULLの場合も弾く必要がある

	if ( strcmp($input_comment, "コメント") == 0 || strcmp($input_comment, "") == 0 ) {
		echo "あのねあのねコメントが空なの";
	} else {
		$sql = "INSERT INTO {$title_id} (user, comment, date_com) value ('{$input_name}', '{$input_comment}', '2019-09-23 13:57')";
		try {
			$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
			$arr = $db->query($sql, PDO::FETCH_ASSOC);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}

        /**********************************/
        /*               (2)              */
        /* INSERT処理後にレンダリングする */
	/**********************************/
	echo "<div style=\"border: 1px solid #3399FF;\" class=\"comment_area\">";
	echo "<p style=\"margin-top:0; margin-bottom:20px; font-size:15px;\">直近のコメへ移動</p>";

	$sql2 = 'SELECT * from '.$title_id;
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

        echo "<div class=\"input_com_block\">";
        echo "<form method=\"post\" action=\"\" enctype=\"multipart/form-data\">";
        echo "<input type=\"text\" name=\"input_name\" value=\"名前\" class=\"input_name\" onfocus=\"if(this.value==this.defaultValue){this.value='';this.style.color='black';}\" onblur=\"if(this.value==''){this.value=this.defaultValue;this.style.color='#999999'}\"/><br>";
        echo "<input type=\"file\" name=\"input_fname\"><br>";
        echo "<textarea name=\"input_comment\" class=\"input_comment\" onfocus=\"if(this.value==this.defaultValue){this.value='';this.style.color='black';}\" onblur=\"if(this.value==''){this.value=this.defaultValue;this.style.color='#999999'}\" >コメント</textarea><br>";
	echo "<input type=\"submit\" name=\"send\" value=\"書き込む\" class=\"input_com_button\" />";
        echo "</form>";
        echo "</div>";

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
