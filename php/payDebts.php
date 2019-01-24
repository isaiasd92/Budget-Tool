<?php
/*
	This script returns the bill info into a modal for loggin a payment in bills.php
*/

    include 'db.php';

    if(isset($_POST["pay_debt_id"]))
	{
		$output = '';
		$pay_debt_query = 'SELECT id, company, due_date, amount, is_paid, notes FROM debt WHERE id = "'.$_POST["pay_debt_id"].'"';
        $pay_debt_result = mysqli_query($conn, $pay_debt_query);

        while($pay_debt_row = mysqli_fetch_array($pay_debt_result))
		{
            $output .= '
            <form method="post" id="add_debt_form">
                <h1>
                    '.$pay_debt_row["company"].'
                </h1>
                <br />
                <label>
                    Amount
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-usd"></span>
                    </div>
                    <input type="text" id="pay_debt_amount" value="'.$pay_debt_row["amount"].'" class="form-control" />
                </div>
                <br>
                <label>
                    Debt ID
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-list-alt"></span>
                    </div>
                    <input type="text" disabled="disabled" id="pay_debt_id" value="'.$pay_debt_row["id"].'" class="form-control" />
                </div>
                <br />
                <button type="button" name="update" id="update_debt_payment" class="btn btn-success">Update</button>
            </form> ';
        }

		echo $output;
    }
    mysqli_close($conn); 
?>
