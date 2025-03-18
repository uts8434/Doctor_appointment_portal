<?php
session_start();
include("../connection.php");

if (!isset($_SESSION["user"])) {
    header("Location: appointment.php?status=error&message=Session expired");
    exit();
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: appointment.php?status=error&message=Invalid ID");
    exit();
}

$id = intval($_GET["id"]);

$sql = "DELETE FROM appointment WHERE appoid = ?";
$stmt = $database->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: appointment.php?status=success&message=Deleted successfully");
    } else {
        header("Location: appointment.php?status=error&message=Failed to delete");
    }
    $stmt->close();
} else {
    header("Location: appointment.php?status=error&message=Database error");
}
exit();
?>
