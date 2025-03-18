<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/patient.css">



    <title>Settings</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-X 0.5s;
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


    //import database
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
        <div class="dash-body" style="margin-top: 15px">
            <div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-top: 25px;">
                <div style="display: flex ; justify-content:center;align-items: center; margin-left:10px;">
                    <a href="settings.php">
                        <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <span class="tn-in-text">Back</span>
                        </button>
                    </a>
                    <p style="font-size: 23px; font-weight: 600;margin-left:30px;">Settings</p>

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

            <div class="user-settings-container">
                <div class="user-settings-options">
                    <a href="?action=edit&id=<?php echo $userid ?>&error=0" class="custom-link">
                        <div class="user-settings-item">
                            <i class="fas fa-user-cog"></i>
                            <div>
                                <h2>Account Settings</h2>
                                <p>Edit your Account Details & Change Password</p>
                            </div>
                        </div>
                    </a>

                    <a href="?action=view&id=<?php echo $userid ?>" class="custom-link">
                        <div class="user-settings-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <h2>View Account Details</h2>
                                <p>View Personal information About Your Account</p>
                            </div>
                        </div>
                    </a>

                    <a href="?action=drop&id=<?php echo $userid . '&name=' . $username ?>" class="custom-link">
                        <div class="user-settings-item delete-account">
                            <i class="fas fa-user-times"></i>
                            <div>
                                <h2>Delete Account</h2>
                                <p>Will Permanently Remove your Account</p>
                            </div>
                        </div>
                    </a>
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
                        <a class="close" href="settings.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-doctor.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

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
                        <a class="close" href="settings.php">&times;</a>
                        <div class="content">
                            eDoc Web App<br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td colspan="4">
                                    <p style="padding: 0;margin: 0;text-align: center;font-size: 25px;font-weight:  700;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                                 <td class="label-td" colspan="2">
                                    ' . $name . '<br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                                <td class="label-td" colspan="2">
                                ' . $email . '<br><br>
                                </td>
                            </tr>
                           
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">AYUSHMAN CARD NUMBER:
                                         </label>
                                </td>
                                 <td class="label-td" colspan="2">
                                ' . $nic . '<br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                                 <td class="label-td" colspan="2">
                                ' . $tele . '<br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Specialties: </label>
                                    
                                </td>
                                <td class="label-td" colspan="2">
                                ' . $spcil_name . '<br><br>
                            </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2">
                                    <a href="settings.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        } elseif ($action == 'edit') {
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
                                <a class="close" href="settings.php">&times;</a> 
                                    <div style="display: flex;justify-content: center;">
                                        <div class="abc">
                                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                                <tr>
                                                    <td class="label-td" colspan="4">' . $errorlist[$error_1] . '</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <p style="padding: 0;margin: 0;text-align: center;font-size: 25px;font-weight: 700;">Edit Doctor Details.<br/></p>
                                                        <p style="text-align: center;">Doctor ID : ' . $id . ' (Auto Generated)<br></p>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <form action="edit-doc.php" method="POST" class="add-new-form">
                                                        <label for="Email" class="form-label">Email: </label>
                                                        <input type="hidden" value="' . $id . '" name="id00">
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="hidden" name="oldemail" value="' . $email . '" >
                                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    
                                                    <td class="label-td" colspan="2">
                                                        <label for="name" class="form-label">Name: </label>
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="text" name="name" class="input-text" placeholder="Doctor Name" value="' . $name . '" required><br>
                                                    </td>
                                                </tr>
                                                
                                                
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="nic" class="form-label">AYUSHMAN CARD NUMBER:</label>
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="text" name="nic" class="input-text" placeholder="AYUSHMAN CARD NUMBER" value="' . $nic . '" required><br>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="Tele" class="form-label">Telephone: </label>
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required><br>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="spec" class="form-label">Choose specialties: (Current' . $spcil_name . ')</label> 
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <select name="spec" id="" class="box">';


                                                            $list11 = $database->query("select  * from  specialties;");

                                                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                                                $row00 = $list11->fetch_assoc();
                                                                $sn = $row00["sname"];
                                                                $id00 = $row00["id"];
                                                                echo "<option value=" . $id00 . ">$sn</option><br/>";
                                                            };

                                                            echo     '  </select><br><br>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="password" class="form-label">Password: </label>
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
                                                    </td>
                                                </tr>
                                            <tr>
                                                    <td class="label-td" colspan="2">
                                                        <label for="cpassword" class="form-label">Conform Password: </label>
                                                    </td>
                                                    <td class="label-td" colspan="2">
                                                        <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
                                                    </td>
                                                </tr>
                                                
                                                
                                    
                                                <tr>
                                                    <td colspan="2" style="display:flex; justify-content:center; align-items:space-between;">
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
            } else {
                echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                            <br><br><br><br>
                                <h2>Edit Successfully!</h2>
                                <a class="close" href="settings.php">&times;</a>
                                <div class="content">
                                    If You change your email also Please logout and login again with your new email
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                    <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                                    <a href="../logout.php" class="non-style-link"><button  class="btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Log out&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                        </center>
                    </div>
                </div>
    ';
            };
        }
    }
    ?>
    </div>

</body>

</html>