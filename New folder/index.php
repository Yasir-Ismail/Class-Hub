<?php include 'includes/header.php'; ?>

<section class="hero">
    <h1>Welcome to ClassHub</h1>
    <p>Your all-in-one portal for class management, resources, and real-time updates.</p>
    <a href="announcements.php" class="btn btn-primary">Check Announcements</a>
</section>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 2rem;">
    <!-- Quick Access Cards -->
    <a href="schedule.php" class="glass-card">
        <i class="fas fa-calendar-alt" style="font-size: 2rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
        <h3>Lecture Schedule</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">View your weekly timetable and subject timings.</p>
    </a>

    <a href="lms_reminders.php" class="glass-card">
        <i class="fas fa-tasks" style="font-size: 2rem; color: #fbbf24; margin-bottom: 1rem;"></i>
        <h3>LMS Reminders</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Never miss a quiz or assignment deadline again.</p>
    </a>

    <a href="resources.php" class="glass-card">
        <i class="fas fa-file-pdf" style="font-size: 2rem; color: #ef4444; margin-bottom: 1rem;"></i>
        <h3>Class Resources</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Download lecture slides, PDFs, and past papers.</p>
    </a>

    <a href="faculty.php" class="glass-card">
        <i class="fas fa-chalkboard-teacher" style="font-size: 2rem; color: #10b981; margin-bottom: 1rem;"></i>
        <h3>Faculty Info</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Connect with your teachers and view their profiles.</p>
    </a>

    <a href="gallery.php" class="glass-card">
        <i class="fas fa-images" style="font-size: 2rem; color: #8b5cf6; margin-bottom: 1rem;"></i>
        <h3>Events Gallery</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Explore photos from class trips and achievements.</p>
    </a>

    <a href="rules.php" class="glass-card">
        <i class="fas fa-gavel" style="font-size: 2rem; color: #f43f5e; margin-bottom: 1rem;"></i>
        <h3>Rules & Guidelines</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Stay updated with classroom policies and attendance rules.</p>
    </a>
</div>

<?php include 'includes/footer.php'; ?>
