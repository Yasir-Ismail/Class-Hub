<?php 
require_once __DIR__ . '/auth.php'; 

// Forced Login Policy
if (!isLoggedIn() && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassHub - Class Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: var(--primary-color);
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
            border: 1px solid var(--glass-border);
            border-radius: 0.5rem;
            z-index: 1001;
            margin-top: 0.5rem;
            backdrop-filter: blur(10px);
        }
        .dropdown-content a {
            color: var(--text-muted);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
        }
        .dropdown-content a:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
        }
        /* JS handles the display toggle */
        .dropdown-content.show {
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.php" class="logo">
                    <i class="fas fa-graduation-cap"></i> ClassHub
                </a>
                <div class="menu-toggle" id="mobile-menu">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links" id="nav-list">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="announcements.php">Announcements</a></li>
                    <li><a href="schedule.php">Schedule</a></li>
                    <li><a href="lms_reminders.php">LMS</a></li>
                    <li><a href="resources.php">Resources</a></li>
                    <li><a href="faculty.php">Faculty</a></li>
                    
                    <?php if (isLoggedIn()): ?>
                        <?php if (hasRole(['Admin', 'CR/GR'])): ?>
                            <li class="dropdown">
                                <a href="javascript:void(0)" id="profile-dropdown-btn" style="color: var(--text-muted); font-weight: 500;">
                                    <i class="fas fa-user-circle" style="color: var(--accent-color);"></i> <?php echo explode(' ', $_SESSION['full_name'])[0]; ?> <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                                </a>
                                <div class="dropdown-content" id="profile-dropdown-content">
                                    <a href="admin/index.php"><i class="fas fa-tachometer-alt"></i> Admin Panel</a>
                                    <a href="profile.php"><i class="fas fa-user-cog"></i> Profile Settings</a>
                                    <div style="border-top: 1px solid var(--glass-border); margin: 0.5rem 0;"></div>
                                    <a href="logout.php" style="color: #ef4444;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li><a href="profile.php"><i class="fas fa-user-cog"></i> Profile</a></li>
                        <?php endif; ?>
                        
                        <li>
                            <a href="logout.php" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;" title="Logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="login.php" class="btn btn-primary" style="padding: 0.5rem 1rem;">Login <i class="fas fa-sign-in-alt" style="margin-left: 0.3rem;"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
