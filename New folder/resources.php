<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch resources
$stmt = $pdo->query("SELECT * FROM resources ORDER BY upload_date DESC");
$resources = $stmt->fetchAll();
?>

<section style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.5rem;">Class Resources</h1>
            <p style="color: var(--text-muted);">Download lecture slides, handouts, and past papers.</p>
        </div>
        <i class="fas fa-folder-open" style="font-size: 3rem; color: #ef4444; opacity: 0.5;"></i>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <?php if ($resources): ?>
            <?php foreach ($resources as $res): ?>
                <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                    <div style="font-size: 2.5rem; color: var(--accent-color);">
                        <?php 
                        $icon = 'fa-file-alt';
                        if ($res['category'] == 'PDF') $icon = 'fa-file-pdf';
                        elseif ($res['category'] == 'Slides') $icon = 'fa-file-powerpoint';
                        ?>
                        <i class="fas <?php echo $icon; ?>"></i>
                    </div>
                    <div style="flex: 1;">
                        <h4 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($res['title']); ?></h4>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">
                            <?php echo $res['category']; ?> • <?php echo date('M d, Y', strtotime($res['upload_date'])); ?>
                        </p>
                    </div>
                    <a href="<?php echo htmlspecialchars($res['file_path']); ?>" class="btn btn-primary" style="padding: 0.5rem;" title="Download" download>
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                <p style="color: var(--text-muted);">No resources uploaded yet.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
