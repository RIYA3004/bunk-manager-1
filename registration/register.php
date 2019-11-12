<?php

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: ../dashboard/dashboard.php");
    exit;
}
 
require_once "../db.php";
 
$username = $password = $confirm_password = $first_name = $last_name = $email =  "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = $email_err =  "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // First Name
    if(empty(trim($_POST["first_name"]))){
        $first_name_err = "Please enter first name.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    // Last Name
    if(empty(trim($_POST["last_name"]))){
        $last_name_err = "Please enter last name.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    // Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter correct email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = md5(trim($_POST["password"]));
    }

    // Confirm Password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please enter your password.";
    } else {
        $confirm_password = md5(trim($_POST["confirm_password"]));
        if ($password != $confirm_password)
            $confirm_password_err = "Password does not match.";
    }
    
    if(empty($first_name_err) && empty($last_name_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO users (username, password, fname, lname, email) VALUES('$username', '$password', '$first_name', '$last_name', '$email')";
        
        $result = mysqli_query($db, $sql);
        
        if($result)
        {
            alert("Register Successfully!");
            header("Location: login.php");
        }
        else 
        {
            alert("Error while registering!");
        }
            
    }
    
    // Close connection
    mysqli_close($db);
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Register | Bunk Manager</title>
        <?php include_once '../includes/header.php'; ?> 

           
    </head>

    <body class="animsition">
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                <h3>Bunk Manager</h3>
                            </div>
                            <div class="login-form">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="au-input au-input--full">
                                        <span class="help-block"><?php echo $first_name_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name" class="au-input au-input--full">
                                        <span class="help-block"><?php echo $last_name_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="au-input au-input--full" value="<?php echo $email; ?>">
                                        <span class="help-block"><?php echo $email_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label>Username</label>
                                        <input type="text" name="username" class="au-input au-input--full" value="<?php echo $username; ?>">
                                        <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>    
                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label>Password</label>
                                        <input type="password" name="password" class="au-input au-input--full">
                                        <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>

                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password" class="au-input au-input--full">
                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Register">
                                    </div>
                                    
                                </form>
                                <div class="register-link">
                                    <p>
                                        Already have account?
                                        <a href="login.php">Sign In</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../includes/scripts.php'; ?>
    </body>
</html>