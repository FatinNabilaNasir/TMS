<?php
include("engine.php");

header('Content-Type: application/json');

$taskId = $_GET['task_id'];
$sql = "SELECT * FROM task_remarks WHERE task_id = '$taskId'";
$result = $conn->query($sql);

$remarks = [];
if ($row = $result->fetch_assoc()) {
    $remarks[] = $row;
}
echo json_encode($remarks);
