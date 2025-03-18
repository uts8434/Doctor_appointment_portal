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
    $result = $stmt->get_result();
    $userfetch = $result->fetch_assoc();

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
                            You want to delete Your Account<br>(' . substr($nameget, 0, 40) . ').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-account.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
                </div>
            </div>
            ';
        } elseif ($action == 'view') {
            $sqlmain = "select * from patient where pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $name = $row["pname"];
            $email = $row["pemail"];
            $address = $row["paddress"];


            $dob = $row["pdob"];
            $nic = $row['pnic'];
            $tele = $row['ptel'];
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
                            
                                <tr >
                                    <td colspan="4" >
                                        <p style="padding: 0;margin: 0;text-align: center;font-size: 25px;font-weight: 700;">View Details.</p><br><br>
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
                                        <label for="nic" class="form-label">AYUSHMAN CARD NUMBER: </label>
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
                                        <label for="spec" class="form-label">Address: </label>
                                        
                                    </td>
                                    <td class="label-td" colspan="2"> ' . $address . '<br><br>
                                     </td>
                                </tr>
                                
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Date of Birth: </label>
                                        
                                    </td>
                                    <td class="label-td" colspan="2">
                                    ' . $dob . '<br><br>
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
            $sqlmain = "select * from patient where pid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $name = $row["pname"];
            $email = $row["pemail"];



            $address = $row["paddress"];
            $nic = $row['pnic'];
            $tele = $row['ptel'];

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
                    <div id="popup1" class="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 999;">
                        <div class="popup" style="background: #fff; width: 50%; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                            <center>
                                <a class="close" href="settings.php" style="position: absolute; top: 10px; right: 15px; font-size: 25px; text-decoration: none; color: #333;">&times;</a>
                                <div style="display: flex; justify-content: center;">
                                    <div class="abc" style="width: 100%;">
                                        <table width="100%" style="border-collapse: collapse;">
                                            <tr>
                                                <td colspan="2" style="color: red; font-weight: bold; text-align: center;">
                                                    ' . $errorlist[$error_1] . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p style="font-size: 22px; font-weight: 600; text-align: left; margin-bottom: 10px;">Edit User Account Details</p>
                                                    <span style="font-size: 14px; color: gray;">User ID:' . $id . ' (Auto Generated)</span><br><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <form action="edit-user.php" method="POST" class="add-new-form">
                                                        <input type="hidden" name="id00" value="' . $id . '">
                                                        <label for="Email" style="font-weight: 500; display: block; margin-bottom: 5px;">Email:</label>
                                                        <input type="hidden" name="oldemail" value="' . $email . '">
                                                        <input type="email" name="email" placeholder="Email Address" value="' . $email . '" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="name" style="font-weight: 500; display: block; margin-bottom: 5px;">Name:</label>
                                                        <input type="text" name="name" placeholder="Full Name" value="' . $name . '" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="nic" style="font-weight: 500; display: block; margin-bottom: 5px;">AYUSHMAN CARD NUMBER:</label>
                                                        <input type="text" name="nic" placeholder="AYUSHMAN CARD NUMBER" value="' . $nic . '" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="Tele" style="font-weight: 500; display: block; margin-bottom: 5px;">Telephone:</label>
                                                        <input type="tel" name="Tele" placeholder="Telephone Number" value="' . $tele . '" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="address" style="font-weight: 500; display: block; margin-bottom: 5px;">Address:</label>
                                                        <input type="text" name="address" placeholder="Address" value="' . $address . '" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="password" style="font-weight: 500; display: block; margin-bottom: 5px;">Password:</label>
                                                        <input type="password" name="password" placeholder="Define a Password" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <label for="cpassword" style="font-weight: 500; display: block; margin-bottom: 5px;">Confirm Password:</label>
                                                        <input type="password" name="cpassword" placeholder="Confirm Password" required 
                                                            style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
                                                        
                                                        <div style="display: flex; justify-content: space-between;">
                                                            <input type="reset" value="Reset" style="background: #f0f0f0; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                                            <input type="submit" value="Save" style="background: #007BFF; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>';
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
                </div>';
            };
        }
    }
    ?>
    </div>

</body>

</html>