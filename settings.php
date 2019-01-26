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
            Settings
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
                <span class="menu-icon glyphicon glyphicon-cog"></span>
                Settings
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

        <!-- Settings -->
        <div id="settings-container" class="row text-center">
            
            <?php
                $settings_query = "SELECT auto_update, send_emails, email_day FROM settings ;";
                $settings_query_results = mysqli_query($conn, $settings_query);
            ?>

            <?php
                while($settings_query_row = mysqli_fetch_array($settings_query_results))
                {
            ?>

            <!-- Auto Update -->
            <h1 class="settings-option">
                Update Bills and Income Records Automatically
            </h1>
            <div class="wrapper text-center">
                <div class="btn-group" id="settings-auto-update" data-toggle="buttons">
                        
                <?php
                    if($settings_query_row["auto_update"] == 1)
                    {
                ?>        
                    <label class="btn btn-default btn-on btn-lg active" id="edit_auto_update_yes_label">
                    <input type="radio" id="edit_auto_update_yes" value="1" checked>Yes</label>
                    <label class="btn btn-default btn-off btn-lg" id="edit_auto_update_no_label">
                    <input type="radio" id="edit_auto_update_no" value="0">No</label>
                <?php
                    }
                    elseif($settings_query_row["auto_update"] == 0)
                    {
                ?>
                    <label class="btn btn-default btn-on btn-lg" id="edit_auto_update_yes_label">
                    <input type="radio" id="edit_auto_update_yes" value="1">Yes</label>
                    <label class="btn btn-default btn-off btn-lg active" id="edit_auto_update_no_label">
                    <input type="radio" id="edit_auto_update_no" value="0" checked>No</label>
                <?php
                    }
                ?>
                </div>
            </div>
            <!-- End Auto Update -->

            <!-- Send Emails -->
            <h1 class="settings-option">
                Send Emails Automatically
            </h1>
            <div class="wrapper text-center">
                <div class="btn-group" id="settings_send_emails" data-toggle="buttons">
                        
                <?php
                    if($settings_query_row["send_emails"] == 1)
                    {
                ?>        
                    <label class="btn btn-default btn-on btn-lg active" id="edit_send_emails_yes_label">
                    <input type="radio" id="edit_send_emails_yes" value="1" checked>Yes</label>
                    <label class="btn btn-default btn-off btn-lg" id="edit_send_emails_no_label">
                    <input type="radio" id="edit_send_emails_no" value="0">No</label>
                <?php
                    }
                    elseif($settings_query_row["send_emails"] == 0)
                    {
                ?>
                    <label class="btn btn-default btn-on btn-lg" id="edit_send_emails_yes_label">
                    <input type="radio" id="edit_send_emails_yes" value="1">Yes</label>
                    <label class="btn btn-default btn-off btn-lg active" id="edit_send_emails_no_label">
                    <input type="radio" id="edit_send_emails_no" value="0" checked>No</label>
                <?php
                    }
                ?>
                </div>
            </div>
            <!-- End Send Emails -->

            <!-- Email Day -->
            <div id="settings-day-container">
                <label>
                    <h1>
                        Send Email On Which Day
                    </h1>
                </label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                    <input type="text" id="settings_day" value="<?php echo $settings_query_row["email_day"] ?>" class="form-control" />
                </div>
            </div>
            <!-- End Email Day -->
            <?php
                }
            ?>

            <!-- Save Settings -->
            <div class="row">
                <button type="button" name="update" id="update_settings" class="btn btn-success">
                    Update
                </button>
            </div>
            <!-- End Save Settings -->

        </div>
        <!-- End Settings -->
    </body>
</html>

<!-- Settings Updated Popup -->
<div id="settings_updated" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Settings Updated! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Settings Updated Popup -->

<!-- Invalid Date Popup -->
<div id="invalid_date" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content confirmation">
            <div class="modal-header" style="text-align: center; font-size: 30px;">
                <label> Invalid Date! </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                    <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Invalid Date Popup -->

<!-- Close MySQL Connection -->
<?php mysqli_close($conn); ?>