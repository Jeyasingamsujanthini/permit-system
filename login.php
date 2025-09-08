<?php
// backend/login.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../frontend/login.html");
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Email and password are required.");
}

$stmt = $conn->prepare("SELECT id, name, email, password FROM users_p WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        // successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        // redirect to user page
        header("Location: ../frontend/user/permit.html");
        exit();
    } else {
        die("Invalid email or password.");
    }
} else {
    die("Invalid email or password.");
}

$stmt->close();
$conn->close();
?>