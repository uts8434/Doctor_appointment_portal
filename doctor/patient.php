<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <title>Patients</title>
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


    //import database
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["docid"];
    $username = $userfetch["docname"];


    //echo $userid;
    //echo $username;
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
        <?php

        $selecttype = "My";
        $current = "My patients Only";
        if ($_POST) {

            if (isset($_POST["search"])) {
                $keyword = $_POST["search12"];

                $sqlmain = "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                $selecttype = "my";
            }

            if (isset($_POST["filter"])) {
                if (isset($_POST["showonly"]) && $_POST["showonly"] == 'all') {
                    $sqlmain = "select * from patient";
                    $selecttype = "All";
                    $current = "All patients";
                } else {
                    $sqlmain = "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
                    $selecttype = "My";
                    $current = "My patients Only";
                }
            }
        } else {
            $sqlmain = "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid;";
            $selecttype = "My";
        }



        ?>
        <div class="dash-body">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); margin-bottom: 15px;">

                <div>
                    <a href="patient.php">
                        <button style="background-color: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                            Back
                        </button>
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                    <form action="" method="post" style="display: flex; align-items: center; gap: 10px;">
                        <input type="search" name="search12" placeholder="Search Patient name or Email"
                            list="patient" style="padding: 8px 8px 8px 50px; width: 100%; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">

                        <?php
                        echo '<datalist id="patient">';
                        $list11 = $database->query($sqlmain);
                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            echo "<option value='{$row00["pname"]}'>";
                            echo "<option value='{$row00["pemail"]}'>";
                        };
                        echo '</datalist>';
                        ?>

                        <input type="submit" value="Search" name="search"
                            style="background-color: royalblue; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 14px;">
                    </form>
                </div>

                <div style="display: flex; gap:10px;">
                    <div style="text-align: right;">
                        <p style="font-size: 14px; color: #777; margin: 0;">Today's Date</p>
                        <p style="font-size: 16px; font-weight: bold; margin: 0;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            echo date('Y-m-d');
                            ?>
                        </p>
                    </div>

                    <div>
                        <button style="background: none; border: none; cursor: pointer;">
                            <img src="../img/calendar.svg" alt="Calendar" style="width: 30px; height: 30px;">
                        </button>
                    </div>
                </div>
            </div>

            <div style="padding: 15px; margin-left: 20px;">
                <p style="font-size: 18px; color: #313131; font-weight: bold;">
                    <?php echo $selecttype . " Patients (" . $list11->num_rows . ")"; ?>
                </p>
            </div>


            <div style="width: 100%; padding-top: 0px; text-align: center; background-color:#dadada; padding:15px;">
                <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                    <div style="text-align: right; font-size: 16px;">Show Details About:</div>
                    <div style="width: 30%;">
                        <select name="showonly" style="width: 90%; height: 37px; margin: 0;border-radius:5px; padding:10px;">
                            <option value="" disabled selected hidden><?php echo $current ?></option>
                            <option value="my">My Patients Only</option>
                            <option value="all">All Patients</option>
                        </select>
                    </div>
                    <div style="width: 12%; ">
                        <form action="" method="post">
                            <input type="submit" name="filter" value="Filter" style="padding: 15px; margin: 0; width: 100%; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius:10px;">
                        </form>
                    </div>
                </div>
            </div>

            <div style="width: 100%; text-align: center; margin-top: 20px; overflow-x: auto;">
                <div style="width: 99%; margin: 0 auto; border-spacing: 0;">
                    <div style="display: flex; font-weight: bold; padding: 10px; background-color: #f1f1f1;">
                        <div style="flex: 1;">Name</div>
                        <div style="flex: 1;">AYUSHMAN CARD NUMBER</div>
                        <div style="flex: 1;">Telephone</div>
                        <div style="flex: 1;">Email</div>
                        <div style="flex: 1;">Date of Birth</div>
                        <div style="flex: 1;">Events</div>
                    </div>

                    <?php
                    $result = $database->query($sqlmain);
                    if ($result->num_rows == 0) {
                        echo '<div style="text-align: center; padding: 20px;">
                                <img src="../img/notfound.svg" width="25%">
                                <p style="font-size: 20px; color: rgb(49, 49, 49);">We couldn’t find anything related to your keywords!</p>
                                <a href="patient.php" style="text-decoration: none;">
                                    <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer;">Show all Patients</button>
                                </a>
                            </div>';
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div style="display: flex; padding: 10px; border-bottom: 1px solid #ddd;">
                                    <div style="flex: 1;">' . substr($row["pname"], 0, 35) . '</div>
                                    <div style="flex: 1;">' . substr($row["pnic"], 0, 12) . '</div>
                                    <div style="flex: 1;">' . substr($row["ptel"], 0, 10) . '</div>
                                    <div style="flex: 1;">' . substr($row["pemail"], 0, 20) . '</div>
                                    <div style="flex: 1;">' . substr($row["pdob"], 0, 10) . '</div>
                                    <div style="flex: 1; text-align: center;">
                                        <a href="?action=view&id=' . $row["pid"] . '" style="text-decoration: none;">
                                            <button style="padding: 12px; background-color: #007bff; color: white; border: none; cursor: pointer;">View</button>
                                        </a>
                                    </div>
                                </div>';
                        }
                    }
                    ?>
                </div>
            </div>


        </div>




        <?php
        if ($_GET) {

            $id = $_GET["id"];
            $action = $_GET["action"];
            $sqlmain = "select * from patient where pid='$id'";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $name = $row["pname"];
            $email = $row["pemail"];
            $nic = $row["pnic"];
            $dob = $row["pdob"];
            $tele = $row["ptel"];
            $address = $row["paddress"];
            echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                                <a class="close" href="patient.php">&times;</a>
                                <div class="content">

                                </div>
                                <div style="display: flex;justify-content: center;">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                
                                    <tr>
                                        <td colspan="4" >
                                            <p style="padding: 0;margin: 0;text-align: center;font-size: 25px;font-weight: 600;">View Details.</p><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Patient ID: </label>
                                        </td>
                                         <td class="label-td" colspan="2">
                                            P-' . $id . '<br><br>
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
                                        <td class="label-td" colspan="2">
                                    ' . $address . '<br><br>
                                    </td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Date of Birth: </label>
                                        </td>
                                        <td class="label-td" colspan="2">
                                            ' . $dob . '<br><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="4">
                                            <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                        
                                            
                                        </td>
                        
                                    </tr>
                                

                                </table>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
        };

        ?>
    </div>


</body>

</html>