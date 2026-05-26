<?php session_start(); $loggedIn = isset($_SESSION['user_id']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SmartFix IT Solutions</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="gallery.php">Gallery</a></li>
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

    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Professional Computer Tech &amp; Support</h1>
            <p>
                We provide fast, reliable and affordable computer repair,
                virus removal, data recovery and network installation
                services for homes and businesses.
            </p>
            <a href="contact.php" class="cta-button">Request Support</a>
            <?php if (!$loggedIn): ?>
            <div class="hero-guest-cta">
                <a href="login.php" class="hero-cta-login">Log In</a>
                <a href="register.php" class="hero-cta-register">Get Started ✦</a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="services-preview">
        <h2>Our Core Services</h2>
        <div class="card-container">
            <div class="service-card">
                <h3>💻 Laptop Repair</h3>
                <p>Hardware replacement and advanced software troubleshooting.</p>
            </div>
            <div class="service-card">
                <h3>🛡 Virus Removal</h3>
                <p>Complete malware, spyware and ransomware protection services.</p>
            </div>
            <div class="service-card">
                <h3>🌐 Network Setup</h3>
                <p>Professional home and office WiFi installation and configuration.</p>
            </div>
        </div>
        <div class="services-button">
            <a href="services.php" class="cta-button">View All Services</a>
        </div>
    </section>

    <section class="about home-about">
        <h2>Why Choose SmartFix IT Solutions</h2>
        <div class="about-content">
            <p>
                Our experienced technicians provide reliable and secure IT
                solutions for individuals and businesses. We focus on fast
                service, affordable pricing and long-term technical support.
            </p>
        </div>
        <div class="stats">
            <div class="stat"><h3>500+</h3><p>Devices Repaired</p></div>
            <div class="stat"><h3>98%</h3><p>Customer Satisfaction</p></div>
            <div class="stat"><h3>24/7</h3><p>Support Availability</p></div>
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
