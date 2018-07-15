<?php include '../resources/includes/init.php'; ?>
<html>
	<?php include INCLUDES . '/head.php'; ?>
	<body>
<?php 
    include INCLUDES . '/nav.php';

// Client Credentials Flow (as opposed to Authorization Flow (no user access))

$session = new SpotifyWebAPI\Session(
    'e39ee00e0ac54018aebaf433c8157e8c',
    'e2c39bef60d24762acec712fd2e596da'
    );

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// Store the access token somewhere. In a database for example.

// Fetch your access token from somewhere. A database for example.

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

print_r($_GET);



if (isset($_GET['artist_name'])) {
    $artist = search_artist($_GET['artist_name']);
    if (isset($artist)) {
        output($artist);
        $stmt = $db->prepare('SELECT `spotify_id` FROM `artist` WHERE `spotify_id` = ? LIMIT 1');
        $stmt->bind_param('s', $artist->id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (empty($result->fetch_assoc())) { // Artist does not exist in our database
            if ($stmt = $db->prepare('INSERT INTO `artist` (spotify_id, name) VALUES (?, ?)')) {
                $stmt->bind_param('ss', $artist->id, $artist->name);
                if ($stmt->execute()) {
                    echo 'Successfully loaded artist.';
                } else {
                    echo 'Error - could not load artist';
                }
            } else {
                echo $db->error;
            }
        }
        ?>
        <div class="artist">
        		<?php 
        		
        		echo "<p><b>{$artist->name}</b></p><p>{$artist->followers->total} followers</p>";

            ?>
        		<img height="160" width="160" alt="<?php echo $artist->name; ?>" src="<?php echo $artist->images[0]->url; ?>">
        </div>
        <?php
        
    }
    
} else {
    ?>
    <form name = "search_artist" action="index.php" method="GET">
		Artist Name: <input type="text" name="artist_name">
	</form>
	<?php
}

$stmt = $db->prepare('SELECT * FROM `artist`');
$stmt->execute();
$result = $stmt->get_result();

while ($artist = $result->fetch_assoc()) {
    echo "<p>{$artist['name']}, {$artist['id']}, {$artist['spotify_id']}";
}


?>
	
    </body>
</html>