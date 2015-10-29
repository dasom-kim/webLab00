<!DOCTYPE html>
<html>
	<head>
		<title>SQL</title>
	</head>

	<body>

	<?php
		
		
		$name = $_POST["Name"];
		$db = new PDO("mysql:dbname=$name;host=localhost", "root", "dasom1993");
		$query = $_POST["queries"];
		$query2 = $db->quote($query);
		$rows = $db->query($query);
		foreach ($rows as $row) {
			?>
			<li>
			<?php
			foreach ($row as $key => $value) {
			?>
				<?= $key ?>:<?= $value ?>
			<?php		
			}
			?>
			<li>
			<?php
		}
	?>
	
	</body>
</html>
