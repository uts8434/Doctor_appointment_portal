<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .menu-link {
            display: flex;
            justify-content: center;
            align-items: center;
            text-wrap: nowrap;

        }

        .menu-text {
            padding-left: 5%;

        }
    </style>
</head>

<body>
    <?php

    //learn from w3schools.com

    session_start();

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'd') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }



    //import database
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["docid"];
    $username = $userfetch["docname"];
    //echo $userid;
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
                                <p class="profile-title"><?php echo substr($username, 0, 22) ?></p>
                                <p class="profile-subtitle"><?php echo substr($useremail, 0, 22)  ?></p>
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
                                <i class="fas fa-home"></i>
                                <p class="menu-text">Dashboard</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="appointment.php" class="menu-link">
                                <i class="fas fa-user-md"></i>
                                <p class="menu-text">My Appointments</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="schedule.php" class="menu-link">
                                <i class="fas fa-calendar-alt"></i>
                                <p class="menu-text">My Sessions</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="patient.php" class="menu-link">
                                <i class="fas fa-book"></i>
                                <p class="menu-text">My Patients</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="settings.php" class="menu-link">
                                <i class="fas fa-cog"></i>
                                <p class="menu-text">Settings</p>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="dash-body">
            <div style="display: flex; align-items: center; width: 100%; padding: 10px;">
                <div style="width: 13%;">
                    <a href="schedule.php">
                        <button style="padding: 11px; margin-left: 20px; width: 125px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div style="flex-grow: 1;">
                    <p style="font-size: 23px; padding-left: 12px; font-weight: 600;">My Sessions</p>
                </div>
                <div style="width: 15%; text-align: right;">
                    <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
                    <p style="margin: 0; font-size: 16px; font-weight: bold;">
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        $today = date('Y-m-d');
                        echo $today;
                        $list110 = $database->query("SELECT * FROM schedule WHERE docid=$userid;");
                        ?>
                    </p>
                </div>
                <div style="width: 10%; display: flex; justify-content: center;">
                    <button style="border: none; background: none; cursor: pointer;">
                        <img src="../img/calendar.svg" width="100%">
                    </button>
                </div>
            </div>

            <div style="width: 100%; padding-top: 10px;">
                <p style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49); font-weight: bold;">
                    My Sessions (<?php echo $list110->num_rows; ?>)
                </p>
            </div>


            <div style="width: 100%; margin-top: 25px;">
                <div style="display: flex; justify-content: center; align-items: center; padding:20px; background: #f0f2f5;">
                    <div style="display: flex; align-items: center; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15); width: 60%;">
                        <form action="" method="post" style="display: flex; align-items: center; width: 100%;">

                            <!-- Date Label -->
                            <label for="date" style="font-size: 16px; font-weight: bold; color: #333; margin-right: 10px;">Date:</label>

                            <!-- Date Input -->
                            <input type="date" name="sheduledate" id="date" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; outline: none; transition: border 0.3s;" onfocus="this.style.border='1px solid #007bff'" onblur="this.style.border='1px solid #ccc'">

                            <!-- Filter Button -->
                            <input type="submit" name="filter" value="Filter" style="margin-left: 15px; padding: 10px 15px; background: #007bff; color: white; font-size: 14px; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">

                        </form>
                    </div>
                </div>



                <div style="display: flex; justify-content: center; margin-top: 20px;">
                    <div style="width: 100%; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                        <!-- Table Heading -->
                        <div style="display: flex; justify-content: space-between; font-weight: bold; padding: 12px; background: #007BFF; color: white; border-radius: 5px;">
                            <div style="flex: 1;">Session Title</div>
                            <div style="flex: 1; text-align: center;">Scheduled Date & Time</div>
                            <div style="flex: 1; text-align: center;">Max Bookings</div>
                            <div style="flex: 1; text-align: center;">Actions</div>
                        </div>

                        <?php
                        $sqlmain = "SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime, schedule.nop 
                                        FROM schedule 
                                        INNER JOIN doctor ON schedule.docid = doctor.docid 
                                        WHERE doctor.docid = $userid";
                        $result = $database->query($sqlmain);

                        if ($result->num_rows == 0) {
                            echo '<div style="text-align: center; margin-top: 50px;">
                                        <img src="../img/notfound.svg" width="120px" style="margin-bottom: 15px;">
                                        <p style="font-size: 18px; color: #313131;">No sessions found!</p>
                                        <a href="schedule.php" style="text-decoration: none;">
                                            <button style="padding: 10px 20px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Show All Sessions</button>
                                        </a>
                                    </div>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div style="display: flex; justify-content: space-between; padding: 12px; border-bottom: 1px solid #ddd; align-items: center;">
                                            <div style="flex: 1;">' . substr($row["title"], 0, 30) . '</div>
                                            <div style="flex: 1; text-align: center;">' . substr($row["scheduledate"], 0, 10) . ' ' . substr($row["scheduletime"], 0, 5) . '</div>
                                            <div style="flex: 1; text-align: center;">' . $row["nop"] . '</div>
                                            <div style="flex: 1; text-align: center; display: flex; justify-content: center; gap: 10px;">
                                                <a href="?action=view&id=' . $row["scheduleid"] . '" style="text-decoration: none;">
                                                    <button style="padding: 8px 16px; background: #28A745; color: white; border: none; border-radius: 5px; cursor: pointer;">View</button>
                                                </a>
                                                <a href="?action=drop&id=' . $row["scheduleid"] . '&name=' . $row["title"] . '" style="text-decoration: none;">
                                                    <button style="padding: 8px 16px; background: #DC3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
                                                </a>
                                            </div>
                                        </div>';
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php

    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        if ($action == 'drop') {
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
            $sqlmain = "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where  schedule.scheduleid=$id";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $docname = $row["docname"];
            $scheduleid = $row["scheduleid"];
            $title = $row["title"];
            $scheduledate = $row["scheduledate"];
            $scheduletime = $row["scheduletime"];


            $nop = $row['nop'];


            $sqlmain12 = "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
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
                                    <td colspan="4">
                                        <p style="padding: 0;margin: 0;text-align: center;font-size: 25px;font-weight: 600;">View Details.</p><br><br>
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
                                            
                                    </thead>
                                    <tbody>';




            $result = $database->query($sqlmain12);

            if ($result->num_rows == 0) {
                echo '<tr>
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

                    echo '<tr style="text-align:center;">
                                                    <td>
                                                    ' . substr($pid, 0, 15) . '
                                                    </td>
                                                    <td style="font-weight:600;padding:25px">' .

                        substr($pname, 0, 25)
                        . '</td >
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
                </div>';
        }
    }

    ?>


</body>

</html>