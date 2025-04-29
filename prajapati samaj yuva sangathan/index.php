<!-- scholarship for use
 <?php include 'db.php'; ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Government Scholarships - Prajapati Samaj</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* (same CSS you already wrote) */
  </style>
</head>
<body>

  <header>
    <h1>Government Scholarships</h1>
    <p>Support for Students of Prajapati Samaj</p>
  </header>

  <div class="container">

    <?php
      $scholarshipQuery = "SELECT * FROM scholarships ORDER BY id DESC";
      $scholarshipResult = $conn->query($scholarshipQuery);

      if ($scholarshipResult->num_rows > 0) {
          while($row = $scholarshipResult->fetch_assoc()) {
              echo '<div class="card">';
              echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
              echo '<p>' . htmlspecialchars($row['description']) . '</p>';
              echo '<a href="' . htmlspecialchars($row['link']) . '" target="_blank">Learn More →</a>';
              echo '</div>';
          }
      } else {
          echo "<p>No scholarships available yet.</p>";
      }
    ?>

    <div class="news-section">
      <h2>Latest Scholarship News</h2>
      <div class="news-feed">
        <?php
          $newsQuery = "SELECT * FROM news ORDER BY date DESC";
          $newsResult = $conn->query($newsQuery);

          if ($newsResult->num_rows > 0) {
              while($news = $newsResult->fetch_assoc()) {
                  echo '<div class="news-item">';
                  echo '<strong>' . htmlspecialchars(date('F d, Y', strtotime($news['date']))) . ':</strong> ';
                  echo htmlspecialchars($news['content']);
                  echo '</div>';
              }
          } else {
              echo "<p>No news available yet.</p>";
          }
        ?>
      </div>
    </div>

    <div style="text-align:center;">
      <a href="index.php" class="btn-home">← Back to Home</a>
    </div>

  </div>

</body>
</html>
