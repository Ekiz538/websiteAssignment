<?php session_start(); $loggedIn = isset($_SESSION['user_id']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials - SmartFix IT Solutions</title>
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
                <li><a href="testimonials.php" class="active">Testimonials</a></li>
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

    <section id="testimonials" class="testimonials-page">
        <h2>What Our Clients Say</h2>
        <div class="testimonials-intro">
            <p>
                We take pride in delivering reliable and professional IT support.
                Here is what some of our satisfied clients say about our services.
            </p>
        </div>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Excellent service! They fixed my laptop in no time. Very professional and affordable."</p>
                <h4>Tuhaise Given Biheegu</h4><span>Small Business Owner</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Best IT support team I've worked with. They set up our entire office network flawlessly."</p>
                <h4>Oketayot Emmanuel Kisembo</h4><span>Corporate Manager</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Fast response time and great customer service. Highly recommend for any tech issues!"</p>
                <h4>Mudulo Juliet Zemei</h4><span>Freelancer</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★</div>
                <p>"Recovered all my important files after a hard drive crash. True lifesavers!"</p>
                <h4>Monday Davido</h4><span>Photographer</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"Professional, knowledgeable, and friendly. They explain everything in simple terms."</p>
                <h4>Bwambale Davis</h4><span>Teacher</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p>"24/7 support is a game changer. They're always there when we need them most."</p>
                <h4>Katahwire Atwiine Davis</h4><span>Restaurant Owner</span>
            </div>
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
