<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Protect the page
requireRole(['Admin', 'CR/GR']);

// Handle Add / Delete
if (isset($_POST['add_resource'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    
    // File upload logic
    $target_dir = "../assets/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $db_path = "assets/uploads/" . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO resources (title, file_path, category) VALUES (?, ?, ?)");
        $stmt->execute([$title, $db_path, $category]);
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("SELECT file_path FROM resources WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $res = $stmt->fetch();
    
    if ($res) {
        $full_path = "../" . $res['file_path'];
        if (file_exists($full_path)) unlink($full_path);
        
        $del_stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $del_stmt->execute([$_GET['delete']]);
    }
    header("Location: manage_resources.php");
    exit();
}

$resources = $pdo->query("SELECT * FROM resources ORDER BY upload_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Manage Class Resources</h1>

        <div class="glass-card" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem;">Upload New Resource</h3>
            <form method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <input type="text" name="title" placeholder="Resource Title" required style="grid-column: span 2; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <select name="category" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                    <option value="PDF">PDF Document</option>
                    <option value="Slides">Lecture Slides</option>
                    <option value="Past Papers">Past Paper</option>
                </select>
                <input type="file" name="file" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.6rem; border-radius: 0.5rem; color: white;">
                <button type="submit" name="add_resource" class="btn btn-primary" style="justify-self: start;">Upload resource</button>
            </form>
        </div>

        <div class="glass-card" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">
                        <th style="padding: 1rem 2rem;">Resource Title</th>
                        <th style="padding: 1rem 2rem;">Category</th>
                        <th style="padding: 1rem 2rem;">Date</th>
                        <th style="padding: 1rem 2rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resources as $res): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 1rem 2rem;"><?php echo htmlspecialchars($res['title']); ?></td>
                        <td style="padding: 1rem 2rem;"><?php echo $res['category']; ?></td>
                        <td style="padding: 1rem 2rem;"><?php echo date('M d, Y', strtotime($res['upload_date'])); ?></td>
                        <td style="padding: 1rem 2rem;">
                            <a href="?delete=<?php echo $res['id']; ?>" onclick="return confirm('Are you sure?')" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
