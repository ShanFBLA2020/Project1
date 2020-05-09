<?php
// Include config file
require_once "config.php";
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
     } else
	{
	$id =  "W";
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
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">CSAP.ORG</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
        </li>
      </ul>
    </nav>

<?php include "../../content1.html" ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">
	    <?php
		if ($id == "W") echo "Last 7 Days - Service Hours ";
		if ($id == "M3") echo "Last 3 Months - Service Hours ";
		?>
		 </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Share</button>
                <button class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div>
          </div>

          <canvas class="my-4" id="myChart" width="900" height="360"></canvas>

 
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

   <?php
	$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if (mysqli_connect_errno()) 
	{ 
		echo "Database connection failed."; 
    	} 
	  if ($id == "W") {
		$query = "select dayname(servicedate) wth, sum(servicehours) hrs  from servicehours where servicedate >= CURRENT_DATE-7 group by dayname(servicedate)";
		$result = mysqli_query($connection, $query); 
	 } 
	  if ($id == "M3") {
		$query = "select monthname(servicedate) wth, sum(servicehours) hrs  from servicehours where servicedate >= DATE_ADD(CURRENT_DATE(), INTERVAL -90 DAY) group by monthname(servicedate);";
		$result = mysqli_query($connection, $query); 
	 } 
   ?>

		<?php
		$labels = "[";
		$data = "[";
		while ($row = mysqli_fetch_array($result)) {
			if ($labels == "[") {	
				$labels = $labels . "'" . $row['wth'] . "'";
				$data = $data . "'" . $row['hrs'] . "'";
			} else
			{
				$labels = $labels . "," . "'" . $row['wth'] . "'";
				$data = $data  . "," . "'" . $row['hrs'] . "'";
			}
				}
		$labels = $labels . "]";
		$data = $data . "]";
		//labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		//data: [50, 100, 120, 145, 180, 122, 201],
	        ?>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?php echo $labels; ?>,
          datasets: [{
            data: <?php echo $data; ?>,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
  </body>
</html>
