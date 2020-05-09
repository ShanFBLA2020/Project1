<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $svchours = $servicedate = "";
$name_err = $svchours_err = $servicedate_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    // Validate student service hours
    $input_svchours= trim($_POST["svchours"]);
    if(empty($input_svchours)){
        $svchours_err = "Please enter student hours";     
    } else{
        $svchours = $input_svchours;
    }
    
    // Validate student name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter student name";     
    } else {
        $name = $input_name;
    }

    // Validate service date
    $input_servicedate = trim($_POST["servicedate"]);
    if(empty($input_servicedate)){
        $servicedaate_err = "Please enter service date";     
    } else {
        $servicedate = $input_servicedate;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($svchours_err) && empty($servicedate_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO servicehours (student_id, servicedate, servicehours) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_id, $param_servicedate, $param_svchours);
            
            // Set parameters
            $param_id = $name;
            $param_svchours = $svchours;
            $param_servicedate = $servicedate;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CSAP.ORG</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../index.html">Sign out</a>
        </li>
      </ul>
    </nav>

<?php include "../content1.html" ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add Student Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

			<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                         <label>Student Name</label>
		    	<?php
			echo '<p><select name=' . 'name' . '>
				<option>Select</option>';
				$sqli = "SELECT student_id, student_name FROM student";
				$result = mysqli_query($link, $sqli);
				while ($row = mysqli_fetch_array($result)) {
					echo $row['student_id'];
					echo '<option value = ' .$row['student_id']. '>'. $row['student_id'] . ' - ' . $row['student_name'].'</option>';
				}
				echo '</select></p>';
				unset($link);
			?>
		          <span class="help-block"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($servicedate_err)) ? 'has-error' : ''; ?>">
                            <label>Student Service Date</label>
                            <input type="date" name="servicedate" class="form-control"><?php echo $servicedate; ?></>
                            <span class="help-block"><?php echo $servicedate_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($svchours_err)) ? 'has-error' : ''; ?>">
                            <label>Student Service Hours</label>
                            <input name="svchours" class="form-control"><?php echo $svchours; ?></>
                            <span class="help-block"><?php echo $svchours_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>



        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="jquery-slim.min.js"><\/script>')</script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

  </body>
</html>