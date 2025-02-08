<?php
// Fetch videos for the user
$videos = $db->query("SELECT * FROM videos WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<div class="video-grid">
    <?php while ($video = $videos->fetch_assoc()): ?>
        <div class="video-card">
            <div class="video-thumbnail" style="background: url('<?= htmlspecialchars($video['thumbnail_url']) ?>') no-repeat center; background-size: cover;"></div>
            <div class="video-info">
                <h3 class="video-title"><?= htmlspecialchars($video['title']) ?></h3>
                <div class="video-stats">
                    <span><?= htmlspecialchars($video['views']) ?> views</span>
                    <span><?= htmlspecialchars($video['created_at']) ?></span>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
