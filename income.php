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

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

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
                <span class="menu-icon glyphicon glyphicon-usd"></span>
                Income
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
        <!-- Table -->
        <div  id="income_table" class="table-responsive">
            <table class="table table-bordered">
                <tr class="results" >
                    <th>Paycheck</th>
                    <th>Amount</th>
                    <th>Pay Date</th>
                    <th></th>
                </tr>
                <?php
                    $income_query = "SELECT id, name, pay_date, amount FROM income ORDER BY id DESC";
                    $income_result = mysqli_query($conn, $income_query);

                    while($income_row = mysqli_fetch_array($income_result))
                    {
                ?>
                <tr id="<?php echo $income_row["id"]; ?>">
                    <td data-target="income_list_name">
                        <?php echo $income_row["name"]; ?>
                    </td>
                    <td data-target="income_list_amount">
                        <?php echo $income_row["amount"]; ?>
                    </td>
                    <td data-target="income_list_pay_date">
                        <?php echo date("m/d/Y", strtotime($income_row["pay_date"])) ?>
                    </td>
                    <td>
                        <button data-id="<?php echo $income_row["id"]; ?>" class="menuButton view_incomes btn btn-secondary">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </button>
                        <button data-id="<?php echo $income_row["id"]; ?>" class="menuButton edit_incomes btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button data-id="<?php echo $income_row["id"]; ?>" class="menuButton delete_income btn btn-danger">
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
        <button id="addNew" class="menuButton btn btn-primary" data-toggle="modal" data-target="#add_income_modal">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </body>
</html>

<!-- View Income Modal -->
<div id="view_income_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Income</h4>
            </div>
            <div class="modal-body" id="income_detail">
            </div>
        </div>
    </div>
</div>
<!-- End View Income Modal -->

<!-- Add Income Modal -->
<div id="add_income_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Add New Income</h4>
            </div>
            <div class="modal-body" id="income_add">
                <form method="post" id="add_income_form">
                    <label>
                        Name
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </div>
                        <input type="text" id="income_add_name" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Pay Date
                    </label>
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span id="income_add_calendar" class="glyphicon glyphicon-th"></span>
                        </div>
                        <input type="text" id="income_add_pay_date" class="form-control">
                    </div>
                    <br />
                    <label>
                        Amount
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-usd"></span>
                        </div>
                        <input type="text" id="income_add_amount" class="form-control" />
                    </div>
                    <br />
                    <button type="button" name="insert" id="insert_income" class="btn btn-success">insert</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Income Modal -->

<!-- Edit Income Modal -->
<div id="edit_income_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Edit Income</h4>
            </div>
            <div class="modal-body" id="income_edit">
            </div>
        </div>
    </div>
</div>
<!-- End Edit Income Modal -->

<!-- Income Added Popup -->
<div id="income_added" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Income Added! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Income Added Popup -->

<!-- Income Removed Popup -->
<div id="income_removed" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Income Removed! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Income Removed Popup -->

<!-- Income Updated Popup -->
<div id="income_updated" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Income Updated! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Income Updated Popup -->