<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $checkbox = "";
$username_err = $password_err = $confirm_password_err = $checkbox_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?"; 
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
     if(empty(trim($_POST["terms"]))){
	$checkbox_err = "Please agree to terms and conditions";
    }
    else{
    	$checkbox = trim($_POST["terms"]);
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&&empty($checkbox_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ../login/index.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
  margin-top:30px;
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
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    	<label for="email"><b>Email</b></label>
    	<input type="text" placeholder="Enter Email" name="username" value="<?php echo $username; ?>" required>
    	<span class="help-block"><?php echo $username_err; ?></span>
    </div>   

    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    	<label for="psw"><b>Password</b></label>
    	<input type="password" placeholder="Enter Password" name="password" value="<?php echo $password; ?>" required>
        <span class="help-block"><?php echo $password_err; ?></span>
    </div>
 
    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="confirm_password" value="<?php echo $confirm_password; ?>" required>
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
    </div>
   <div class="form-group <?php echo (!empty($checkbox_err)) ? 'has-error' : ''; ?>">
        <label for="terms"><input type="checkbox" id="terms" name="terms" value="terms"> I Agree to Terms & Conditions</label><br>
        <span class="help-block"><?php echo $checkbox_err; ?></span>
   </div>
  

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="../login/index.php">Sign in</a>.</p>
  </div>
</form>

</body>
</html>