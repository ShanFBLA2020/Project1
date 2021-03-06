<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $number = $grade = "";
$name_err = $number_err = $grade_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate number number
    $input_number = trim($_POST["number"]);
    if(empty($input_number)){
        $number_err = "Please enter an number.";
    } else{
        $number = $input_number;
    }

    // Validate grade
    $input_grade = trim($_POST["grade"]);
    if(empty($input_grade)){
        $grade_err = "Please enter the grade";
    } else{
        $grade = $input_grade;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($number_err) && empty($grade_err)){
        // Prepare an update statement
        $sql = "UPDATE student SET student_name=?, student_number=?, student_grade=? WHERE student_id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_number, $param_grade, $param_id);

            // Set parameters
            $param_name = $name;
            $param_number = $number;
            $param_grade = $grade;
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
    if(isset($_GET["student_id"]) && !empty(trim($_GET["student_id"]))){
        // Get URL parameter
        $id =  trim($_GET["student_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM student WHERE student_id = ?";
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
                    $name = $row["student_name"];
                    $number = $row["student_number"];
                    $grade = $row["student_grade"];
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
                         <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                             <label>Student Name</label>
                             <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                             <span class="help-block"><?php echo $name_err;?></span>
                         </div>
                         <div class="form-group <?php echo (!empty($number_err)) ? 'has-error' : ''; ?>">
                             <label>Student Number</label>
                             <textarea name="number" class="form-control"><?php echo $number; ?></textarea>
                             <span class="help-block"><?php echo $number_err;?></span>
                         </div>
                         <div class="form-group <?php echo (!empty($grade_err)) ? 'has-error' : ''; ?>">
                             <label>Student Grade</label>
                             <input type="text" name="grade" class="form-control" value="<?php echo $grade; ?>">
                             <span class="help-block"><?php echo $grade_err;?></span>
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