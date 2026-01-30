<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Protect the page
requireRole(['Admin', 'CR/GR']);

// Handle Add / Delete
if (isset($_POST['add_announcement'])) {
    $stmt = $pdo->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
    $stmt->execute([$_POST['title'], $_POST['content']]);
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_announcements.php");
    exit();
}

$announcements = $pdo->query("SELECT * FROM announcements ORDER BY date_posted DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Manage Announcements</h1>

        <!-- Add Form -->
        <div class="glass-card" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem;">Add New Announcement</h3>
            <form method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                <input type="text" name="title" placeholder="Announcement Title" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <textarea name="content" placeholder="Content details..." required rows="4" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; resize: vertical;"></textarea>
                <button type="submit" name="add_announcement" class="btn btn-primary" style="align-self: flex-start;">Post Announcement</button>
            </form>
        </div>

        <!-- List -->
        <div class="glass-card" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">
                        <th style="padding: 1rem 2rem;">Title</th>
                        <th style="padding: 1rem 2rem;">Date</th>
                        <th style="padding: 1rem 2rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $ann): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 1rem 2rem;"><?php echo htmlspecialchars($ann['title']); ?></td>
                        <td style="padding: 1rem 2rem;"><?php echo date('M d, Y', strtotime($ann['date_posted'])); ?></td>
                        <td style="padding: 1rem 2rem;">
                            <a href="?delete=<?php echo $ann['id']; ?>" onclick="return confirm('Are you sure?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
