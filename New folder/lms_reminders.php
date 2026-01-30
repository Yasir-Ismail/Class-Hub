<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch reminders
$stmt = $pdo->query("SELECT * FROM reminders WHERE due_date >= CURDATE() ORDER BY due_date ASC");
$reminders = $stmt->fetchAll();
?>

<section style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.5rem;">LMS Reminders</h1>
            <p style="color: var(--text-muted);">Keep track of upcoming quizzes and assignments.</p>
        </div>
        <i class="fas fa-tasks" style="font-size: 3rem; color: #fbbf24; opacity: 0.5;"></i>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <?php if ($reminders): ?>
            <?php foreach ($reminders as $rem): ?>
                <div class="glass-card" style="border-top: 4px solid <?php echo $rem['type'] == 'Quiz' ? '#fbbf24' : '#ef4444'; ?>;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="background: <?php echo $rem['type'] == 'Quiz' ? 'rgba(251, 191, 36, 0.1)' : 'rgba(239, 68, 68, 0.1)'; ?>; 
                                     color: <?php echo $rem['type'] == 'Quiz' ? '#fbbf24' : '#ef4444'; ?>;
                                     padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 600;">
                            <?php echo $rem['type']; ?>
                        </span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="far fa-calendar-alt"></i> Due: <?php echo date('M d, Y', strtotime($rem['due_date'])); ?>
                        </span>
                    </div>
                    <h3 style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($rem['title']); ?></h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;"><?php echo nl2br(htmlspecialchars($rem['description'])); ?></p>
                    
                    <div style="margin-top: 1.5rem; text-align: right;">
                        <button class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem;">View Details</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="glass-card" style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem;"></i>
                <h3>All caught up!</h3>
                <p style="color: var(--text-muted);">No upcoming quizes or assignments found.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
