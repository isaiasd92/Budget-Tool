<?php
/*
	This script removes debts from the database via debt.php
*/

    include 'db.php';

    if(isset($_POST["delete_debt_id"])){
        $output = '';
        $delete_debt_select_query = "SELECT id, company, amount, due_date, is_paid FROM debt ORDER BY id ASC;";
        $delete_debt_select_result = mysqli_query($conn, $delete_debt_select_query);
        $total_debt_rows = mysqli_num_rows($delete_debt_select_result);
          
        if($total_debt_rows > 0){
            $delete_debt_query = 'DELETE FROM debt WHERE id = "'.$_POST["delete_debt_id"].'";';
            mysqli_query($conn, $delete_debt_query);
        }

        $delete_debt_results = mysqli_query($conn, $delete_debt_select_query);

        $output .= '
            <table class="table table-bordered">
                <tr class="results" >
                    <th>Debt</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Paid</th>
                    <th></th>
                </tr>';
        while($delete_debt_select_rows = mysqli_fetch_array($delete_debt_results)) {
            $output .= '
            <tr id="'.$delete_debt_select_rows["id"].'">
                <td data-target="debt_list_company">
                    '.$delete_debt_select_rows["company"].'
                </td>
                <td data-target="debt_list_amount">
                    '.$delete_debt_select_rows["amount"].'
                </td>
                <td data-target="debt_list_due_date">
                    '.$delete_debt_select_rows["due_date"].'
                </td>';
                if($delete_debt_select_rows["is_paid"] == 0)
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
                    <button data-id="'.$delete_debt_select_rows["id"].'" class="menuButton pay_debts btn btn-success">
                        <span class="glyphicon glyphicon-usd"></span>
                    </button>
                    <button data-id="'.$delete_debt_select_rows["id"].'" class="menuButton view_debts btn btn-secondary">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </button>
                    <button data-id="'.$delete_debt_select_rows["id"].'" class="menuButton edit_debts btn btn-warning">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button data-id="'.$delete_debt_select_rows["id"].'" class="menuButton delete_debt btn btn-danger">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>';
        }
        $output .= '
            </table>';
        echo $output;
    }
    mysqli_close($conn); 
?>
