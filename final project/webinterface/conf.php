<?php

$dbhost = '127.0.0.1'; // database host
$dbuser = ''; // database user
$dbpass = ''; // database password
$dbname = ''; // database name
$results_per_page = 10; // number of results per page

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (!$conn) {
    die('Error connecting to mysql. :-( <br/>');
} else {
    #echo 'Yes, we have connected to MySQL! :-) <br/>';
}
