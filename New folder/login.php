<?php 
ob_start();
require_once 'includes/auth.php';
if (isLoggedIn() && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (in_array($_SESSION['role'], ['Admin', 'CR/GR'])) {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->execute([$username, $role]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        // Redirect based on role
        session_write_close();
        if (in_array($user['role'], ['Admin', 'CR/GR'])) {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = 'Invalid credentials for the selected role.';
        // Debug Log (can be removed later)
        if (!$user) {
            $error .= " (No user found with username: $username and role: $role)";
        } else {
            $error .= " (Password mismatch)";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClassHub</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
        }
        
        input:focus, select:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
        }
        
        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding: 2rem 1rem;
            }
            
            .login-container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="glass-card login-container">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="logo" style="justify-content: center; margin-bottom: 1rem; font-size: 2rem;">
                <i class="fas fa-graduation-cap"></i> ClassHub
            </div>
            <h2 style="margin-top: 1rem;">Welcome Back</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Please login to your account</p>
        </div>

        <?php if ($error): ?>
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.2); font-size: 0.9rem; text-align: center;">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-size: 0.85rem; font-weight: 500; color: var(--text-muted);">Select Role</label>
                <select name="role" required style="width: 100%; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                    <option value="Student" selected>Student</option>
                    <option value="Teacher">Teacher</option>
                    <option value="CR/GR">CR/GR</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-size: 0.85rem; font-weight: 500; color: var(--text-muted);">Username</label>
                <div style="position: relative;">
                    <i class="fas fa-user" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="text" name="username" required placeholder="Username" style="width: 100%; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem 0.75rem 0.75rem 2.8rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <label style="font-size: 0.85rem; font-weight: 500; color: var(--text-muted);">Password</label>
                <div style="position: relative;">
                    <i class="fas fa-key" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="password" name="password" required placeholder="Password" style="width: 100%; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem 0.75rem 0.75rem 2.8rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem;">Sign In</button>
        </form>
    </div>
</body>
</html>
