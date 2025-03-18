<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Login</title>
</head>
<body>
    <?php
        session_start();


        if (isset($_SESSION['message'])) {
            echo "<script>
                alert('" . $_SESSION['message'] . "');
                window.location.href = '../login.php'; // Redirect to login page after alert
            </script>";

            // Unset message after displaying it
            unset($_SESSION['message']);

            // Destroy the session
            session_destroy();
        }


        $_SESSION["user"] = "";
        $_SESSION["usertype"] = "";

        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $_SESSION["date"] = $date;

        // Import database connection
        include("connection.php");

        if ($_POST) {
            $email = $_POST['useremail'];
            $password = $_POST['userpassword'];

            $error = '<label for="promter" class="form-label"></label>';

            $result = $database->query("select * from webuser where email='$email'");
            if ($result->num_rows == 1) {
                $utype = $result->fetch_assoc()['usertype'];
                if ($utype == 'p') {
                    // Patient login logic
                    $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                    if ($checker->num_rows == 1) {
                        // Patient dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'p';
                        header('location: patient/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                } elseif ($utype == 'a') {
                    // Admin login logic
                    $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                    if ($checker->num_rows == 1) {
                        // Admin dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'a';
                        header('location: admin/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                } elseif ($utype == 'd') {
                    // Doctor login logic
                    $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                    if ($checker->num_rows == 1) {
                        // Doctor dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'd';
                        header('location: doctor/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                }
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We can\'t find any account for this email.</label>';
            }
        } else {
            $error = '<label for="promter" class="form-label">&nbsp;</label>';
        }
    ?>

<div class="container">
    <div class="header-text">Welcome Back!</div>
    <p class="sub-text">Login with your details to continue</p>
    
    <form action="" method="POST">
        <div class="input-group">
            <input type="email" name="useremail" id="useremail" class="input-text" required>
            <label for="useremail" class="floating-label">Email</label>
            <i class="fa fa-envelope icon"></i>
        </div>

        <div class="input-group">
            <input type="password" name="userpassword" id="userpassword" class="input-text" required>
            <label for="userpassword" class="floating-label">Password</label>
            <i class="fa fa-lock icon"></i>
        </div>

        <div class="error-message">
            <?php echo $error ?>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <div class="signup-section">
            <p class="sub-text">Don't have an account&#63; 
                <a href="signup.php" class="hover-link1">Sign Up</a>
            </p>
        </div>
    </form>
</div>

</body>
</html>
