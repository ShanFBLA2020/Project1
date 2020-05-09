<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT a.id, b.student_number, b.student_name, a.servicedate, a.servicehours FROM ServiceHours a, student b where a.student_id = b.student_id and id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $student_name = $row["student_name"];
                $student_number = $row["student_number"];
		$servicedate = $row["servicedate"];	
                $servicehours = $row["servicehours"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Student Name</label>
                        <p class="form-control-static"><?php echo $row["student_name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Student Number</label>
                        <p class="form-control-static"><?php echo $row["student_number"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Service Date </label>
                        <p class="form-control-static"><?php echo $row["servicedate"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Student Hours</label>
                        <p class="form-control-static"><?php echo $row["servicehours"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
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