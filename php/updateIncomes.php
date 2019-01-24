<?php
/*
	This script updates income data to the database from a form in income.php
*/

	include 'db.php';

	if(isset($_POST['update_income_name'])){
        $output = '';
        $update_income_name = $_POST["update_income_name"];
        $update_income_payDate = $_POST["update_income_pay_date"];
        $update_income_amount = $_POST["update_income_amount"];
        $update_income_id = $_POST["update_income_id"];

        $update_income_query = "UPDATE income SET name = '$update_income_name', pay_date = '$update_income_payDate', amount = '$update_income_amount' WHERE id = '$update_income_id';";
        
        if(mysqli_query($conn, $update_income_query)){
            $update_income_select_query = "SELECT id, name, amount, pay_date FROM income ORDER BY id ASC;";
            $update_income_select_result = mysqli_query($conn, $update_income_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Bill</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th></th>
                    </tr>';
                while($update_income_select_row = mysqli_fetch_array($update_income_select_result)) {
                    $output .= '
                    <tr id="'.$update_income_select_row["id"].'">
                        <td data-target="income_list_name">
                            '.$update_income_select_row["name"].'
                        </td>
                        <td data-target="income_list_amount">
                            '.$update_income_select_row["amount"].'
                        </td>
                        <td data-target="income_list_pay_date">
                            '.$update_income_select_row["pay_date"].'
                        </td>
                        <td>
                            <button data-id="'.$update_income_select_row["id"].'" class="menuButton view_incomes btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$update_income_select_row["id"].'" class="menuButton edit_incomes btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$update_income_select_row["id"].'" class="menuButton delete_income btn btn-danger">
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
