<?php
include('config.php');

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Address</th><th>Generated ID</th><th>Photo</th><th>Date Created</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["full_name"]."</td>
                <td>".$row["address"]."</td>
                <td>".$row["generated_id"]."</td>
                <td><img src='".$row["photo_path"]."' style='width: 50px; height: 50px;'></td>
                <td>".$row["created_at"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

$conn->close();
?>
