<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch schedule sorted by day and time
$stmt = $pdo->query("SELECT * FROM schedule ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), start_time");
$schedules = $stmt->fetchAll();

// Group by day
$grouped_schedule = [];
foreach ($schedules as $row) {
    $grouped_schedule[$row['day']][] = $row;
}

// Get current day and time for highlighting
$current_day = date('l');
$current_time = date('H:i:s');
?>

<style>
    .schedule-header {
        margin-bottom: 3rem;
        text-align: center;
    }

    .schedule-container {
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .timetable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0.5rem;
        min-width: 1000px;
    }

    .timetable th {
        background: var(--primary-color);
        color: var(--accent-color);
        padding: 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05rem;
        position: sticky;
        top: 0;
    }

    .timetable td {
        vertical-align: top;
        width: 14.28%; /* 7 days */
    }

    .class-card {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 1rem;
        height: 100%;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .class-card:hover {
        border-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.3);
    }

    .class-card.active {
        border-color: #10b981;
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
    }

    .class-card.active::before {
        content: 'LIVE';
        position: absolute;
        top: 0;
        right: 0;
        background: #10b981;
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-bottom-left-radius: 0.5rem;
    }

    .class-subject {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-color);
        line-height: 1.3;
    }

    .class-info {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .class-info i {
        width: 14px;
        color: var(--accent-color);
    }

    .time-slot {
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-color);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.2rem 0.5rem;
        border-radius: 0.3rem;
        display: inline-block;
        margin-bottom: 0.3rem;
    }

    .empty-day {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
        font-style: italic;
        font-size: 0.8rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 0.75rem;
        border: 1px dashed var(--glass-border);
    }

    .prayer-card {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .prayer-card .class-subject {
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .timetable td {
            display: block;
            width: 100%;
            margin-bottom: 2rem;
        }
        .timetable tr {
            display: flex;
            flex-direction: column;
        }
        .timetable th {
            display: block;
            margin-bottom: 0.5rem;
            text-align: left;
        }
        .timetable {
            min-width: unset;
        }
    }
</style>

<section style="padding: 4rem 0;">
    <div class="schedule-header">
        <div style="max-width: 1200px; margin: 0 auto; text-align: left; margin-bottom: 1rem;">
            <a href="index.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.9rem; font-weight: 500;" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">Lecture Schedule</h1>
        <p style="color: var(--text-muted);">Access your weekly academic timetable and classroom locations.</p>
    </div>

    <div class="schedule-container">
        <table class="timetable">
            <thead>
                <tr>
                    <?php 
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach ($days as $day): 
                    ?>
                        <th><?php echo $day; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($days as $day): ?>
                        <td>
                            <?php if (isset($grouped_schedule[$day])): ?>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <?php foreach ($grouped_schedule[$day] as $class): 
                                        $is_active = ($day == $current_day && $current_time >= $class['start_time'] && $current_time <= $class['end_time']);
                                        $is_prayer = (strpos($class['subject'], 'Prayer') !== false);
                                    ?>
                                        <div class="class-card <?php echo $is_active ? 'active' : ''; ?> <?php echo $is_prayer ? 'prayer-card' : ''; ?>">
                                            <div class="time-slot">
                                                <i class="far fa-clock"></i> 
                                                <?php echo date('h:i A', strtotime($class['start_time'])); ?> - <?php echo date('h:i A', strtotime($class['end_time'])); ?>
                                            </div>
                                            <div class="class-subject"><?php echo htmlspecialchars($class['subject']); ?></div>
                                            <div class="class-info">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                <span><?php echo htmlspecialchars($class['teacher']); ?></span>
                                            </div>
                                            <?php if (!empty($class['room']) && $class['room'] !== '-'): ?>
                                                <div class="class-info">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span><?php echo htmlspecialchars($class['room']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-day">No Classes</div>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
