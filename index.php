<?php
// Include the database connection file
include('db_connection.php');

// Handle file upload if the form is submitted
if (isset($_POST['upload'])) {
    // Get the uploaded file
    $file = $_FILES['main_picture'];

    // Get the file name and destination path
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $destination = 'uploads/' . $fileName;

    // Check if the uploads directory exists, if not, create it
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    // Move the uploaded file to the 'uploads' directory
    if (move_uploaded_file($fileTmpName, $destination)) {
        // Update the main picture in the database
        $sql = "UPDATE students SET profile_picture = '$fileName' WHERE id = 1";  // Adjust as needed
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success-msg'>Picture uploaded successfully!</p>";
        } else {
            echo "<p class='error-msg'>Error updating picture: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='error-msg'>Failed to upload picture.</p>";
    }
}

// Fetch the student's data (including the profile picture)
$sql = "SELECT profile_picture FROM students WHERE id = 1";  // Adjust as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $profile_picture = $student['profile_picture'];
} else {
    $profile_picture = 'default_image.jpg';  // Path to a default image
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function triggerFileInput() {
            document.getElementById('main_picture').click();
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Welcome to My Portfolio</h1>
            <div class="profile-container">
                <!-- Make the profile picture a clickable link -->
                <a href="about.php">
                    <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic">
                </a>
                <form action="index.php" method="POST" enctype="multipart/form-data" class="upload-form">
                    <input type="file" name="main_picture" id="main_picture" style="display: none;" required>
                    <button type="button" onclick="triggerFileInput()" class="upload-btn">Upload Profile Picture</button>
                    <button type="submit" name="upload" style="display: none;"></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
