<?php
header('Content-Type: application/json');
include 'dbcon.php';
// $conn = new mysqli('epiz_34301861_discuss', 'root', '', 'chat_db');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed.']));
}

$result = $conn->query('SELECT username, message FROM messages ORDER BY created_at ASC');
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$conn->close();

echo json_encode(['success' => true, 'messages' => $messages]);
?>
