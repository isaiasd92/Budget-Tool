<?php
/*
	This script adds income data to the database from a form in income.php
*/

	include 'db.php';

	if(isset($_POST['income_add_name'])){
        $output = '';
        $add_income_name = $_POST["income_add_name"];
        $add_income_payDate = $_POST["income_add_pay_date"];
        $add_income_amount = $_POST["income_add_amount"];

        $add_income_query = "INSERT INTO income(name, pay_date, amount) VALUES('$add_income_name', '$add_income_payDate', '$add_income_amount'); ";

        if(mysqli_query($conn, $add_income_query)){
            $add_income_select_query = "SELECT id, name, amount, pay_date FROM income ORDER BY id ASC;";
            $add_income_select_result = mysqli_query($conn, $add_income_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Pay Date</th>
                        <th></th>
                    </tr>';
                while($add_income_select_row = mysqli_fetch_array($add_income_select_result)) {
                    $output .= '
                    <tr id="'.$add_income_select_row["id"].'">
                        <td data-target="income_list_name">
                            '.$add_income_select_row["name"].'
                        </td>
                        <td data-target="income_list_amount">
                            '.$add_income_select_row["amount"].'
                        </td>
                        <td data-target="income_list_pay_date">
                            '.$add_income_select_row["pay_date"].'
                        </td>
                        <td>
                            <button data-id="'.$add_income_select_row["id"].'" class="menuButton view_incomes btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$add_income_select_row["id"].'" class="menuButton edit_incomes btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$add_income_select_row["id"].'" class="menuButton delete_income btn btn-danger">
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