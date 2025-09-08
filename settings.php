<?php
// backend/admin/settings.php
require_once("../utils/auth.php");
require_admin();
include_once("../db.php");

$admin_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $new_password = $_POST['password'] ?? '';

    if ($name === '' || $email === '') {
        echo "Name & email required";
        exit();
    }

    // ensure email not used by other user
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $admin_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Email already in use.";
        exit();
    }
    $stmt->close();

    if ($new_password !== '') {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $hash, $admin_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $admin_id);
    }
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        $_SESSION['email'] = $email;
        header("Location: ../../admin/settings.html?updated=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
header("Location: ../../admin/settings.html");
exit();
?>
