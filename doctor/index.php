<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <title>Dashboard</title>
    <style>
        .dashbord-tables,
        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        #anim {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
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
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; background: #f8f9fa; border-bottom: 1px solid #ddd;">
                <div style="font-size: 23px; font-weight: 600;">Dashboard</div>

                <div style="display: flex; align-items: center; justify-content: center; gap:30px;">
                    <div style="text-align: right;">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); margin: 0;">Today's Date</p>
                        <p style="margin: 0; font-weight: 600;">
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            echo date('Y-m-d');
                            ?>
                        </p>
                    </div>

                    <button style="border: none; background: transparent; cursor: pointer; display: flex; align-items: center; padding: 5px;">
                        <img src="../img/calendar.svg" alt="Calendar" style="width: 24px; height: 24px;">
                    </button>
                </div>
            </div>

            <div style="width: 100%;  margin: 0 auto; padding: 80px; background: url('../img/b4.jpg') no-repeat center center/cover; text-align: center; color: white; position: relative; overflow: hidden;">
                <div style="background: rgba(0, 0, 0, 0.75); padding: 50px; border-radius: 15px;">
                    <h3 style="margin: 0; font-size: 30px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);">
                        Welcome, <span style="color: red;"><?php echo $username; ?>!</span>
                    </h3>
                    <p style="margin: 20px auto; font-size: 20px; line-height: 1.8; font-weight: 400; max-width: 80%; opacity: 0.9; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);">
                        We are excited to have you onboard! Get ready to manage your **appointments effortlessly**.
                        View your schedule, track patient visits, and stay on top of everything—all in one place.
                    </p>
                    <a href="appointment.php" style="text-decoration: none;">
                        <button style="width: 55%; max-width: 300px; padding: 16px; background: linear-gradient(135deg, #007bff, #0056b3); color: white; border: none; border-radius: 12px; cursor: pointer; font-size: 18px; font-weight: 700; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3); transition: all 0.3s ease-in-out;">
                            View My Appointments
                        </button>
                    </a>
                </div>
            </div>
            <?php



            $doctorrow = $patientrow = $appointmentrow = $schedulerow = null;
            $doctorCount = $patientCount = $appointmentCount = $scheduleCount = 0;


            $doctorrow = $database->query("SELECT * FROM doctor");
            if ($doctorrow) {
                $doctorCount = $doctorrow->num_rows;
            }


            $patientrow = $database->query("SELECT * FROM patient");
            if ($patientrow) {
                $patientCount = $patientrow->num_rows;
            }

            $appointmentrow = $database->query("SELECT * FROM appointment");
            if ($appointmentrow) {
                $appointmentCount = $appointmentrow->num_rows;
            }


            $schedulerow = $database->query("SELECT * FROM schedule WHERE scheduledate = CURDATE()");
            if ($schedulerow) {
                $scheduleCount = $schedulerow->num_rows;
            }

            $today = date("Y-m-d");
            ?>



            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; padding: 30px; background: #f4f4f9; border-radius: 10px;">

                <div style="flex: 1 1 calc(50% - 10px); display: flex; align-items: center; background: #007bff; color: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                    <div style="font-size: 35px; font-weight: bold; flex-grow: 1;">
                        <?php echo $doctorCount; ?>
                        <p style="font-size: 18px; margin-top: 5px;">All Doctors</p>
                    </div>
                    <div style="font-size: 40px;">🩺</div>
                </div>

                <div style="flex: 1 1 calc(50% - 10px); display: flex; align-items: center; background: #28a745; color: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                    <div style="font-size: 35px; font-weight: bold; flex-grow: 1;">
                        <?php echo $patientCount; ?>
                        <p style="font-size: 18px; margin-top: 5px;">All Patients</p>
                    </div>
                    <div style="font-size: 40px;">👨‍⚕️</div>
                </div>

                <div style="flex: 1 1 calc(50% - 10px); display: flex; align-items: center; background: #ffc107; color: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                    <div style="font-size: 35px; font-weight: bold; flex-grow: 1;">
                        <?php echo $appointmentCount; ?>
                        <p style="font-size: 18px; margin-top: 5px;">New Bookings</p>
                    </div>
                    <div style="font-size: 40px;">📅</div>
                </div>

                <div style="flex: 1 1 calc(50% - 10px); display: flex; align-items: center; background: #dc3545; color: white; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                    <div style="font-size: 35px; font-weight: bold; flex-grow: 1;">
                        <?php echo $scheduleCount; ?>
                        <p style="font-size: 18px; margin-top: 5px;">Today’s Sessions</p>
                    </div>
                    <div style="font-size: 40px;">⏳</div>
                </div>
            </div>

           
            <div style="margin-top: 40px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                <h3 style="font-size: 22px; margin-bottom: 20px; text-align: center;">Your Upcoming Sessions Until Next Week</h3>
                <div style="max-height: 250px; overflow-y: auto; padding: 10px; border-radius: 5px; background: #f9f9f9;">
                    <?php
                    $nextweek = date("Y-m-d", strtotime("+1 week"));
                    $sqlmain = "SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime 
                                        FROM schedule 
                                        INNER JOIN doctor ON schedule.docid = doctor.docid  
                                        WHERE schedule.scheduledate >= '$today' AND schedule.scheduledate <= '$nextweek' 
                                        ORDER BY schedule.scheduledate DESC";
                    $result = $database->query($sqlmain);

                    if ($result->num_rows == 0) {
                        echo '<div style="text-align: center; padding: 40px; font-size: 18px; color: #777;">
                                        <p>We couldn’t find anything related to your keywords!</p>
                                        <a href="schedule.php" style="display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 10px;">Show All Sessions</a>
                                    </div>';
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div style="display: flex; justify-content: space-between; padding: 10px 15px; border-bottom: 1px solid #ddd;">
                                            <div style="font-size: 18px; font-weight: bold;">' . htmlspecialchars(substr($row["title"], 0, 30)) . '</div>
                                            <div style="font-size: 16px; color: #555;">📅 ' . htmlspecialchars(substr($row["scheduledate"], 0, 10)) . '</div>
                                            <div style="font-size: 16px; color: #555;">⏰ ' . htmlspecialchars(substr($row["scheduletime"], 0, 5)) . '</div>
                                        </div>';
                        }
                    }
                    ?>
                </div>
            </div>

          </div>

    </div>


</body>

</html>