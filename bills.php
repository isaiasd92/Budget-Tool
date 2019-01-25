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
            Bills
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
        <script id="thisChart"></script>

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
                <span class="menu-icon glyphicon glyphicon-inbox"></span>
                Bills
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

        <!-- Bill Chart Collapse Bar -->
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                <a class="accordion-toggle" id="bill-chartButton" style="text-decoration:none" data-toggle="collapse" data-parent="#accordion" href="#collapseChart">
                    <h4 class="panel-title">
                        <span id="bill-icon-chartButton" class="glyphicon glyphicon-plus"></span>
                        Chart
                    </h4>
                </a>
                </div>
                <div id="collapseChart" class="panel-collapse collapse">
                    <div class="panel-body">
                        
                        <!-- Date Selector Title -->
                        <div class="row">
                            <a id="date-title-link">
                                <h1 id="date-title"></h1>
                            </a>
                        </div>
                        <!-- End Date Selector Title -->

                        <!-- Failure Message -->
                        <div id="bill-chart-failure" class="row hide">
                            <h1>
                                No Data Available! Please Try Another Date
                            </h1>
                        </div>
                        <!-- End Failure Message -->

                        <!-- Year Selector -->
                        <div id="bill-years" class="container-fluid">
                            <div class="row year-row">
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2019">
                                            2019
                                        </button>
                                        <button class="btn year-button" value="2020">
                                            2020
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2021">
                                            2021
                                        </button>
                                        <button class="btn year-button" value="2022">
                                            2022
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2023">
                                            2023
                                        </button>
                                        <button class="btn year-button" value="2024">
                                            2024
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row year-row">
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2025">
                                            2025
                                        </button>
                                        <button class="btn year-button" value="2026">
                                            2026
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2027">
                                            2027
                                        </button>
                                        <button class="btn year-button" value="2028">
                                            2028
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn year-button" value="2029">
                                            2029
                                        </button>
                                        <button class="btn year-button" value="2030">
                                            2030
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Year Selector -->

                        <!-- Month Selector -->
                        <div id="bill-months" class="container-fluid hide">
                            <div class="row month-row">
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="1">
                                            Jan
                                        </button>
                                        <button class="btn month-button" value="2">
                                            Feb
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="3">
                                            Mar
                                        </button>
                                        <button class="btn month-button" value="4">
                                            Apr
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="5">
                                            May
                                        </button>
                                        <button class="btn month-button" value="6">
                                            Jun
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row month-row">
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="7">
                                            Jul
                                        </button>
                                        <button class="btn month-button" value="8">
                                            Aug
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="9">
                                            Sep
                                        </button>
                                        <button class="btn month-button" value="10">
                                            Oct
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="row">
                                        <button class="btn month-button" value="11">
                                            Nov
                                        </button>
                                        <button class="btn month-button" value="12">
                                            Dec
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Month Selector -->

                        <!-- Chart Legend -->
                        <div id="bill-chart-legend-button" class="dropdown hide">
                            <button class="btn dropdown-toggle" type="button" id="bill-chart-legend_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon glyphicon-list"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div id="bill-chart-legend-container" class="dropdown-item row">
                                    <div id="bill-chart-legend" class="chart-legend"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End Chart Legend -->
                        
                        <!-- Chart -->
                        <div class="doughnut-chart">
                            <canvas id="myDoughnutChart" width="100%" height="100%"></canvas>
                        </div>
                        <!-- End Chart -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bill Chart Collapse Bar -->

        <!-- Bill Collapse Bar -->
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                <a class="accordion-toggle" id="bill-tableButton" style="text-decoration:none" data-toggle="collapse" data-parent="#accordion" href="#collapseBill">
                    <h4 class="panel-title">
                        <span id="bill-icon-tableButton" class="glyphicon glyphicon-plus"></span>
                        Table
                    </h4>
                </a>
                </div>
                <div id="collapseBill" class="panel-collapse collapse">
                    <div class="panel-body">
                        <!-- Table -->
                        <div  id="bill_table" class="table-responsive">
                            <table class="table table-bordered">
                                <tr class="results" >
                                    <th>Bill</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Paid</th>
                                    <th></th>
                                </tr>
                                <?php
                                    $bill_query = "SELECT id, company, amount, due_date, is_paid FROM bills ORDER BY id ASC";
                                    $bill_result = mysqli_query($conn, $bill_query);

                                    while($bill_row = mysqli_fetch_array($bill_result))
                                    {
                                ?>
                                <tr id="<?php echo $bill_row["id"]; ?>">
                                    <td data-target="bill_list_company">
                                        <?php echo $bill_row["company"]; ?>
                                    </td>
                                    <td data-target="bill_list_amount">
                                        <?php echo $bill_row["amount"]; ?>
                                    </td>
                                    <td data-target="bill_list_due_date">
                                        <?php echo date("m/d/Y", strtotime($bill_row["due_date"])) ?>
                                    </td>
                                        <?php   
                                            if($bill_row["is_paid"] == 0)
                                            {
                                        ?>
                                        <td data-target="debt_list_is_paid">
                                            No
                                        </td>
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                        <td data-target="debt_list_is_paid" style="background-color: lightgreen;">
                                            Yes
                                        </td>
                                        <?php
                                            }
                                        ?>
                                    <td>
                                        <button data-id="<?php echo $bill_row["id"]; ?>" class="menuButton view_bills btn btn-secondary">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                        </button>
                                        <button data-id="<?php echo $bill_row["id"]; ?>" class="menuButton edit_bills btn btn-warning">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>
                                        <button data-id="<?php echo $bill_row["id"]; ?>" class="menuButton delete_bill btn btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bill Collapse Bar -->
        
        <button id="addNew" class="menuButton btn btn-primary" data-toggle="modal" data-target="#add_bill_modal">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </body>
</html>

<!-- View Bill Modal -->
<div id="view_bill_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Bills</h4>
            </div>
            <div class="modal-body" id="bill_detail">
            </div>
        </div>
    </div>
</div>
<!-- End View Bill Modal -->

<!-- Add Bill Modal -->
<div id="add_bill_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Add New Bill</h4>
            </div>
            <div class="modal-body" id="bill_add">
                <form method="post" id="add_bill_form">
                    <label>
                        Name
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </div>
                        <input type="text" id="bill_add_company" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Due Date
                    </label>
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span id="bill_add_calendar" class="glyphicon glyphicon-th"></span>
                        </div>
                        <input type="text" id="bill_add_due_date" class="form-control">
                    </div>
                    <br />
                    <label>
                        Amount
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-usd"></span>
                        </div>
                        <input type="text" id="bill_add_amount" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Notes
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-file"></span>
                        </div>
                        <input type="text" id="bill_add_notes" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Paid
                    </label>
                    <div class="input-group">
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-lg" id="add_bill_is_paid_yes_label">
                            <input type="radio" id="bill_add_is_paid_yes" value="1">Yes</label>
                            <label class="btn btn-default btn-off btn-lg active" id="add_bill_is_paid_no_label">
                            <input type="radio" id="bill_add_is_paid_no" value="0">No</label>
                        </div>
                    </div>
                    <br />
                    <button type="button" name="insert" id="insert_bill" class="btn btn-success">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Bill Modal -->

<!-- Edit Bill Modal -->
<div id="edit_bill_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Edit Bill</h4>
            </div>
            <div class="modal-body" id="bill_edit">
            </div>
        </div>
    </div>
</div>
<!-- End Edit Bill Modal -->

<!-- Bill Added Popup -->
<div id="bill_added" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Bill Added! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Bill Added Popup -->

<!-- Bill Removed Popup -->
<div id="bill_removed" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Bill Removed! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Bill Removed Popup -->

<!-- Bill Updated Popup -->
<div id="bill_updated" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Bill Updated! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Bill Updated Popup -->

<!-- Delete Confirmation Popup -->
<div id="bills_delete_confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Are You Sure You Want to Delete This? </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success yes_button glyphicon glyphicon-ok" id="bills_delete_confirmation_yes" value="1"></button>
                <button type="button" class="btn btn-danger no_button btn btn-danger glyphicon glyphicon-remove" id="bills_delete_confirmation_no" value="0"></button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Confirmation Popup -->

<!-- Close MySQL Connection -->
<?php mysqli_close($conn); ?>