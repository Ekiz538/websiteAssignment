<?php session_start(); $loggedIn = isset($_SESSION['user_id']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn more about SmartFix IT Solutions, a trusted provider of IT support and computer repair services.">
    <title>About - SmartFix IT Solutions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>

    <header>
        <nav aria-label="Main Navigation">
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
                <li><a href="about.php" class="active">About</a></li>
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

    <main>
        <section id="about" class="about-page">
            <h2>About Us</h2>
            <div class="about-page-content">
                <p>
                    SmartFix IT Solutions is a trusted computer repair and IT support company
                    dedicated to helping individuals and businesses solve technology
                    problems quickly and professionally. With over 15 years of experience,
                    our certified technicians provide fast, affordable and reliable
                    solutions for hardware, software and networking issues.
                </p>
                <p>
                    We believe technology should support productivity, not slow it down.
                    That is why we focus on quality service, honest communication and
                    long-term customer satisfaction.
                </p>
            </div>

            <div class="about-highlights">
                <div class="highlight-box">
                    <h3>Our Mission</h3>
                    <p>To provide dependable, affordable and secure IT support services that help clients stay connected and productive.</p>
                </div>
                <div class="highlight-box">
                    <h3>Our Vision</h3>
                    <p>To become the most trusted computer repair and technical support provider for homes and businesses in our community.</p>
                </div>
                <div class="highlight-box">
                    <h3>Our Values</h3>
                    <p>Professionalism, reliability, customer satisfaction, innovation and data security guide every service we provide.</p>
                </div>
            </div>

            <div class="stats">
                <div class="stat"><h3>5000+</h3><p>Happy Clients</p></div>
                <div class="stat"><h3>24/7</h3><p>Support Available</p></div>
                <div class="stat"><h3>15+</h3><p>Years Experience</p></div>
                <div class="stat"><h3>98%</h3><p>Success Rate</p></div>
            </div>
        </section>
    </main>

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
