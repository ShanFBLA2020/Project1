<?php
// Initialize the session
session_start();
 
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $checkbox = "";
$username_err = $password_err = $checkbox_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    if(empty(trim($_POST["terms"]))){
	$checkbox_err = "Please agree to terms and conditions";
    }
    else{
    	$checkbox = trim($_POST["terms"]);
    }
    // Validate credentials
    if(empty($username_err) && empty($password_err)&& empty($checkbox_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: ../dashboard/index.php");
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

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: black;
  margin: 0 auto; 
  width:50%;
  margin-top:50px;
margin-bottom:50px;
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.help-block{
  color: red;
  font-weight: bold;

}
.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="container">
    <h1>Sign In</h1>
    <p>Please fill in this form to sign in</p>
    <hr>

<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="username" value="<?php echo $username; ?>" required>
    <span class="help-block"><?php echo $username_err; ?></span>
</div>   

<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
    <span class="help-block"><?php echo $password_err; ?></span>
</div>

<div class="form-group <?php echo (!empty($checkbox_err)) ? 'has-error' : ''; ?>">
    <label for="terms"><input type="checkbox" id="terms" name="terms" value="terms"> I Agree to Terms & Conditions</label><br>
    <span class="help-block"><?php echo $checkbox_err; ?></span>
</div>


<div class="form-group">
    <button type="submit" class="registerbtn" value="Login">Sign In</button>
  </div>
  
  <div class="container signin">
    <p>Please sign-up for an account? <a href="../signup/index.php">Sign up</a>.</p>
  </div>
</form>

</body>
</html>