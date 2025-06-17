<?php
include 'config.php';

if (isset($_GET['progress_id'])) {
    $progress_id = intval($_GET['progress_id']);
    $stmt = $conn->prepare("SELECT filename, filepath FROM task_attachments WHERE progress_id = ?");
    $stmt->bind_param("i", $progress_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attachments = [];
    while ($row = $result->fetch_assoc()) {
        $attachments[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($attachments);
}
?>
