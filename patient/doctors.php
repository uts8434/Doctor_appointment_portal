<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



    <title>Doctors</title>
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
    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];

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

            <div class="header_nav" style="margin-top: 5%;">

                <div>
                    <a href="doctors.php">
                        <button class="login-btn btn-primary-soft btn ">
                            <!--     -->
                            <span class="tn-in-text">Back</span>
                        </button>
                    </a>
                </div>

                <div class="nav-bar">
                    <form action="doctors.php" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">
                        &nbsp;&nbsp;

                        <?php
                        echo '<datalist id="doctors">';
                        $list11 = $database->query("select docname from doctor;");
                        while ($row00 = $list11->fetch_assoc()) {
                            $d = $row00["docname"];

                            echo "<option value='$d'>";
                        }
                        echo '</datalist>';
                        ?>

                        <input type="submit" value="Search" class="login-btn btn-primary-soft btn" style="padding: 10px 25px;">
                    </form>
                </div>

                <div class="calender">
                    <div class="date-container">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0; text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            $today = date('Y-m-d');
                            echo $today;

                            $patientrow = $database->query("select * from patient;");
                            $doctorrow = $database->query("select * from doctor;");
                            $appointmentrow = $database->query("select * from appointment where appodate >= '$today';");
                            $schedulerow = $database->query("select * from schedule where scheduledate = '$today';");
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
            <div style="background-color: #dadada; padding:10px; border-radius:10px; font-weight: 600;">
                <?php

                $list11 = $database->query("SELECT docname, docemail FROM doctor;");
                ?>

                <div class="doctors-container">
                    <p class="heading-main" style="margin-left: 3em; color: royalblue; ">All Doctors (<?php echo $list11->num_rows; ?>)</p>
                </div>
            </div>




            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">


                <?php
                if ($_POST) {
                    $keyword = $_POST["search"];

                    $sqlmain = "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                } else {
                    $sqlmain = "select * from doctor order by docid desc";
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
                                                Doctor Name

                                            </th>
                                            <th class="table-headin">
                                                Email
                                            </th>
                                            <th class="table-headin">

                                                Specialties

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
                                                                <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Doctors &nbsp;</font></button>
                                                                </a>
                                                            </center>
                                                            <br><br><br><br>
                                                        </td>
                                                    </tr>';
                                        } else {
                                            for ($x = 0; $x < $result->num_rows; $x++) {
                                                $row = $result->fetch_assoc();
                                                $docid = $row["docid"];
                                                $name = $row["docname"];
                                                $email = $row["docemail"];
                                                $spe = $row["specialties"];
                                                $spcil_res = $database->query("select sname from specialties where id='$spe'");
                                                $spcil_array = $spcil_res->fetch_assoc();
                                                $spcil_name = $spcil_array["sname"];
                                                echo '<tr>
                                                        <td> &nbsp;' .  substr($name, 0, 30). '</td>
                                                        <td>' . substr($email, 0, 20) . '
                                                        </td>
                                                        <td>
                                                            ' . substr($spcil_name, 0, 20) . '
                                                        </td>

                                                        <td>
                                                            <div style="display:flex;justify-content: center;">
                                                            
                                                                    <a href="?action=view&id=' . $docid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="?action=session&id=' . $docid . '&name=' . $name . '"  class="non-style-link"><button  class="btn-primary-soft btn button-icon menu-icon-session-active"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Sessions</font></button></a>
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
        if ($action == 'drop') {
            $nameget = $_GET["name"];
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <h2>Are you sure?</h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            <a href="delete-doctor.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                            </div>
                        </center>
                </div>
                </div>
                ';
        } elseif ($action == 'view') {
            $sqlmain = "SELECT * FROM doctor WHERE docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $name = $row["docname"];
            $email = $row["docemail"];
            $spe = $row["specialties"];

            $stmt = $database->prepare("select sname from specialties where id=?");
            $stmt->bind_param("s", $spe);
            $stmt->execute();
            $spcil_res = $stmt->get_result();
            $spcil_array = $spcil_res->fetch_assoc();
            $spcil_name = $spcil_array["sname"];
            $nic = $row['docnic'];
            $tele = $row['doctel'];
            echo '
                <div id="popup1" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); display: flex; align-items: center; justify-content: center;">
                    <div class="popup" style="width: 50%; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center; position: relative;">
                        
                        <h2 style="margin: 0; padding: 10px 0; font-size: 22px; font-weight: 600; color: #333;">Doctor Details</h2>
                        
                        <!-- Close Button -->
                        <a href="doctors.php" style="position: absolute; top: 10px; right: 15px; font-size: 25px; text-decoration: none; color: #555;">&times;</a>

                        <div style="margin-bottom: 20px; font-size: 16px; color: #666;">eDoc Web App</div>
                        
                        <div style="display: flex; justify-content: center;">
                            <table width="90%" style="border-collapse: collapse; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);">
                                
                                <tr>
                                    <td colspan="4" style="padding-bottom: 15px; font-size: 20px; font-weight: 500; color: #333; text-align: center; font-weight:600;">View Details</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding: 10px; font-weight: bold; color: #444;">Name:</td>
                                    <td colspan="2" style="padding: 10px; color: #222;"> ' . $name . ' </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding: 10px; font-weight: bold; color: #444;">Email:</td>
                                    <td colspan="2" style="padding: 10px; color: #222;">' . $email . '</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding: 10px; font-weight: bold; color: #444;">AYUSHMAN CARD NUMBER:</td>
                                    <td colspan="2" style="padding: 10px; color: #222;">' . $nic . '</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding: 10px; font-weight: bold; color: #444;">Telephone:</td>
                                    <td colspan="2" style="padding: 10px; color: #222;">' . $tele . '</td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="padding: 10px; font-weight: bold; color: #444;">Specialties:</td>
                                    <td colspan="2" style="padding: 10px; color: #222;">' . $spcil_name . '</td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align: center; padding-top: 20px;">
                                        <a href="doctors.php">
                                            <input type="button" value="OK" style="background: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                                        </a>
                                    </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>

                ';
        } elseif ($action == 'session') {
            $name = $_GET["name"];
            echo '
               <div id="popup1" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); display: flex; align-items: center; justify-content: center;">
                    <div class="popup" style="width: 40%; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); text-align: center; position: relative;">
                        
                        <!-- Close Button -->
                        <a href="doctors.php" style="position: absolute; top: 10px; right: 15px; font-size: 24px; text-decoration: none; color: #666;">&times;</a>

                        <h2 style="margin: 0 0 15px; font-size: 22px; font-weight: 600; color: #333;">Redirect to Doctors Sessions?</h2>

                        <div style="margin-bottom: 20px; font-size: 16px; color: #555;">
                            You want to view all sessions by <br><strong><?php echo substr($name, 0, 40); ?></strong>.
                        </div>

                        <form action="schedule.php" method="post" style="display: flex; flex-direction: column; align-items: center;">
                            <input type="hidden" name="search" value="' . $name . '">

                            <div style="margin-top: 15px; display: flex; gap: 15px;">
                                <!-- No Button -->
                                <a href="doctors.php" style="text-decoration: none;">
                                    <button type="button" style="background: #ccc; color: #333; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer;">No</button>
                                </a>
                                
                                <!-- Yes Button -->
                                <input type="submit" value="Yes" style="background: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer;">
                            </div>
                        </form>

                    </div>
                </div>

                ';
        } elseif ($action == 'edit') {
            $sqlmain = "select * from doctor where docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $name = $row["docname"];
            $email = $row["docemail"];
            $spe = $row["specialties"];

            $sqlmain = "select sname from specialties where id='?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s", $spe);
            $stmt->execute();
            $result = $stmt->get_result();

            $spcil_array = $spcil_res->fetch_assoc();
            $spcil_name = $spcil_array["sname"];
            $nic = $row['docnic'];
            $tele = $row['doctel'];

            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '0' => '',

            );

            if ($error_1 != '4') {
                echo '
                        <div id="popup1" class="overlay">
                                <div class="popup">
                                <center>
                                
                                    <a class="close" href="doctors.php">&times;</a> 
                                    <div style="display: flex;justify-content: center;">
                                    <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                            <td class="label-td" colspan="2">' .
                    $errorlist[$error_1]
                    . '</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Doctor Details.</p>
                                            Doctor ID : ' . $id . ' (Auto Generated)<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <form action="edit-doc.php" method="POST" class="add-new-form">
                                                <label for="Email" class="form-label">Email: </label>
                                                <input type="hidden" value="' . $id . '" name="id00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                            <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Name: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="name" class="input-text" placeholder="Doctor Name" value="' . $name . '" required><br>
                                            </td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="nic" class="form-label">AYUSHMAN CARD NUMBER:</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="nic" class="input-text" placeholder="AYUSHMAN CARD NUMBER:" value="' . $nic . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="Tele" class="form-label">Telephone: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="spec" class="form-label">Choose specialties: (Current' . $spcil_name . ')</label>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <select name="spec" id="" class="box">';


                $list11 = $database->query("select  * from  specialties;");

                for ($y = 0; $y < $list11->num_rows; $y++) {
                    $row00 = $list11->fetch_assoc();
                    $sn = $row00["sname"];
                    $id00 = $row00["id"];
                    echo "<option value=" . $id00 . ">$sn</option><br/>";
                };




                echo     '       </select><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="password" class="form-label">Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
                                            </td>
                                        </tr><tr>
                                            <td class="label-td" colspan="2">
                                                <label for="cpassword" class="form-label">Conform Password: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
                                            </td>
                                        </tr>
                                        
                            
                                        <tr>
                                            <td colspan="2">
                                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                                <input type="submit" value="Save" class="login-btn btn-primary btn">
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
            }
        } else {
            echo '
                    <div id="popup1" class="overlay">
                         <div class="popup">
                            <center>
                                <br><br><br><br>
                                <h2>Edit Successfully!</h2>
                                <a class="close" href="doctors.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                    <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                        </div>
                    </div>';
        }
    };

    ?>


</body>

</html>