<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$awardname = $effectivedate = $svchours = "";
$awardname_err = $effectivedate_err = $svchours_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate award name
    $input_awardname = trim($_POST["awardname"]);
    if(empty($input_awardname)){
        $awardname_err = "Please enter award name";     
    } else{
        $awardname = $input_awardname;
    }
    
    // Validate effective date
    $input_effectivedate = trim($_POST["effectivedate"]);
    if(empty($input_effectivedate)){
        $effectivedate_err = "Please enter effective date";     
    } else {
        $effectivedate = $input_effectivedate;
    }

    // Validate effective date
    $input_svchours = trim($_POST["svchours"]);
    if(empty($input_svchours)){
        $svchours_err = "Please enter Service Hours";     
    } else {
        $svchours = $input_svchours;
    }

    // Check input errors before updating in database
    if(empty($awardname_err) && empty($effectivedate_err) && empty($svchours_err)){
        // Prepare an update statement
        $sql = "UPDATE awardcriteria SET awardname =?, effectivedate=?, svchours=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_awardname, $param_effectivedate, $param_svchours, $param_id);

            // Set parameters
            $param_awardname = $awardname;
            $param_effectivedate = $effectivedate;
            $param_svchours = $svchours;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM awardcriteria WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $awardname = $row["awardname"];
                    $effectivedate = $row["effectivedate"];
                    $svchours = $row["svchours"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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

          <h2>Student Details - Update Record</h2>
     <div class="wrapper">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <p>Please edit the input values and submit to update the record.</p>
                     <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($awardname_err)) ? 'has-error' : ''; ?>">
                            <label>Award Name</label>
                            <input type="text" name="awardname" class="form-control" value="<?php echo $awardname; ?>">
                            <span class="help-block"><?php echo $awardname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($effectivedate_err)) ? 'has-error' : ''; ?>">
                            <label>Effective Date</label>
                            <input type="date" name="effectivedate" class="form-control" value="<?php echo $effectivedate; ?>">
                            <span class="help-block"><?php echo $effectivedate_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($svchours_err)) ? 'has-error' : ''; ?>">
                            <label>Service Hours</label>
                            <input type="text" name="svchours" class="form-control" value="<?php echo $svchours; ?>">
                            <span class="help-block"><?php echo $svchours_err;?></span>
                        </div>
                         <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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