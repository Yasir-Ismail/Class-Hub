<?php 
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Protect the page
requireRole(['Admin', 'CR/GR']);

// Handle Add / Delete
if (isset($_POST['add_photo'])) {
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    
    $target_dir = "../assets/uploads/";
    $file_name = "gallery_" . time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (title, image_path, event_date) VALUES (?, ?, ?)");
        $stmt->execute([$title, $file_name, $event_date]);
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    $img = $stmt->fetch();
    
    if ($img) {
        $path = "../assets/uploads/" . $img['image_path'];
        if (file_exists($path)) unlink($path);
        
        $del_stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $del_stmt->execute([$_GET['delete']]);
    }
    header("Location: manage_gallery.php");
    exit();
}

$gallery = $pdo->query("SELECT * FROM gallery ORDER BY event_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-main">
        <h1 style="margin-bottom: 2rem;">Manage Event Gallery</h1>

        <div class="glass-card" style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1.5rem;">Add New Event Photo</h3>
            <form method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <input type="text" name="title" placeholder="Event Title (e.g. Class Trip 2025)" required style="grid-column: span 2; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <input type="date" name="event_date" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white;">
                <input type="file" name="image" accept="image/*" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.6rem; border-radius: 0.5rem; color: white;">
                <button type="submit" name="add_photo" class="btn btn-primary" style="justify-self: start;">Add to Gallery</button>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
            <?php foreach ($gallery as $item): ?>
                <div class="glass-card" style="padding: 0; overflow: hidden; position: relative;">
                    <img src="../assets/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" style="width: 100%; height: 150px; object-fit: cover;">
                    <div style="padding: 1rem;">
                        <h4 style="font-size: 0.9rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($item['title']); ?></h4>
                        <a href="?delete=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure?')" style="color: #ef4444; font-size: 0.8rem;"><i class="fas fa-trash"></i> Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
