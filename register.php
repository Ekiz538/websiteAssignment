<?php
session_start();
require 'db.php';

$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS phone VARCHAR(30) NULL AFTER email");

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if (!$name || !$email || !$password || !$confirm) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'An account with that email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins  = $conn->prepare('INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)');
            $ins->bind_param('ssss', $name, $email, $phone, $hash);
            $ins->execute();
            $success = 'Account created! <a href="login.php">Log in here</a>.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartFix IT Solutions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>

    <header>
        <nav>
            <div class="logo">
                <a href="index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <img src="images/favicon.png" alt="Logo" style="height: 45px;">
                    <span>SmartFix</span>
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
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php" class="nav-getstarted">Get Started</a></li>
            </ul>
        </nav>
    </header>

    <section class="contact-page">
        <h2>Create an Account</h2>

        <?php if ($error): ?>
            <div style="max-width:500px;margin:0 auto 1.5rem;padding:1rem 1.5rem;background:#fdecea;border-left:4px solid #e74c3c;border-radius:6px;color:#c0392b;font-weight:500;">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="max-width:500px;margin:0 auto 1.5rem;padding:1rem 1.5rem;background:#e8f8ff;border-left:4px solid #00d4ff;border-radius:6px;color:#007a99;font-weight:500;">
                ✅ <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form class="contact-form" method="POST" action="register.php">
            <input type="text"     name="name"     placeholder="Full Name"        required>
            <input type="email"    name="email"    placeholder="Email Address"    required>
            <input type="tel"      name="phone"    placeholder="Phone Number (Optional)">
            <input type="password" name="password" placeholder="Password (min 6)" required>
            <input type="password" name="confirm"  placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>

        <p style="text-align:center;margin-top:1rem;color:#444;">
            Already have an account? <a href="login.php" style="color:#00d4ff;">Log in</a>
        </p>
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

    <script src="script.js"></script>
</body>
</html>
