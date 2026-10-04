<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
}

require 'config.php';

// Fetch events
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC")->fetch_all(MYSQLI_ASSOC);

// Fetch messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DWC Admin Panel</title>
<style>
body { font-family: Arial; padding: 20px; background: #f9f9f9; }
h2 { color: #4B0082; }
table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
th, td { border: 1px solid #4B0082; padding: 10px; text-align: left; }
th { background: #FFD700; }
button { padding:5px 10px; border:none; border-radius:5px; cursor:pointer; background:#4B0082; color:#FFD700; }
button:hover { transform: scale(1.05); }
.logout { float:right; margin-bottom:20px; }
</style>
</head>
<body>

<h1>Admin Panel - David Worship Center</h1>
<form action="logout.php" method="POST" class="logout">
    <button type="submit">Logout</button>
</form>

<h2>Events</h2>
<table>
<tr>
<th>ID</th>
<th>Event Name</th>
<th>Date</th>
<th>Location</th>
<th>Description</th>
</tr>
<?php foreach($events as $event): ?>
<tr>
<td><?= $event['id'] ?></td>
<td><?= htmlspecialchars($event['name']) ?></td>
<td><?= $event['event_date'] ?></td>
<td><?= htmlspecialchars($event['location']) ?></td>
<td><?= htmlspecialchars($event['description']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<h2>Messages</h2>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Action</th>
</tr>
<?php foreach($messages as $msg): ?>
<tr>
<td><?= $msg['id'] ?></td>
<td><?= htmlspecialchars($msg['name']) ?></td>
<td><?= htmlspecialchars($msg['email']) ?></td>
<td><?= htmlspecialchars($msg['message']) ?></td>
<td>
    <form action="resend_message.php" method="POST" style="margin:0;">
        <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
        <button type="submit">Resend</button>
    </form>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>