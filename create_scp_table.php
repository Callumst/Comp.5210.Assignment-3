<?php

include 'credentials.php';

$conn = new mysqli('localhost', $user, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS scp (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    subject     VARCHAR(255)    NOT NULL,
    class       VARCHAR(100)    NOT NULL,
    description TEXT            NOT NULL,
    containment TEXT            NOT NULL,
    image       VARCHAR(500)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'scp' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>