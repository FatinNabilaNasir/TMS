<?php include("server/engine.php"); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="./assets/favicon-are-new-67x67.png">

    <link rel="stylesheet" href="style.css">

    <title>
        Management |  AR Eastern Sdn Bhd
    </title>
  </head>
  <body>
        <!-- LOGO AR EASTERN -->
    <div class="header"></div>
    <img class="logo" src="assets/img/logo-are-website-612x150.png" alt="AR Eastern Sdn Bhd" style="height: 4.4rem; margin-top: -80px;">
    <form method="post" >
    <a href="logout.php" title="Logout" style="float:right; margin-right: 90px; margin-top: -69px;" class="logout-icon">
    <i class="fa fa-sign-out" style="font-size:28px;"></i></a>
    </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

<div class="content">
<div class="main-content" id="mainContent">
    <div class="container">
        <div class="row">

            <!-- To Do -->
            <div class="col-lg-4">
                <div class="card-box">
                    <div class="nomove">
                        <h5 class="header-title" style="margin-top:10px; font-weight: bold;">
                            To Do
                        </h5>
                    </div>

                    <div class="scroll-container" style="margin-top: 6px; background-color: transparent; margin-top: -16px;">
                        <form method="get">
                            <div class="dropdown3">
                                <button type="button" onclick="myFunction3()" class="dropbtn btn-filter" style="margin-bottom: 15px;">
                                    <i class="fa fa-filter"></i>
                                </button>
                                <div id="myDropdown3" class="dropdown-content" style="margin-bottom: 10px;">
                                    <input type="text" name="search3" placeholder="Search.." id="myInput3"
                                        onkeyup="filterFunction3()" value="<?= isset($_GET['search3']) ? htmlspecialchars($_GET['search3']) : '' ?>"
                                        class="form-control3">
                                         <button type="button" onclick="clearSearch('search3', 'myInput3', 'myFunction3')" id="clearBtn3"
                                            style="position: absolute; right: 10px; top: 18%; transform: translateY(-50%);
                                                    background: transparent; border: none; font-size: 18px; color: black; cursor: pointer;">
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

                        $result = $conn->query($sql);
                         if ($result && $result->num_rows === 0 && !empty($search)) {
                           echo "<div style='text-align: center; margin-top: 15px; color: black;'>Search not found.</div>";
                        }

                        if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            $taskData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                    ?>

                    <!-- Task Card -->
                    <ul class="sortable-list taskList list-unstyled ui-sortable" id="upcoming">
                        <li class="task-warning ui-sortable-handle"  onclick="showTaskDetail(JSON.parse('<?= $taskData ?>'))">
                            <b><?= htmlspecialchars($row['taskname']) ?></b>
                            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit']) ?>, <?= htmlspecialchars($row['tasklocation']) ?></p>
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

            <!-- in progress  -->
            <div class="col-lg-4">
    <div class="card-box">
        <div class="nomove">
            <h5 class="header-title" style="margin-top:10px; font-weight: bold;">In Progress</h5>
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
                                    background: transparent; border: none; font-size: 18px; color: black; cursor: pointer;">
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
            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit']) ?>, <?= htmlspecialchars($row['tasklocation']) ?></p>
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
                        <h5 class="header-title" style="margin-top:10px; font-weight: bold;">Completed</h5>
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
                                        style="position: absolute; right: 10px; top: 18%; transform: translateY(-50%);
                                                background: transparent; border: none; font-size: 18px; color: black; cursor: pointer;">
                                        &times;
                                    </button>
                                </div>
                            </div>
                        </form>   
                    <?php
                       $search = isset($_GET['search2']) ? $conn->real_escape_string($_GET['search2']) : '';
                        $sql = "SELECT * FROM tasks WHERE taskstatus = 'completed'";
if (!empty($search)) {
     $sql .= " AND (picname LIKE '%$search%' OR taskname LIKE '%$search%' OR taskterminal LIKE '%$search%' OR tasklocation LIKE '%$search%' OR taskunit LIKE '%$search%')";
}
$sql .= " ORDER BY id DESC";
                        $result = $conn->query($sql);

                         if ($result && $result->num_rows === 0 && !empty($search)) {
                           echo "<div style='text-align: center; margin-top: 15px; color: black;'>Search not found.</div>";
                        }

                        if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            $taskData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                    ?>

                    <ul class="sortable-list taskList list-unstyled ui-sortable" id="completed">
                        <li class="task-warning ui-sortable-handle"  onclick="showCompleteDetail(JSON.parse('<?= $taskData ?>'))">
                            <b><?= htmlspecialchars($row['taskname']) ?></b>
                            <p><?= htmlspecialchars($row['taskterminal']) ?>, <?= htmlspecialchars($row['taskunit']) ?>, <?= htmlspecialchars($row['tasklocation']) ?></p>
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

    <!-- Task Detail Popup -->
    <div class="popup1 clearfix" id="popup2" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeTaskDetail()">&times;</span>
        <form action="">
            <h5 ><Label id="tasktitle-label"></Label></h5>
        </div>
            <p>
                <b>Date Created : </b>
                <span id="createdate-label"></span>
            </p>
            <p>
                <b>Name (PIC) : </b>
                <span id="picname-label"></span>
            </p>
            <p>
                <b>System : </b>
                <span id="tasksystem-label"></span>
            </p>
            <p>
                <b>Terminal : </b>
                <span id="taskterminal-label"></span>
            </p>
            <p>
                <b>Location : </b>
                <span id="tasklocation-label"></span>
            </p>
            <p>
                <b>Unit : </b>
                <span id="taskunit-label"></span>
            </p>
    
            <p>
                <b>Description : </b>
                <span id="taskdescription-label"></span>
            </p>
        </form>
    </div>

    <!-- Progress Detail Popup -->
    <div class="popup1" id="popup3" style="padding-top: 0px;">
        <div class="fixedtitle">
            <span class="close" onclick="closeProgressDetail()">&times;</span>
            <h5 ><Label id="ptasktitle-label"></Label></h5>
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
            <h5 ><Label id="ctasktitle-label"></Label></h5>
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
    let taskdetailpopup = document.getElementById('popup2')
    let progressdetailpopup = document.getElementById('popup3')
    let completedtaskdetail = document.getElementById('popup5')

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

    function clearSearch(searchId, inputId, dropdownFunctionName) {
    document.getElementById(inputId).value = "";
    localStorage.setItem("keepDropdownOpen", dropdownFunctionName);
    const url = new URL(window.location.href);
    url.searchParams.delete(searchId);
    window.history.replaceState({}, document.title, url);
     location.reload();
}

    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }   

    function filterFunction() {
        const input = document.getElementById("myInput");
        const filter = input.value.toUpperCase();
        const div = document.getElementById("myDropdown");
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

    function printReport(id) {
        window.open('fill_data.php?id=' + id, '_blank');
    }
</script>

<style>
body{
    margin-top: 50px;
    background: #DCDCDC;
    align-items: center;
    justify-content: center;
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
    border-radius: 10px;
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

/* Popups */

.popup1, .popup2, .popup3, .popup4, .popup5 {
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
.popup1::-webkit-scrollbar, .popup3::-webkit-scrollbar, .popup5::-webkit-scrollbar {
    width: 8px;
    margin-right: -8px;
}

.popup1::-webkit-scrollbar-track, .popup3::-webkit-scrollbar-track, .popup5::-webkit-scrollbar-track {
    background: transparent;
    margin-top: 75px;
    margin-bottom: 15px;
}

.popup1::-webkit-scrollbar-thumb, .popup3::-webkit-scrollbar-thumb, .popup5::-webkit-scrollbar-thumb {
    background-color: #aaa;
    border-radius: 10px;
    border: 2px solid transparent;
    background-clip: content-box;
}

/* Remove arrows (usually appear in older WebKit browsers) */
.popup1::-webkit-scrollbar-button, .popup3::-webkit-scrollbar-button, .popup5::-webkit-scrollbar-button {
    display: none;
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

.printpopup {
    position: fixed; /* Stay in place */
    z-index: 2; /* Sit on top */
    left: 50%;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.31); /* Black w/ opacity */
    visibility: hidden;
}

.printform {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
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
    margin-top: 230px;
}

.ui-sortable-handle:hover {
    cursor: pointer;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

.open-popup {
    visibility: visible;
    top: 50%;
    transform: translate(-50%,-50%) scale(1);
}

.close {
    color: black;
    font-weight: bold;
}

.printclose {
    color: white;
    font-size: 50px;
    font-weight: bold;
    cursor: pointer;
    float: right;
    margin-right: 20px;
}

.popup1 label, .popup2 label, .popup3 label, .popup5 label {
    margin-top: 10px;
    margin-bottom: 2px;
    display: block;
}

.popup1 input {
    width: 60%;
    height: 0%;
    background: #b5b2b2;
    outline: none;
    border: 1px solid rgba(255, 255, 255, 0.28);
    border-radius: 10px;
    font-size: 16px;
    color: black;
    padding: 10px 5px 10px 5px;
}

/* Buttons */

.btn-custom {
    background-color: white;
    color: black;
    margin: 20px 0px -5px -2px;
    border-radius: 100%;
    border: 10px;
    border-color: rgb(209, 204, 204);
}

.btn-custom:hover {
    background-color:rgb(209, 204, 204);
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

.btn-addtask {
    width: 17%;
    float: right;
    margin-top: 50px;
    padding: 10px 0;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 18px;
    border-radius: 4px;
    box-shadow: none;
}

.btn-addtask:hover {
    background-color:rgb(11, 101, 128);
    cursor: pointer;
}

.btn-delete {
    background: none;
    padding: 2px 7px 2px 7px;;
    border-radius: 100%;
}

.btn-delete:hover {
    border-color: red;
    background-color:rgb(209, 204, 204);
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

.logout-icon i {
    color: black;
    font-size: 28px;
    transition: color 0.3s ease;
}

.logout-icon:hover i {
    color: blue;
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
    margin-top: 20px;
    margin-bottom: 10px;
    padding: 5px 0;
    background-color: #0c81a3;
    color: white;
    border: 0;
    outline: none;
    font-style: 14px;
    border-radius: 4px;
    box-shadow: none;
    float: right;
    margin-right: 20px;
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
  overflow: auto;
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

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}

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