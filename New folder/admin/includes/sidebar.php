<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = getRole();
?>
<!-- Mobile Toggle Button -->
<button class="admin-sidebar-toggle" id="admin-sidebar-toggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Mobile Overlay -->
<div class="admin-sidebar-overlay" id="admin-sidebar-overlay"></div>

<aside class="admin-sidebar" id="admin-sidebar">
    <div class="logo">
        <i class="fas fa-user-shield"></i> <?php echo $role; ?> Panel
    </div>
    
    <nav class="admin-nav">
        <a href="index.php" class="admin-nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="manage_students.php" class="admin-nav-link <?php echo $current_page == 'manage_students.php' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Students
        </a>
        <a href="manage_announcements.php" class="admin-nav-link <?php echo $current_page == 'manage_announcements.php' ? 'active' : ''; ?>">
            <i class="fas fa-bullhorn"></i> Announcements
        </a>
        <a href="manage_reminders.php" class="admin-nav-link <?php echo $current_page == 'manage_reminders.php' ? 'active' : ''; ?>">
            <i class="fas fa-tasks"></i> LMS Reminders
        </a>
        <a href="manage_resources.php" class="admin-nav-link <?php echo $current_page == 'manage_resources.php' ? 'active' : ''; ?>">
            <i class="fas fa-file-upload"></i> Resources
        </a>
        <a href="../profile.php" class="admin-nav-link">
            <i class="fas fa-user-cog"></i> Profile Settings
        </a>
        <!-- Add more links here if needed -->
    </nav>

    <div class="admin-sidebar-footer">
        <a href="../logout.php" class="admin-nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <a href="../index.php" class="admin-nav-link hub-link">
            <i class="fas fa-arrow-left"></i> Back to Hub
        </a>
    </div>
</aside>

<script src="../assets/js/main.js"></script>
