<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

$success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $message])) {
        $success = true;
    }
}
?>

<section style="padding: 4rem 0;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 4rem; align-items: start;">
        <div>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Get In Touch</h1>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Have a question or feedback? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; border-radius: 50%; color: var(--accent-color);">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 0.25rem;">Our Location</h4>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">Education Block, Main Campus.</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #10b981;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 style="margin-bottom: 0.25rem;">Email Support</h4>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">support@classhub.edu</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <?php if ($success): ?>
                <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; border: 1px solid rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-check-circle"></i> Thank you! Your feedback has been received.
                </div>
            <?php endif; ?>

            <form action="contact.php" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Full Name</label>
                    <input type="text" name="name" required placeholder="Enter your name" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none; border-color: var(--glass-border);">
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="font-size: 0.9rem; font-weight: 500;">Message / Suggestion</label>
                    <textarea name="message" required rows="5" placeholder="What's on your mind?" style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--glass-border); padding: 0.75rem; border-radius: 0.5rem; color: white; outline: none; resize: vertical;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<style>
    input:focus, textarea:focus {
        border-color: var(--accent-color) !important;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
    }
</style>
