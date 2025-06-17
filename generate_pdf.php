<?php
ob_clean(); // Clear any previous output
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'fpdf/fpdf.php';
// No need for FPDI now unless you use it elsewhere

// --- Connect to database ---
$conn = new mysqli("localhost", "root", "", "taskmonitoring");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// --- Get task ID from URL or fallback to first completed task ---
$taskId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

// If no ID given, find the first completed task by ID ascending
if ($taskId === 0) {
    $query = "SELECT id FROM tasks WHERE taskstatus = 'completed' ORDER BY id ASC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $taskId = (int) $result->fetch_assoc()['id'];
    } else {
        die("No completed tasks found.");
    }
}

// --- Fetch the task by ID ---
$query = "SELECT * FROM tasks WHERE id = $taskId AND taskstatus = 'completed'";
$result = $conn->query($query);
if (!$result || $result->num_rows === 0) {
    die("Task not found or not marked as completed.");
}
$task = $result->fetch_assoc();

// --- Fetch latest remark (optional) ---
$remark = '';
$remarkResult = $conn->query("SELECT remark FROM task_remarks WHERE task_id = $taskId ORDER BY id DESC LIMIT 1");
if ($remarkResult && $remarkResult->num_rows > 0) {
    $remark = $remarkResult->fetch_assoc()['remark'];
}

// --- Generate PDF ---
$pdf = new FPDF();
$pdf->AddPage();

// Use the rasterized image as background
$pdf->Image('server/document_page1.png', 0, 0, 210, 297); // A4 dimensions in mm

// --- Set font and style ---
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);

// --- Fill in data ---
$pdf->SetXY(60, 60);   $pdf->Write(0, $task['tasksystem']);     // SYSTEM
$pdf->SetXY(60, 75);   $pdf->Write(0, $task['taskunit']);       // UNIT
$pdf->SetXY(80, 105);  $pdf->Write(0, $task['createdate']);     // DATE

if (!empty($remark)) {
    $pdf->SetXY(60, 110);
    $pdf->MultiCell(150, 7, "\n" . $remark);
}

$pdf->SetXY(60, 165);  $pdf->Write(0, $task['picname']);        // DONE BY
$pdf->SetXY(150, 175); $pdf->Write(0, date("d M Y H:i"));       // DATE & TIME

// --- Output PDF ---
$pdf->Output('I', 'work_card_' . $taskId . '.pdf');
?>