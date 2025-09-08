<?php
// backend/admin/view_reports.php
require_once("../utils/auth.php");
require_admin();
include_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add_report') {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        if ($title !== '' && $content !== '') {
            $stmt = $conn->prepare("INSERT INTO reports (report_title, report_content) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $content);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($action === 'delete_report') {
        $rid = intval($_POST['report_id'] ?? 0);
        if ($rid > 0) {
            $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
            $stmt->bind_param("i", $rid);
            $stmt->execute();
            $stmt->close();
        }
    }
    header("Location: ../../admin/reports.html");
    exit();
}

// For GET JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $res = $conn->query("SELECT * FROM reports ORDER BY created_at DESC");
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rows);
    exit();
}
header("Location: ../../admin/reports.html");
exit();
?>
