<?php
$host = 'localhost';
$db   = 'smartfix_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;background:#1a1a2e;color:#e74c3c;padding:2rem;text-align:center;">
        <h2>❌ Database Connection Failed</h2>
        <p>Could not connect to the database. Make sure XAMPP MySQL is running and you have run install.php.</p>
    </div>');
}
