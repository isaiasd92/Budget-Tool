<?php
/*
	This script removes incomes from the database via income.php
*/

    include 'db.php';

    if(isset($_POST["delete_income_id"])){
        $output = '';
        $delete_income_select_query = "SELECT id, name, pay_date, amount FROM income ORDER BY id DESC";
        $delete_income_select_result = mysqli_query($conn, $delete_income_select_query);
        $total_income_rows = mysqli_num_rows($delete_income_select_result);
          
        if($total_income_rows > 0){
            $delete_income_query = 'DELETE FROM income WHERE id = "'.$_POST["delete_income_id"].'";';
            mysqli_query($conn, $delete_income_query);
        }

        $delete_income_results = mysqli_query($conn, $delete_income_select_query);

        $output .= '
            <table class="table table-bordered">
                <tr class="results" >
                    <th>Paycheck</th>
                    <th>Amount</th>
                    <th>Pay Date</th>
                    <th></th>
                </tr>';
        while($delete_income_select_rows = mysqli_fetch_array($delete_income_results)) {
            $output .= '
            <tr id="'.$delete_income_select_rows["id"].'">
                <td data-target="income_list_name">
                    '.$delete_income_select_rows["name"].'
                </td>
                <td data-target="income_list_amount">
                    '.$delete_income_select_rows["amount"].'
                </td>
                <td data-target="income_list_pay_date">
                    '.$delete_income_select_rows["pay_date"].'
                </td>
                <td>
                    <button data-id="'.$delete_income_select_rows["id"].'" class="menuButton view_bills btn btn-secondary">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </button>
                    <button data-id="'.$delete_income_select_rows["id"].'" class="menuButton edit_bills btn btn-warning">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button data-id="'.$delete_income_select_rows["id"].'" class="menuButton delete_bill btn btn-danger">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>';
        }
        $output .= '
            </table>';
        echo $output;
    }
?>