<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch gallery items
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY event_date DESC");
$gallery = $stmt->fetchAll();
?>

<section style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem;">
        <a href="index.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500;" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 style="font-size: 2.5rem;">Event Gallery</h1>
        <p style="color: var(--text-muted);">Moments captured during class events and trips.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        <?php if ($gallery): ?>
            <?php foreach ($gallery as $item): ?>
                <div class="glass-card" style="padding: 0; overflow: hidden; height: 350px; position: relative; cursor: pointer;">
                    <img src="assets/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: var(--transition);">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 2rem 1.5rem; text-align: left;">
                        <h4 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($item['title']); ?></h4>
                        <p style="font-size: 0.8rem; color: rgba(255,255,255,0.7);"><?php echo date('M Y', strtotime($item['event_date'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback with generate_image placeholder later or just sample layout -->
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                <i class="fas fa-camera" style="font-size: 3rem; color: #8b5cf6; margin-bottom: 1rem;"></i>
                <p style="color: var(--text-muted);">No photos yet. Start capturing moments!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
