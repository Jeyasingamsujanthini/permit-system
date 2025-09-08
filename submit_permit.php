<?php
//backend/submit_permit.php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../user/permitApp1.html");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$permit_type = trim($_POST['permit_type'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($permit_type === '' || $description === '') {
    echo("All fields are required.");
    exit();
}

$stmt = $conn->prepare("INSERT INTO permits (user_id, permit_type, description) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $permit_type, $description);
if ($stmt->execute()) {
    //redirect to user dashboard with success message
    header("Location: ../user/prevAppli.html?submitted=1");
    exit();
} else {
    echo("Failed to submit permit: " . $stmt->error);
}
$stmt->close();
$conn->close();

?>