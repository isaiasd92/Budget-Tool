<?php
/*
	This script gets the budget info and outputs the data in index.php
*/

	include 'db.php';

	if(isset($_POST['from_date'])){
        $output = '';
        $budget_from_date = $_POST["from_date"];
        $budget_through_date = $_POST["through_date"];

        $get_budget_bill_date_range = "SELECT SUM(amount) AS bill_amount_sum FROM bills WHERE due_date BETWEEN '$budget_from_date' AND '$budget_through_date';";
        $get_budget_income_date_range = "SELECT SUM(amount) AS income_amount_sum FROM income WHERE pay_date BETWEEN '$budget_from_date' AND '$budget_through_date';";
        
        $budget_bill_result = mysqli_query($conn, $get_budget_bill_date_range);
        $budget_income_result = mysqli_query($conn, $get_budget_income_date_range);
        
        while($budget_bill_row = mysqli_fetch_array($budget_bill_result))
        {
            $budget_bill_total = $budget_bill_row["bill_amount_sum"];
        }
        while($budget_income_row = mysqli_fetch_array($budget_income_result))
        {
            $budget_income_total = $budget_income_row["income_amount_sum"];
        }

        $budget_balance = $budget_income_total - $budget_bill_total;

        $output .= '
        <tr class="alert-danger">
            <td class="budget_column">
                <h1>Total Due</h1>
            </td>
            <td class="budget_column_amount">
                <h1><b>$ '.$budget_bill_total.'</b></h1>
            </td>
        </tr>
        <tr class="alert-success">
            <td class="budget_column">
                <h1>Total Income</h1>
            </td>
            <td class="budget_column_amount">
                <h1><b>$ '.$budget_income_total.'</b></h1>
            </td>
        </tr>
        <tr class="alert-info">
            <td class="budget_column">
                <h1>Balance</h1>
            </td>
            <td class="budget_column_amount">
                <h1><b>$ '.$budget_balance.'</b></h1>
            </td>
        </tr>
        ';

        echo $output;
    }
?>