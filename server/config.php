<?php
$host = 'sql106.infinityfree.com'; // InfinityFree database host
$user = 'if0_39242920';            // Your account username
$pass = 'kgLOVNWNoDmdR3';      // Use the password shown in your InfinityFree panel
$dbname = 'if0_39242920_taskmonitoring'; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
