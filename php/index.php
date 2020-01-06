<html>
<?php
	/**********************************/
	/*            DB諸情報            */
	/*コンテナから見えるホスト名を設定*/
	/*     ホスト名にはコンテナ名     */
	/**********************************/
	define('DB_DATABASE', 'keijiban_db');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'password');
	define('PDO_DSN', 'mysql:host=4d9c192b9cf2;dbname=' . DB_DATABASE);

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
				echo "これは何の条件分岐でしょうか";
			}
			$title_num = $que_res['id'];
			echo $title_num, "<br><br>";
			if ($que_res === end($arr)) {
				echo "これは何の条件分岐でしょうか";
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
	$sql2 = 'SELECT * from title_table';
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql2, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "<br>";
			}
			echo $que_res['title_id'], $que_res['title'],  $que_res['last_com'], $que_res['total_com'];
			echo "<br><br>";
			if ($que_res === end($arr)) {
				echo "<br>";
			}
		}

		
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
?>
</table>
</html>
