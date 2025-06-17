<?php
// Database connection
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['task_id'] ?? null;

    if ($taskId) {
        // Update task status to 'inprogress'
        $stmt = $conn->prepare("UPDATE tasks SET taskstatus = 'inprogress' WHERE id = ?");
        $stmt->bind_param("i", $taskId);
        
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
    } else {
        echo "invalid";
    }
}
?>
