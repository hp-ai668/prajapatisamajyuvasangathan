<?php
// Database configuration
$servername = "localhost";
$username = "root";        // default for XAMPP
$password = "";            // default for XAMPP
$database = "prajapati_samaj";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Insert data into database
$sql = "INSERT INTO contact_messages (name, email, phone, city, subject, message) 
        VALUES ('$name', '$email', '$phone', '$city', '$subject', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Thank you for contacting us! We will get back to you soon.'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
