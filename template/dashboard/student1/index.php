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

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../student/index.php">
                  <span data-feather="users"></span>
                  Manage Students
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Service Hours
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="award"></span>
                  Service Awards
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Saved reports</span>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Weekly
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Monthly
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

	  <div class="wrapper">
              <div class="row">
                <div class="col-md-6">
			<h2>Student Details</h2>
		</div>
                <div class="col-md-6">
                  <div class="page-header clearfix">
                    <a href="create.php" class="btn btn-success pull-right"><span data-feather="plus-circle"></span> Add New Student</a>
                  </div>
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
                    $sql = "SELECT * FROM employees";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                  echo "<table class='table table-bordered table-striped'>";
                  echo "<thead>";
                  echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Name</th>";
                    echo "<th>Address</th>";
                    echo "<th>Salary</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  while($row = mysqli_fetch_array($result)){
                  echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['salary'] . "</td>";
                    echo "<td>";
                      echo "<a href='read.php?id=". $row['id'] ."' > view </a>";
                      echo "<a href='update.php?id=". $row['id'] ."' > update </a>";
                      echo "<a href='   delete.php?id=". $row['id'] ."' > delete </a>";
                      echo "</td>";
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