<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";  // Default XAMPP password
$dbname = "id_card_generator";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate'])) {
    // Get form data
    $fullName = $_POST['fullName'];
    $address = $_POST['address'];

    // Handle photo upload
    $photo = $_FILES['photo'];
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoError = $photo['error'];

    if ($photoError === 0) {
        // Save the uploaded photo to the 'uploads' directory
        $uploadDir = 'uploads/';
        $photoPath = $uploadDir . uniqid('', true) . '.' . pathinfo($photoName, PATHINFO_EXTENSION);

        if (move_uploaded_file($photoTmpName, $photoPath)) {
            // Fetch the last generated ID from the database
            $result = $conn->query("SELECT generated_id FROM users ORDER BY generated_id DESC LIMIT 1");
            $lastId = 0;  // Default to 0 if no IDs are found
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = (int)substr($row['generated_id'], 3);  // Remove the 'PRJ' prefix and convert to integer
            }

            // Increment the last ID by 1
            $newId = $lastId + 1;

            // Format the new ID to have leading zeros (e.g., PRJ01, PRJ02, ...)
            $formattedId = str_pad($newId, 2, '0', STR_PAD_LEFT);

            // Generate the new ID with 'PRJ' prefix
            $id = 'PRJ' . $formattedId;

            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO users (full_name, address, photo_path, generated_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullName, $address, $photoPath, $id);

            if ($stmt->execute()) {
                // Output HTML for the ID Card with enhanced design
                echo "<html><body>";
                echo "<div class='container' style='width: 350px; border-radius: 16px; padding: 20px; background: linear-gradient(135deg, #6a1b9a, #ab47bc); color: white; font-family: Arial, sans-serif; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>";
                
                // Highlight "Prajapati Samaj Yuva Sangathan"
                echo "<h2 style='text-align: center; font-size: 22px; font-weight:; background-color:rgb(245, 223, 127); color: #6a1b9a; padding: 8px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>";
                echo "Prajapati Samaj Yuva Sangathan";
                echo "</h2>";

                echo "<div style='text-align: center; margin-bottom: 15px;'>";
                echo "<img src='$photoPath' style='width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #fff;' alt='User Photo'>";
                echo "</div>";
                echo "<h3 style='text-align: center; font-size: 20px; font-weight: 600;'>$fullName</h3>";
                echo "<p style='text-align: center; font-size: 14px; margin-bottom: 10px;'>Address: $address</p>";
                echo "<p style='text-align: center; font-size: 14px; margin-bottom: 20px;'>ID No: <strong>$id</strong></p>";
                echo "<p style='text-align: center; font-size: 12px; background: #fff; color: #6a1b9a; padding: 5px; border-radius: 8px;'>Issued by Prajapati Samaj Yuva Sangathan</p>";
                echo "</div>";

                // Generate Download Button (for ID card as image)
                echo "<div style='text-align: center; margin-top: 20px;'>";
                echo "<button onclick='downloadIDCard()' style='background-color: #43a047; padding: 12px 20px; color: white; font-size: 16px; border-radius: 8px; cursor: pointer;'>Download ID Card</button>";
                echo "</div>";

                echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'></script>";
                echo "<script>
                        function downloadIDCard() {
                            var idCard = document.querySelector('.container');
                            html2canvas(idCard).then(function(canvas) {
                                var link = document.createElement('a');
                                link.download = '$id-id_card.png';
                                link.href = canvas.toDataURL();
                                link.click();
                            });
                        }
                      </script>";
                echo "</body></html>";
            } else {
                echo "Error saving user data to database.";
            }
            $stmt->close();
        } else {
            echo "Error uploading the photo.";
        }
    } else {
        echo "Error with file upload.";
    }
}

$conn->close();
?>
