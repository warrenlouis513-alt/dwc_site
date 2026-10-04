<?php
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit;
}

require 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])){
    $id = intval($_POST['message_id']);
    $res = $conn->query("SELECT * FROM messages WHERE id=$id");
    if($res->num_rows){
        $msg = $res->fetch_assoc();
        // For now, just display success
        // You could add mail() here to actually resend
        echo "Message from {$msg['name']} would be resent.";
    }
}

header("Location: admin.php");
exit;