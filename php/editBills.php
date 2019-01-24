<?php
/*
	This script returns the bill info into a modal for editing in bills.php
*/

    include 'db.php';

    if(isset($_POST["edit_bill_id"]))
	{
		$output = '';
		$edit_bill_query = 'SELECT id, company, due_date, amount, notes, is_paid FROM bills WHERE id = "'.$_POST["edit_bill_id"].'"';
        $edit_bill_result = mysqli_query($conn, $edit_bill_query);

        while($edit_bill_row = mysqli_fetch_array($edit_bill_result))
		{
            $output .= '
            <form method="post" id="edit_bill_form">
                <label>
                    Name
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <input type="text" id="edit_bill_company" value="'.$edit_bill_row["company"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Due Date
                </label>
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                    <input type="text" id="edit_bill_due_date" value="'.$edit_bill_row["due_date"].'" class="form-control">
                </div>
                <br />
                <label>
                    Amount
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </div>
                    <input type="text" id="edit_bill_amount" value="'.$edit_bill_row["amount"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Notes
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-file"></span>
                    </div>
                    <input type="text" id="edit_bill_notes" value="'.$edit_bill_row["notes"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Paid
                </label>
                <div class="input-group">
                    <div class="btn-group" id="status" data-toggle="buttons">';
                        
                if($edit_bill_row["is_paid"] == 1)
                {
                    $output .= '
                        <label class="btn btn-default btn-on btn-lg active">
                        <input type="radio" id="edit_bill_is_paid_yes" value="1" checked>Yes</label>
                        <label class="btn btn-default btn-off btn-lg" id="edit_bill_is_paid_no_label">
                        <input type="radio" id="edit_bill_is_paid_no" value="0">No</label>';
                }
                elseif($edit_bill_row["is_paid"] == 0)
                {
                    $output .= '
                        <label class="btn btn-default btn-on btn-lg" id="edit_bill_is_paid_yes_label">
                        <input type="radio" id="edit_bill_is_paid_yes" value="1">Yes</label>
                        <label class="btn btn-default btn-off btn-lg active" id="edit_bill_is_paid_no_label">
                        <input type="radio" id="edit_bill_is_paid_no" value="0" checked>No</label>';
                }
                $output .= '
                    </div>
                </div>
                <br />
                <label>
                    ID
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-list-alt"></span>
                    </div>
                    <input type="text" disabled="disabled" id="edit_bill_id" value="'.$edit_bill_row["id"].'" class="form-control" />
                </div>
                <br />
                <div class="input-group">
                    <button type="button" name="update" id="update_bill" class="btn btn-success">Update</button>
                </div>
            </form> ';
        }

		echo $output;
    }
    mysqli_close($conn); 
?>