<?php
// backend/update_profile.php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../user/profile.html");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$new_password = $_POST['password'] ?? '';

if ($name === '' || $email === '') {
    echo "Name and email required.";
    exit();
}

// check email not used by someone else
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Email already used by another account.";
    exit();
}
$stmt->close();

if ($new_password !== '') {
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $hash, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['user_name'] = $name;
    $_SESSION['email'] = $email;
    header("Location: ../user/profile.html?updated=1");
    exit();
} else {
    echo "Error updating profile: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
