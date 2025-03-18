<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
        exit();
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
    exit();
}

include("../connection.php");

$sqlmain = "SELECT * FROM patient WHERE pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

if ($_POST) {
    if (isset($_POST["booknow"])) {
        $apponum = $_POST["apponum"];
        $scheduleid = $_POST["scheduleid"];
        $date = $_POST["date"];

        // Secure SQL Query
        $sql2 = "INSERT INTO appointment (pid, apponum, scheduleid, appodate) VALUES (?, ?, ?, ?)";
        $stmt = $database->prepare($sql2);
        $stmt->bind_param("iiis", $userid, $apponum, $scheduleid, $date);
        
        if ($stmt->execute()) {
            header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

 ?>