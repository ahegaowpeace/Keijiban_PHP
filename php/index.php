<html>
<table>
	<tr>
		<th>title_id</th>
		<th>title</th>
		<th>last_com</th>
		<th>total_com</th>
	</tr>
<?php
	/**********************************/
	/*            DB諸情報            */
	/*コンテナから見えるホスト名を設定*/
	/*     ホスト名にはコンテナ名     */
	/**********************************/
	define('DB_DATABASE', 'keijiban_db');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'password');
	define('PDO_DSN', 'mysql:host=0a5ba6c0bc58;dbname=' . DB_DATABASE);

	/**********************************/
	/*Title Table から表示用データ抽出*/
	/*   title, last_com, total_com   */
	/**********************************/
	$sql = 'SELECT * from title_table';
	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "<tr>";
			}
			echo "<td>", $que_res['title_id'], "</td><td>", $que_res['title'], "</td><td>", $que_res['last_com'], "</td><td>", $que_res['total_com'], "</td>";
			if ($que_res === end($arr)) {
				echo "</tr>";
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
