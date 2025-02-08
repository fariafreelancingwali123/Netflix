<?php
require_once 'db.php';
session_start();

// Handle search
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
if ($searchQuery) {
    $movies = $db->query("SELECT * FROM movies WHERE title LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%'");
} else {
    $movies = $db->query("SELECT * FROM movies");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to Video Streaming Platform</h1>

    <!-- Search Bar -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search for movies..." value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Movie Grid -->
    <div class="movies-grid">
        <?php if ($movies->num_rows > 0): ?>
            <?php while ($movie = $movies->fetch_assoc()): ?>
                <div class="movie">
                    <img src="<?= $movie['thumbnail'] ?>" alt="<?= $movie['title'] ?>">
                    <h3><?= $movie['title'] ?></h3>
                    <p><?= $movie['category'] ?></p>
                    <a href="movie_details.php?id=<?= $movie['id'] ?>">Watch Now</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No movies found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
