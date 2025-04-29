<!-- workshop backend -->
<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Default username in XAMPP
$password = "";     // Default password is empty in XAMPP
$dbname = "prajapati_samaj"; // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the input data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $workshop = $conn->real_escape_string(trim($_POST['workshop']));

    // SQL Insert Query
    $sql = "INSERT INTO registrations (name, email, phone, workshop) 
            VALUES ('$name', '$email', '$phone', '$workshop')";

    if ($conn->query($sql) === TRUE) {
        // Show nice success page
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Successful</title>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
            <style>
                body {
                    background: #f5f5f5;
                    font-family: "Poppins", sans-serif;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }
                .thank-you-box {
                    background: white;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    text-align: center;
                }
                .thank-you-box h1 {
                    color: #8e24aa;
                    margin-bottom: 20px;
                }
                .thank-you-box p {
                    font-size: 18px;
                    color: #555;
                    margin-bottom: 30px;
                }
                .btn-home {
                    display: inline-block;
                    padding: 12px 25px;
                    background-color: #8e24aa;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: 600;
                    transition: background-color 0.3s;
                }
                .btn-home:hover {
                    background-color: #6a1b9a;
                }
            </style>
        </head>
        <body>
            <div class="thank-you-box">
                <h1>🎉 Thank You, ' . htmlspecialchars($name) . '!</h1>
                <p>You have successfully registered for the <strong>' . htmlspecialchars($workshop) . '</strong> workshop.</p>
                <a href="index.html" class="btn-home">← Back to Workshops</a>
            </div>
        </body>
        </html>';
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
