<?php
include('db_connection.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $high_school = $_POST['high_school'];
    $college = $_POST['college'];
    $address = $_POST['address'];

    // Update student details
    $sql = "UPDATE students SET high_school = ?, college = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $high_school, $college, $address, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: about.php?id=" . $id);
        exit();
    } else {
        echo "Failed to update student details.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Student Details</h1>
        <form method="POST" action="edit_student.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="high_school">High School:</label>
            <input type="text" name="high_school" id="high_school" value="<?php echo htmlspecialchars($high_school); ?>" required><br><br>
            <label for="college">College:</label>
            <input type="text" name="college" id="college" value="<?php echo htmlspecialchars($college); ?>" required><br><br>
            <label for="address">Address:</label>
            <textarea name="address" id="address" rows="4" required><?php echo htmlspecialchars($address); ?></textarea><br><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
