<?php
session_start();
if (isset($_SESSION["loggedin"]) ){
    if ($_SESSION["loggedin"] == true) {
        if ($_SESSION["usertype"] == 1) {

        } else if ($_SESSION["usertype"] == 2) {
            header("Location:../../merchant/index.php");
        } else {
            session_destroy();
            header("Location:../../../index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        ChupIn
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="orange">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
        <div class="logo">
            <a href="http://www.chupnow.com" class="simple-text logo-mini">
                <img src="../../images/chuplogo.jpeg">
            </a>
            <a href="http://www.chupnow.com" class="simple-text logo-normal">
                ChupIn
            </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav">

                <li>
                    <a href="./profile.php">
                        <i class="now-ui-icons users_single-02"></i>
                        <p>User Profile</p>
                    </a>
                </li>
                <li class="active">
                    <a href="./previous.php">
                        <i class="now-ui-icons design_bullet-list-67"></i>
                        <p>Previous Check-Ins</p>
                    </a>
                </li>

                <li>
                    <a href="../index.php">
                        <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                        <p>Check In</p>
                    </a>
                </li>
                <li>
                    <a href="../actions/logout.php">
                        <i class="now-ui-icons media-1_button-power"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="">Previous</a>
                </div>


            </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">

        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category"></h5>
                            <h4 class="card-title">Previous Chup-Ins</h4>

                        </div>
                        <div class="card-body">
                           <table class="table-bordered">
                               <thead class="table header">
                                    <tr>
                                        <h5><b>
                                        <td>Restaurant Name</td>
                                        <td>Date and Time</td>
                                        <td>Temperature</td>
                                        </h5></b>
                                    </tr>
                               </thead>
                               <tbody class="header">
                               <?php
                               include ("../../includes/con.php");
                               $userid = $_SESSION["id"];
                               $sql = "SELECT merchantid, datetime, temperature FROM checkin WHERE userid=$userid";


                               if($stmt = mysqli_prepare($con, $sql)){
                                   // Attempt to execute the prepared statement
                                   if(mysqli_stmt_execute($stmt)){
                                       // Store result
                                       mysqli_stmt_store_result($stmt);

                                       // Check if username exists, if yes then verify password
                                       for($count=0; $count< mysqli_stmt_num_rows($stmt); $count++){
                                           // Bind result variables
                                           mysqli_stmt_bind_result($stmt, $merchantid, $datetime, $temperature);
                                           if(mysqli_stmt_fetch($stmt)){
                                              $query2 = "SELECT restaurantname FROM users WHERE id=$merchantid";
                                              $res = mysqli_query($con, $query2);
                                              $row = mysqli_fetch_assoc($res);
                                              $name = $row["restaurantname"];
                                              echo "<tr class='d-lg-table-row'><td class='d-lg-table-cell'>$name</td><td class='d-lg-table-cell'>$datetime</td>
                                                    <td class='d-lg-table-cell'>$temperature</td></tr>";

                                           } else{
                                               // Display an error message if password is not valid

                                           }
                                       }
                                   }

                                   // Close statement
                                   mysqli_stmt_close($stmt);
                               }
                               ?>

                               </tbody>
                           </table>

                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <footer class="footer">
                <div class=" container-fluid ">
                    <nav>
                        <ul>
                            <li>
                                <a >
                                    Chup Now
                                </a>
                            </li>
                            <li>
                                <a href="chupnow.com">
                                    About Us
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <div class="copyright" id="copyright">
                        &copy; <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Coded by <a href="https://www.linkedin.com/in/byron-tze-min-kweh-039a4515b/" target="_blank">Byron Kweh</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();

        });
    </script>
</body>

</html>