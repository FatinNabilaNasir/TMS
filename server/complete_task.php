<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'] ?? null;
    $remark = trim($_POST['remark'] ?? '');
    $completedDate = $_POST['completedDate'];

    if (!$taskId || $remark === '') {
        echo "Missing task ID or remark.";
        exit;
    }

    // Insert into task_remarks
    $stmt = $conn->prepare("INSERT INTO task_remarks (task_id, remark, completed_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $taskId, $remark, $completedDate);
    $stmt->execute();


    // Update task status
    $update = $conn->prepare("UPDATE tasks SET taskstatus = 'completed' WHERE id = ?");
    $update->bind_param("i", $taskId);
    $update->execute();

    // echo "Task marked as completed with remark.";
}
?>
