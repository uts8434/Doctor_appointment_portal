<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Sign Up</title>
    
</head>
<body>
        <?php
                session_start();

                $_SESSION["user"]="";
                $_SESSION["usertype"]="";

                // Set the new timezone
                date_default_timezone_set('Asia/Kolkata');
                $date = date('Y-m-d');

                $_SESSION["date"]=$date;



                if($_POST){
                    $_SESSION["personal"]=array(
                        'fname'=>$_POST['fname'],
                        'lname'=>$_POST['lname'],
                        'address'=>$_POST['address'],
                        'nic'=>$_POST['nic'],
                        'dob'=>$_POST['dob']
                    );


                    print_r($_SESSION["personal"]);
                    header("location: create-account.php");

                }

        ?>
    <div class="container">
        <h2 class="header-text">Let's Get Started</h2>
        <p class="sub-text">Add Your Personal Details to Continue</p>
        
        <form action="" method="POST">
            
            <div class="input-group">
                <input type="text" name="fname" id="fname" required>
                <label for="fname">First Name</label>
            </div>

            <div class="input-group">
                <input type="text" name="lname" id="lname" required>
                <label for="lname">Last Name</label>
            </div>

            <div class="input-group">
                <input type="text" name="address" id="address" required>
                <label for="address">Address</label>
            </div>

            <div class="input-group">
                <input type="text" name="nic" id="nic" required>
                <label for="nic">Ayushman Card Number</label>
            </div>

            <div class="input-group">
                <input type="date" name="dob" id="dob" required>
                <label for="dob">Date of Birth</label>
            </div>

            <div class="btn-group">
                <input type="reset" value="Reset" class="btn reset-btn">
                <input type="submit" value="Next" class="btn submit-btn">
            </div>

            <p class="sub-text">Already have an account? <a href="login.php" class="hover-link1">Login</a></p>
        </form>
    </div>

    
</body>
</html>