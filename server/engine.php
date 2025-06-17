<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_submit"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $stored_password, $role);
        $stmt->fetch();

        if ($password === $stored_password) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: dashboard.php");
            } elseif ($role === 'manager') {
                header("Location: managementdashboard.php");
            } elseif ($role === 'pic') {
                header("Location: picdashboard.php");
            }
            exit;
        } else {
            $_SESSION['flash_message'] = "Wrong password.";
        }
    } else {
        $_SESSION['flash_message'] = "Username not found.";
    }

    $stmt->close();

    // Redirect to clear POST data and show toast
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_submit"])) {
    $picname = $_POST["picname"];
    $taskname = $_POST["taskname"];
    $taskstatus = "todo";
    $createdate = $_POST["createdate"];
    $tasksystem = $_POST["tasksystem"];
    $taskterminal = $_POST["taskterminal"];
    $tasklocation = $_POST["tasklocation"];
    $taskunit = $_POST["taskunit"];
    $taskdescription = $_POST["taskdescription"];

    $stmt = $conn->prepare("INSERT INTO tasks (picname, taskname, taskstatus, createdate, tasksystem, taskterminal, tasklocation, taskunit, taskdescription) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssssss", $picname, $taskname, $taskstatus, $createdate, $tasksystem, $taskterminal, $tasklocation, $taskunit, $taskdescription);

    if ($stmt->execute()) {
        header("Location: dashboard.php?status=success");
        echo "Data saved successfully!";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_submit'])) {
    // form data
    $username = $_POST['newusername'];
    $name = $_POST['newname'];
    $role = $_POST['newuserrole'];
    $password = $_POST['newuserpassword'];

    // check if username exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['flash_message'] = "❌ Username is taken. Try something else.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $role, $name);
        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "✅ User successfully added!";
        } else {
            $_SESSION['flash_message'] = "❌ Error adding user.";
        }
        $stmt->close();
    }
    $check_stmt->close();

    // redirect to clear POST data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $username = $_POST['delete_user'];

    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        alert('User $username deleted successfully.');
        window.location.href = window.location.href;
    </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_submit"])) {
    $task_id = $_POST['task_id'];
    $taskname = $_POST['taskname_edit'];
    $createdate = $_POST['createdate_edit'];
    $picname = $_POST['picname_edit'];
    $tasksystem = $_POST['tasksystem_edit'];
    $taskterminal = $_POST['taskterminal_edit'];
    $tasklocation = $_POST['tasklocation_edit'];
    $taskunit = $_POST['taskunit_edit'];
    $taskdescription = $_POST['taskdescription_edit'];

   $stmt = $conn->prepare("UPDATE tasks SET taskname = ?, createdate = ?, picname = ?, tasksystem = ?, taskterminal = ?, tasklocation = ?, taskunit = ?, taskdescription = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $taskname, $createdate, $picname, $tasksystem, $taskterminal, $tasklocation, $taskunit, $taskdescription, $task_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?status=success");
        echo "Data saved successfully!";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['progress_update'])) {
    $task_id = $_POST['task_id']; // make sure task_id is passed in a hidden input
    $update_status = $_POST['statusupdate'];
    $created_at = $_POST['progressdate'];
    $progress_text = $_POST['progressdescription'];

    $sql = "INSERT INTO task_progress (task_id, update_status, start_date, progress_text) 
            VALUES ('$task_id', '$update_status', '$created_at', '$progress_text')";
    if ($conn->query($sql) === TRUE) {        
        $progress_id = $conn->insert_id;

        if (isset($_FILES['attachments']) && is_array($_FILES['attachments']['name'])) {
            $targetDir = "uploads/tasks/";
        
            foreach ($_FILES['attachments']['name'] as $index => $fileName) {
                $fileTmp = $_FILES['attachments']['tmp_name'][$index];
                $fileError = $_FILES['attachments']['error'][$index];
        
                if (!empty($fileName) && $fileError === UPLOAD_ERR_OK) {
                    $safeName = time() . "_" . basename($fileName);
                    $filePath = $targetDir . $safeName;
        
                    if (move_uploaded_file($fileTmp, $filePath)) {
                        $stmt = $conn->prepare("INSERT INTO task_attachments (progress_id, filename, filepath) VALUES (?, ?, ?)");
                        $stmt->bind_param("iss", $progress_id, $safeName, $filePath);
                        $stmt->execute();
                    } else {
                        echo "Failed to move file: $fileName<br>";
                    }
                } else {
                    echo "Error with file: $fileName<br>";
                }
            }
        } else {
            echo "No files uploaded.";
        }

        header("Location: picdashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
