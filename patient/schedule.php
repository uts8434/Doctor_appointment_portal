<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    $result = $stmt->get_result();
    $userfetch = $result->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];



    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');

    ?>
    <div class="parent">
    <!-- style=" display:none;" -->
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


        <?php
        

        $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today'  order by schedule.scheduledate asc";
        $sqlpt1="";
        $insertkey="";
        $q='';
        $searchtype="All";
                if($_POST){
                //print_r($_POST);
                
                    if(!empty($_POST["search"])){
                        /*TODO: make and understand */
                        $keyword=$_POST["search"];
                        $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and (doctor.docname='$keyword' or doctor.docname like '$keyword%' or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' or schedule.title='$keyword' or schedule.title like '$keyword%' or schedule.title like '%$keyword' or schedule.title like '%$keyword%' )  order by schedule.scheduledate asc";
                        //echo $sqlmain;
                        $insertkey=$keyword;
                        $searchtype="Search Result: ";
                        $q='"';
                    }

                }


        $result= $database->query($sqlmain);
        // print_r($result);
        ?>

        <div class="dash-body">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 10px 20px;">


                <div style="width: 13%;">
                    <a href="schedule.php">
                        <button class="login-btn btn-primary-soft btn " style="padding: 11px; width: 125px;">
                            <span class="tn-in-text">Back</span>
                        </button>
                    </a>
                </div>


                <div style="flex-grow: 1; display: flex; justify-content: center;">
                    <form action="" method="post" class="header-search" style="display: flex; align-items: center; gap: 10px;">
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" value="<?php echo $insertkey; ?>" style="width: 250px;">
                        <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding: 10px 25px;">
                    </form>
                </div>


                <div style="width: 15%; text-align: right;">
                    <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
                    <p class="heading-sub12" style="margin: 0;">
                        <?php echo $today; ?>
                    </p>
                </div>

                <div style="width: 10%; display: flex; justify-content: center; align-items: center;">
                    <button class="btn-label" style="display: flex; justify-content: center; align-items: center;">
                        <img src="../img/calendar.svg" width="100%">
                    </button>
                </div>

            </div>



            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype . " Sessions" . "(" . $result->num_rows . ")"; ?> </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q . $insertkey . $q; ?> </p>
                    </td>

                </tr>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll" style="width:100%; padding: 50px; border: none; box-sizing: border-box;">
                                <div style="width: 100%; display: flex; flex-wrap: wrap; justify-content:flex-start; gap: 20px;">
                                    <?php
                                    if ($result->num_rows == 0) {
                                        echo '<div style="width: 100%; text-align: center; padding: 50px 0;">
                                            <img src="../img/notfound.svg" width="25%">
                                            <p style="font-size:20px; color:rgb(49, 49, 49); margin-top: 10px;">We couldn\'t find anything related to your keywords!</p>
                                            <a href="schedule.php" style="text-decoration: none;">
                                                <button style="background-color: #007bff; color: white; border: none; padding: 12px 20px; margin-top: 10px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                                                    Show all Sessions
                                                </button>
                                            </a>
                                        </div>';
                                    } else {
                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                            for ($q = 0; $q < 3; $q++) {
                                                $row = $result->fetch_assoc();
                                                if (!isset($row)) break;

                                                $scheduleid = $row["scheduleid"];
                                                $title = $row["title"];
                                                $docname = $row["docname"];
                                                $scheduledate = $row["scheduledate"];
                                                $scheduletime = $row["scheduletime"];

                                                if ($scheduleid == "") break;

                                                echo '
                                                    <div style="width: 20%; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                                                        <div style="font-size: 20px; font-weight: 600; color: #333; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            ' . substr($title, 0, 21) . '
                                                        </div>
                                                        <div style="font-size: 16px; color: #555; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            ' . substr($docname, 0, 30) . '
                                                        </div>
                                                        <div style="font-size: 14px; color: #777; margin-bottom: 15px;">
                                                            ' . $scheduledate . '<br>
                                                            Starts: <b>' . substr($scheduletime, 0, 5) . '</b> (24h)
                                                        </div>
                                                        <a href="booking.php?id=' . $scheduleid . '" style="text-decoration: none;">
                                                            <button style="background-color: #007bff; color: white; border: none; padding: 12px 20px; width: 100%; border-radius: 5px; font-size: 16px; cursor: pointer;">
                                                                Book Now
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

    
</body>

</html>