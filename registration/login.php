<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: ../dashboard/dashboard.php");
    exit;
}
 
require_once "../db.php";
 
$username = $password = "";
$username_err = $password_err = "";
$is_admin = false;
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $req_password = md5(trim($_POST["password"]));
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password, is_admin FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql))
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $password, $is_admin);

                    if(mysqli_stmt_fetch($stmt)){
                        if($req_password == $password){

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userid"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["is_admin"] = $is_admin;

                            if ($is_admin)
                                header("location: ../admin/admin-dashboard.php");
                            else
                                header("location: ../dashboard/dashboard.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login | Bunk Manager</title>
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

                                    <div class="form-group">
                                        <input type="submit" class="au-btn au-btn--block au-btn--green m-b-20" value="Login">
                                    </div>
                                </form>

                                <div class="register-link">
                                    <p>
                                        Don't you have account?
                                        <a href="register.php">Sign Up Here</a>
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