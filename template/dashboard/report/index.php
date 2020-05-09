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
              <div class="row">
                <div class="col-md-6">
			<h2>Award Report</h2>
		</div>
	  </div>
          <div class="wrapper">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT student_name, student_number, sum(servicehours) svchours,
			(case 
 				when sum(servicehours) > (select svchours from awardcriteria where upper(awardname) like '%GOLD%')  then 'GOLD'
				when sum(servicehours) > (select svchours from awardcriteria where upper(awardname) like '%SILVER%')  then 'SILVER'
				when sum(servicehours) > (select svchours from awardcriteria where upper(awardname) like '%BRONZE%')  then 'BRONZE'
			 else 'NEED MORE HOURS'
 			end) Award
			FROM student a, servicehours b where a.student_id = b.student_id group by student_name,  student_number";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                  echo "<table class='table table-bordered table-striped'>";
                  echo "<thead>";
                  echo "<tr>";
                    echo "<th>Student Number</th>";
                    echo "<th>Student Name</th>";
                    echo "<th>Service Hours</th>";
                    echo "<th>Award</th>";
                    echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  while($row = mysqli_fetch_array($result)){
		    if ($row['Award']=="GOLD") {$image = "<img src='goldaward.svg' />";}
		    if ($row['Award']=="SILVER") {$image = "<img src='silveraward.svg' />";}
		    if ($row['Award']=="BRONZE") {$image = "<img src='bronzeaward.svg' />";}
		    if ($row['Award']=="NEED MORE HOURS") {$image = "";}
                    echo "<tr>";
                    echo "<td>" . $row['student_number'] . "</td>";
                    echo "<td>" . $row['student_name'] . " " . $image . "</td>";
                    echo "<td>" . $row['svchours'] . "</td>";
                    echo "<td>" . $row['Award'] . "</td>";
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