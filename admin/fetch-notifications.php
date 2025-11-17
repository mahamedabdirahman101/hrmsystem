<?php
include('config/dbcon.php');
header('Content-Type: application/json');

// Get unread count
$countQuery = "SELECT COUNT(*) as unread_count FROM notifications WHERE is_read = 0";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$unreadCount = $countRow['unread_count'];

// Get latest 5 notifications (read or unread)
$notifQuery = "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5";
$notifResult = mysqli_query($con, $notifQuery);

$notifications = [];

while ($row = mysqli_fetch_assoc($notifResult)) {
    $notifications[] = [
        'message' => $row['message'],
        'time' => date('M d, H:i', strtotime($row['created_at'])),
        'is_read' => $row['is_read']
    ];
}

echo json_encode([
    'count' => $unreadCount,
    'notifications' => $notifications
]);
?>
