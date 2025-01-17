<?php
// index.php
include 'connect.php';

// Check if database connection succeeded.
if ($conn->connect_error) {
    // Print an alert with the error
    echo "<div class='alert alert-danger text-center' role='alert'>
            <strong>Database Connection Failed:</strong> " . htmlspecialchars($conn->connect_error) . "
          </div>";
    exit;
}

// Optionally, check if we are using the right DB (if not included in connect.php)
if (!$conn->select_db("mydb")) {
    echo "<div class='alert alert-danger text-center' role='alert'>
            <strong>Error selecting database:</strong> " . htmlspecialchars($conn->error) . "
          </div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple Dictionary App</title>

  <!-- Bootstrap 5 (CDN) -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <style>
    body {
      background-color: #f8f9fa; /* light gray background */
    }
    .navbar-brand strong {
      color: #0d6efd; /* custom brand color */
    }
  </style>
</head>

<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">
        <strong>My Dictionary</strong>
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            Simple Dictionary
          </div>
          <div class="card-body">
            <!-- Input Form -->
            <form method="POST" class="d-flex">
              <input
                type="text"
                name="word"
                id="word"
                class="form-control me-2"
                placeholder="Enter a word"
                required
              />
              <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <hr />

            <!-- Dictionary Results -->
            <?php
            // Only proceed if this is a POST request and 'word' is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['word'])) {
              $word = trim($_POST['word']);

              // Validate the word (e.g., ensure it's not empty)
              if (strlen($word) === 0) {
                echo "<div class='alert alert-warning' role='alert'>
                        Please enter a valid word.
                      </div>";
              } else {
                // Prepare the query
                $stmt = $conn->prepare("SELECT definition FROM dictionary WHERE word = ?");
                if (!$stmt) {
                  echo "<div class='alert alert-danger' role='alert'>
                          <strong>Error preparing statement:</strong> " . htmlspecialchars($conn->error) . "
                        </div>";
                  exit;
                }

                // Bind parameters
                if (!$stmt->bind_param("s", $word)) {
                  echo "<div class='alert alert-danger' role='alert'>
                          <strong>Error binding parameters:</strong> " . htmlspecialchars($stmt->error) . "
                        </div>";
                  exit;
                }

                // Execute the statement
                if (!$stmt->execute()) {
                  echo "<div class='alert alert-danger' role='alert'>
                          <strong>Error executing statement:</strong> " . htmlspecialchars($stmt->error) . "
                        </div>";
                  exit;
                }

                // Fetch results
                $result = $stmt->get_result();
                if (!$result) {
                  echo "<div class='alert alert-danger' role='alert'>
                          <strong>Error fetching result:</strong> " . htmlspecialchars($stmt->error) . "
                        </div>";
                  exit;
                }

                // Display definitions if found
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<p><strong>Definition:</strong> " . htmlspecialchars($row["definition"]) . "</p>";
                  }
                } else {
                  echo "<div class='alert alert-info' role='alert'>
                          No definition found for <strong>" . htmlspecialchars($word) . "</strong>.
                        </div>";
                }

                // Clean up
                $stmt->close();
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript (CDN) -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
