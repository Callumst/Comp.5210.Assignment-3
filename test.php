<?php
$servername = "localhost";
$username = "a30113130_Callum"; 
$password = "Turtlenuggets28";
$database = "a30113130_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Listing Fields in 'kenworth' Table:</h2>";

// This SQL command asks the database for the structure of the table
$result = $conn->query("DESCRIBE kenworth");

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: sans-serif;'>";
    echo "<tr style='background: #eee;'>
            <th>Field</th>
            <th>Type</th>
            <th>Null</th>
            <th>Key</th>
            <th>Default</th>
            <th>Extra</th>
          </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "The table exists but no structure was found (or the table name is wrong).";
}

$conn->close();
?>