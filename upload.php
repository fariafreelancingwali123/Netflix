<?php
require_once 'db.php';
session_start();

// Ensure only logged-in users can upload
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check file size
    if ($_FILES['video']['size'] > 100 * 1024 * 1024) {
        echo "File too large. Maximum size is 100 MB.";
        exit;
    }

    // Get form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $runtime = $_POST['runtime'];
    $thumbnail = 'uploads/' . $_FILES['thumbnail']['name'];
    $file_url = 'uploads/' . $_FILES['video']['name'];

    // Move uploaded files to the server
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail);
    move_uploaded_file($_FILES['video']['tmp_name'], $file_url);

    // Insert movie details into the database
    $db->query("INSERT INTO movies (title, category, description, runtime, thumbnail, file_url)
                VALUES ('$title', '$category', '$description', '$runtime', '$thumbnail', '$file_url')");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Movie</title>
</head>
<body>
    <h1>Upload a New Movie</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Movie Title" required>
        <input type="text" name="category" placeholder="Category" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="runtime" placeholder="Runtime (minutes)" required>
        <input type="file" name="thumbnail" accept="image/*" required>
        <input type="file" name="video" accept="video/mp4" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
