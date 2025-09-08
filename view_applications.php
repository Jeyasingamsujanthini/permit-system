<?php
// backend/admin/view_applications.php
require_once("../utils/auth.php");
require_admin();
include_once("../db.php");

// Handle POST for update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'update_status') {
        $permit_id = intval($_POST['permit_id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';
        if ($permit_id > 0 && in_array($status, ['pending','approved','rejected'])) {
            $stmt = $conn->prepare("UPDATE permits SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $permit_id);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($action === 'delete_permit') {
        $permit_id = intval($_POST['permit_id'] ?? 0);
        if ($permit_id > 0) {
            $stmt = $conn->prepare("DELETE FROM permits WHERE id = ?");
            $stmt->bind_param("i", $permit_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    header("Location: ../../admin/view-applications.html");
    exit();
}

// For AJAX: return JSON of all permits
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $q = "SELECT p.id, p.permit_type, p.description, p.status, p.applied_at, u.id as user_id, u.name as user_name, u.email as user_email
          FROM permits p JOIN users u ON p.user_id = u.id
          ORDER BY p.applied_at DESC";
    $res = $conn->query($q);
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rows);
    exit();
}

// otherwise redirect to admin page
header("Location: ../../admin/view-applications.html");
exit();
?>
