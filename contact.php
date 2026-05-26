<?php
session_start();
require 'db.php';

$loggedIn = isset($_SESSION['user_id']);
$success  = '';
$error    = '';

if (isset($_SESSION['contact_success'])) {
    $success = $_SESSION['contact_success'];
    unset($_SESSION['contact_success']);
}

if ($loggedIn && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    // Fetch the user's name, email, and phone from the database
    $stmtUser = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
    $stmtUser->bind_param('i', $_SESSION['user_id']);
    $stmtUser->execute();
    $stmtUser->bind_result($name, $email, $phone);
    $stmtUser->fetch();
    $stmtUser->close();

    if (!$message) {
        $error = 'Please describe your issue.';
    } else {
        $stmt = $conn->prepare(
            'INSERT INTO messages (user_id, name, email, phone, message) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('issss', $_SESSION['user_id'], $name, $email, $phone, $message);
        $stmt->execute();
        $stmt->close();
        $_SESSION['contact_success'] = "✅ Message sent! We'll get back to you soon.";
        header('Location: contact.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - SmartFix IT Solutions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>

    <header>
        <nav>
            <div class="logo">
                <a href="index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <img src="images/favicon.png" alt="Logo" style="height: 45px;">
                    <span><span class="logo-full">SmartFix IT Solutions</span><span class="logo-short">SmartFix</span></span>
                </a>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">☰ Menu</label>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="testimonials.php">Testimonials</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <?php if ($loggedIn && $_SESSION['is_admin']): ?>
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                <?php elseif ($loggedIn): ?>
                    <li class="nav-dropdown">
                        <span class="nav-username" style="cursor:pointer;">👤 <?= htmlspecialchars($_SESSION['user_name']) ?> ▾</span>
                        <ul class="dropdown-menu">
                            <li><a href="my_messages.php">My Messages</a></li>
                            <li><a href="logout.php" class="nav-logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-getstarted">Get Started</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section id="contact" class="contact-page">
        <h2>Contact Us</h2>

        <div class="contact-intro">
            <p>
                Need technical assistance or have a question about our services?
                Our support team is ready to help. Fill out the form below and
                we will get back to you as soon as possible.
            </p>
        </div>

        <?php if ($loggedIn): ?>

            <?php if ($success): ?>
                <div style="max-width:500px;margin:0 auto 1.5rem;padding:1rem 1.5rem;background:#e8f8ff;border-left:4px solid #00d4ff;border-radius:6px;color:#007a99;font-weight:500;">
                    ✅ <?= htmlspecialchars($success) ?>
                </div>
            <?php elseif ($error): ?>
                <div style="max-width:500px;margin:0 auto 1.5rem;padding:1rem 1.5rem;background:#fdecea;border-left:4px solid #e74c3c;border-radius:6px;color:#c0392b;font-weight:500;">
                    ❌ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!$success): ?>
            <div class="contact-box">
                <form class="contact-form" method="POST" action="contact.php">
                    <textarea           name="message" placeholder="Describe your issue" rows="5" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
            <?php endif; ?>

        <?php else: ?>

            <div style="text-align:center;padding:2rem;background:#f9f9f9;border-radius:10px;max-width:500px;margin:0 auto;">
                <p style="font-size:1.1rem;color:#444;margin-bottom:1.5rem;">
                    You need to be logged in to send a message.
                </p>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <a href="login.php" class="cta-button">Log In</a>
                    <a href="register.php" class="cta-button" style="background:#1a1a2e;color:#00d4ff;border:2px solid #00d4ff;">Register</a>
                </div>
            </div>

        <?php endif; ?>

    </section>

    <footer>
        <div class="footer-bottom">
            <div class="footer-team">
                <p class="footer-team-title">Project Team</p>
                <div class="names-grid">
                    <span>Tuhaise Given Biheegu</span>
                    <span>Oketayot Emmanuel Kisembo</span>
                    <span>Mudulo Juliet Zemei</span>
                    <span>Monday Davido</span>
                    <span>Bwambale Davis</span>
                    <span>Katahwire Atwiine Davis</span>
                </div>
            </div>
            <div class="footer-contact-info">
                <p>📞 +256 700 123456</p>
                <p>✉️ <a href="mailto:support@smartfixitsolutions.com">support@smartfixitsolutions.com</a></p>
                <p>📍 Kampala, Uganda</p>
            </div>
        </div>
        <p class="footer-copy">&copy; 2026 SmartFix IT Solutions. All rights reserved.</p>
    </footer>

    <!-- Dummy Chatbot Icon -->
    <div id="dummy-chatbot" style="position:fixed;bottom:2rem;right:6rem;background:#00d4ff;width:55px;height:55px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(0,212,255,0.4);cursor:pointer;z-index:1000;transition:transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" onclick="alert('Chatbot coming soon!')">
        <span style="font-size:1.6rem;">🤖</span>
    </div>

    <script src="script.js"></script>
</body>
</html>
