<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user && $current_password === $user['password']) {
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                $update = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
                if ($update->execute([$new_username, $new_password, $_SESSION['user_id']])) {
                    $_SESSION['username'] = $new_username;
                    $msg = "Profile updated successfully!";
                }
            } else {
                $err = "Passwords do not match.";
            }
        } else {
            $update = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
            if ($update->execute([$new_username, $_SESSION['user_id']])) {
                $_SESSION['username'] = $new_username;
                $msg = "Username updated successfully!";
            }
        }
    } else {
        $err = "Incorrect current password.";
    }
}
?>

<section style="padding: 4rem 0;">
    <div style="max-width: 600px; margin: 0 auto;">
        <a href="index.php" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500;" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 style="margin-bottom: 2rem;">Profile Settings</h1>
        
        <?php if ($msg): ?>
            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; border: 1px solid rgba(16, 185, 129, 0.3);">
                <i class="fas fa-check-circle"></i> <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <?php if ($err): ?>
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                <i class="fas fa-exclamation-circle"></i> <?php echo $err; ?>
            </div>
        <?php endif; ?>

        <div class="glass-card">
            <form method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Username</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Current Password (required to save changes)</label>
                    <input type="password" name="current_password" required style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>

                <hr style="border: 0; border-top: 1px solid var(--glass-border); margin: 0.5rem 0;">

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">New Password (leave blank to keep current)</label>
                    <input type="password" name="new_password" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Confirm New Password</label>
                    <input type="password" name="confirm_password" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
