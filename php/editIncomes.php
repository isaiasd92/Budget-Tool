<?php
/*
	This script returns the bill info into a modal for editing in bills.php
*/

    include 'db.php';

    if(isset($_POST["edit_income_id"]))
	{
		$output = '';
		$edit_incomeQuery = 'SELECT id, name, pay_date, amount FROM income WHERE id = "'.$_POST["edit_income_id"].'"';
        $edit_incomeResult = mysqli_query($conn, $edit_incomeQuery);

        while($edit_incomeRow = mysqli_fetch_array($edit_incomeResult))
		{
            $output .= '
            <form method="post" id="edit_income_form">
                <label>
                    Name
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <input type="text" id="edit_income_name" value="'.$edit_incomeRow["name"].'" class="form-control" />
                </div>
                <br />
                <label>
                    Pay Date
                </label>
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                    <input type="text" id="edit_income_pay_date" value="'.$edit_incomeRow["pay_date"].'" class="form-control">
                </div>
                <br />
                <label>
                    Amount
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </div>
                    <input type="text" id="edit_income_amount" value="'.$edit_incomeRow["amount"].'" class="form-control" />
                </div>
                <br />
                <label>
                    ID
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-list-alt"></span>
                    </div>
                    <input type="text" disabled="disabled" id="edit_income_id" value="'.$edit_incomeRow["id"].'" class="form-control" />
                </div>
                <br />
                <div class="input-group">
                    <button type="button" name="update" id="update_income" class="btn btn-success">Update</button>
                </div>
            </form> ';
        }

		echo $output;
	}
?>
