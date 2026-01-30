<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch schedule sorted by day
$stmt = $pdo->query("SELECT * FROM schedule ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time");
$schedules = $stmt->fetchAll();

// Group by day
$grouped_schedule = [];
foreach ($schedules as $row) {
    $grouped_schedule[$row['day']][] = $row;
}
?>

<section style="padding: 4rem 0;">
    <div style="margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem;">Lecture Schedule</h1>
        <p style="color: var(--text-muted);">Weekly timetable for all subjects.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <?php 
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($days as $day): 
        ?>
            <div class="glass-card" style="padding: 1.5rem;">
                <h3 style="color: var(--accent-color); border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    <?php echo $day; ?>
                </h3>
                <?php if (isset($grouped_schedule[$day])): ?>
                    <?php foreach ($grouped_schedule[$day] as $class): ?>
                        <div style="margin-bottom: 1.5rem; padding-left: 1rem; border-left: 2px solid var(--accent-color);">
                            <div style="font-weight: 600; font-size: 1.1rem;"><?php echo htmlspecialchars($class['subject']); ?></div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">
                                <i class="far fa-clock"></i> <?php echo date('h:i A', strtotime($class['start_time'])); ?> - <?php echo date('h:i A', strtotime($class['end_time'])); ?>
                            </div>
                            <div style="font-size: 0.9rem; color: var(--text-muted);">
                                <i class="far fa-user"></i> <?php echo htmlspecialchars($class['teacher']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-muted); font-style: italic;">No classes scheduled.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
