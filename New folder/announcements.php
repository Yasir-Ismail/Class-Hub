<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch announcements
$stmt = $pdo->query("SELECT * FROM announcements ORDER BY date_posted DESC");
$announcements = $stmt->fetchAll();
?>

<section style="padding: 4rem 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
        <div>
            <h1 style="font-size: 2.5rem;">Class Announcements</h1>
            <p style="color: var(--text-muted);">Stay updated with the latest notices and updates.</p>
        </div>
        <i class="fas fa-bullhorn" style="font-size: 3rem; color: var(--accent-color); opacity: 0.5;"></i>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <?php if ($announcements): ?>
            <?php foreach ($announcements as $ann): ?>
                <div class="glass-card" style="padding: 1.5rem; text-align: left;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <h3 style="color: var(--accent-color);"><?php echo htmlspecialchars($ann['title']); ?></h3>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="far fa-clock"></i> <?php echo date('M d, Y', strtotime($ann['date_posted'])); ?>
                        </span>
                    </div>
                    <p style="color: var(--text-color);"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="glass-card" style="text-align: center;">
                <p style="color: var(--text-muted);">No announcements yet. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
