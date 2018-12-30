<?php
/*
	This script returns the bill info into a modal for editing in bills.php
*/

    include 'db.php';

    if(isset($_POST["edit_debt_id"]))
	{
		$output = '';
		$edit_debt_query = 'SELECT id, company, due_date, amount, is_paid, notes FROM debt WHERE id = "'.$_POST["edit_debt_id"].'"';
        $edit_debt_result = mysqli_query($conn, $edit_debt_query);

        while($edit_debt_row = mysqli_fetch_array($edit_debt_result))
		{
            $output .= '
            <form method="post" id="add_debt_form">
                <label>
                    Name
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <input type="text" id="edit_debt_company" value="'.$edit_debt_row["company"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Due Date
                </label>
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span id="debt_add_calendar" class="glyphicon glyphicon-th"></span>
                    </div>
                    <input type="text" id="edit_debt_due_date" value="'.$edit_debt_row["due_date"].'" class="form-control">
                </div>
                <br />
                <label>
                    Amount
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </div>
                    <input type="text" id="edit_debt_amount" value="'.$edit_debt_row["amount"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Notes
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-file"></span>
                    </div>
                    <input type="text" id="edit_debt_notes" value="'.$edit_debt_row["notes"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Paid
                </label>
                <div class="input-group">
                    <div class="btn-group" id="status" data-toggle="buttons">';
                        
                if($edit_debt_row["is_paid"] == 1)
                {
                    $output .= '
                        <label class="btn btn-default btn-on btn-lg active">
                        <input type="radio" id="edit_debt_is_paid_yes" value="1" checked>Yes</label>
                        <label class="btn btn-default btn-off btn-lg" id="edit_debt_is_paid_no_label">
                        <input type="radio" id="edit_debt_is_paid_no" value="0">No</label>';
                }
                elseif($edit_debt_row["is_paid"] == 0)
                {
                    $output .= '
                        <label class="btn btn-default btn-on btn-lg" id="edit_debt_is_paid_yes_label">
                        <input type="radio" id="edit_debt_is_paid_yes" value="1">Yes</label>
                        <label class="btn btn-default btn-off btn-lg active" id="edit_debt_is_paid_no_label">
                        <input type="radio" id="edit_debt_is_paid_no" value="0" checked>No</label>';
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
                    <input type="text" disabled="disabled" id="edit_debt_id" value="'.$edit_debt_row["id"].'" class="form-control" />
                </div>
                <br />
                <button type="button" name="insert" id="update_debt" class="btn btn-success">insert</button>
            </form> ';
        }

		echo $output;
	}
?>
