<?php
include('config/dbcon.php');

// Update all unread notifications to mark them as read
$query = "UPDATE notifications SET is_read = 1 WHERE is_read = 0";
mysqli_query($con, $query);

// Return a simple success response
echo json_encode(['status' => 'success']);
?>
