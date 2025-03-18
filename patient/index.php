<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/animations.css">   -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/patient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <title>Dashboard</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        .anime {
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

    //learn from w3schools.com

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



    //echo $userid;
    //echo $username;

    ?>
    <div class="perent">
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



        <div class="dash-body" style="">
            <div class="navbar">
                <div class="nav-left">
                    <p class="nav-title">Home</p>
                </div>

                <div class="nav-middle"></div> <!-- Empty div for spacing -->

                <div class="nav-right">
                    <p class="date-label">Today's Date</p>
                    <p class="current-date">
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        $today = date('Y-m-d');
                        echo $today;

                        $patientrow = $database->query("SELECT * FROM patient;");
                        $doctorrow = $database->query("SELECT * FROM doctor;");
                        $appointmentrow = $database->query("SELECT * FROM appointment WHERE appodate >= '$today';");
                        $schedulerow = $database->query("SELECT * FROM schedule WHERE scheduledate = '$today';");
                        ?>
                    </p>
                </div>

                <div class="nav-calendar">
                    <button class="btn-label">
                        <i class="fas fa-calendar-alt"></i> <!-- Font Awesome Calendar Icon -->
                    </button>
                </div>
            </div>
            <div class="welcome-container">
                <div class="welcome-content">
                    <h3>Welcome!</h3>
                    <h1><?php echo $username ?>.</h1>
                    <p>
                        Haven't any idea about doctors? No problem! Jump to
                        <a href="doctors.php" class="non-style-link"><b>"All Doctors"</b></a> section or
                        <a href="schedule.php" class="non-style-link"><b>"Sessions"</b></a>.<br>
                        Track your past and future appointment history.<br>
                        Also, find out the expected arrival time of your doctor or medical consultant.
                    </p>

                    <h3>Channel a Doctor Here</h3>

                    <form action="schedule.php" method="post" class="search-form">
                        <input type="search" name="search" class="search-input"
                            placeholder="Search Doctor and We will Find The Session Available" list="doctors">

                        <?php
                        echo '<datalist id="doctors">';
                        $list11 = $database->query("SELECT docname FROM doctor;");
                        while ($row = $list11->fetch_assoc()) {
                            echo "<option value='{$row["docname"]}'>";
                        }
                        echo '</datalist>';
                        ?>

                        <input type="submit" value="Search" class="search-btn">
                    </form>
                </div>
            </div>

            <div class="home">
                <div class="dashboard-container">
                    <div class="dashboard-header">
                        <p class="status-title">Status</p>
                    </div>
                    <div class="dashboard-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-content">
                                <div class="h3-dashboard">All Doctors</div>
                                <div class="h1-dashboard">
                                    <?php echo $doctorrow->num_rows ?>
                                </div>

                            </div>
                            <div class="dashboard-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                        <div class="dashboard-item">
                            <div class="dashboard-content">
                                <div class="h3-dashboard">All Patients</div>
                                <div class="h1-dashboard">
                                    <?php echo $patientrow->num_rows ?>
                                </div>

                            </div>
                            <div class="dashboard-icon">
                                <i class="fas fa-procedures"></i>
                            </div>
                        </div>
                        <div class="dashboard-item">
                            <div class="dashboard-content">
                                <div class="h3-dashboard">New Booking</div>
                                <div class="h1-dashboard">
                                    <?php echo $appointmentrow->num_rows ?>
                                </div>

                            </div>
                            <div class="dashboard-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="dashboard-item">
                            <div class="dashboard-content">
                                <div class="h3-dashboard">Today Sessions</div>

                                <div class="h1-dashboard">
                                    <?php echo $schedulerow->num_rows ?>
                                </div>
                            </div>
                            <div class="dashboard-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="booking-container">
                    <p class="booking-title">Your Upcoming Booking</p>
                    <div class="booking-table-container">
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>Appoint. Number</th>
                                    <th>Session Title</th>
                                    <th>Doctor</th>
                                    <th>Scheduled Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nextweek = date("Y-m-d", strtotime("+1 week"));
                                $sqlmain = "SELECT * FROM schedule 
                                            INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
                                            INNER JOIN patient ON patient.pid=appointment.pid 
                                            INNER JOIN doctor ON schedule.docid=doctor.docid  
                                            WHERE patient.pid=$userid AND schedule.scheduledate >= '$today' 
                                            ORDER BY schedule.scheduledate ASC";

                                $result = $database->query($sqlmain);

                                if ($result->num_rows == 0) {
                                    echo '<tr>
                                            <td colspan="4" class="no-booking">
                                                <i class="fas fa-calendar-times"></i> 
                                                <p>Nothing to show here!</p>
                                                <a href="schedule.php" class="btn-primary">Channel a Doctor</a>
                                            </td>
                                        </tr>';
                                } else {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>
                                                <td>' . $row["apponum"] . '</td>
                                                <td>' . substr($row["title"], 0, 30) . '</td>
                                                <td>' . substr($row["docname"], 0, 20) . '</td>
                                                <td>' . substr($row["scheduledate"], 0, 10) . ' ' . substr($row["scheduletime"], 0, 5) . '</td>
                                            </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>

</body>

</html>