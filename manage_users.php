<?php
// backend/admin/manage_users.php
require_once("../utils/auth.php");
require_admin();
include_once("../db.php");

// Handle POST actions: delete or change role
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $uid = intval($_POST['user_id'] ?? 0);
        if ($uid > 0) {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: ../../admin/manage-user.html");
        exit();
    } elseif ($action === 'change_role') {
        $uid = intval($_POST['user_id'] ?? 0);
        $role = $_POST['role'] ?? 'user';
        if ($uid > 0 && in_array($role, ['user','admin'])) {
            $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->bind_param("si", $role, $uid);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: ../../admin/manage-user.html");
        exit();
    }
}

// GET: output user list for admin pages (you can include this file or fetch directly)
$result = $conn->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
$users = [];
while ($r = $result->fetch_assoc()) $users[] = $r;

// if this file is requested directly return JSON (optional)
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($users);
    exit();
}

// otherwise include admin HTML page or redirect to admin manage page
header("Location: ../../admin/manage-user.html");
exit();
?>
