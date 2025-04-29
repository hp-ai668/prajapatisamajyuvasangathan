<?php
// Connect to database
$servername = "localhost";
$username = "root"; // default in XAMPP
$password = "";     // default empty in XAMPP
$database = "prajapati_samaj";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
$fullName = $_POST['fullName'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$class = $_POST['class'];
$stream = $_POST['stream'];
$subjects = $_POST['subjects'];
$interests = $_POST['interests'];
$previousSession = $_POST['previousSession'];
$sector = $_POST['sector'];
$goals = $_POST['goals'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO career_guidance (fullName, gender, dob, class, stream, subjects, interests, previousSession, sector, goals, mobile, email)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssssss", $fullName, $gender, $dob, $class, $stream, $subjects, $interests, $previousSession, $sector, $goals, $mobile, $email);

// Execute
if ($stmt->execute()) {
    echo "<h2>Thank you for submitting your information!</h2>";
    // Redirect after 3 seconds
    header("Refresh: 3; url=index.html");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
