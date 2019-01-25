<?php
/*
	This script updates debt payment data to the database from a form in debt.php
*/

	include 'db.php';

	if(isset($_POST['pay_debt_id'])){
        $output = '';
        $payment_debt_amount = $_POST["pay_debt_amount"];
        $payment_debt_id = $_POST["pay_debt_id"];

        $payment_select_query = "SELECT id, company, amount, due_date, is_paid FROM debt WHERE id = '$payment_debt_id' ; ";
        $payment_select_query_results = mysqli_query($conn, $payment_select_query);

        while($payment_select_query_row = mysqli_fetch_array($payment_select_query_results)) {
            $payment_new_balance = $payment_select_query_row["amount"] - $payment_debt_amount;

            if($payment_new_balance <= 0){
                $payment_is_paid = 1;
            }
            else{
                $payment_is_paid = $payment_select_query_row["is_paid"];
            }
        }
        $current_date = date("Y-m-d");
        $payment_update_debt_query = "UPDATE debt SET amount = '$payment_new_balance', is_paid = '$payment_is_paid' WHERE id = '$payment_debt_id'; ";
        $payment_insert_query = "INSERT INTO debt_payments (debt_id, amount, date_paid) VALUES ('$payment_debt_id', '$payment_debt_amount', '$current_date' ); ";
        
        if((mysqli_query($conn, $payment_update_debt_query)) && (mysqli_query($conn, $payment_insert_query))){
            $payment_update_debt_select_query = "SELECT id, company, amount, due_date, is_paid FROM debt ORDER BY id ASC;";
            $payment_update_debt_select_result = mysqli_query($conn, $payment_update_debt_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Debt</th>
                        <th>Amount</th>
                        <th>Pay Off</th>
                        <th>Paid</th>
                        <th></th>
                    </tr>';
                while($payment_update_debt_select_row = mysqli_fetch_array($payment_update_debt_select_result)) {
                    $output .= '
                    <tr id="'.$payment_update_debt_select_row["id"].'">
                        <td data-target="debt_list_company">
                            '.$payment_update_debt_select_row["company"].'
                        </td>
                        <td data-target="debt_list_amount">
                            '.$payment_update_debt_select_row["amount"].'
                        </td>
                        <td data-target="debt_list_due_date">
                            '.$payment_update_debt_select_row["due_date"].'
                        </td>';
                        if($payment_update_debt_select_row["is_paid"] == 0)
                        {
                            $output .= 
                            '<td data-target="debt_list_is_paid">
                                No
                            </td>';
                        }
                        else
                        {
                            $output .= 
                            '<td data-target="debt_list_is_paid" style="background-color: lightgreen;">
                                Yes
                            </td>';
                        }
                        $output .= '
                        <td>
                            <button data-id="'.$payment_update_debt_select_row["id"].'" class="menuButton view_debts_payments btn btn-primary">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button data-id="'.$payment_update_debt_select_row["id"].'" class="menuButton pay_debts btn btn-success">
                                <span class="glyphicon glyphicon-usd"></span>
                            </button>
                            <button data-id="'.$payment_update_debt_select_row["id"].'" class="menuButton view_debts btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$payment_update_debt_select_row["id"].'" class="menuButton edit_debts btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$payment_update_debt_select_row["id"].'" class="menuButton delete_debt btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </td>
                    </tr>';
                }
                $output .= '
                </table>';
        }

        echo $output;
    }
    mysqli_close($conn); 
?>
