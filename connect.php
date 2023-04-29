<?php
$uname = "root";
$dbpass = "";
$host = "localhost";
$db = "database";

$conn = mysqli_connect($host, $uname, $dbpass, $db);

// Check if the connection was successful
if (!$conn) {
    die("Sorry, there was an error connecting to the database. Please try again later.");
}


