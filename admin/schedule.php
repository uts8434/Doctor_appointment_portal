<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/animations.css"> -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <title>Schedule</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<body>
    <?php

            //learn from w3schools.com

            session_start();

            if (isset($_SESSION["user"])) {
                if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
                    header("location: ../login.php");
                }
            } else {
                header("location: ../login.php");
            }



            //import database
            include("../connection.php");


    ?>
    <div class="parent">
        <div class="container">
            <div class="menu">
                <div class="menu-container">
                    <div class="profile-container">
                        <div class="inner_profile-container">
                            <div class="profile-img">
                                <img src="../img/user.png" alt="User" class="profile-pic">
                            </div>
                            <div class="profile-info">
                                <p class="profile-title">Administrator</p>
                            </div>
                        </div>
                        <div class="logout-container">
                            <a href="../logout.php">
                                <button class="logout-btn">Log out</button>
                            </a>
                        </div>
                    </div>
                    <div class="menu-row">
                        <div class="menu-btn menu-active">
                            <a href="index.php" class="menu-link">
                                <p class="menu-text">Dashboard</p>
                            </a>
                        </div>
                    </div>
                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="doctors.php" class="menu-link">
                                <p class="menu-text">Doctors</p>
                            </a>
                        </div>
                    </div>
                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="schedule.php" class="menu-link">
                                <p class="menu-text">Schedule</p>
                            </a>
                        </div>
                    </div>
                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="appointment.php" class="menu-link">
                                <p class="menu-text">Appointment</p>
                            </a>
                        </div>
                    </div>
                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="patient.php" class="menu-link">
                                <p class="menu-text">Patients</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="dash-body">
            <div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-top: 25px;">
                <div style="display: flex ; justify-content:center;align-items: center; margin-left:10px;">
                    <a href="schedule.php">
                        <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <span class="tn-in-text">Back</span>
                        </button>
                    </a>
                    <p style="font-size: 23px; font-weight: 600;margin-left:30px;">Schedule Manager</p>

                </div>
                <div style="display: flex;  margin-right:5%">
                    <div style="text-align: right;">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
                        <p class="heading-sub12" style="margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            echo date('Y-m-d');
                            ?>
                        </p>
                    </div>
                    <div class="calendar-container">
                        <button class="btn-label">
                            <i class="fas fa-calendar-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="background-color:#dadada; ">
                <div style=" display: flex; justify-content:space-between; padding: 2% 5%; ">
                    <div class="heading-main12" style=" ">Schedule a Session</div>
                    <a href="?action=add-session&id=none&error=0" class="non-style-link">
                        <button class="login-btn btn-primary btn button-icon" style=" ">Add a Session</button>
                    </a>
                </div>
                <div class="session-container" style="padding: 2% 5%;">
                    <?php

                    date_default_timezone_set('Asia/Kolkata');

                    $today = date('Y-m-d');
                    // echo $today;

                    $list110 = $database->query("select  * from  schedule;");

                    ?>
                    <p class="heading-main12 " style="color: royalblue;">All Sessions (<?php echo $list110->num_rows; ?>)</p>
                </div>
            </div>
            <div class="filter-container">
                
                <div class="filter-label">Date:</div>
                <div class="filter-input">
                    <form action="" method="post">
                        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items">
                    </form>
                </div>

                <div class="filter-label">Doctor:</div>
                <div class="filter-input">
                    <select name="docid" class="box filter-container-items">
                        <option value="" disabled selected hidden>Choose Doctor Name from the list</option>

                        <?php
                            $list11 = $database->query("SELECT * FROM doctor ORDER BY docname ASC;");
                            while ($row00 = $list11->fetch_assoc()) {
                                $sn = $row00["docname"];
                                $id00 = $row00["docid"];
                                echo "<option value='$id00'>$sn</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="filter-button">
                    <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter">
                    </form>
                </div>
            </div>




            <table border="0"  style="  width:95%; margin:0 auto; ">
                <?php

                    date_default_timezone_set('Asia/Kolkata');

                    $today = date('Y-m-d');
                    // echo $today;

                    $list110 = $database->query("select  * from  schedule;");

                ?>




                <?php
                    if ($_POST) {
                        $sqlpt1 = "";
                        if (!empty($_POST["sheduledate"])) {
                            $sheduledate = $_POST["sheduledate"];
                            $sqlpt1 = " schedule.scheduledate='$sheduledate' ";
                        }

                        $sqlpt2 = "";
                        if (!empty($_POST["docid"])) {
                            $docid = $_POST["docid"];
                            $sqlpt2 = " doctor.docid=$docid ";
                        }
                        
                        $sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid ";
                        $sqllist = array($sqlpt1, $sqlpt2);
                        $sqlkeywords = array(" where ", " and ");
                        $key2 = 0;
                        foreach ($sqllist as $key) {

                            if (!empty($key)) {
                                $sqlmain .= $sqlkeywords[$key2] . $key;
                                $key2++;
                            };
                        };
                        
                    } else {
                        $sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";
                    }



                ?>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">
                                                Session Title
                                            </th>

                                            <th class="table-headin">
                                                Doctor
                                            </th>

                                            <th class="table-headin">
                                                Sheduled Date & Time
                                            </th>
                                            <th class="table-headin">

                                                Max num that can be booked

                                            </th>

                                            <th class="table-headin">
                                                Events
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                            $result = $database->query($sqlmain);

                                            if ($result->num_rows == 0) {
                                                echo '<tr>
                                                            <td colspan="4">
                                                                <br><br><br><br>
                                                                <center>
                                                                    <img src="../img/notfound.svg" width="25%">
                                                                    
                                                                    <br>
                                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                                                    </a>
                                                                </center>
                                                                <br><br><br><br>
                                                            </td>
                                                        </tr>';
                                            } else {
                                                for ($x = 0; $x < $result->num_rows; $x++) {
                                                    $row = $result->fetch_assoc();
                                                    $scheduleid = $row["scheduleid"];
                                                    $title = $row["title"];
                                                    $docname = $row["docname"];
                                                    $scheduledate = $row["scheduledate"];
                                                    $scheduletime = $row["scheduletime"];
                                                    $nop = $row["nop"];
                                                    echo '<tr>
                                                            <td> &nbsp;' . substr($title, 0, 30) . '</td>

                                                            <td>' . substr($docname, 0, 20) . '</td>

                                                            <td style="text-align:center;">
                                                                ' . substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5) . '
                                                            </td>
                                                            
                                                            <td style="text-align:center;">
                                                                ' . $nop . '
                                                            </td>

                                                            <td>
                                                            
                                                                <div style="display:flex;justify-content: center;">
                                                                    
                                                                    <a href="?action=view&id='.$scheduleid .'" class="non-style-link">
                                                                        <button class="view1 " >
                                                                        <i class="fas fa-eye" style="color:royalblue; font-size: 1.3em; "></i> <!-- Change icon color -->
                                                                            <span class=" tn-in-text" style="font-weight:bold; ">View</span>
                                                                        </button>
                                                                    </a>
                                                                    <a href="?action=drop&id='. $scheduleid .'&name='.urlencode($title) .'" class="non-style-link">
                                                                        <button class="remove " >
                                                                            <i class="fas fa-trash-alt" style="color: white;"></i> <!-- Change icon color -->
                                                                            <span class=" tn-in-text">Remove</span>
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                }
                                            }

                                        ?>

                                    </tbody>

                                </table>
                            </div>
                        </center>
                    </td>
                </tr>



            </table>
        </div>
    </div>
    <?php

        if ($_GET) {
            $id = $_GET["id"];
            $action = $_GET["action"];
            if ($action == 'add-session') {

                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                            <center>
                                <a class="close" href="schedule.php">&times;</a> 
                                <div style="display: flex;justify-content: center;">
                                    <div class="abc">
                                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                            <tr>
                                                <td class="label-td" colspan="2"></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Session.</p><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <form action="add-session.php" method="POST" class="add-new-form">
                                                        <label for="title" class="form-label">Session Title : </label>
                                                    
                                                </td>
                                                <td class="label-td" colspan="2">
                                                    <select name="title" id="" class="box">
                                                        <option value="" disabled selected hidden>Choose doctor specialization</option><br />';


                                                        $list11 = $database->query("select * from specialties order by sname asc;");

                                                        for ($y = 0; $y < $list11->num_rows; $y++) {
                                                            $row00 = $list11->fetch_assoc();
                                                            $sn = $row00["sname"];
                                                            $id00 = $row00["id"];
                                                            echo "<option value=" . $sn . ">$sn</option><br />";
                                                            };




                                                            echo '
                                                    </select><br><br>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                
                                                <td class="label-td" colspan="2">
                                                    <label for="docid" class="form-label">Select Doctor: </label>
                                                </td>
                                                <td class="label-td" colspan="2">
                                                    <select name="docid" id="" class="box" >
                                                    <option value="" disabled selected hidden>Choose Doctor Name from the list</option><br/>';


                                                    $list11 = $database->query("select  * from  doctor order by docname asc;");

                                                    for ($y = 0; $y < $list11->num_rows; $y++) {
                                                        $row00 = $list11->fetch_assoc();
                                                        $sn = $row00["docname"];
                                                        $id00 = $row00["docid"];
                                                        echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                    };

                                                    echo     '</select><br><br>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="nop" class="form-label">Number of Patients/Appointment Numbers : </label>
                                                </td>
                                                <td class="label-td" colspan="2">
                                                    <input type="number" name="nop" class="input-text" min="0"  placeholder="The final appointment number for this session depends on this number" required><br>
                                                </td>
                                            </tr>
                                            
                                                    
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="date" class="form-label">Session Date: </label>
                                                </td>
                                                <td class="label-td" colspan="2">
                                                    <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                                </td>
                                            </tr>
                                        
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="time" class="form-label">Schedule Time: </label>
                                                </td>
                                                <td class="label-td" colspan="2">
                                                    <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                                </td>
                                            </tr>
                                        
                                        
                                            <tr>
                                                <td colspan="2">
                                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                
                                                </td>
                                                <td colspan="2">
                                                        <a href="./add-session.php"><input type="submit" value="Place this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                                                    </a>
                                                </td>
                                
                                            </tr>
                                            </form>
                                        
                                            
                                        </table>
                                    </div>
                                </div>
                            </center>
                        <br><br>
                    </div>
                </div>
                ';
            } elseif ($action == 'session-added') {
                $titleget = $_GET["title"];
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <br><br>
                            <h2>Session Placed.</h2>
                            <a class="close" href="schedule.php">&times;</a>
                            <div class="content">
                            ' . substr($titleget, 0, 40) . ' was scheduled.<br><br>
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                                <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                                <br><br><br><br>
                            </div>
                        </center>
                    </div>
                </div>
                ';
            } elseif ($action == 'drop') {
                $nameget = $_GET["name"];
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <h2>Are you sure?</h2>
                            <a class="close" href="schedule.php">&times;</a>
                            <div class="content">
                                You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                                <a href="delete-session.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                                <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                            </div>
                        </center>
                    </div>
                </div>
                ';
            } elseif ($action == 'view') {
                $sqlmain = "SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime, schedule.nop 
                FROM schedule 
                INNER JOIN doctor ON schedule.docid = doctor.docid  
                WHERE schedule.scheduleid = $scheduleid";

                $result = $database->query($sqlmain);
                $row = $result->fetch_assoc();
                $docname = $row["docname"];
                $scheduleid = $row["scheduleid"];
                $title = $row["title"];
                $scheduledate = $row["scheduledate"];
                $scheduletime = $row["scheduletime"];


                $nop = $row['nop'];
                $sqlmain12 = "SELECT * FROM appointment 
                INNER JOIN patient ON patient.pid = appointment.pid 
                INNER JOIN schedule ON schedule.scheduleid = appointment.scheduleid 
                WHERE schedule.scheduleid =  $scheduleid ;";

                $result12 = $database->query($sqlmain12);
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup" style="width: 70%;">
                        <center>
                            <h2></h2>
                            <a class="close" href="schedule.php">&times;</a>
                            <div class="content">
                                
                                
                            </div>
                            <div class="abc scroll" style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Session Title: </label>
                                        </td>
                                        <td class="label-td" colspan="2">
                                            ' . $title . '<br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Email" class="form-label">Doctor of this session: </label>
                                        </td>
                                        <td class="label-td" colspan="2">
                                        ' . $docname . '<br><br>
                                        </td>
                                    </tr>
                                
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="nic" class="form-label">Scheduled Date: </label>
                                        </td>
                                        <td class="label-td" colspan="2">
                                        ' . $scheduledate . '<br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Scheduled Time: </label>
                                        </td>
                                        <td class="label-td" colspan="2">
                                        ' . $scheduletime . '<br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="spec" class="form-label"><b>Patients that Already registerd for this session:</b> (' . $result12->num_rows . "/" . $nop . ')</label>
                                            <br><br>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td colspan="4">
                                            <center>
                                                <div class="abc scroll">
                                                    <table width="100%" class="sub-table scrolldown" border="0">
                                                                <thead>
                                                                    <tr>   
                                                                            <th class="table-headin">
                                                                                Patient ID
                                                                            </th>
                                                                            <th class="table-headin">
                                                                                Patient name
                                                                            </th>
                                                                            <th class="table-headin">
                                                                                
                                                                                Appointment number
                                                                                
                                                                            </th>
                                                                            
                                                                            
                                                                            <th class="table-headin">
                                                                                Patient Telephone
                                                                            </th>
                                                                    </tr>
                                                                        
                                                                </thead>
                                                            <tbody>';
                                                                $result = $database->query($sqlmain12);

                                                                if ($result->num_rows == 0) {
                                                                    echo '  <tr>
                                                                                <td colspan="7">
                                                                                        <br><br><br><br>
                                                                                    <center>
                                                                                        <img src="../img/notfound.svg" width="25%">
                                                                                                        
                                                                                        <br>
                                                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                                                                        <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                                                                                        </a>
                                                                                    </center>
                                                                                        <br><br><br><br>
                                                                                                
                                                                                </td>
                                                                            </tr>';
                                                                } else {
                                                                    for ($x = 0; $x < $result->num_rows; $x++) {
                                                                        $row = $result->fetch_assoc();
                                                                        $apponum = $row["apponum"];
                                                                        $pid = $row["pid"];
                                                                        $pname = $row["pname"];
                                                                        $ptel = $row["ptel"];

                                                                        echo ' <tr style="text-align:center;">
                                                                        <td>
                                                                        ' . substr($pid, 0, 15) . '
                                                                        </td>
                                                                        <td style="font-weight:600;padding:25px">' . substr($pname, 0, 25) . '</td >
                                                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                                                        ' . $apponum . '
                                                                        </td>
                                                                        <td>
                                                                        ' . substr($ptel, 0, 25) . '
                                                                        </td>
                                                                        
                                                                        </tr>';
                                                                    }
                                                                }
                                                        echo '</tbody>
                                    
                                                    </table>
                                                </div>
                                            </center>
                                        </td> 
                                    </tr>

                                </table>
                            </div>
                        </center>
                        <br><br>
                    </div>
                </div>
                ';
            }
        }

    ?>
    


</body>

</html>