<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

requireRole(['Admin', 'CR/GR']);

$msg = '';
if (isset($_POST['add_student'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, 'Student', ?)");
    if ($stmt->execute([$username, $password, $full_name])) {
        $msg = "Student added successfully.";
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'Student'");
    $stmt->execute([$_GET['delete']]);
    header("Location: manage_students.php");
    exit();
}

$students = $pdo->query("SELECT * FROM users WHERE role = 'Student' ORDER BY full_name ASC")->fetchAll();
$current_role = getRole();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Manage Students</h1>

        <?php if ($msg): ?>
            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <div class="glass-card" style="margin-bottom: 3rem;">
            <h3>Add New Student</h3>
            <form method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                <input type="text" name="full_name" placeholder="Full Name" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <input type="text" name="username" placeholder="Username" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <input type="password" name="password" placeholder="Password" required style="grid-column: span 2; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <button type="submit" name="add_student" class="btn btn-primary" style="justify-self: start;">Add Student</button>
            </form>
        </div>

        <div class="glass-card" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">
                        <th style="padding: 1rem 2rem;">Full Name</th>
                        <th style="padding: 1rem 2rem;">Username</th>
                        <th style="padding: 1rem 2rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($students): ?>
                        <?php foreach ($students as $student): ?>
                        <tr style="border-bottom: 1px solid var(--glass-border);">
                            <td style="padding: 1rem 2rem;"><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td style="padding: 1rem 2rem;"><?php echo htmlspecialchars($student['username']); ?></td>
                            <td style="padding: 1rem 2rem;">
                                <a href="?delete=<?php echo $student['id']; ?>" onclick="return confirm('Delete this student?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="padding: 2rem; text-align: center; color: var(--text-muted);">No students found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
