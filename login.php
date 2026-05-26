<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ' . ($_SESSION['is_admin'] ? 'admin/dashboard.php' : 'index.php'));
    exit;
}

require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$email || !$password) {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, name, password, is_admin FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $name, $hash, $is_admin);
        $stmt->fetch();
        $stmt->close();

        if ($id && password_verify($password, $hash)) {
            $_SESSION['user_id']   = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin']  = (bool) $is_admin;
            header('Location: ' . ($is_admin ? 'admin/dashboard.php' : 'index.php'));
            exit;
        } else {
            $error = 'Incorrect email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartFix IT Solutions</title>
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
                <li><a href="login.php" class="nav-getstarted active">Get Started</a></li>
            </ul>
        </nav>
    </header>

    <section class="contact-page">
        <h2>Log In</h2>

        <?php if ($error): ?>
            <div style="max-width:500px;margin:0 auto 1.5rem;padding:1rem 1.5rem;background:#fdecea;border-left:4px solid #e74c3c;border-radius:6px;color:#c0392b;font-weight:500;">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form class="contact-form" method="POST" action="login.php">
            <input type="email"    name="email"    placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password"      required>
            <button type="submit">Log In</button>
        </form>

        <p style="text-align:center;margin-top:1rem;color:#444;">
            No account yet? <a href="register.php" style="color:#00d4ff;">Register here</a>
        </p>
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
    </footer>

    <script src="script.js"></script>
</body>
</html>
