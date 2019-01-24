<?php 
    include 'php/db.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Budget Tool
        </title>

        <!-- CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
        
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

        <!-- Javascript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script src="js/chart.bundle.js"></script>
        <script src="js/scripts.js"></script>

        <!-- Summary Chart -->
        <script id="thisBudgetChart"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div id="banner">
                Our Budget
            </div>
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
    
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"><span class="menu-icon glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="bills.php"><span class="menu-icon glyphicon glyphicon-inbox"></span> Bills</a></li>
                        <li><a href="income.php"><span class="menu-icon glyphicon glyphicon-usd"></span> Income</a></li>
                        <li><a href="debt.php"><span class="menu-icon glyphicon glyphicon-alert"></span> Debt</a></li>
                        <li><a href="calculator.php"><span class="menu-icon glyphicon glyphicon-phone"></span> Calculator</a></li>
                        <li><a href="settings.php"><span class="menu-icon glyphicon glyphicon-cog"></span> Settings</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Date Range -->
        <div id="budget-summary-title" class="row text-center">
            <h1>
                This Month's Summary
            </h1>

            <!-- Chart -->
            <div class="doughnut-chart">
                <canvas id="myBudgetChart" width="100%" height="100%"></canvas>
            </div>
            <!-- End Chart -->
            
        </div>
        <!-- End Date Range -->
        
    </body>
</html>

<!-- Close MySQL Connection -->
<?php mysqli_close($conn); ?>