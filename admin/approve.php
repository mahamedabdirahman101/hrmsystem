<?php
// Database credentials (replace with your own)
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'phpadminpanel';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die(json_encode(['success' => false, 'message' => $conn->connect_error])); // Send JSON error
}

// Get the JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data) || count($data) === 0) {
    die(json_encode(['success' => false, 'message' => "No items selected."]));
}

$conn->begin_transaction(); // Start the transaction

$success = true; // Flag to track overall success

foreach ($data as $item) {
  // Sanitize input (VERY IMPORTANT - prevent SQL injection)
  $id = $conn->real_escape_string($item['id']);
  $LeaveId = $conn->real_escape_string($item['leave_id']);
  $name = $conn->real_escape_string($item['name']);
  $leaveType = $conn->real_escape_string($item['leave_type']);
  $startDate = $conn->real_escape_string($item['start_date']);
  $endDate = $conn->real_escape_string($item['end_date']);
  
  $stmt = $conn->prepare("INSERT INTO `approve_leaves` (leave_id, id, name, leave_type, start_date, end_date) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isss", $id,$LeaveId,$name,$leaveType, $startDate, $endDate); // "i" for integer, "s" for string

  if (!$stmt->execute()) {
    $success = false;
    break; // Exit the loop on the first error
  }
  $stmt->close();

  $stmt = $conn->prepare("DELETE FROM `leave_requests` WHERE id = ?");
  $stmt->bind_param("i", $id);

  if (!$stmt->execute()) {
      $success = false;
      break;
  }
  $stmt->close();
}

if ($success) {
  $conn->commit();
  echo json_encode(['success' => true]);
} else {
  $conn->rollback();
  echo json_encode(['success' => false, 'message' => "Error processing items."]); // More specific error message if needed
}

$conn->close();
?>