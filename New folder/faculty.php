<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch faculty
$stmt = $pdo->query("SELECT * FROM faculty ORDER BY name ASC");
$faculties = $stmt->fetchAll();
?>

<section style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem;">Faculty Information</h1>
        <p style="color: var(--text-muted);">Meet our experienced educators and subject experts.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        <?php if ($faculties): ?>
            <?php foreach ($faculties as $fac): ?>
                <div class="glass-card" style="text-align: center; padding: 2.5rem 1.5rem;">
                    <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; border: 3px solid var(--accent-color); padding: 5px;">
                        <img src="assets/images/<?php echo $fac['profile_pic']; ?>" alt="<?php echo $fac['name']; ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; background: #334155;" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($fac['name']); ?>&background=0D8ABC&color=fff'">
                    </div>
                    <h3 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($fac['name']); ?></h3>
                    <p style="color: var(--accent-color); font-weight: 500; margin-bottom: 1rem;"><?php echo htmlspecialchars($fac['subject']); ?></p>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: center; margin-top: 1.5rem;">
                        <a href="mailto:<?php echo $fac['email']; ?>" style="font-size: 0.9rem; color: var(--text-muted);">
                            <i class="fas fa-envelope" style="width: 20px;"></i> <?php echo htmlspecialchars($fac['email']); ?>
                        </a>
                        <a href="tel:<?php echo $fac['phone']; ?>" style="font-size: 0.9rem; color: var(--text-muted);">
                            <i class="fas fa-phone" style="width: 20px;"></i> <?php echo htmlspecialchars($fac['phone']); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1 / -1; text-align: center; color: var(--text-muted);">No faculty records found.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
