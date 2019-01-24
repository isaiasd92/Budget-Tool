<?php
/*
	This script updates settings data to the database from a form in settings.php
*/

	include 'db.php';

    $output = '';
    $update_settings_auto_update = $_POST["settings_auto_update"];
    $update_settings_send_emails  = $_POST["settings_send_emails"];
    $update_settings_day = $_POST["settings_day"];

    $update_settings_query = "UPDATE settings SET auto_update = '$update_settings_auto_update', send_emails = '$update_settings_send_emails', email_day = '$update_settings_day' WHERE 1 ; ";
    
    if(mysqli_query($conn, $update_settings_query)){
        $update_settings_query_select = "SELECT auto_update, send_emails, email_day FROM settings ;";
        $update_settings_query_results_select = mysqli_query($conn, $update_settings_query_select);

        $output .= '
        <h1 class="settings-option">
            Update Bills and Income Records Automatically
        </h1>';
        
        while($update_settings_query_row_select = mysqli_fetch_array($update_settings_query_results_select)){
                    $output .= '
            <div class="wrapper text-center">
                <div class="btn-group" id="settings-auto-update" data-toggle="buttons">';
                        
                if($update_settings_query_row_select["auto_update"] == 1){

                    $output .= '
                    <label class="btn btn-default btn-on btn-lg active" id="edit_auto_update_yes_label">
                    <input type="radio" id="edit_auto_update_yes" value="1" checked>Yes</label>
                    <label class="btn btn-default btn-off btn-lg" id="edit_auto_update_no_label">
                    <input type="radio" id="edit_auto_update_no" value="0">No</label>';

                }
                else{

                    $output .= '
                    <label class="btn btn-default btn-on btn-lg" id="edit_auto_update_yes_label">
                    <input type="radio" id="edit_auto_update_yes" value="1">Yes</label>
                    <label class="btn btn-default btn-off btn-lg active" id="edit_auto_update_no_label">
                    <input type="radio" id="edit_auto_update_no" value="0" checked>No</label>';

                }
                    $output .= '
                </div>
            </div>';

            $output .= '
            <h1 class="settings-option">
                Send Emails Automatically
            </h1>
            <div class="wrapper text-center">
                <div class="btn-group" id="settings_send_emails" data-toggle="buttons">';
                        
                if($update_settings_query_row_select["send_emails"] == 1){
                    $output .= '
                    <label class="btn btn-default btn-on btn-lg active" id="edit_send_emails_yes_label">
                    <input type="radio" id="edit_send_emails_yes" value="1" checked>Yes</label>
                    <label class="btn btn-default btn-off btn-lg" id="edit_send_emails_no_label">
                    <input type="radio" id="edit_send_emails_no" value="0">No</label>';
                }
                else{
                    $output .= '
                    <label class="btn btn-default btn-on btn-lg" id="edit_send_emails_yes_label">
                    <input type="radio" id="edit_send_emails_yes" value="1">Yes</label>
                    <label class="btn btn-default btn-off btn-lg active" id="edit_send_emails_no_label">
                    <input type="radio" id="edit_send_emails_no" value="0" checked>No</label>';
                }
                    $output .= '
                </div>
            </div>

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
                    <input type="text" id="settings_day" value="'.$update_settings_query_row_select["email_day"].'" class="form-control" />
                </div>
            </div>

            <div class="row">
                <button type="button" name="update" id="update_settings" class="btn btn-success">
                    Update
                </button>
            </div>';
        }

        echo $output;
    }
    mysqli_close($conn); 
?>
