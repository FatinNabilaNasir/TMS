<?php

include("server/engine.php");

require 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

// Load the DOCX template
$template = new TemplateProcessor('uploads/Document MWC.docx');

$pdo = new PDO('mysql:host=localhost;dbname=taskmonitoring', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get report ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID.");
}
$reportId = (int)$_GET['id'];

// Fetch report info
$reportStmt = $pdo->prepare("SELECT t.picname, t.createdate, t.tasksystem, t.taskterminal, t.tasklocation, t.taskunit, (SELECT MIN(created_at) 
                            FROM task_progress WHERE task_id = t.id) AS min_start_date FROM tasks t WHERE t.id = ?");
$reportStmt->execute([$reportId]);
$detail = $reportStmt->fetch(PDO::FETCH_ASSOC);

$minStartDateFormatted = $detail['min_start_date'] ? date('d-m-Y', strtotime($detail['min_start_date'])) : '';

$template->setValue('system', htmlspecialchars($detail['tasksystem']));
$template->setValue('start_date', htmlspecialchars($minStartDateFormatted));
$template->setValue('location', htmlspecialchars($detail['tasklocation']));
$template->setValue('unit', htmlspecialchars($detail['taskunit']));
$template->setValue('terminal', htmlspecialchars($detail['taskterminal']));

$reportStmt = $pdo->prepare("SELECT tasks.*, users.name AS pic_name FROM tasks LEFT JOIN users ON tasks.picname = users.username 
                            WHERE tasks.id = ?");
$reportStmt->execute([$reportId]);
$name = $reportStmt->fetch(PDO::FETCH_ASSOC);

$template->setValue('client', htmlspecialchars($name['pic_name']));

$reportStmt = $pdo->prepare("SELECT remark, completed_date FROM task_remarks WHERE task_id = ?");
$reportStmt->execute([$reportId]);
$report = $reportStmt->fetch(PDO::FETCH_ASSOC);

$completedDateFormatted = $report['completed_date'] ? date('d-m-Y', strtotime($report['completed_date'])) : '';

$template->setValue('remark', htmlspecialchars($report['remark']));
$template->setValue('end_date', htmlspecialchars($completedDateFormatted));

$reportStmt = $pdo->prepare("SELECT id, progress_text, update_status, start_date FROM task_progress WHERE task_id = ? ORDER BY start_date ASC");
$reportStmt->execute([$reportId]);
$items = $reportStmt->fetchALL(PDO::FETCH_ASSOC);

$template->cloneRow('progress', count($items));

foreach (array_values($items) as $i => $item) {
    $index = $i + 1;

    $createdAtFormatted = $item['start_date'] ? date('d-m-Y', strtotime($item['start_date'])) : '';

    $template->setValue("pdate#{$index}", htmlspecialchars($createdAtFormatted));
    $template->setValue("progress#{$index}", htmlspecialchars($item['progress_text']));
    $template->setValue("update#{$index}", htmlspecialchars($item['update_status']));

    $reportStmt = $pdo->prepare("SELECT filepath FROM task_attachments WHERE progress_id = ? LIMIT 1");
    $reportStmt->execute([$item['id']]);
    $imagePath = $reportStmt->fetchColumn();

    $isValidImage = false;
    if ($imagePath && file_exists($imagePath) && is_readable($imagePath)) {
        $fileInfo = getimagesize($imagePath);
        if ($fileInfo !== false) {
            $isValidImage = true;
        }
    }

    if ($isValidImage) {
        $template->setImageValue("image#{$index}", [
            'path' => $imagePath,
            'width' => 300,
            'height' => 200,
            'ratio' => true,
        ]);
    } else {
        $template->setValue("image#{$index}", 'No attachment');
    }
}

// Save the filled report
$outputFile = "generated_report.docx";
$template->saveAs($outputFile);

$pdfFile = "generated_report.pdf";

// Sanitize paths if needed
$docxPath = escapeshellarg(realpath($outputFile));
$outputDir = escapeshellarg(dirname(__FILE__));

// Windows (if needed):
$command = "soffice --headless --convert-to pdf $docxPath --outdir $outputDir";

exec($command, $output, $result);

// ==== STEP 3: Output HTML + JS to open PDF and trigger print ====

if (file_exists($pdfFile)) {
    echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Printing...</title>
</head>
<body>
    <p>Report is being prepared for printing...</p>
    <script>
        const printWindow = window.open('$pdfFile', '_blank');
        if (printWindow) {
            printWindow.onload = function() {
                printWindow.print();
            };
            // Close the current window after opening the print window
            setTimeout(function() {
                window.close();
            }, 1000); // Delay to ensure the new window has time to open
        } else {
            alert("Popup blocked. Please allow popups to print the report.");
        }
    </script>
</body>
</html>
HTML;
} else {
    echo " PDF generation failed. Check LibreOffice setup.";
}