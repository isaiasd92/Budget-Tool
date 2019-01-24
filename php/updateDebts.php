<?php
/*
	This script updates debt data to the database from a form in debt.php
*/

	include 'db.php';

	if(isset($_POST['update_debt_company'])){
        $output = '';
        $update_debt_company = $_POST["update_debt_company"];
        $update_debt_dueDate = $_POST["update_debt_due_date"];
        $update_debt_amount = $_POST["update_debt_amount"];
        $update_debt_notes = $_POST["update_debt_notes"];
        $update_debt_is_paid = $_POST["update_debt_is_paid"];
        $update_debt_id = $_POST["update_debt_id"];

        $update_debt_query = "UPDATE debt SET company = '$update_debt_company', due_date = '$update_debt_dueDate', amount = '$update_debt_amount', notes = '$update_debt_notes', is_paid = '$update_debt_is_paid' WHERE id = '$update_debt_id';";
        
        if(mysqli_query($conn, $update_debt_query)){
            $update_debt_select_query = "SELECT id, company, amount, due_date, is_paid FROM debt ORDER BY id ASC;";
            $update_debt_select_result = mysqli_query($conn, $update_debt_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Debt</th>
                        <th>Amount</th>
                        <th>Pay Off</th>
                        <th>Paid</th>
                        <th></th>
                    </tr>';
                while($update_debt_select_row = mysqli_fetch_array($update_debt_select_result)) {
                    $output .= '
                    <tr id="'.$update_debt_select_row["id"].'">
                        <td data-target="debt_list_company">
                            '.$update_debt_select_row["company"].'
                        </td>
                        <td data-target="debt_list_amount">
                            '.$update_debt_select_row["amount"].'
                        </td>
                        <td data-target="debt_list_due_date">
                            '.$update_debt_select_row["due_date"].'
                        </td>';
                        if($update_debt_select_row["is_paid"] == 0)
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
                            <button data-id="'.$update_debt_select_row["id"].'" class="menuButton view_debts_payments btn btn-primary">
                                <span class="glyphicon glyphicon-list-alt"></span>
                            </button>
                            <button data-id="'.$update_debt_select_row["id"].'" class="menuButton pay_debts btn btn-success">
                                <span class="glyphicon glyphicon-usd"></span>
                            </button>
                            <button data-id="'.$update_debt_select_row["id"].'" class="menuButton view_debts btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$update_debt_select_row["id"].'" class="menuButton edit_debts btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$update_debt_select_row["id"].'" class="menuButton delete_debt btn btn-danger">
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
