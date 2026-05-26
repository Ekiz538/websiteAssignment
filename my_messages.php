<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Ensure the new columns exist if the admin hasn't visited the dashboard yet
$conn->query("ALTER TABLE messages ADD COLUMN IF NOT EXISTS admin_reply TEXT NULL");
$conn->query("ALTER TABLE messages ADD COLUMN IF NOT EXISTS replied_at TIMESTAMP NULL");
$conn->query("ALTER TABLE messages ADD COLUMN IF NOT EXISTS user_read_reply TINYINT(1) NOT NULL DEFAULT 1");

$userId = $_SESSION['user_id'];
$conn->query("UPDATE messages SET user_read_reply = 1 WHERE user_id = $userId AND user_read_reply = 0");
$stmt = $conn->prepare("SELECT id, message, sent_at, admin_reply, replied_at FROM messages WHERE user_id = ? ORDER BY sent_at DESC");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$loggedIn = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Messages - SmartFix IT Solutions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <style>
        .messages-container { max-width: 800px; margin: 120px auto 60px; padding: 0 2rem; }
        .message-card { background: #16213e; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .message-card.has-reply { border-top: 4px solid #00d4ff; }
        .message-card.no-reply { border-top: 4px solid #888; }
        .message-body { margin-bottom: 1rem; white-space: pre-wrap; font-size: 1.05rem; }
        .message-meta { font-size: 0.85rem; color: #aaa; margin-bottom: 1rem; }
        .reply-box { background: rgba(0, 212, 255, 0.1); border-left: 4px solid #00d4ff; padding: 1rem; border-radius: 4px; }
        .reply-label { color: #00d4ff; font-weight: bold; margin-bottom: 0.5rem; display: block; }
        .reply-body { white-space: pre-wrap; }
        .reply-meta { font-size: 0.8rem; color: #888; margin-top: 0.5rem; }
        .no-msgs { text-align: center; padding: 3rem; background: #f9f9f9; border-radius: 8px; color: #555; }
        body.dark .no-msgs { background: #16213e; color: #ddd; }
    </style>
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
                <?php if ($loggedIn && $_SESSION['is_admin']): ?>
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                <?php else: ?>
                    <li class="nav-dropdown">
                        <span class="nav-username" style="cursor:pointer;">👤 <?= htmlspecialchars($_SESSION['user_name']) ?> ▾</span>
                        <ul class="dropdown-menu">
                            <li><a href="my_messages.php">My Messages</a></li>
                            <li><a href="logout.php" class="nav-logout">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="messages-container">
        <h2 style="margin-bottom: 2rem; color: #1a1a2e;">💬 My Messages</h2>
        
        <?php if (empty($messages)): ?>
            <div class="no-msgs">
                <h3>You haven't sent any messages yet.</h3>
                <p style="margin-top:1rem;"><a href="contact.php" class="cta-button">Go to Contact Page</a></p>
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-card <?= $msg['admin_reply'] ? 'has-reply' : 'no-reply' ?>">
                    <div class="message-meta">Sent on <?= date('d M Y, h:i A', strtotime($msg['sent_at'])) ?></div>
                    <div class="message-body"><?= htmlspecialchars($msg['message']) ?></div>
                    
                    <?php if ($msg['admin_reply']): ?>
                        <div class="reply-box" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                            <div>
                                <span class="reply-label" style="margin-bottom:0.2rem;">Job Status:</span>
                                <div class="reply-meta" style="margin-top:0;">Updated on <?= date('d M Y, h:i A', strtotime($msg['replied_at'])) ?></div>
                            </div>
                            <div style="font-size:1.1rem;font-weight:bold;background:#00d4ff;color:#1a1a2e;padding:0.4rem 1rem;border-radius:20px;">
                                <?= htmlspecialchars($msg['admin_reply']) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="font-size:0.9rem; color:#aaa; font-style:italic;">Awaiting reply...</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <footer>
        <div class="footer-team">
            <p class="footer-team-title">Project Team</p>
            <span>Tuhaise Given Biheegu</span>
            <span>Oketayot Emmanuel Kisembo</span>
            <span>Mudulo Juliet Zemei</span>
            <span>Monday Davido</span>
            <span>Bwambale Davis</span>
            <span>Katahwire Atwiine Davis</span>
        </div>
        <p class="footer-copy">&copy; 2026 SmartFix IT Solutions. All rights reserved.</p>
    </footer>

    <!-- Dummy Chatbot Icon -->
    <div id="dummy-chatbot" style="position:fixed;bottom:2rem;right:6rem;background:#00d4ff;width:55px;height:55px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 16px rgba(0,212,255,0.4);cursor:pointer;z-index:1000;transition:transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" onclick="alert('Chatbot coming soon!')">
        <span style="font-size:1.6rem;">🤖</span>
    </div>

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
    <script>
        // Make sure h2 adapts to dark mode dynamically
        if(document.body.classList.contains('dark')) {
            document.querySelector('.messages-container h2').style.color = '#e0e0e0';
        }
    </script>
</body>
</html>
