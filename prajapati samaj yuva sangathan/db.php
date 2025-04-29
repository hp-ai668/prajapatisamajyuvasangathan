<!-- database connection -->
<?php
$servername = "localhost";
$username = "root"; // default in XAMPP
$password = "";     // no password
$database = "prajapati_samaj";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
