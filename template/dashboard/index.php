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
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.html">SCVTHS FBLA COMMUNITY SERVICE</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="../logout/index.php">Sign out</a>
        </li>
      </ul>
    </nav>



	<?php include "content1.html" ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

                  <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT student_number,  student_name, servicedate, servicehours
			FROM student a, servicehours b where a.student_id = b.student_id order by servicedate desc";
			?>

          <h2><i class="fas fa-trophy"></i>Recent Service Hours</h2>
          <div class="table-responsive">
	<?php
		   if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
            			echo "<table class='table table-striped table-sm'>";
   				echo "<thead>";
                  		echo "<tr>";
                    		echo "<th>Student Number</th>";
                    		echo "<th>Student Name</th>";
                    		echo "<th>Service Date</th>";
                    		echo "<th>Service Hours</th>";
                    		echo "</tr>";
                  		echo "</thead>";
				echo "<tbody>";
                  		while($row = mysqli_fetch_array($result)){
					echo "<tr>";
                    			echo "<td>" . $row['student_number'] . "</td>";
                    			echo "<td>" . $row['student_name'] . "</td>";
                    			echo "<td>" . $row['servicedate'] . "</td>";
                    			echo "<td>" . $row['servicehours'] . "</td>";
                    			echo "</tr>";
                  		}
                  		echo "</tbody>";
                  		echo "</table>";
			// Free result set
                  	mysqli_free_result($result);
                  	} else{
                  		echo "<p class='lead'><em>No records were found.</em></p>";
                  	}
                  	} else{
                  		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                  	}
                  // Close connection
                  mysqli_close($link);
                  ?>
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
