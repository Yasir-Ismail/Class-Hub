<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Protect the page
requireRole(['Admin', 'CR/GR']);

// Handle Add / Delete
if (isset($_POST['add_reminder'])) {
    $stmt = $pdo->prepare("INSERT INTO reminders (title, type, due_date, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['type'], $_POST['due_date'], $_POST['description']]);
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM reminders WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_reminders.php");
    exit();
}

$reminders = $pdo->query("SELECT * FROM reminders ORDER BY due_date ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reminders - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Manage LMS Reminders</h1>

        <div class="glass-card" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem;">Create New Reminder</h3>
            <form method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <input type="text" name="title" placeholder="Title (e.g. Quiz 1)" required style="grid-column: span 2; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <select name="type" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                    <option value="Quiz">Quiz</option>
                    <option value="Assignment">Assignment</option>
                </select>
                <input type="date" name="due_date" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <textarea name="description" placeholder="Description..." required rows="3" style="grid-column: span 2; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; resize: vertical;"></textarea>
                <button type="submit" name="add_reminder" class="btn btn-primary" style="justify-self: start;">Add Reminder</button>
            </form>
        </div>

        <div class="glass-card" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">
                        <th style="padding: 1rem 2rem;">Title</th>
                        <th style="padding: 1rem 2rem;">Type</th>
                        <th style="padding: 1rem 2rem;">Due Date</th>
                        <th style="padding: 1rem 2rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reminders as $rem): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 1rem 2rem;"><?php echo htmlspecialchars($rem['title']); ?></td>
                        <td style="padding: 1rem 2rem;"><?php echo $rem['type']; ?></td>
                        <td style="padding: 1rem 2rem;"><?php echo date('M d, Y', strtotime($rem['due_date'])); ?></td>
                        <td style="padding: 1rem 2rem;">
                            <a href="?delete=<?php echo $rem['id']; ?>" onclick="return confirm('Are you sure?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
