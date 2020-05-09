<?php

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $email = $phone = $country = $subject = "";
$name_err = $email_err = $phone_err = $country_err = $subject_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

// Validate name
if(empty(trim($_POST["name"]))){
     $name_err = "Please enter a name.";     
} elseif(strlen(trim($_POST["name"])) < 3){
     $name_err = "Name must have atleast over 3 characters.";
} else{
    $name = trim($_POST["name"]);
}

// Validate email
if(empty(trim($_POST["email"]))){
     $email_err = "Please enter a email";     
} elseif(strlen(trim($_POST["email"])) < 3){
     $email_err = "email must have atleast over 3 characters.";
} else{
    $email = trim($_POST["email"]);
}

// Validate phone
if(empty(trim($_POST["phone"]))){
     $phone_err = "Please enter a phone";     
} elseif(strlen(trim($_POST["phone"])) < 10){
     $email_err = "email must have 10 digits";
} else{
    $phone = trim($_POST["phone"]);
}

$country = trim($_POST["country"]);
$subject = trim($_POST["subject"]);


    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($phone_err) && empty($country_err) && empty($subject_err)    ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO contactme (name, email, phone, reachmeon, subject) VALUES (?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_phone, $param_country, $param_subject);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
	    $param_phone = $phone;
	    $param_country = $country;
	    $param_subject = $subject;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ../index.html");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);

//end for post if stmt
}

?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

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

/* Style inputs */
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

/* Style the container/contact section */
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 10px;
}

/* Create two columns that float next to eachother */
.column {
  float: left;
  width: 50%;
  margin-top: 6px;
  padding: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>

<h2>Responsive Contact Section</h2>
<p>Resize the browser window to see the effect.</p>


<div class="container">
  <div style="text-align:center">
    <h2>Contact me</h2>
    <p>Leave me a message</p>
  </div>
  <div class="row">
    <div class="column">
      <img src="contactme.png" style="width:100%">
    </div>
    <div class="column">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <label for="fname">Name</label>
        <input type="text" id="fname" name="name" placeholder="Your name..">
        <label for="lname">Email</label>
        <input type="text" id="lname" name="email" placeholder="Your Email..">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="Your Phone.">
        
	<label for="country">Reach me on </label>
        <select id="country" name="country">
          <option value="email">Email</option>
          <option value="phone">Mobile</option>
        </select>

        <label for="subject">Subject</label>
        <textarea id="subject" name="subject" placeholder="Enter Subject" style="height:170px"></textarea>
        <input type="submit" value="Submit">
      </form>
    </div>
  </div>
</div>

</body>
</html>
