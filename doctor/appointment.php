<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Appointments</title>
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

    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["docid"];
    $username = $userfetch["docname"];

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
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">


                <div style="flex: 1;">
                    <a href="appointment.php">
                        <button style="padding: 11px; margin-left: 20px; width: 125px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">
                            Back
                        </button>
                    </a>
                </div>

                <div style="flex: 2; text-align: center;">
                    <p style="font-size: 23px; font-weight: 600; margin: 0;">Appointment Manager</p>
                </div>

                <div style="flex: 1; text-align: right;">
                    <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
                    <p style="font-size: 16px; font-weight: bold; margin: 0;">
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        $today = date('Y-m-d');
                        echo $today;
                        $list110 = $database->query("SELECT * FROM schedule 
                                                            INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                                                            INNER JOIN patient ON patient.pid = appointment.pid 
                                                            INNER JOIN doctor ON schedule.docid = doctor.docid  
                                                            WHERE doctor.docid = $userid ");
                        ?>
                    </p>
                </div>


                <div style="flex: 0.5; display: flex; justify-content: center; align-items: center;">
                    <button style="background: none; border: none; cursor: pointer; padding: 5px;">
                        <img src="../img/calendar.svg" style="width: 40px; height: 40px;">
                    </button>
                </div>

            </div>

            <div style="padding: 10px; margin-top: 10px;">
                <p style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49); font-weight: bold;">
                    My Appointments (<?php echo $list110->num_rows; ?>)
                </p>
            </div>

            <div style="background-color:#dadada; width: 100%; padding: 20px; display: flex; justify-content: center;">
                <div style="display:  align-items: center; gap: 10px; padding: 15px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 60%;">


                    <label for="date" style="font-size: 16px; font-weight: bold;">Date:</label>

                    <form action="" method="post" style="display: flex; width: 100%; gap: 10px;">
                        <input type="date" name="sheduledate" id="date" class="input-text" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">

                        <input type="submit" name="filter" value="Filter" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
                    </form>
                </div>
            </div>


            <div style="width: 100%; margin-top: 25px;">
                <?php
                $sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, patient.pname, 
                            schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate 
                            FROM schedule 
                            INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                            INNER JOIN patient ON patient.pid = appointment.pid 
                            INNER JOIN doctor ON schedule.docid = doctor.docid 
                            WHERE doctor.docid = $userid";

                if ($_POST) {
                    if (!empty($_POST["sheduledate"])) {
                        $sheduledate = $_POST["sheduledate"];
                        $sqlmain .= " AND schedule.scheduledate='$sheduledate' ";
                    }
                }

                $result = $database->query($sqlmain);
                ?>

                <div style="width: 93%; margin: auto; overflow-x: auto;">
                    <div style="display: flex; font-weight: bold; padding: 10px; background-color: #f8f8f8; border-bottom: 1px solid #ddd;">
                        <div style="flex: 1;">Patient Name</div>
                        <div style="flex: 1; text-align: center;">Appointment Number</div>
                        <div style="flex: 1;">Session Title</div>
                        <div style="flex: 1; text-align: center;">Session Date & Time</div>
                        <div style="flex: 1; text-align: center;">Appointment Date</div>
                        <div style="flex: 1; text-align: center;">Events</div>
                    </div>

                    <?php if ($result->num_rows == 0): ?>
                        <div style="text-align: center; padding: 20px;">
                            <img src="../img/notfound.svg" width="25%">
                            <p style="font-size: 20px; color: #313131;">We couldn't find anything related to your keywords!</p>
                            <a href="appointment.php" style="text-decoration: none;"><button style="padding: 10px 20px; background: #007bff; color: #fff; border: none; cursor: pointer;">Show all Appointments</button></a>
                        </div>
                    <?php else: ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div style="display: flex; padding: 10px; border-bottom: 1px solid #ddd; align-items: center;">
                                <div style="flex: 1; font-weight: 600;">&nbsp;<?= substr($row["pname"], 0, 25) ?></div>
                                <div style="flex: 1; text-align: center; font-size: 23px; font-weight: 500; color: #007bff;">
                                    <?= $row["apponum"] ?>
                                </div>
                                <div style="flex: 1;">
                                    <?= substr($row["title"], 0, 15) ?>
                                </div>
                                <div style="flex: 1; text-align: center;">
                                    <?= substr($row["scheduledate"], 0, 10) ?> @<?= substr($row["scheduletime"], 0, 5) ?>
                                </div>
                                <div style="flex: 1; text-align: center;">
                                    <?= $row["appodate"] ?>
                                </div>
                                <div style="flex: 1; display: flex; justify-content: center;">
                                    <a href="?action=drop&id=<?= $row['appoid'] ?>&name=<?= $row['pname'] ?>&session=<?= $row['title'] ?>&apponum=<?= $row['apponum'] ?>" style="text-decoration: none;">
                                        <button style="padding: 10px 20px; background: #dc3545; color: #fff; border: none; cursor: pointer;">Cancel</button>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
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
                                            <td class="label-td" colspan="2">' .
                    ""

                    . '</td>
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
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="title" class="input-text" placeholder="Name of this Session" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="label-td" colspan="2">
                                                <label for="docid" class="form-label">Select Doctor: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <select name="docid" id="" class="box" >
                                                <option value="" disabled selected hidden>Choose Doctor Name from the list</option><br/>';


                $list11 = $database->query("select  * from  doctor;");

                for ($y = 0; $y < $list11->num_rows; $y++) {
                    $row00 = $list11->fetch_assoc();
                    $sn = $row00["docname"];
                    $id00 = $row00["docid"];
                    echo "<option value=" . $id00 . ">$sn</option><br/>";
                };




                echo     '       </select><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="nop" class="form-label">Number of Patients/Appointment Numbers : </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="number" name="nop" class="input-text" min="0"  placeholder="The final appointment number for this session depends on this number" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="date" class="form-label">Session Date: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="date" name="date" class="input-text" min="' . date('Y-m-d') . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="time" class="form-label">Schedule Time: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                                <input type="submit" value="Place this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                                            </td>
                            
                                        </tr>
                                    
                                        </form>
                                        </tr>
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
                $session = $_GET["session"];
                $apponum = $_GET["apponum"];
                echo '
                        <div id="popup1" class="overlay">
                                <div class="popup">
                                <center>
                                    <h2>Are you sure?</h2>
                                    <a class="close" href="appointment.php">&times;</a>
                                    <div class="content">
                                        You want to delete this record<br><br>
                                        Patient Name: &nbsp;<b>' . substr($nameget, 0, 40) . '</b><br>
                                        Appointment number &nbsp; : <b>' . substr($apponum, 0, 40) . '</b><br><br>
                                        
                                    </div>
                                    <div style="display: flex;justify-content: center;">
                                    <a href="delete-appointment.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                                    <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                                    </div>
                                </center>
                        </div>
                        </div>
                        ';
            } elseif ($action == 'view') {
                $sqlmain = "select * from doctor where docid='$id'";
                $result = $database->query($sqlmain);
                $row = $result->fetch_assoc();
                $name = $row["docname"];
                $email = $row["docemail"];
                $spe = $row["specialties"];

                $spcil_res = $database->query("select sname from specialties where id='$spe'");
                $spcil_array = $spcil_res->fetch_assoc();
                $spcil_name = $spcil_array["sname"];
                $nic = $row['docnic'];
                $tele = $row['doctel'];
                echo '
                        <div id="popup1" class="overlay">
                                <div class="popup">
                                <center>
                                    <h2></h2>
                                    <a class="close" href="doctors.php">&times;</a>
                                    <div class="content">
                                        eDoc Web App<br>
                                        
                                    </div>
                                    <div style="display: flex;justify-content: center;">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Name: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                ' . $name . '<br><br>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="Email" class="form-label">Email: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                            ' . $email . '<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="nic" class="form-label">AYUSHMAN CARD NUMBER:</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                            ' . $nic . '<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="Tele" class="form-label">Telephone: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                            ' . $tele . '<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="spec" class="form-label">Specialties: </label>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                        <td class="label-td" colspan="2">
                                        ' . $spcil_name . '<br><br>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                            
                                                
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
    </div>

</body>

</html>