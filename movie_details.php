<?php
require_once 'db.php';
$id = $_GET['id'];
$movie = $db->query("SELECT * FROM movies WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $movie['title'] ?></title>
</head>
<body>
    <h1><?= $movie['title'] ?></h1>
    <p><?= $movie['description'] ?></p>
    <p>Runtime: <?= $movie['runtime'] ?> minutes</p>
    <video controls>
        <source src="<?= $movie['file_url'] ?>" type="video/mp4">
    </video>
</body>
</html>
