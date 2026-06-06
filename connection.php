<?php

include "credentials.php";

// Connection Object
$connection = new mysqli("localhost", $user, $pw, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Select all records from the scp table
$records = $connection->prepare("SELECT * FROM scp");

if (!$records) {
    die("Query preparation failed: " . $connection->error);
}

// Run the command
if (!$records->execute()) {
    die("Query execution failed: " . $records->error);
}

// Save results into a var
$result = $records->get_result();

if (!$result) {
    die("Could not fetch query results: " . $connection->error);
}

?>