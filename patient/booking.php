<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/animations.css">   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Sessions</title>
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


    include("../connection.php");

    $sqlmain = "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();

    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];





    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');


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
        <div style="display: flex; justify-content: space-between; align-items: center; margin: 3% 5%; gap: 15px;">
    <!-- Back Button -->
    <a href="schedule.php">
        <button class="login-btn btn-primary-soft btn" style="padding: 12px 20px; border-radius: 8px; background: #007bff; color: white; border: none; font-weight: bold; cursor: pointer;">
            Back
        </button>
    </a>

    <!-- Search Bar -->
    <form action="schedule.php" method="post" class="header-search" style="display: flex; align-items: center; gap: 10px;">
        <input type="search" name="search" class="input-text header-searchbar" 
            placeholder="Search Doctor, Email, or Date (YYYY-MM-DD)" list="doctors" 
            style="padding-left: 40px; border-radius: 8px; border: 1px solid #ccc; width: 280px; font-size: 14px;">
        
        <button type="submit" class="login-btn btn-primary btn" style="padding: 12px 20px; border: none; border-radius: 8px; background: var(--primarycolor); color: white; font-weight: bold; cursor: pointer;">
            <i class="fas fa-search" style="margin-right: 5px;"></i> Search
        </button>
    </form>

    <!-- Today's Date & Calendar -->
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="text-align: right;">
            <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
            <p class="heading-sub12" style="margin: 0; font-weight: bold; font-size: 16px;"><?php echo $today; ?></p>
        </div>
        <button class="btn-label" style="display: flex; justify-content: center; align-items: center; background: none; border: none; cursor: pointer;">
            <i class="fas fa-calendar-alt" style="font-size: 26px; color: #007bff;"></i>
        </button>
    </div>
</div>

<datalist id="doctors">
    <?php
    $list11 = $database->query("SELECT DISTINCT docname FROM doctor;");
    $list12 = $database->query("SELECT DISTINCT title FROM schedule;");

    while ($row = $list11->fetch_assoc()) {
        echo "<option value='{$row["docname"]}'>";
    }

    while ($row = $list12->fetch_assoc()) {
        echo "<option value='{$row["title"]}'>";
    }
    ?>
</datalist>

            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">


                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">

                                    <tbody>

                                        <?php

                                        if (($_GET)) {


                                            if (isset($_GET["id"])) {


                                                $id = $_GET["id"];

                                                $sqlmain = "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduleid=? order by schedule.scheduledate desc";
                                                $stmt = $database->prepare($sqlmain);
                                                $stmt->bind_param("i", $id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                //echo $sqlmain;
                                                $row = $result->fetch_assoc();
                                                $scheduleid = $row["scheduleid"];
                                                $title = $row["title"];
                                                $docname = $row["docname"];
                                                $docemail = $row["docemail"];
                                                $scheduledate = $row["scheduledate"];
                                                $scheduletime = $row["scheduletime"];
                                                $sql2 = "select * from appointment where scheduleid=$id";
                                                //echo $sql2;
                                                $result12 = $database->query($sql2);
                                                $apponum = ($result12->num_rows) + 1;

                                                echo '
                                                        <form action="booking-complete.php" method="post">
                                                            <input type="hidden" name="scheduleid" value="' . $scheduleid . '" >
                                                            <input type="hidden" name="apponum" value="' . $apponum . '" >
                                                            <input type="hidden" name="date" value="' . $today . '" >   

                                                        </form>
                                                    
                                                        ';


                                                echo '
                                                    <div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px; justify-content: center;">
                                                            <!-- Session Details -->
                                                            <div style="flex: 1; min-width: 300px; max-width: 500px; background: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                                                                <h2 style="font-size: 22px; margin-bottom: 15px; color: #333;">Session Details</h2>
                                                                <p style="font-size: 16px; margin-bottom: 8px;"><strong>Doctor Name:</strong> ' . $docname . '</p>
                                                                <p style="font-size: 16px; margin-bottom: 8px;"><strong>Doctor Email:</strong>' . $docemail . '</p>
                                                                <hr style="border: none; height: 1px; background: #ddd; margin: 15px 0;">
                                                                <p style="font-size: 16px; margin-bottom: 8px;"><strong>Session Title:</strong> ' . $title . '</p>
                                                                <p style="font-size: 16px; margin-bottom: 8px;"><strong>Scheduled Date:</strong> ' . $scheduledate . '</p>
                                                                <p style="font-size: 16px; margin-bottom: 8px;"><strong>Session Starts:</strong> ' . $scheduletime . '</p>
                                                                <p style="font-size: 16px; font-weight: bold; color: #007bff;">Channeling Fee: ₹500.00</p>
                                                            </div>

                                                            <!-- Appointment Number -->
                                                            <div style="flex: 1; min-width: 250px; max-width: 300px; background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); text-align: center;">
                                                                <h3 style="font-size: 20px; color: #333; margin-bottom: 15px;">Your Appointment Number</h3>
                                                                <div style="font-size: 50px; font-weight: bold; color: #ffffff; background: #007bff; display: inline-block; padding: 15px 25px; border-radius: 8px;">
                                                                    ' . $apponum . '
                                                                </div>
                                                                <div style="text-align: center; margin-top: 20px;">
                                                                <form action="booking-complete.php" method="post">
                                                                    <input type="hidden" name="scheduleid" value="'.$scheduleid.'">
                                                                    <input type="hidden" name="apponum" value="'.$apponum.'">
                                                                    <input type="hidden" name="date" value="'.$today.'">
                                                                    <input type="submit" value="Book Now" name="booknow" 
                                                                        style="background: #007bff; color: #fff; font-size: 18px; padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                                                                </form>
                                                            </div>
                                                            </div>
                                                        </div>

                                                            

                                                        ';
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





</body>

</html>