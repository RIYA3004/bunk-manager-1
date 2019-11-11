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
 
$username = $password = $confirm_password = $first_name = $last_name = "";
$username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = "";
 
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
        $sql = "INSERT INTO users (username, password, fname, lname) VALUES('$username', '$password', '$first_name', '$last_name')";
        
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Bunk Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin: 60px auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <p>Please fill in your credentials to register.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control">
                <span class="help-block"><?php echo $first_name_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control">
                <span class="help-block"><?php echo $last_name_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register">
            </div>
            <p>Already have an account? <a href="login.php">Log In</a>.</p>
        </form>
    </div>    
</body>
</html>