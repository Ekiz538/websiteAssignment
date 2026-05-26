<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    echo json_encode(['unread' => 0]);
    exit;
}

require 'db.php';

// Ensure column exists to avoid errors on pages where db isn't hit first
$conn->query("ALTER TABLE messages ADD COLUMN IF NOT EXISTS user_read_reply TINYINT(1) NOT NULL DEFAULT 1");

$userId = (int)$_SESSION['user_id'];
$stmt = $conn->prepare("SELECT COUNT(*) FROM messages WHERE user_id = ? AND user_read_reply = 0");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($unreadCount);
$stmt->fetch();
$stmt->close();

echo json_encode(['unread' => $unreadCount]);
