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
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'p') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");
    $sqlmain = "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];

    $sqlmain = "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

    if ($_POST) {

        if (!empty($_POST["sheduledate"])) {
            $sheduledate = $_POST["sheduledate"];
            $sqlmain .= " and schedule.scheduledate='$sheduledate' ";
        };
    }

    $sqlmain .= "order by appointment.appodate  asc";
    $result = $database->query($sqlmain);
    ?>
    <?php
    if (isset($_GET["status"]) && isset($_GET["message"])) {
        $status = $_GET["status"];
        $message = $_GET["message"];

        echo "<script>
        alert('$message');
        window.location.href = 'appointment.php'; // Redirect to remove GET parameters
    </script>";
    }
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
                                <p class="menu-text">Home</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="doctors.php" class="menu-link">
                                <i class="fas fa-user-md"></i>
                                <p class="menu-text">All Doctors</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="schedule.php" class="menu-link">
                                <i class="fas fa-calendar-alt"></i>
                                <p class="menu-text">Scheduled Sessions</p>
                            </a>
                        </div>
                    </div>

                    <div class="menu-row">
                        <div class="menu-btn">
                            <a href="appointment.php" class="menu-link">
                                <i class="fas fa-book"></i>
                                <p class="menu-text">My Bookings</p>
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

            <div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-top: 25px;">
                <div style="display: flex ; justify-content:center;align-items: center; margin-left:10px;">
                    <a href="settings.php">
                        <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <span class="tn-in-text">Back</span>
                        </button>
                    </a>
                    <p style="font-size: 23px; font-weight: 600;margin-left:30px;">My Bookings history</p>

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

            <div style="padding-top:10px;width: 100%;">
                <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49);">
                    My Bookings (<?php echo $result->num_rows; ?>)
                </p>
            </div>
            <div style="padding-top:0px; width: 100%;">
                <div style="display: flex; justify-content: center;">
                    <div class="filter-container" style="display: flex; align-items: center; gap: 10px;">


                        <div style="width: 5%; text-align: center;">Date:</div>

                        <div style="width: 30%;">
                            <form action="" method="post" style="display: flex; gap: 10px;">
                                <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0; width: 95%;">
                        </div>

                        <div style="width: 12%;">
                            <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0; width: 100%;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll" style="width:100%; padding: 20px; border: none; box-sizing: border-box;">
                                <div style="width: 93%; display: flex; flex-wrap: wrap; justify-content:flex-start; gap: 20px;">
                                    <?php
                                    if ($result->num_rows == 0) {
                                        echo '<div style="width: 100%; text-align: center; padding: 50px 0;">
                                            <img src="../img/notfound.svg" width="25%">
                                            <p style="font-size:20px; color:rgb(49, 49, 49); margin-top: 10px;">We couldn\'t find anything related to your keywords!</p>
                                            <a href="appointment.php" style="text-decoration: none;">
                                                <button style="background-color: #007bff; color: white; border: none; padding: 12px 20px; margin-top: 10px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                                                    Show all Appointments
                                                </button>
                                            </a>
                                        </div>';
                                    } else {
                                        for ($x = 0; $x < ($result->num_rows); $x++) {
                                            for ($q = 0; $q < 3; $q++) {
                                                $row = $result->fetch_assoc();
                                                if (!isset($row)) break;

                                                $scheduleid = $row["scheduleid"];
                                                $title = $row["title"];
                                                $docname = $row["docname"];
                                                $scheduledate = $row["scheduledate"];
                                                $scheduletime = $row["scheduletime"];
                                                $apponum = $row["apponum"];
                                                $appodate = $row["appodate"];
                                                $appoid = $row["appoid"];

                                                if ($scheduleid == "") break;

                                                echo '
                                                    <div style="width: 30%; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                                                        <div style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                                                            Booking Date: ' . substr($appodate, 0, 30) . '<br>
                                                            Reference Number: OC-000-' . $appoid . '
                                                        </div>
                                                        <div style="font-size: 20px; font-weight: bold; color: #007bff; margin-bottom: 10px;">
                                                            ' . substr($title, 0, 21) . '
                                                        </div>
                                                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 16px;">
                                                            <div>Appointment Number:</div>
                                                            <div style="font-size: 22px; font-weight: bold; color: #007bff;">' . $apponum . '</div>
                                                        </div>
                                                        <div style="font-size: 16px; color: #555; margin-bottom: 10px; display:flex ; justify-content:center;">
                                                            <p>Doctor Name: <span style="color:royalblue; font-weight:600;">' . substr($docname, 0, 30) . '</span></p>
                                                        </div>
                                                        <div style="font-size: 14px; color: #777; margin-bottom: 15px;">
                                                            Scheduled Date: ' . $scheduledate . '<br>
                                                            Starts: <b>@' . substr($scheduletime, 0, 5) . '</b> (24h)
                                                        </div>
                                                        <a href="?action=drop&id=' . $appoid . '&title=' . $title . '&doc=' . $docname . '" style="text-decoration: none;">
                                                            <button style="background-color: #ff4d4d; color: white; border: none; padding: 12px 20px; width: 100%; border-radius: 5px; font-size: 16px; cursor: pointer;">
                                                                Cancel Booking
                                                            </button>
                                                        </a>
                                                    </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
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
        if ($action == 'booking-added') {

            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <br><br>
                        <h2>Booking Successfully.</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                        Your Appointment number is ' . $id . '.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
                </div>
            </div>
            ';
        } elseif ($action == 'drop') {
            $title = $_GET["title"];
            $docname = $_GET["doc"];
            $id = $_GET["id"];

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to Cancel this Appointment?<br><br>
                            Session Name: &nbsp;<b>' . substr($title, 0, 40) . '</b><br>
                            Doctor name&nbsp; : <b>' . substr($docname, 0, 40) . '</b><br><br>
                            
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
            $sqlmain = "select * from doctor where docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $name = $row["docname"];
            $email = $row["docemail"];
            $spe = $row["specialties"];

            $sqlmain = "select sname from specialties where id=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s", $spe);
            $stmt->execute();
            $spcil_res = $stmt->get_result();
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


</body>

</html>