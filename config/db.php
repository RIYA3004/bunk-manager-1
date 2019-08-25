<?php
	$db_data = file_get_contents("db-config.json");
	$db_data = json_decode($db_data, true);

	$db = new mysqli($db_data['HOST'], $db_data['USERNAME'], $db_data['PASSWORD'], $db_data['DB_NAME']);
	if ($db->connect_errno !== 0) {
	  die ('We are down at the moment, please try again later');
	}
?>