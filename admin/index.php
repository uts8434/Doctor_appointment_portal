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
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-contai ner {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .dashboard-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .dashboard-icons i {
            font-size: 28px;
            color: #007bff;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        
        .dashboard-icons:hover {
            background-color: #007bff;
        }

        .dashboard-icons:hover i {
            color: white;
            transform: scale(1.1);
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







        <div class="dash-body" style="margin-top: 15px">

            <div class="header_nav">
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

            <div class="status-container">
                <p>Status</p>

                <div class="dashboard-grid">
                    <div class="dashboard-items">
                        <div>
                            <div class="h1-dashboard">
                                <?php echo $doctorrow->num_rows; ?>
                            </div><br>
                            <div class="h3-dashboard">
                                Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class=" dashboard-icons">
                            <i class="fas fa-briefcase-medical"></i>
                        </div>

                    </div>

                    <div class="dashboard-items">
                        <div>
                            <div class="h1-dashboard">
                                <?php echo $patientrow->num_rows; ?>
                            </div><br>
                            <div class="h3-dashboard">
                                Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="dashboard-icons">
                            <i class="fas fa-user-injured"></i>
                        </div>
                    </div>

                    <div class="dashboard-items">
                        <div>
                            <div class="h1-dashboard">
                                <?php echo $appointmentrow->num_rows; ?>
                            </div><br>
                            <div class="h3-dashboard">
                                New Booking &nbsp;&nbsp;
                            </div>
                        </div>
                        <div class="dashboard-icons">
                        <i class="fas fa-calendar-plus"></i> <!-- Book icon for new booking -->
                        </div>
                    </div>

                    <div class="dashboard-items">
                        <div>
                            <div class="h1-dashboard">
                                <?php echo $schedulerow->num_rows; ?>
                            </div><br>
                            <div class="h3-dashboard" style="font-size: 15px">
                                Today Sessions
                            </div>
                        </div>
                        <div class="dashboard-icons">
                            <i class="fas fa-calendar-day"></i>
                        </div>

                    </div>
                </div>
            </div>








            <div class="dashbord-tables">


                <div class="appointments-container left_container">
                    <div class="appointment-box">
                        <p class="section-title">
                            Upcoming Appointments until Next <?php echo date("l", strtotime("+1 week")); ?>
                        </p>
                        <p class="section-description">
                            Here's Quick access to Upcoming Appointments until 7 days<br>
                            More details available in @Appointment section.
                        </p>
                    </div>

                    <div class="appointments-list cntr">
                        <h3 class="table-heading">Upcoming Appointments</h3>
                        <div class="scroll-container">
                            <?php
                                $nextweek = date("Y-m-d", strtotime("+1 week"));
                                $sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, patient.pname, 
                                schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate 
                                FROM schedule 
                                INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                                INNER JOIN patient ON patient.pid = appointment.pid 
                                INNER JOIN doctor ON schedule.docid = doctor.docid  
                                WHERE schedule.scheduledate >= '$today'  
                                AND schedule.scheduledate <= '$nextweek' 
                                ORDER BY schedule.scheduledate DESC";

                                $result = $database->query($sqlmain);

                                if ($result->num_rows == 0) {
                                    echo '<div class="no-results">
                                            <img src="../img/notfound.svg" class="no-results-img">
                                            <p>We couldn’t find any appointments!</p>
                                            <a href="appointment.php" class="">Show all Appointments</a>
                                        </div>';
                                } else {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="appointment-card">
                                                <span class="appointment-number">#' . $row["apponum"] . '</span>
                                                <span class="appointment-detail"><strong>Patient:</strong> ' . $row["pname"] . '</span>
                                                <span class="appointment-detail"><strong>Doctor:</strong> ' . $row["docname"] . '</span>
                                                <span class="appointment-detail"><strong>Session:</strong> ' . $row["title"] . '</span>
                                            </div>';
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <div class="button-item ">
                        <a href="appointment.php">
                            <button class="btn_primary ">Show all Appointments</button>
                        </a>
                    </div>


                </div>

                <div class="appointments-container bx2 ">
                    <div class="session-box">
                        <p class="section-title ">
                            Upcoming Sessions until Next <?php echo date("l", strtotime("+1 week")); ?>
                        </p>
                        <p class="section-description ">
                            Here's Quick access to Upcoming Sessions that are Scheduled until 7 days<br>
                            Add, Remove, and many features available in @Schedule section.
                        </p>
                    </div>

                    <div class="sessions-list cntr1">
                        <h3 class="table-heading">Upcoming Sessions</h3>
                        <div class="scroll-container">
                            <?php
                                    $sqlmain = "SELECT schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime 
                                    FROM schedule 
                                    INNER JOIN doctor ON schedule.docid = doctor.docid  
                                    WHERE schedule.scheduledate >= '$today' 
                                    AND schedule.scheduledate <= '$nextweek' 
                                    ORDER BY schedule.scheduledate DESC";

                                    $result = $database->query($sqlmain);

                                        if ($result->num_rows == 0) {
                                            echo '<div class="no-results">
                                                        <img src="../img/notfound.svg" class="no-results-img">
                                                        <p>No scheduled sessions found!</p>
                                                        <a href="schedule.php" class="">Show all Sessions</a>
                                                    </div>';
                                        } else {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="session-card">
                                                        <span class="session-title">' . $row["title"] . '</span>
                                                        <span class="session-detail"><strong>Doctor:</strong> ' . $row["docname"] . '</span>
                                                        <span class="session-detail"><strong>Date & Time:</strong> ' . $row["scheduledate"] . ' ' . substr($row["scheduletime"], 0, 5) . '</span>
                                                    </div>';
                                            }
                                        }
                            ?>
                        </div>
                    </div>


                    <div class="button-item b">
                        <a href="schedule.php" class="non-style-link">
                            <button class="btn_primary btn">Show all Sessions</button>
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </div>





</body>

</html>