<?php
	date_default_timezone_set('Asia/Tokyo');
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
	define('PDO_DSN', 'mysql:host=435ce8cd4e5a;dbname=' . DB_DATABASE);
	$gip = '3.114.249.132';
	$title_id = $_SERVER['QUERY_STRING'];

	$first_sql = "SELECT title FROM title_table WHERE title_id='{$title_id}'";
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$title_name_arr = $db->query($first_sql, PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		foreach($title_name_arr as $que_res) {
			$title_name = $que_res['title'];
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}

	/*********************************************************/
	/*                    コメントエリア                     */
	/*                          (1)                          */
	/*            レンダリング前にINSERT処理を実施           */
	/*POSTが来たらPOSTクリアするためにheader()でGETリクエスト*/
	/*              header()はレンダリングの前               */
	/*********************************************************/
	if ( !empty($_POST['input_comment']) ) {
		$input_name = $_POST['input_name'];
		$input_comment = $_POST['input_comment'];
		$input_comment_time = date("Y-m-d H:i:s");
		
		//リロードの度にINSERTしないようにクエリ変数初期化
		//commentブロックのレンダリング前だから$input_commentがNULLの場合も弾く必要がある
		//リロード時のPOSTクリア
		if ( strcmp($input_comment, "コメント") == 0 ) {
			echo "あのねあのねコメントが空なの";
		} else if ( strcmp($input_comment, "") == 0 ) {
		//リロード時の初期値NULLなので何もしない
		} else {
			$sql = "INSERT INTO {$title_id} (user, comment, date_com) value ('{$input_name}', '{$input_comment}', '{$input_comment_time}')";
			$sql2 = "UPDATE title_table SET last_com='{$input_comment_time}' WHERE title_id='{$title_id}'";
			try {
				$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
				$arr = $db->query($sql, PDO::FETCH_ASSOC);
				$arr2 = $db->query($sql2, PDO::FETCH_ASSOC);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit;
			}
		}
		$redirect_url = "{$_SERVER['PHP_SELF']}".'?'."{$title_id}";
		header("Location: $redirect_url");
		exit;
	}

	/******************************************/
	/*              スレ作成エリア            */
	/*                    (1)                 */
	/*Insert title_table & Create CommentTable*/
	/******************************************/
	if ( !empty($_POST['make_sled_input_sleti']) ) {
		$input_sleti = $_POST['make_sled_input_sleti'];
		$sle_timestamp = date("Y_md_Hi");
		$dummy_first_comment_timestamp = date("Y-m-d H:i:s");

		if ( strcmp($input_sleti, "スレッド名") == 0 ) {
			echo "あのねあのねスレッド名が空なの";
		} else if ( strcmp($input_sleti, "") == 0 ) {
			//リロード時の初期値NULLなので何もしない
		} else {
			$sql3 = "CREATE TABLE $sle_timestamp (
					id		INT(4) AUTO_INCREMENT NOT NULL PRIMARY KEY,
					user		VARCHAR(100),
					comment		TEXT,
					date_com	DATETIME
				) DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
			$sql4 = "INSERT INTO title_table (title_id, title, last_com, total_com) value ('{$sle_timestamp}', '{$input_sleti}', '{$dummy_first_comment_timestamp}', 1)";
	
			try {
				$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
				$arr = $db->query($sql3, PDO::FETCH_ASSOC);
				$arr2 = $db->query($sql4, PDO::FETCH_ASSOC);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit;
			}
		}
	$redirect_url = "{$_SERVER['PHP_SELF']}".'?'."{$title_id}";
	header("Location: $redirect_url");
	exit;
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<?php
		echo "<title>{$title_name}</title>";
	?>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1 style="text-align:center;">掲示板 on Docker</h1>
<?php
	/**********************************/
	/*         スレタイエリア         */
	/**********************************/
	echo "<div style=\"border: 1px solid#3399FF;\" class=\"sleti_area\">";

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
	$sql = 'SELECT * FROM title_table ORDER BY id DESC';
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "これは何の条件分岐";
			}
			echo "<p class=\"slti\"><a href=\"http://", $gip, "/article.php", "?", $que_res['title_id'], "\" target=\"_blank\">【", $que_res['last_com'], "】 ", $que_res['title'], "</a></p>";
			if ($que_res === end($arr)) {
				echo "これは何の条件分岐";
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
        /*               (2)              */
        /* INSERT処理後にレンダリングする */
	/**********************************/
	echo "<div style=\"border: 1px solid #3399FF;\" class=\"comment_area\">";
	echo "<p style=\"margin-top:0; margin-bottom:20px; font-size:15px;\"><a href=\"#lastcom\">直近のコメへ移動</a></p>";

	$sql2 = 'SELECT * from '.$title_id;
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql2, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "これは何の条件分岐";
			}
			echo "<p class=\"comment_header\">", $que_res['id'], "：", $que_res['user'], "：", $que_res['date_com'], "</p>";
			echo "<p class=\"comment\">", $que_res['comment'];
			if ($que_res === end($arr)) {
				echo "これは何の条件分岐";
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
	echo "<input type=\"submit\" name=\"send\" value=\"書き込む\" class=\"input_com_button\" id=\"lastcom\" />";
        echo "</form>";
        echo "</div>";

	echo "</div>";

	/**********************************/
	/*         スレ作成エリア         */
	/*                (2)             */
	/*          レンダリング          */
	/**********************************/
	echo "<div style=\"border: 1px solid #3399FF;\" class=\"make_sled_area\">";
	echo "<div class=\"explain_block\">";
	echo "<h2 style=\"margin:0;\">ルール</h2>";
	echo "<ul class=\"explain_list\"><li>書き込めるのは現状テキストのみ</li><li>荒らしたら負け</li></ul>";
	echo "</div>";
	
	echo "<div class=\"make_sled_block\">";
	echo "<form method=\"post\" action=\"\">";
	echo "<input type=\"text\" name=\"make_sled_input_sleti\" value=\"スレッド名\" class=\"make_sled_input_sleti\" onfocus=\"if(this.value==this.defaultValue){this.value='';this.style.color='black';}\" onblur=\"if(this.value==''){this.value=this.defaultValue;this.style.color='#999999'}\"/><br>";
	echo "<input type=\"submit\" name=\"send_sle\" value=\"スレッドを立てる\" class=\"button_sle\" />";
	echo "</form>";
	echo "</div>";

	echo "</div>";

	echo "<div class=\"backtop\">";
	echo "<a href=\"#\">ページ上部へ移動</a>";
	echo "</div>";
?>
</body>
</html>
