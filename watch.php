<?php
// Database connection
$db = new mysqli('localhost', 'your_db_username', 'your_db_password', 'your_db_name');

// Check connection
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if a video ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid video ID.");
}

$video_id = intval($_GET['id']);

// Fetch video details from the database
$stmt = $db->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->bind_param("i", $video_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Video not found.");
}

$video = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch <?= htmlspecialchars($video['title']) ?></title>
    <style>
        body {
            background-color: #141414;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #000;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: #e50914;
            font-size: 24px;
            text-decoration: none;
        }

        .main-content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
            background-color: #000;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-title {
            font-size: 24px;
            margin: 20px 0 10px;
        }

        .video-description {
            font-size: 16px;
            color: #ccc;
            margin: 10px 0;
        }

        .back-link {
            display: inline-block;
            margin: 20px 0;
            color: #e50914;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="dashboard.php" class="logo">VIDEOFLIX</a>
        <a href="logout.php" style="color: #fff;">Sign Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="video-container">
            <!-- Embed video -->
            <iframe 
                src="<?= htmlspecialchars($video['video_url']) ?>" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>

        <h1 class="video-title"><?= htmlspecialchars($video['title']) ?></h1>
        <p class="video-description"><?= nl2br(htmlspecialchars($video['description'])) ?></p>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
