<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
                .container {
                    width: 50%;
                    max-width: 500px;
                    margin: 50px auto;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    background: #fff;
                    animation: transitionIn-X 0.5s;
                }

                .form-group {
                    position: relative;
                    margin-bottom: 20px;
                }

                .input-text {
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    outline: none;
                    background: transparent;
                }

                .form-group label {
                    position: absolute;
                    top: 50%;
                    left: 10px;
                    transform: translateY(-50%);
                    transition: all 0.3s ease-in-out;
                    font-size: 16px;
                    color: #888;
                    pointer-events: none;
                }

                .input-text:focus ~ label,
                .input-text:not(:placeholder-shown) ~ label {
                    top: 5px;
                    left: 10px;
                    font-size: 12px;
                    color: #333;
                    background: #fff;
                    padding: 0 5px;
                }

                .btn {
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: 0.3s;
                }

                .btn-primary {
                    background: #007bff;
                    color: #fff;
                }

                .btn-primary:hover {
                    background: #0056b3;
                }

                .btn-primary-soft {
                    background: #f8f9fa;
                    color: #333;
                    border: 1px solid #ccc;
                }

                .btn-primary-soft:hover {
                    background: #e2e6ea;
                }

                .text-center {
                    text-align: center;
                }

                .error-message {
                    color: rgb(255, 62, 62);
                    text-align: center;
                }

    </style>
</head>
<body>

<?php
    session_start();
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";
    date_default_timezone_set('Asia/Kolkata');
    $_SESSION["date"] = date('Y-m-d');
    include("connection.php");

    if ($_POST) {
        $fname = $_SESSION['personal']['fname'];
        $lname = $_SESSION['personal']['lname'];
        $name = $fname . " " . $lname;
        $address = $_SESSION['personal']['address'];
        $nic = $_SESSION['personal']['nic'];
        $dob = $_SESSION['personal']['dob'];
        $email = $_POST['newemail'];
        $tele = $_POST['tele'];
        $newpassword = $_POST['newpassword'];
        $cpassword = $_POST['cpassword'];

        if ($newpassword == $cpassword) {
            $sqlmain = "SELECT * FROM webuser WHERE email = ?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $error = '<p class="text-center" style="color:red;">Already have an account with this Email address.</p>';
            } else {
                $database->query("INSERT INTO patient(pemail, pname, ppassword, paddress, pnic, pdob, ptel) 
                                VALUES('$email', '$name', '$newpassword', '$address', '$nic', '$dob', '$tele')");
                $database->query("INSERT INTO webuser VALUES('$email', 'p')");

                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "p";
                $_SESSION["username"] = $fname;

                header('Location: patient/index.php');
                exit;
            }
        } else {
            $error = '<p class="text-center" style="color:red;">Password Confirmation Error! Reconfirm Password.</p>';
        }
    } else {
        $error = '<p class="text-center"></p>';
    }
?>

<div class="container">
    <h2 class="text-center">Let's Get Started</h2>
    <p class="text-center">It's Okay, Now Create a User Account.</p>
    
    <form action="" method="POST">
        
        <div class="form-group">
            <input type="email" name="newemail" class="input-text" placeholder=" " required>
            <label for="newemail">Email</label>
        </div>

        <div class="form-group">
            <input type="tel" name="tele" class="input-text" placeholder=" " pattern="[0-9]{10}">
            <label for="tele">Mobile Number</label>
        </div>

        <div class="form-group">
            <input type="password" name="newpassword" class="input-text" placeholder=" " required>
            <label for="newpassword">Create New Password</label>
        </div>

        <div class="form-group">
            <input type="password" name="cpassword" class="input-text" placeholder=" " required>
            <label for="cpassword">Confirm Password</label>
        </div>

        <?php echo $error ?>

        <div class="form-group">
            <input type="reset" value="Reset" class="btn btn-primary-soft">
        </div>
        <div class="form-group">
            <input type="submit" value="Sign Up" class="btn btn-primary">
        </div>

        <p class="text-center">Already have an account? <a href="login.php">Login</a></p>

    </form>
</div>


</body>
</html>
