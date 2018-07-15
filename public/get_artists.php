<?php

include '../resources/includes/init.php'; 



if (isset($_GET['artist_name'])) {
	$search_term = '%' . $_GET['artist_name'] . '%';
	echo "Search term: {$search_term}";
	$stmt = $db->prepare("SELECT `name` FROM `artist` WHERE `name` LIKE ?");
	$stmt->bind_param('s', $search_term);
	$stmt->execute();
	$result = $stmt->get_result();
	$matches = array();
	while ($artist = $result->fetch_assoc()) {
		$matches[] = $artist['name'];
	}
	echo json_encode($matches);
}

?>