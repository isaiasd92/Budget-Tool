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
            Debts
        </title>

        <!-- CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet">
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
        
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
                <span class="menu-icon glyphicon glyphicon-inbox"></span>
                Debts
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
        <!-- Table -->
        <div  id="debt_table" class="table-responsive">
            <table class="table table-bordered">
                <tr class="results" >
                    <th>Debt</th>
                    <th>Amount</th>
                    <th>Pay Off</th>
                    <th>Paid</th>
                    <th></th>
                </tr>
                <?php
                    $debt_query = "SELECT id, company, amount, due_date, is_paid FROM debt ORDER BY id ASC";
                    $debt_result = mysqli_query($conn, $debt_query);

                    while($debt_row = mysqli_fetch_array($debt_result))
                    {
                ?>
                <tr id="<?php echo $debt_row["id"]; ?>">
                    <td data-target="debt_list_company">
                        <?php echo $debt_row["company"]; ?>
                    </td>
                    <td data-target="debt_list_amount">
                        <?php echo $debt_row["amount"]; ?>
                    </td>
                    <td data-target="debt_list_due_date">
                        <?php echo date("m/d/Y", strtotime($debt_row["due_date"])) ?>
                    </td>
                        <?php   
                            if($debt_row["is_paid"] == 0)
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
                        <button data-id="<?php echo $debt_row["id"]; ?>" class="menuButton view_debts_payments btn btn-primary">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </button>
                        <button data-id="<?php echo $debt_row["id"]; ?>" class="menuButton pay_debts btn btn-success">
                            <span class="glyphicon glyphicon-usd"></span>
                        </button>
                        <button data-id="<?php echo $debt_row["id"]; ?>" class="menuButton view_debts btn btn-secondary">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </button>
                        <button data-id="<?php echo $debt_row["id"]; ?>" class="menuButton edit_debts btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button data-id="<?php echo $debt_row["id"]; ?>" class="menuButton delete_debt btn btn-danger">
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
        <button id="addNew" class="menuButton btn btn-primary" data-toggle="modal" data-target="#add_debt_modal">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </body>
</html>

<!-- View Debt Modal -->
<div id="view_debt_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Debts</h4>
            </div>
            <div class="modal-body" id="debt_detail">
            </div>
        </div>
    </div>
</div>
<!-- End View Debt Modal -->

<!-- Add Debt Modal -->
<div id="add_debt_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Add New Debt</h4>
            </div>
            <div class="modal-body" id="debt_add">
                <form method="post" id="add_debt_form">
                    <label>
                        Name
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </div>
                        <input type="text" id="debt_add_company" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Pay Off
                    </label>
                    <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                            <span id="debt_add_calendar" class="glyphicon glyphicon-th"></span>
                        </div>
                        <input type="text" id="debt_add_due_date" class="form-control">
                    </div>
                    <br />
                    <label>
                        Amount
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-usd"></span>
                        </div>
                        <input type="text" id="debt_add_amount" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Notes
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-file"></span>
                        </div>
                        <input type="text" id="debt_add_notes" class="form-control" />
                    </div>
                    <br />
                    <label>
                        Paid
                    </label>
                    <div class="input-group">
                        <div class="btn-group" id="status" data-toggle="buttons">
                            <label class="btn btn-default btn-on btn-lg" id="add_debt_is_paid_yes_label">
                            <input type="radio" id="debt_add_is_paid_yes" value="1">Yes</label>
                            <label class="btn btn-default btn-off btn-lg active" id="add_debt_is_paid_no_label">
                            <input type="radio" id="debt_add_is_paid_no" value="0">No</label>
                        </div>
                    </div>
                    <br />
                    <button type="button" name="insert" id="insert_debt" class="btn btn-success">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Debt Modal -->

<!-- Edit Debt Modal -->
<div id="edit_debt_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Edit Debt</h4>
            </div>
            <div class="modal-body" id="debt_edit">
            </div>
        </div>
    </div>
</div>
<!-- End Edit Debt Modal -->

<!-- Pay Debt Modal -->
<div id="pay_debt_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title">Pay Debt</h4>
            </div>
            <div class="modal-body" id="debt_payment">
            </div>
        </div>
    </div>
</div>
<!-- End Pay Debt Modal -->

<!-- Payment Made Modal -->
<div id="debt_payment_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <h1 class="modal-title">
                    Payment Made!
                    <span class="glyphicon glyphicon-usd"></span>
                    <span class="glyphicon glyphicon-usd"></span>
                    <span class="glyphicon glyphicon-usd"></span>
                    <span class="glyphicon glyphicon-usd"></span>
                </h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Payment Made Modal -->

<!-- Debt Added Popup -->
<div id="debt_added" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Debt Added! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Debt Added Popup -->

<!-- Debt Removed Popup -->
<div id="debt_removed" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Debt Removed! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Debt Removed Popup -->

<!-- Debt Updated Popup -->
<div id="debt_updated" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Debt Updated! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Debt Updated Popup -->

<!-- View Debt Payment Popup -->
<div id="view_debt_payment_modal" class="modal fade">
    <div class="modal-dialog">
        <div id="view_debt_payment_content" class="modal-content confirmation">
        </div>
    </div>
</div>
<!-- End View Debt Payment Popup -->

<!-- Delete Confirmation Popup -->
<div id="debts_delete_confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Are You Sure You Want to Delete This? </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success yes_button glyphicon glyphicon-ok" id="debts_delete_confirmation_yes" value="1"></button>
                <button type="button" class="btn btn-danger no_button btn btn-danger glyphicon glyphicon-remove" id="debts_delete_confirmation_no" value="0"></button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Confirmation Popup -->

<!-- Close MySQL Connection -->
<?php mysqli_close($conn); ?>