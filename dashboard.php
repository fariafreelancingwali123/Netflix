<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$user = $db->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoFlix Dashboard</title>
    <style>
        /* Previous CSS remains same until hero-section */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Netflix Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #141414;
            color: #ffffff;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(to bottom, rgba(0,0,0,0.7) 10%, rgba(0,0,0,0));
            padding: 0 4%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.4s;
        }

        .navbar.scrolled {
            background: #141414;
        }

        .logo {
            color: #e50914;
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            margin-right: 25px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-button {
            color: #fff;
            text-decoration: none;
            padding: 7px 17px;
            border-radius: 3px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .upload-btn {
            background-color: #e50914;
        }

        .upload-btn:hover {
            background-color: #f40612;
        }

        .logout-btn {
            background-color: rgba(109, 109, 110, 0.7);
        }

        .logout-btn:hover {
            background-color: rgba(109, 109, 110, 0.4);
        }

        .hero-section {
            position: relative;
            height: 80vh;
            display: flex;
            align-items: center;
            padding: 0 4%;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, #141414, transparent);
            z-index: 1;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin-top: 100px;
        }

        .hero-title {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero-description {
            font-size: 1.2rem;
            color: #e5e5e5;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .main-content {
            margin: 0 4%;
            padding-bottom: 50px;
        }

        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .video-card {
            background: #2f2f2f;
            border-radius: 4px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .video-card:hover {
            transform: scale(1.05);
        }

        .video-thumbnail {
            width: 100%;
            height: 140px;
            overflow: hidden;
        }

        .video-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-info {
            padding: 15px;
        }

        .video-title {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .video-stats {
            font-size: 0.9rem;
            color: #a1a1a1;
            display: flex;
            justify-content: space-between;
        }

        /* Rest of your existing CSS */
        
        .category-pills {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            overflow-x: auto;
            padding: 10px 0;
        }

        .category-pill {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 20px;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .category-pill:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .category-pill.active {
            background: #e50914;
        }

        .profile-icon {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            background-color: #666;
            margin-left: 20px;
        }

        .row-header {
            font-size: 1.4vw;
            font-weight: 500;
            margin-bottom: 1em;
            color: #e5e5e5;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .video-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-links">
            <a href="#" class="logo">VIDEOFLIX</a>
            <a href="upload.php" class="nav-button upload-btn">Upload Video</a>
        </div>
        <div class="nav-links">
            <span style="color: #e5e5e5"><?= htmlspecialchars($user['username']) ?></span>
            <a href="logout.php" class="nav-button logout-btn">Sign Out</a>
            <div class="profile-icon"></div>
        </div>
    </nav>

    <section class="hero-section">
        <img src="/api/placeholder/1920/1080" alt="Featured Video" class="hero-background">
        <div class="hero-content">
            <h1 class="hero-title">Featured Video</h1>
            <p class="hero-description">
                How to Create Professional Videos: A Complete Guide for Beginners
            </p>
            <div class="video-stats">
                <span>Added 2 days ago</span>
                <span>• 15K views</span>
            </div>
        </div>
    </section>

    <main class="main-content">
        <div class="category-pills">
            <div class="category-pill active">All</div>
            <div class="category-pill">Recently Uploaded</div>
            <div class="category-pill">Most Viewed</div>
            <div class="category-pill">Tutorials</div>
            <div class="category-pill">Entertainment</div>
            <div class="category-pill">Education</div>
        </div>

        <section class="content-row">
            <h2 class="row-header">Your Latest Videos</h2>
            <div class="video-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Beginner's Guide to Video Editing</h3>
                        <div class="video-stats">
                            <span>10K views</span>
                            <span>2 days ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">5 Tips for Better Cinematography</h3>
                        <div class="video-stats">
                            <span>8.5K views</span>
                            <span>5 days ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Advanced Color Grading Tutorial</h3>
                        <div class="video-stats">
                            <span>12K views</span>
                            <span>1 week ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Sound Design Masterclass</h3>
                        <div class="video-stats">
                            <span>15K views</span>
                            <span>2 weeks ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-row">
            <h2 class="row-header">Trending Now</h2>
            <div class="video-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Making a Short Film in 24 Hours</h3>
                        <div class="video-stats">
                            <span>50K views</span>
                            <span>1 day ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Pro Camera Setup Guide</h3>
                        <div class="video-stats">
                            <span>35K views</span>
                            <span>3 days ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Creative Lighting Techniques</h3>
                        <div class="video-stats">
                            <span>28K views</span>
                            <span>4 days ago</span>
                        </div>
                    </div>
                </div>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/400/225" alt="Video Thumbnail">
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Video Marketing Strategies</h3>
                        <div class="video-stats">
                            <span>42K views</span>
                            <span>1 week ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Add scrolled class to navbar when scrolling
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Category pills click handler
        document.querySelectorAll('.category-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                document.querySelector('.category-pill.active').classList.remove('active');
                pill.classList.add('active');
            });
        });
    </script>
</body>
</html>
