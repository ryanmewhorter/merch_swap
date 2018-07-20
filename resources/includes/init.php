<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('file_uploads', 'on');
error_reporting(E_ALL);

define('SITE_NAME',     'Merch Swap');
define('PROJECT_DIR',   'E:/wamp/www/merch_swap');
define('PUBLIC',        PROJECT_DIR . '/public');
define('RESOURCES',     PROJECT_DIR . '/resources');
define('IMG',           RESOURCES . '/img');
define('INCLUDES',      RESOURCES . '/includes');

$db = new mysqli('localhost', 'ryan', 'pineapple97', 'merch_swap');

require_once PROJECT_DIR . '/vendor/autoload.php';

function search_artist($artist_name) {
    global $api;
    $results = $api->search($artist_name, 'artist', ['limit' => 1])->artists->items;
    if (empty($results)) {
        return null;
    } else {
        return $results[0];
    }
}

function output($variable) {
    echo '<pre>'; print_r($variable); echo '</pre>';
}

// W3Schools
// Check if image file is a actual image or fake image
function verify_image($file) {
    return (getimagesize($file) !== false);
}

// Check if file already exists

// Check file size

// Allow certain file formats
function file_type($file) {
    return strtolower(pathinfo($file, PATHINFO_EXTENSION));
}

?>