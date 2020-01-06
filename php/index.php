<html>
<table>
	<tr>
		<th>id</th>
		<th>title</th>
		<th>pagenum</th>
	</tr>
<?php
	/**********************************/
	/*            DB諸情報            */
	/*コンテナから見えるホスト名を設定*/
	/*     ホスト名にはコンテナ名     */
	/**********************************/
	define('DB_DATABASE', 'test_db');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'password');
	define('PDO_DSN', 'mysql:host=b4da929b46b0;dbname=' . DB_DATABASE);
	$sql = 'SELECT * from master_table';

	try {
		$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$arr = $db->query($sql, PDO::FETCH_ASSOC);
		foreach($arr as $que_res) {
			if ($que_res === reset($arr)) {
				echo "<tr>";
			}
			echo "<td>", $que_res['id'], "</td><td>", $que_res['title'], "</td><td>", $que_res['pagenum'], "</td>";
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
