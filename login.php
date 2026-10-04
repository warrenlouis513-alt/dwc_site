<?php
// =====================================
// Admin Login - David Worship Center
// =====================================

// Show all errors while developing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Hardcoded admin credentials
$adminUser = "admin";
$adminPass = "DWC21378"; // CHANGE TO STRONG PASSWORD

// If already logged in, redirect to admin
if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true){
    header("Location: admin.php");
    exit;
}

$error = '';

// Handle form submission
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if($username === $adminUser && $password === $adminPass){
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - DWC</title>
<style>
body { font-family: Arial; padding:50px; background:#f9f9f9; text-align:center;}
form { display:inline-block; padding:20px; border:1px solid #4B0082; background:#FFD700; border-radius:6px;}
input { padding:10px; margin:10px 0; width:100%; border-radius:6px; border:1px solid #4B0082; }
button { padding:10px 20px; border:none; border-radius:6px; background:#4B0082; color:#FFD700; cursor:pointer;}
button:hover { transform: scale(1.05); }
.error { color:red; margin-bottom:10px; }
</style>
</head>
<body>
<h1>Admin Login - David Worship Center</h1>
<form method="POST" action="">
    <?php if($error) echo "<div class='error'>$error</div>"; ?>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>