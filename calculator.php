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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

        <!-- Javascript -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script src="js/scripts.js"></script>

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
                <span class="menu-icon glyphicon glyphicon-phone"></span>
                Calculator
            </div>
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
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
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <!-- Calculator -->
        <?php
            $data_bill_query = "SELECT company, amount, due_date FROM bills";
            $data_debt_query = "SELECT company, amount, due_date FROM debt";
            $data_income_query = "SELECT name, amount, pay_date FROM income";

            $data_bill_result = mysqli_query($conn, $data_bill_query);
            $data_debt_result = mysqli_query($conn, $data_debt_query);
            $data_income_result = mysqli_query($conn, $data_income_query);
        ?>
        <!-- Bills -->
        <table class="table calculator_table">
            <tr class="results">
                <th>Bills</th>
                <th>Company</th>
                <th>Amount</th>
                <th>Due Date</th>
            </tr>
            <?php

                while($data_bill_row = mysqli_fetch_array($data_bill_result))
                {
            ?>
            <tr>
                <td>
                    <input type="checkbox" class="bill_checkbox" checked data-toggle="toggle" data-width="50" data-onstyle="success" data-offstyle="danger">
                </td>
                <td>
                    <?php echo $data_bill_row["company"]; ?>
                </td>
                <td value="<?php echo $data_bill_row["amount"]; ?>">
                    <?php echo $data_bill_row["amount"]; ?>
                </td>
                <td>
                    <?php echo $data_bill_row["due_date"]; ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
        <!-- End Bills -->
        <br/>
        <!-- Debt -->
        <table class="table calculator_table">
            <tr class="results">
                <th>Debt</th>
                <th>Company</th>
                <th>Amount</th>
                <th>Due Date</th>
            </tr>
            <?php

                while($data_debt_row = mysqli_fetch_array($data_debt_result))
                {
            ?>
            <tr>
                <td>
                    <input type="checkbox" class="bill_checkbox" checked data-toggle="toggle" data-width="50" data-onstyle="success" data-offstyle="danger">
                </td>
                <td>
                    <?php echo $data_debt_row["company"]; ?>
                </td>
                <td value="<?php echo $data_debt_row["amount"]; ?>">
                    <?php echo $data_debt_row["amount"]; ?>
                </td>
                <td>
                    <?php echo $data_debt_row["due_date"]; ?>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
        <!-- End Debt -->
        
        <!-- End Calculator -->
    </body>
</html>