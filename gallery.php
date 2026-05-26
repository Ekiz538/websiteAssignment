<?php session_start(); $loggedIn = isset($_SESSION['user_id']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - SmartFix IT Solutions</title>
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
                <li><a href="gallery.php" class="active">Gallery</a></li>
                <li><a href="testimonials.php">Testimonials</a></li>
                <li><a href="contact.php">Contact</a></li>
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

    <section id="gallery" class="gallery-page">
        <h2>Our Work</h2>
        <div class="gallery-intro">
            <p>
                Explore some of the technical solutions and support services
                we provide for homes, offices and businesses. These samples
                represent our work in repair, setup, maintenance and IT support.
            </p>
        </div>
        <div class="gallery-grid">
            <div class="gallery-item"><img src="images/gallery/server.jpg"      alt="Server Setup"></div>
            <div class="gallery-item"><img src="images/gallery/network.jpg"     alt="Network Installation"></div>
            <div class="gallery-item"><img src="images/gallery/hardware.jpg"    alt="Hardware Repair"></div>
            <div class="gallery-item"><img src="images/gallery/data.jpg"        alt="Data Center"></div>
            <div class="gallery-item"><img src="images/gallery/workstation.jpg" alt="Workstation Setup"></div>
            <div class="gallery-item"><img src="images/gallery/support.jpg"     alt="Tech Support"></div>
        </div>
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
