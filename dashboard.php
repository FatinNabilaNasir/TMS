<?php 
include("server/engine.php");
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
} else {
    $message = "";
}
?>
<!doctype html>
<html>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="../assets/favicon-are-new-67x67.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <title>
        Admin |  AR Eastern Sdn Bhd
    </title>
    
  </head>
  <body>
    <!-- LOGO AR EASTERN -->
    <div class="header"></div>
    <img class="logo" src="assets/img/logo-are-website-612x150.png" alt="AR Eastern Sdn Bhd" style="height: 4.4rem; margin-top: -80px;">

    <form method="post" >
    <a href="logout.php" title="Logout" class="logout-icon" >
    <i class="fa fa-sign-out"></i></a>
    </form>

<button class="user-icon-btn" onclick="openUserListPopup()" aria-label="User">
  <!-- Person (user) icon in same style as add-user -->
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" focusable="false">
    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm89.6 32h-11.5c-22.4 10.3-47.3 16-73.6 16s-51.2-5.7-73.6-16H143.9C64.4 288 0 352.4 0 431.9c0 17.4 14.1 32.1 31.6 32.1H416.4c17.4 0 31.6-14.7 31.6-32.1C448 352.4 383.6 288 313.6 288z"/>
  </svg>
</button>
    </div>
   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon-are.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </body>
</html>

<!-- User List form -->
   <div class="popup6" id="popup6" style="padding-top: 0px;">
    <div class="fixedtitle">
        <span class="close" onclick="closeUserListPopup()">&times;</span>

    <h5 style="font-weight: bold;">User List</h5>
  </div>
<?php
$query = "SELECT username, name, role FROM users ORDER BY username ASC";
$result = $conn->query($query);

if ($result->num_rows > 0):
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<tr>
            <th style='text-align: left; padding: 9px;'>Username</th>
            <th style='text-align: left; padding: 9px;'>Name</th>
            <th style='text-align: left; padding: 9px;'>Role</th>
            <th style='text-align: center; padding: 9px;'>Delete?</th>
          </tr>";

    while ($row = $result->fetch_assoc()):
        $username = htmlspecialchars($row['username']);
        $name = htmlspecialchars($row['name']);
        $role = htmlspecialchars($row['role']);

        echo "<tr>
                <td style='padding: 8px;'>$username</td>
                <td style='padding: 8px;'>$name</td>
                <td style='padding: 8px;'>$role</td>
                <td style='padding: 8px; text-align: center;'>
                    <form method='POST' class='delete-user-form' data-username='$username'>
                        <input type='hidden' name='delete_user' value='$username'>
                        <button type='button' class='btn-deleteuser' title='Delete' style='background:none; border:none; cursor:pointer;'>
            <i class='fa fa-trash' style='color: red;'></i>
                    </form>
                </td>
              </tr>";
    endwhile;

    echo "</table>";
endif;
?>
<div id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
  <div style="background:white; padding:20px; border-radius:8px; text-align:center; width:300px;">
    <p id="confirmMessage"></p>
    <button id="confirmYes" style="margin-right: 10px;">Yes</button>
    <button id="confirmNo">No</button>
  </div>
</div>
       <button class="icon-button" onclick="openAddUserPopup()">
  <!-- SVG user-plus icon -->
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm51.2 48H172.8C77.4 304 0 381.4 0 476.8C0 497.7 14.3 512 32 512H416c17.7 0 32-14.3 32-32c0-95.4-77.4-172.8-172.8-172.8zM616 208H560V152c0-13.3-10.7-24-24-24s-24 10.7-24 24v56H456c-13.3 0-24 10.7-24 24s10.7 24 24 24h56v56c0 13.3 10.7 24 24 24s24-10.7 24-24V256h56c13.3 0 24-10.7 24-24s-10.7-24-24-24z"/>
  </svg>
</button>
</div>


<!-- Add User form -->
    <div class="popup7" id="popup7" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeAddUserPopup()">&times;</span>
    <h5 style="font-weight: bold;">Add User</h5>
        </div>
    <form method="POST" id="addUserForm" action=""></form>

    <label for="usernamenew"><b>Username:</b></label>
    <input type="text" id="newusername" name="newusername" placeholder="Input Username" required />

    <label for="namenew"><b>Name:</b></label>
    <input type="text" id="newname" name="newname" placeholder="Input Name" required />

    <label>Role:</label>
    <select name="newuserrole" id="newuserrole" class="styled-dropdown" required>
      <option value="">-- Select Role --</option>
      <option value="admin">Admin</option>
      <option value="pic">PIC</option>
      <option value="manager">Manager</option>
    </select>

    <label for="passwordnew"><b>Password:</b></label>
    <input type="password" id="newuserpassword" name="newuserpassword" placeholder="Input Password" required />

    <br><br>

    <button type="submit" name="user_submit" class="btn-adduser" id="newuser">Add User</button>
</form>
</div>

<?php if (!empty($message)): ?>
<?php if (!empty($message)): ?>
<div id="toast" class="toast-message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
    <?= $message ?>
</div>
<?php endif; ?>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast');
        if (toast) toast.style.display = 'none';
    }, 4000);
</script>
<?php endif; ?>

<div class="content">
<div class="main-content" id="mainContent">
    <div class="container">
        <div class="row">
            <!-- To Do -->
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="nomove">
                        <h4 class="header-title" style="margin-top:10px; font-weight: bold;">
                            To Do
                        </h4>
                    </div>

                    <div class="scroll-container" style="margin-top: 6px; background-color: transparent; margin-top: -16px;" >
                        <form method="get">
                            <div class="dropdown3">
                                <button type="button" onclick="myFunction3()" class="dropbtn btn-filter " style="margin-bottom: 15px;">
                                    <i class="fa fa-filter"></i>
                                </button>
                                <div id="myDropdown3" class="dropdown-content" style="margin-bottom: 10px;">
                                    <input type="text" name="search3" placeholder="Search.." id="myInput3"
                                        onkeyup="filterFunction3()" value="<?= isset($_GET['search3']) ? htmlspecialchars($_GET['search3']) : '' ?>"
                                        class="form-control3">
                                         <button type="button" onclick="clearSearch('search3', 'myInput3', 'myFunction3')" id="clearBtn3"
                                            style="position: absolute; right: 10px; top: 17.5%; transform: translateY(-50%);
                                                    background: transparent; border: none; font-size: 16px; color: black; cursor: pointer;">
                                            &times;
                                        </button>
                                        </button>
                                </div>
                            </div>
                        </form>   
                    <!-- fetch database -->
                    <?php
                        $search = isset($_GET['search3']) ? $conn->real_escape_string($_GET['search3']) : '';
                        $sql = "SELECT * FROM tasks WHERE taskstatus = 'todo'";
                        if (!empty($search)) {
                            $sql .= " AND (picname LIKE '%$search%' OR taskname LIKE '%$search%' OR taskterminal LIKE '%$search%' OR tasklocation LIKE '%$search%' OR taskunit LIKE '%$search%')";
                        }
                        $sql .= " ORDER BY id DESC";

                        // Run query
                        $result = $conn->query($sql);

                         if ($result && $result->num_rows === 0 && !empty($search)) {
                           echo "<div style='text-align: center; margin-top: 15px; color: black;'>Search not found.</div>";
                        }

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                $taskData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
?>
                    

                    <!-- Task Card -->
                    <ul class="sortable-list taskList list-unstyled ui-sortable" id="upcoming">
                        <li class="task-warning ui-sortable-handle"  onclick="showTaskDetail(JSON.parse('<?= $taskData ?>'))">
                            <b><?= htmlspecialchars($row['taskname']) ?></b>
                            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit'])?>, <?= htmlspecialchars($row['tasklocation']) ?></p>
                            <div class="clearfix"></div>
                            <div class="mt-3">
                                <p class="mb-0">
                                    <a class="text-muted">
                                        <span class="font-bold font-secondary">
                                            PIC: <?= htmlspecialchars($row['picname']) ?>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </li>
                    </ul>

                    <?php
                        endwhile;
                    endif;
                    ?>
                    

                    <!-- BUTTON TO ADD TASK  -->
                    <button type="button" class="btn btn-form" onclick="openNewTaskPopup()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <!-- in progress  -->
            <div class="col-lg-4">
    <div class="card-box">
        <div class="nomove">
            <h4 class="header-title" style="font-weight: bold;">In Progress</h4>
            
        
        </div>

        <div class="scroll-container" style="background-color: transparent; margin-top: -16px;">
            <!-- Filter Form -->
            <form method="get">
            <div class="dropdown">
                <button type="button" onclick="myFunction()" class="dropbtn btn-filter" style="margin-bottom: 15px;">
                    <i class="fa fa-filter"></i>
                </button>
                <div id="myDropdown" class="dropdown-content" style="margin-bottom: 10px;">
                    <input type="text" name="search" placeholder="Search.." id="myInput"
                        onkeyup="filterFunction()" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                        class="form-control">
                        <button type="button" onclick="clearSearch('search', 'myInput', 'myFunction')" id="clearBtn"
                        style="position: absolute; right: 10px; top: 77%; transform: translateY(-50%);
                                background: transparent; border: none; font-size: 16px; color: black; cursor: pointer;">
                        &times;
                    </button>
                </div>
            </div>
        </form>

        <!-- PHP Task Cards -->
        <?php
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build query
$sql = "SELECT * FROM tasks WHERE taskstatus = 'inprogress'";
if (!empty($search)) {
     $sql .= " AND (picname LIKE '%$search%' OR taskname LIKE '%$search%' OR taskterminal LIKE '%$search%' OR tasklocation LIKE '%$search%' OR taskunit LIKE '%$search%')";
}
$sql .= " ORDER BY id DESC";

// Run query
$result = $conn->query($sql);

 if ($result && $result->num_rows === 0 && !empty($search)) {
                           echo "<div style='text-align: center; margin-top: 15px; color: black;'>Search not found.</div>";
                        }

if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $taskData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
?>
    <!-- Task Card -->
    <ul class="sortable-list taskList list-unstyled ui-sortable" id="inprogress">
        <li class="task-warning ui-sortable-handle" onclick="showProgressDetail(JSON.parse('<?= $taskData ?>'))">
            <b><?= htmlspecialchars($row['taskname']) ?></b>
            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit'])?> , <?= htmlspecialchars($row['tasklocation']) ?></p>
            <div class="clearfix"></div>
            <div class="mt-3">
                <p class="mb-0">
                    <a class="text-muted"><span class="font-bold font-secondary">PIC: <?= htmlspecialchars($row['picname']) ?></span></a>
                </p>
            </div>
        </li>
    </ul>
<?php
    endwhile;
                    endif;
?>
</div>
    </div>
</div>

            <!-- completed  -->
            <div class="col-lg-4">
                <div class="card-box" id="container">
                    <div class="nomove">
                        <h4 class="header-title" style="font-weight: bold;">Completed</h4>
                    </div>

<div class="scroll-container" style="background-color: transparent; margin-top: -16px;">
    <form method="get">
            <div class="dropdown2">
                <button type="button" onclick="myFunction2()" class="dropbtn btn-filter" style="margin-bottom: 15px;">
                    <i class="fa fa-filter"></i>
                </button>
                <div id="myDropdown2" class="dropdown-content" style="margin-bottom: 10px;">
                    <input type="text" name="search2" placeholder="Search.." id="myInput2"
                        onkeyup="filterFunction2()" value="<?= isset($_GET['search2']) ? htmlspecialchars($_GET['search2']) : '' ?>"
                        class="form-control2">
                        <button type="button" onclick="clearSearch('search2', 'myInput2', 'myFunction2')" id="clearBtn2"
                            style="position: absolute; right: 10px; top: 17.5%; transform: translateY(-50%);
                                    background: transparent; border: none; font-size: 16px; color: black; cursor: pointer;">
                            &times;
                        </button>
                </div>
            </div>
        </form>   
                        
                    
<!-- PHP Task Cards -->
        <?php
$search = isset($_GET['search2']) ? $conn->real_escape_string($_GET['search2']) : '';

// Build query
$sql = "SELECT * FROM tasks WHERE taskstatus = 'completed'";
if (!empty($search)) {
     $sql .= " AND (picname LIKE '%$search%' OR taskname LIKE '%$search%' OR taskterminal LIKE '%$search%' OR tasklocation LIKE '%$search%' OR taskunit LIKE '%$search%')";
}
$sql .= " ORDER BY id DESC";

// Run query
$result = $conn->query($sql);

 if ($result && $result->num_rows === 0 && !empty($search)) {
                           echo "<div style='text-align: center; margin-top: 15px; color: black;'>Search not found.</div>";
                        }


if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $taskData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
?>

                    <ul class="sortable-list taskList list-unstyled ui-sortable" id="completed">
                        <li class="task-warning ui-sortable-handle"  onclick="showCompleteDetail(JSON.parse('<?= $taskData ?>'))">
                            <b><?= htmlspecialchars($row['taskname']) ?></b>
                            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit'])?> , <?= htmlspecialchars($row['tasklocation']) ?></p>
                            <div class="clearfix"></div>
                            <div class="mt-3">
                                <p class="mb-0">
                                    <a class="text-muted">
                                        <span class="font-bold font-secondary">
                                            PIC: <?= htmlspecialchars($row['picname']) ?>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <?php
                        endwhile;
                        endif;
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    </div>
    <!-- container -->

    <!-- new task form -->
     <div class="popup1 clearfix" id="popup1" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeNewTaskPopup()">&times;</span>
            <h5 style="font-weight: bold;">New Task Form</h5>
           </div>
           <form method="POST">
            <label for="picname"><b>Name (PIC):  </b></label>
            <select type="text" placeholder='input task pic name' name="picname" id="picname" class="styled-select" required >
                <option value="">-- Select PIC Name --</option>
                <?php
                    // Fetch all unique picnames from your database
                    include("config.php");
                    $query = "SELECT username FROM users WHERE role = 'pic' ORDER BY username ASC";
                        $result = $conn->query($query);

                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            $username = htmlspecialchars($row['username']);
                            echo "<option value=\"$username\">$username</option>";
                        endwhile;
                    endif;
                ?>
            </select>

            <label for="tasktname"><b>Title:  </b></label>
            <input type="text" placeholder="input task title" name="taskname" id="taskName" required />
                            
            <label for="createdate"><b>Date:  </b></label>
            <input type="date" placeholder="input task start date" name="createdate" id="createdate" required />
                             
            <label for="tasksystem"><b>System:  </b></label>
            <input type="text" placeholder="input system name" name="tasksystem" id="tasksystem" required />

            <label for="taskterminal"><b>Terminal:  </b></label>
            <input type="text" placeholder="input terminal name" name="taskterminal" id="taskterminal" required />
                            
            <label for="tasklocation"><b>Location:  </b></label>
            <input type="text" placeholder="input location" name="tasklocation" id="location" required />
                            
            <label for="taskunit"><b>Unit:  </b></label> 
            <input type="text" placeholder="input unit" name="taskunit" id="taskunit" required />
                            
            <label for="taskdescription"><b>Description:  </b></label>
            <input type="text" placeholder="describe task" name="taskdescription" id="description" required /> <br>

            <button type="submit" name="task_submit" class="btn-addtask" ID="newTask" >Add Task</button>
        </form>
    </div>
    
     <!-- Task Detail Popup -->
      <div class="popup1" id="popup2">
        <span class="close" onclick="closeTaskDetail()">&times;</span>
        <form action="" method="POST" id="editForm">
            <input type="hidden" name="task_id" id="task-id-input">
            <h5>
                <b>
                    <label id="tasktitle-label" id="editTitle"></label>
                    <input type="text" name="taskname_edit" id="tasktitle-input" class="form-control d-none">
                </b>
            </h5>
            <hr>
            <label><b>Date Created : </b><span id="createdate-label"></span>
            <input type="date" name="createdate_edit" id="createdate-input" class="form-control d-none"></label>

            <label><b>Name (PIC): </b>
                <span id="picname-label"></span>
                <select name="picname_edit" id="picname-input"  class="styled-select" required>
                                    
                    <?php
                        include("config.php");
                        $query = "SELECT username FROM users WHERE role = 'pic' ORDER BY username ASC";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                $username = htmlspecialchars($row['username']);
                                echo "<option value=\"$username\">$username</option>";
                            endwhile;
                        endif;
                    ?>
                </select>
            </label>
                                
            <label><b>System : </b><span id="tasksystem-label"></span>
            <input type="text" name="tasksystem_edit" id="tasksystem-input" class="form-control d-none"></label>

            <label><b>Terminal : </b><span id="taskterminal-label"></span>
            <input type="text" name="taskterminal_edit" id="taskterminal-input" class="form-control d-none"></label>
            
            <label><b>Location : </b><span id="tasklocation-label"></span>
            <input type="text" name="tasklocation_edit" id="tasklocation-input" class="form-control d-none"></label>
            
            <label><b>Unit : </b><span id="taskunit-label"></span>
            <input type="text" name="taskunit_edit" id="taskunit-input" class="form-control d-none"></label>
            
            <label>
                <b>Description : </b>
                <span id="taskdescription-label"></span>
                <input type="text" name="taskdescription_edit" id="taskdescription-input" class="form-control d-none">
            </label>
            <i id="edit-icon" class="fa fa-edit" href="" onclick="enableEditMode()" style="font-size:24px; float:right; cursor:pointer;"></i>
                            
            <div id="edit-buttons" class="d-none mt-3" style="float: right; margin-right:30px;" >
                <button type="submit" name= "edit_submit" class="btn btn-success btn-sm">Save</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="disableEditMode()">Cancel</button>
            </div>
        </form>
    </div>
    <!-- Progress Detail Popup -->
    <div class="popup1 clearfix" id="popup3" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeProgressDetail()">&times;</span>
       
            <h5 ><b><Label id="ptasktitle-label"></Label></b></h5>
             </div>
             <form action="">
            <p>
                <b>Date Created : </b>
                <span id="pcreatedate-label"></span>
            </p>
            <p>
                <b>Name (PIC) : </b>
                <span id="ppicname-label"></span>
            </p>
            <p>
                <b>System : </b>
                <span id="ptasksystem-label"></span>
            </p>
            <p>
                <b>Terminal : </b>
                <span id="ptaskterminal-label"></span>
            </p>
            <p>
                <b>Location : </b>
                <span id="ptasklocation-label"></span>
            </p>
            <p>
                <b>Unit : </b>
                <span id="ptaskunit-label"></span>
            </p>
            <p>
                <b>Description : </b>
                <span id="ptaskdescription-label"></span>
            </p>
            <p for="taskprogress"><b>Progress : 
                <div id="progress-updates"></div>
            </b>
        </form>
    </div>

     <!-- Attachments -->
    <div id="attachmentPopup" class="attachment-popup">
    <span class="close" onclick="closeAttachmentPopup()">&times;</span>
        <h5>Attachments</h5>
        <div id="attachmentContent"></div>
    </div>
    
    <!-- Completed Detail Popup -->
    <div class="popup1 clearfix" id="popup5" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeCompletedDetail()">&times;</span>
        
            <h5 ><b><Label id="ctasktitle-label"></Label></b></h5>
        </div>
            <form action="">
            <p>
                <b>Completed Date : </b>
                <span id="ccompleteddate-label"></span>
            </p>

            <p>
                <b>Name (PIC) : </b>
                <span id="cpicname-label"></span>
            </p>

            <p>
                <b>System : </b>
                <span id="ctasksystem-label"></span>
            </p>

            <p>
                <b>Terminal : </b>
                <span id="ctaskterminal-label"></span>
            </p>

            <p>
                <b>Location : </b>
                <span id="ctasklocation-label"></span>
            </p>

            <p>
                <b>Unit : </b>
                <span id="ctaskunit-label"></span>
            </p>

            <p>
                <b>Description : </b>
                <span id="ctaskdescription-label"></span>
            </p>
            <p for="taskprogress">
                <b>Progress : 
                    <div id="ctaskprogress-label"></div>
                </b>
            </p>

            
            <p>
                <br>
                <br>
                <b>Remarks : </b>
                <span id="ctaskremarks-label"></span>
            </p>

            <button 
            class="btn-print" 
            onclick="printReport(completeID)">
                PRINT
                <i class="fa fa-print"></i>
            </button> 
        </form>
    </div>
</div>

<script>
    function clearSearch(searchId, inputId, dropdownFunctionName) {
    document.getElementById(inputId).value = "";
    localStorage.setItem("keepDropdownOpen", dropdownFunctionName);
    const url = new URL(window.location.href);
    url.searchParams.delete(searchId);
    window.history.replaceState({}, document.title, url);
     location.reload();
}
    document.querySelectorAll('.btn-deleteuser').forEach(button => {
  button.addEventListener('click', function() {
    const form = this.closest('form');
    const username = form.getAttribute('data-username');

    const modal = document.getElementById('confirmModal');
    const message = document.getElementById('confirmMessage');
    message.textContent = `Are you sure you want to delete "${username}"?`;

    modal.style.display = 'flex';

    // Re-attach listeners to avoid stacking
    const newYes = document.getElementById('confirmYes').cloneNode(true);
    const newNo = document.getElementById('confirmNo').cloneNode(true);

    document.getElementById('confirmYes').replaceWith(newYes);
    document.getElementById('confirmNo').replaceWith(newNo);

    newYes.addEventListener('click', function() {
      modal.style.display = 'none';
      form.submit();
    });

    newNo.addEventListener('click', function() {
      modal.style.display = 'none';
    });
  });
});

    let newtaskpopup = document.getElementById('popup1')
    let taskdetailpopup = document.getElementById('popup2')
    let progressdetailpopup = document.getElementById('popup3')
    let deleteconfirmationpopup = document.getElementById('popup4')
    let completedtaskdetail = document.getElementById('popup5')
    let userlistpopup = document.getElementById("popup6");
    let adduserpopup = document.getElementById("popup7");

    function openNewTaskPopup(){
        newtaskpopup.classList.add('open-popup');
        document.getElementById('mainContent').classList.add('blurred');
    }
    function closeNewTaskPopup(){
        newtaskpopup.classList.remove('open-popup');
        document.getElementById('mainContent').classList.remove('blurred');
    }

    function openTaskDetail(){
        taskdetailpopup.classList.add('open-popup');
        document.getElementById('mainContent').classList.add('blurred');
        document.getElementById('popup-tasktitle').innerText = task.tasktitle;
    }
    function closeTaskDetail(){
        taskdetailpopup.classList.remove('open-popup');
        document.getElementById('mainContent').classList.remove('blurred');
    }

    function openProgressDetail(){
        progressdetailpopup.classList.add('open-popup')
        document.getElementById('mainContent').classList.add('blurred')
    }
    function closeProgressDetail(){
        progressdetailpopup.classList.remove('open-popup')
        document.getElementById('mainContent').classList.remove('blurred')
    }

    function openCompletedDetail(){
        completedtaskdetail.classList.add('open-popup')
        document.getElementById('mainContent').classList.add('blurred')
    }
    function closeCompletedDetail(){
        completedtaskdetail.classList.remove('open-popup')
        document.getElementById('mainContent').classList.remove('blurred')
    }

    function openDelete(){
        deleteconfirmationpopup.classList.add('open-popup')
        document.getElementById('mainContent').classList.add('blurred')
    }
    function closeDelete(){
        deleteconfirmationpopup.classList.remove('open-popup')
        document.getElementById('mainContent').classList.remove('blurred')
    }
function openUserListPopup() {
    userlistpopup.classList.add("open-popup")
    document.getElementById('mainContent').classList.add('blurred')
}

function closeUserListPopup() {
    userlistpopup.classList.remove("open-popup")
    document.getElementById('mainContent').classList.remove('blurred')
}
function openAddUserPopup() {
    adduserpopup.classList.add("open-popup")
    userlistpopup.classList.remove("open-popup")
    document.getElementById('mainContent').classList.add('blurred')
}

function closeAddUserPopup() {
    adduserpopup.classList.remove("open-popup")
    document.getElementById('mainContent').classList.remove('blurred')
    openUserListPopup()
}

   


    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }   

    function filterFunction() {
        var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    }
    function myFunction2() {
        document.getElementById("myDropdown2").classList.toggle("show");
    }   

    function filterFunction2() {
        const input = document.getElementById("myInput2");
        const filter = input.value.toUpperCase();
        const div = document.getElementById("myDropdown2");
        const a = div.getElementsByTagName("a");
        for (let i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }

    function myFunction3() {
        document.getElementById("myDropdown3").classList.toggle("show");
    }   

    function filterFunction3() {
        const input = document.getElementById("myInput3");
        const filter = input.value.toUpperCase();
        const div = document.getElementById("myDropdown3");
        const a = div.getElementsByTagName("a");
        for (let i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }


    function showTaskDetail(task) {
        // Convert 'yyyy-mm-dd' to 'dd/mm/yyyy'
        const rawDate = task.createdate;
        let formattedDate = 'N/A';
        if (rawDate) {
            const parts = rawDate.split('-'); // [yyyy, mm, dd]
            if (parts.length === 3) {
                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
        }
        document.getElementById('tasktitle-label').innerText =(task.taskname || 'N/A');
        document.getElementById('createdate-label').innerText = formattedDate;
        document.getElementById('picname-label').innerText = (task.picname || 'N/A');
        document.getElementById('tasksystem-label').innerText = (task.tasksystem || 'N/A');
        document.getElementById('taskterminal-label').innerText = (task.taskterminal || 'N/A');
        document.getElementById('tasklocation-label').innerText = (task.tasklocation || 'N/A');
        document.getElementById('taskunit-label').innerText = (task.taskunit || 'N/A');
        document.getElementById('taskdescription-label').innerText = (task.taskdescription || 'N/A');

        // Set input values
        document.getElementById('task-id-input').value = task.id;
        document.getElementById('tasktitle-input').value = task.taskname || '';
        document.getElementById('createdate-input').value = task.createdate || '';
        document.getElementById('picname-input').value = task.picname || '';
        document.getElementById('tasksystem-input').value = task.tasksystem || '';
        document.getElementById('taskterminal-input').value = task.taskterminal || '';
        document.getElementById('tasklocation-input').value = task.tasklocation || '';
        document.getElementById('taskunit-input').value = task.taskunit || '';
        document.getElementById('taskdescription-input').value = task.taskdescription || '';
        disableEditMode(); // Always start in view mode
        openTaskDetail();
    }

    function showProgressDetail(task) {
        // Convert 'yyyy-mm-dd' to 'dd/mm/yyyy'
        const rawDate = task.createdate;
        let formattedDate = 'N/A';
        if (rawDate) {
            const parts = rawDate.split('-'); // [yyyy, mm, dd]
            if (parts.length === 3) {
                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
        }
        document.getElementById('ptasktitle-label').innerText =(task.taskname || 'N/A');
        document.getElementById('pcreatedate-label').innerText = formattedDate;
        document.getElementById('ppicname-label').innerText = (task.picname || 'N/A');
        document.getElementById('ptasksystem-label').innerText = (task.tasksystem || 'N/A');
        document.getElementById('ptaskterminal-label').innerText = (task.taskterminal || 'N/A');
        document.getElementById('ptasklocation-label').innerText = (task.tasklocation || 'N/A');
        document.getElementById('ptaskunit-label').innerText = (task.taskunit || 'N/A');
        document.getElementById('ptaskdescription-label').innerText = (task.taskdescription || 'N/A');

        fetch("server/get_progress.php?task_id=" + task.id)
            .then(response => response.json())
            .then(progressArray => {
                let html = '';
                progressArray.forEach(progress => {
                    const date = new Date(progress.start_date);
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                    const year = date.getFullYear();
                    const formattedDate = `${day}/${month}/${year}`;
                    html += `<p><b>${formattedDate}</b>: ${progress.progress_text} (${progress.update_status})
                    <button class="btn-view" onclick="event.preventDefault(); getAttachment(${progress.id});"> View </button>
                    </p>`;
                });
                document.getElementById("progress-updates").innerHTML = html;
            });
        openProgressDetail();
    }

     function getAttachment(progressId){
        fetch('server/get_attachments.php?progress_id=' + progressId)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('attachmentContent');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = "<p>No attachments found.</p>";
            } else {
                data.forEach(file => {
                    const img = document.createElement('img');
                    img.src = file.filepath;
                    img.alt = file.filename;
                    img.style.width = '100%';
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
                    img.style.display = 'block';
                    img.style.marginBottom = '15px';
                    img.style.borderRadius = '6px';
                    img.style.boxShadow = '0 0 8px rgba(0,0,0,0.1)';
                    container.appendChild(img);
                });
            }

            document.getElementById('attachmentPopup').style.display = 'block';
        });
    }

    function closeAttachmentPopup() {
    document.getElementById('attachmentPopup').style.display = 'none';
    }

    function showCompleteDetail(task) {
        completeID = task.id;
        // Convert 'yyyy-mm-dd' to 'dd/mm/yyyy'
        const rawDate = task.createdate;
        let formattedDate = 'N/A';
        if (rawDate) {
            const parts = rawDate.split('-'); // [yyyy, mm, dd]
            if (parts.length === 3) {
                formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
        }
        document.getElementById('ctasktitle-label').innerText =(task.taskname || 'N/A');
       
        document.getElementById('cpicname-label').innerText = (task.picname || 'N/A');
        document.getElementById('ctasksystem-label').innerText = (task.tasksystem || 'N/A');
        document.getElementById('ctaskterminal-label').innerText = (task.taskterminal || 'N/A');
        document.getElementById('ctasklocation-label').innerText = (task.tasklocation || 'N/A');
        document.getElementById('ctaskunit-label').innerText = (task.taskunit || 'N/A');
        document.getElementById('ctaskdescription-label').innerText = (task.taskdescription || 'N/A');


        fetch("server/get_progress.php?task_id=" + task.id)
        .then(response => response.json())
        .then(progressArray => {
            let html = '';
            progressArray.forEach(progress => {
                const date = new Date(progress.start_date);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const year = date.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;
                html += `<p><b>${formattedDate}</b>: ${progress.progress_text} (${progress.update_status})
                <button class="btn-view" onclick="event.preventDefault(); getAttachment(${progress.id});"> View </button>
                </p>`;
            });
            document.getElementById("ctaskprogress-label").innerHTML = html;
        });

        fetch("server/get_remarks.php?task_id=" + task.id)
        .then(response => response.json())
        .then(remarksArray => {
            let html = '';
            remarksArray.forEach(remarks => {
                const date = new Date(remarks.completed_date);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const year = date.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;
                document.getElementById('ccompleteddate-label').innerText = formattedDate;
                html += `${remarks.remark}`;
            });
            document.getElementById("ctaskremarks-label").innerHTML = html;
        });
        
        openCompletedDetail();
    }

    function enableEditMode() {
        // Hide spans, show inputs
        toggleFields(true);
        document.getElementById('edit-buttons').classList.remove('d-none');
        document.getElementById('edit-icon').classList.add('d-none');
    }

    function disableEditMode() {
        // Hide inputs, show spans
        toggleFields(false);
        document.getElementById('edit-buttons').classList.add('d-none');
        document.getElementById('edit-icon').classList.remove('d-none');
    }

    function toggleFields(editing) {
        const fields = ['tasktitle', 'createdate', 'picname', 'tasksystem', 'taskterminal', 'tasklocation', 'taskunit', 'taskdescription'];

        fields.forEach(id => {
            document.getElementById(`${id}-label`).classList.toggle('d-none', editing);
            document.getElementById(`${id}-input`).classList.toggle('d-none', !editing);
        });
    }

    function printReport(id) {
        window.open('fill_data.php?id=' + id, '_blank');
    }
</script>


<style>
    body{
    margin-top:50px;
    background:#DCDCDC;
     align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
}

.logo {
    padding-left: 3.1%;
    margin-top: -2.6%;
    position: relative;
    z-index: 1;
}

.header {
    width: device-width;
    height: 100px;
    margin-top: -80px;
    background: white;
    opacity: 50%;
    position: relative;
    z-index: -1;
}

.content {
    margin-top: 30px;
}

/* n  */
.btn-form{
    background-color:rgb(255, 255, 255);
  border: none;
  color: black;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 30px 2px auto;
  cursor: pointer;
  border-radius: 100%;
  transition: box-shadow 0.3s ease;
}

/* n  */
.btn-form:hover{
    box-shadow: 1px 5px 5px;
}

.btn-edit{
    background-color:rgb(255, 255, 255);
  border: none;
  color: black;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 30px 2px auto;
  cursor: pointer;
  border-radius: 100%;
  transition: box-shadow 0.3s ease;
}

.btn-view {
    width: 10%;
    float: right;
    margin-top: 3px;
    margin-right: 150px;
    padding: 5px 0;
    background-color:rgb(156, 160, 161);
    color: white;
    border: 0;
    outline: none;
    font-style: 8px;
    border-radius: 4px;
    box-shadow: none;
}

.btn-view:hover {
    background-color:rgb(123, 133, 136);
    cursor: pointer;
}

/* n  */
.btn-edit:hover{
    box-shadow: 1px 5px 5px lightblue;
}
.thumb-sm {
    height: 36px;
    width: 36px;
}

.taskList {
    min-height: 40px;
    margin-top: 10%;
    margin-bottom: 0
}

.taskList li {
    background-color: #fff;
    border: 1px solid rgba(121, 121, 121, .2);
    padding: 10px;
    margin-bottom: 20px;
    /* n  */
    border-radius: 10px;
    transition: box-shadow 0.3s ease;
}

/* n  */
.taskList li:hover{
    box-shadow: 1px 5px 10px ;
}

.taskList li:last-of-type {
    margin-bottom: 0
}

.taskList a {
    font-size: 13px
}

.taskList .checkbox {
    margin-left: 20px;
    margin-top: 5px
}
.text-muted {
    color: #98a6ad!important;
}

/* .popup1{
    width: 400px;
    background: #fff;
    -webkit-border-radius: 6px;
    -moz-border-raduis: 6px;
    border-radius: 6px;
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.1);
    text-align: center;
    padding: 0 30px 60px;
    color: #333;
    visibility: hidden;
    transition: all 0.4s ease-in-out;
} */

.popup1, .popup2, .popup3, .popup4, .popup5, .popup6, .popup7 {
    width: 600px;
    max-height: 90vh;           
    overflow-y: auto;
    background-color: white;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    position: fixed;
    z-index: 2;
    top: 0;
    left: 50%;
    transform: translate(-50%,-50%) scale(0.1);
    text-align: left;
    padding: 20px 30px 20px;
    color: #333;
    overflow: auto;
    visibility: hidden;
    transition: transform 0.4s, top 0.4s;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

.clearfix::after {
    content: "";
    display: table;
    clear: both;
}
.fixedtitle {
    position: sticky; 
    top: 0; 
    z-index: 1; 
    background-color: white; 
    padding: 20px 0px 20px; 
    border-bottom: #808080 solid 1px;
    margin-bottom: 10px;
}
.popup1::-webkit-scrollbar, .popup3::-webkit-scrollbar, .popup5::-webkit-scrollbar, .popup6::-webkit-scrollbar {
    width: 8px;
    margin-right: -8px;
}

.popup1::-webkit-scrollbar-track, .popup3::-webkit-scrollbar-track, .popup5::-webkit-scrollbar-track, .popup6::-webkit-scrollbar-track {
    background: transparent;
    margin-top: 75px;
    margin-bottom: 15px;
}

.popup1::-webkit-scrollbar-thumb, .popup3::-webkit-scrollbar-thumb, .popup5::-webkit-scrollbar-thumb, .popup6::-webkit-scrollbar-thumb {
    background-color: #aaa;
    border-radius: 10px;
    border: 2px solid transparent;
    background-clip: content-box;
}

/* Remove arrows (usually appear in older WebKit browsers) */
.popup1::-webkit-scrollbar-button, .popup3::-webkit-scrollbar-button, .popup5::-webkit-scrollbar-button, .popup6::-webkit-scrollbar-button  {
    display: none;
}

.popup4 {
    background-color: #DCDCDC;
    width: 1450px;
    height: 640px;
    margin-top: 50px;
    text-align: center;
    box-shadow: none;
    transition: none;
}

.popup4 h4 {
    margin-top: 230px;
}

.open-popup{
    visibility: visible;
    top: 50%;
    transform: translate(-50%, -50%) scale(1);
}

.popup1 h2{
    font-size: 38px;
    font-weight: 500;
    margin: 30px 0 10px;
}

/* .popup1 button{
    width: 100%;
    margin-top: 50px;
    padding: 10px 0;
    background-color:rgb(46, 55, 45);
    color: #fff;
    border: 0;
    outline: none;
    font-style: 18px;
    border-radius: 4px;
    box-shadow: 0 5px 5px
        rgba(0,0,0,0.2);

} */

.close {
    color: black;
    font-weight: bold;
}

.popup1 label , .popup3 label, .popup2 label, .popup6 label, .popup7 label {
    margin-top: 10px;
    margin-bottom: 2px;
    display: block;
}

.popup1 input , .popup3 input, .popup2 input, .popup7 input {
    width: 95%;
    background: #b5b2b2;
    outline: none;
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 10px;
    font-size: 16px;
    color: black;
    padding: 10px 5px 10px 5px;
}

.styled-select {
    width: 95%;
    background: #b5b2b2 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='black' d='M0 0l2 2 2-2z'/%3E%3C/svg%3E") no-repeat right 10px center;
    background-size: 10px;
    outline: none;
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 10px;
    font-size: 16px;
    color: black;
    padding: 10px 30px 10px 10px; /* padding-right gives space for arrow */
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
}

.btn-addtask {
     width: 17%;
    float: right;
    margin-top: 20px;
    margin-right: 30px;
    margin-bottom: 10px;
    padding: 5px;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none;
}

.btn-addtask:hover {
    background-color:rgb(11, 101, 128);
    cursor: pointer;
}

.btn-cancel {
    background-color: white;
    color: black;
}

.btn-cancel:hover {
    background-color: rgb(11, 101, 128);
    color: white;
}

.btn-confirmdelete {
    background-color: rgb(183, 50, 50);
    color: white;
}

.btn-confirmdelete:hover {
    background-color:rgb(143, 27, 27);
}

.btn-delete {
    background: none;
    padding: 2px 7px 2px 7px;;
    border-radius: 100%;
}

.btn-delete:hover {
    border-color: red;
    background-color:rgb(209, 204, 204);
}

.title {
    word-wrap: break-word; 
    overflow-wrap: break-word; 
    white-space: normal;
}
.blurred {
  filter: blur(5px);
  transition: filter 0.3s ease-in-out;
  pointer-events: none; /* optional: prevents clicking things in background */
}

.btn-print {
    width: 18%;
    float: right;
    margin-top: 20px;
    margin-right: 20px;
    margin-bottom: 10px;
    padding: 5px;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none;
}

.btn-print:hover {
    background-color:rgb(11, 101, 128);
    cursor: pointer;
}

/* Filtering , Dropdown Search */

.btn-filter {
    margin: 10px 0px 0px 5px;
    padding: 1px 5px 1px 5px;
    border-radius: 2%;
    border-color: rgb(209, 204, 204);
    cursor: pointer;
}

.btn-filter:hover, .btn-filter:focus {
    background-color: rgb(209, 204, 204);
}
.logout-icon {
    position: absolute;
    top: 22px;
    right: 90px;
}

.logout-icon i {
    color: black;
    font-size: 28px;
    transition: color 0.3s ease;
}

.logout-icon:hover i {
    color: blue;
}

.user-icon-btn {
      position: absolute;
    top: 22px;
    right: 185px;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
    }

    .user-icon-btn svg {
      width: 28px;
      height: 28px;
      fill: black;
      transition: fill 0.3s ease;
      display: block;
    }

    .user-icon-btn:hover svg {
      fill: blue;
    }

    .btn-add-user {
    width: 16%;
    margin-top: -10px;
   
    background-color: #0c81a3;
    color: white;
   
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none;
    float: right;
    margin-right: 28px;
    }

    .btn-add-user:hover {
      background-color: #0b657f;
    }

    .btn-add-user i {
      font-size: 18px;
    }

.btn-adduser {
    width: 17%;
    margin-top: 30px;
    padding: 5px 0;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none;
    float: right;
    margin-right: 25px;
}

.btn-adduser:hover {
    background-color:rgb(11, 101, 128);
    cursor: pointer;
}
.btn-deleteuser {
    width: 17%;
    margin-top: 10px;
    padding: 5px 0;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none; 
    margin-right: 5px;
}

.btn-deleteuser:hover {
    background-color:rgb(11, 101, 128);
    cursor: pointer;
}
.icon-button {
      background-color: transparent; /* No background */
      border: none;                  /* No border */
      padding: 0;
      cursor: pointer;
      margin-left: 10px;
      margin-bottom: 10px;
      margin-top: 20px;
    }

    .icon-button svg {
      width: 25px;
      height: 25px;
      fill: #000000; /* Icon color: black */
      transition: transform 0.2s ease;
    }

    .icon-button:hover svg {
      transform: scale(1.1); /* Slight grow on hover */
      fill: blue;
    }

#myInput {
  box-sizing: border-box;
  font-size: 14px;
  padding: 10px 114px 10px 15px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

#myInput2 {
  box-sizing: border-box;
  font-size: 14px;
  padding: 10px 114px 10px 15px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput2:focus {outline: 3px solid #ddd;}

#myInput3 {
  box-sizing: border-box;
  font-size: 14px;
  padding: 10px 114px 10px 15px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput3:focus {outline: 3px solid #ddd;}


.dropdown-content {
  display: none;
  background-color: #f6f6f6;
  min-width: 30px;
  border: 1px solid black;
  border-radius: 1%;
  overflow: hidden;
}

.dropdown-content a {
  color: black;
  font-size: 14px;
  padding: 10px 16px 10px;
  text-decoration: none;
  display: block;
}

.styled-dropdown {
    margin-top: 10px;
    margin-bottom: 2px;
    display: block;
    width: 95%;
    background: #b5b2b2;
    outline: none;
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 10px;
    font-size: 16px;
    color: black;
    padding: 10px 5px 10px 5px;
}
.toast-message {
  position: fixed;
  top: 70px;
  right: 20px;
  padding: 12px 20px;
  border-radius: 6px;
  z-index: 9999;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  font-weight: bold;
  opacity: 0;
  animation: fadeInOut 4s forwards;
}

.toast-message.success {
  background-color: #d4edda;
  color: #155724;
}

.toast-message.error {
  background-color: #f8d7da;
  color: #721c24;
}

/* Keyframes for fadeInOut */
@keyframes fadeInOut {
  0% {
    opacity: 0;
    transform: translateY(-20px);
  }
  10% {
    opacity: 1;
    transform: translateY(0);
  }
  90% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-20px);
  }
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}

.form-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.form-row label {
    width: 100px; /* adjust width as needed */
    margin-right: 10px;
}

.form-row input {
    flex: 1;
    padding: 5px;
}

.attachment-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 70vw;  /* Increased width */
    max-width: 800px;
    height: 70vh;  /* Increased height */
    overflow-y: auto;
    background: #fff;
    padding: 20px;
    z-index: 9999;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
    border-radius: 8px;
}

.attachment-popup img {
    width: 100%;         /* Makes image span the full width of popup */
    max-width: 100%;     /* Prevents overflow */
    height: auto;        /* Maintains aspect ratio */
    display: block;
    margin-top: 20px;
    margin-bottom: 15px; /* Spacing between multiple images */
    border-radius: 6px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
}


</style>