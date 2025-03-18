<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Doctors</title>
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
        <div class="dash-body" style="margin-top: 3%;">

            <div style="display: flex; flex-direction:column;">
                <div class="header_nav">

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

                <div style=" background-color:#dadada;">
                    <div class="add-doctor-container" style=" display:flex; justify-content:space-between; align-items:center; margin:1.5em 2.5em;">
                        <p class="heading-main12" style="">
                            Add New Doctor 
                        </p>
                        <a href="?action=add&id=none&error=0" class="non-style-link">
                            <button class="login-btn btn-primary btn button-icon" style="">
                                Add New 
                            </button>
                        </a>
                    </div>
                    <div style="padding-top: 10px;">
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: royalblue;">All Doctors (<?php echo $list11->num_rows; ?>)
                        </p>
                    </div>
                </div>
            </div>



            <table class="doctor-table" aria-label="Doctor List" style="width: 90%; margin:0 auto;">
                <caption>List of Doctors with their Specialties and Contact Information</caption>
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Email</th>
                        <th>Specialties</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($_POST) {
                            $keyword = $_POST["search"];
                            $sqlmain = "SELECT * FROM doctor WHERE docemail='$keyword' OR docname='$keyword' 
                            OR docname LIKE '$keyword%' OR docname LIKE '%$keyword' OR docname LIKE '%$keyword%'";
                        } else {
                            $sqlmain = "SELECT * FROM doctor ORDER BY docid DESC";
                        }

                        $result = $database->query($sqlmain);

                        if ($result->num_rows == 0) {
                            echo '<tr>
                                        <td colspan="4" class="no-results">
                                            <img src="../img/notfound.svg" width="100" alt="No results found" aria-hidden="true">
                                            <p>We couldn’t find anything related to your keywords!</p>
                                            <a href="doctors.php" class="btn">Show all Doctors</a>
                                        </td>
                                </tr>';
                        } else {
                            while ($row = $result->fetch_assoc()) {
                                $docid = $row["docid"];
                                $name = $row["docname"];
                                $email = $row["docemail"];
                                $spe = $row["specialties"];
                                $spcil_res = $database->query("SELECT sname FROM specialties WHERE id='$spe'");
                                $spcil_array = $spcil_res->fetch_assoc();
                                $spcil_name = $spcil_array["sname"];

                                echo "<tr>
                            <td>" . htmlspecialchars($name) . "</td>
                            <td>" . htmlspecialchars($email) . "</td>
                            <td>" . htmlspecialchars($spcil_name) . "</td>
                            <td class='actions' >
                                <a href='?action=edit&id=$docid&error=0' class='btn edit'>Edit</a>
                                <a href='?action=view&id=$docid' class='btn view'>View</a>
                                <a href='?action=drop&id=$docid&name=$name' class='btn delete'>Remove</a>
                            </td>
                        </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>


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
                            </div>';
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
                                    
                                    <div style="display: flex;justify-content: center;">
                                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                        
                                            <tr rowspan="2">
                                                <td>
                                                    <p colspan="2" style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
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
                                                    <label for="spec" class="form-label">Specialties: </label>
                                                    
                                                </td>
                                                <td class="label-td" colspan="2">' . $spcil_name . '<br><br>
                                                
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
                        </div> ';
                    } elseif ($action == 'add') {
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
                                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Doctor.</p><br><br>
                                                            </td>
                                                            <td><a class="close" href="doctors.php">&times;</a></td>
                                                        </tr>
                                                
                                                        <tr>
                                                            <form action="add-new.php" method="POST" class="add-new-form">
                                                            <td class="label-td" colspan="2">
                                                                <label for="name" class="form-label">Name: </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <input type="text" name="name" class="input-text" placeholder="Doctor Name" required><br>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <label for="Email" class="form-label">Email: </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <input type="email" name="email" class="input-text" placeholder="Email Address" required><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <label for="nic" class="form-label">AYUSHMAN CARD NUMBER: </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <input type="number" name="nic" class="input-text" placeholder="AYUSHMAN CARD NUMBER" required pattern="[0-9]{12}"><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <label for="Tele" class="form-label">Telephone: </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" required pattern="[0-9]{10}"><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <label for="spec" class="form-label">Choose specialties: </label>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-td" colspan="2">
                                                                <select name="spec" id="" class="box" >';


                            $list11 = $database->query("select  * from  specialties order by sname asc;");

                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $sn = $row00["sname"];
                                $id00 = $row00["id"];
                                echo "<option value=" . $id00 . ">$sn</option><br/>";
                            };




                            echo     '       </select><br>
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
                                                    
                                                        <input type="submit" value="Add" class="login-btn btn-primary btn">
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
                                </div>';
                        } else {
                            echo '
                            <div id="popup1" class="overlay">
                                <div class="popup">
                                    <center>
                                    <br><br><br><br>
                                        <h2>New Record Added Successfully!</h2>
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
                                        <a class="close" href="doctors.php">&times;</a>
                                        <h2>Edit Doctor Details</h2>
                                        <p class="subtitle">Doctor ID: <?php echo $id; ?> (Auto Generated)</p>
                                        <div class="form-container">
                                            <form action="edit-doc.php" method="POST" class="edit-doc-form">
                                                <input type="hidden" value="' . $id . '" name="id00">
                                                <input type="hidden" name="oldemail" value="' . $email . '">

                                                <div class="input-group">
                                                    <label for="Email" class="form-label">Email:</label>
                                                    <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input type="text" name="name" class="input-text" placeholder="Doctor Name" value="' . $name . '" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="nic" class="form-label">AYUSHMAN CARD NUMBER:</label>
                                                    <input type="text" name="nic" class="input-text" placeholder="AYUSHMAN CARD NUMBER" value="' . $nic . '" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="Tele" class="form-label">Telephone:</label>
                                                    <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="spec" class="form-label">Choose Specialties (Current: <?php echo $spcil_name; ?>)</label>
                                                        <select name="spec" id="" class="box">';


                            $list11 = $database->query("select  * from  specialties;");
                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $sn = $row00["sname"];
                                $id00 = $row00["id"];
                                echo "<option value=" . $id00 . ">$sn</option><br/>";
                            };
                            echo     ' </select><br><br>

                                                </div>

                                                <div class="input-group">
                                                    <label for="password" class="form-label">Password:</label>
                                                    <input type="password" name="password" class="input-text" placeholder="Define a Password" required>
                                                </div>

                                                <div class="input-group">
                                                    <label for="cpassword" class="form-label">Confirm Password:</label>
                                                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
                                                </div>

                                                <div class="form-buttons">
                                                    <input type="reset" value="Reset" class="btn btn-secondary">
                                                    <input type="submit" value="Save" class="btn btn-primary">
                                                </div>
                                            </form>
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
                        };
                    };
                };

            ?>
        </div>
    </div>


</body>

</html>