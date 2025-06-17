<?php
include("engine.php");

$taskId = $_GET['task_id'];
$sql = "SELECT * FROM task_progress WHERE task_id = '$taskId' ORDER BY start_date ASC";
$result = $conn->query($sql);

$progress = [];
while ($row = $result->fetch_assoc()) {
    $progress[] = $row;
}
echo json_encode($progress);
