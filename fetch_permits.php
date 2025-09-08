<?php
// backend/fetch_permits.php
session_start();
include "db.php";
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "not_logged_in"]);
    exit();
}

$user_id = intval($_SESSION['user_id']);
$stmt = $conn->prepare("SELECT id, permit_type, description, status, applied_at FROM permits WHERE user_id = ? ORDER BY applied_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
}
echo json_encode($rows);
$stmt->close();
$conn->close();
?>
