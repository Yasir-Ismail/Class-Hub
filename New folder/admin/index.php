<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Protect the page
requireRole(['Admin', 'CR/GR']);

$current_role = getRole();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - ClassHub</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="admin-main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <h1>Dashboard Overview</h1>
            <div style="color: var(--text-muted);">Welcome, <?php echo $_SESSION['full_name']; ?></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 2rem; color: #6366f1; background: rgba(99, 102, 241, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Total Students</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">
                        <?php echo $pdo->query("SELECT count(*) FROM users WHERE role = 'Student'")->fetchColumn(); ?>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 2rem; color: var(--accent-color); background: rgba(59, 130, 246, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Active Notices</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">
                        <?php echo $pdo->query("SELECT count(*) FROM announcements")->fetchColumn(); ?>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 2rem; color: #fbbf24; background: rgba(251, 191, 36, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Reminders</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">
                        <?php echo $pdo->query("SELECT count(*) FROM reminders WHERE due_date >= CURDATE()")->fetchColumn(); ?>
                    </div>
                </div>
            </div>

            <div class="glass-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 2rem; color: #10b981; background: rgba(16, 185, 129, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted);">Feedback Items</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">
                        <?php echo $pdo->query("SELECT count(*) FROM feedback")->fetchColumn(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem;">Recent Actions</h2>
            <div class="glass-card" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                            <th style="padding: 1.25rem 2rem;">Activity Description</th>
                            <th style="padding: 1.25rem 2rem;">Timestamp</th>
                            <th style="padding: 1.25rem 2rem;">Action Type</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.95rem;">
                        <tr style="border-bottom: 1px solid var(--glass-border);">
                            <td style="padding: 1.25rem 2rem;">Updated Lecture Schedule for Monday</td>
                            <td style="padding: 1.25rem 2rem;">Jan 29, 10:45 AM</td>
                            <td style="padding: 1.25rem 2rem;"><span style="color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 0.2rem 0.6rem; border-radius: 4px;">Update</span></td>
                        </tr>
                        <tr>
                            <td style="padding: 1.25rem 2rem;">New Assignment Reminder: Database Project</td>
                            <td style="padding: 1.25rem 2rem;">Jan 28, 04:20 PM</td>
                            <td style="padding: 1.25rem 2rem;"><span style="color: var(--accent-color); background: rgba(59, 130, 246, 0.1); padding: 0.2rem 0.6rem; border-radius: 4px;">Create</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
