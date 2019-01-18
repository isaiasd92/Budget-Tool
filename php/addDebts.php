<?php
/*
	This script adds debt data to the database from a form in debt.php
*/

	include 'db.php';

	if(isset($_POST['debt_add_company'])){
        $output = '';
        $add_debt_company = $_POST["debt_add_company"];
        $add_debt_dueDate = $_POST["debt_add_due_date"];
        $add_debt_amount = $_POST["debt_add_amount"];
        $add_debt_notes = $_POST["debt_add_notes"];
        $add_debt_is_paid = $_POST["debt_add_is_paid"];

        $add_debt_query = "INSERT INTO debt(company, due_date, amount, notes, is_paid) VALUES('$add_debt_company', '$add_debt_dueDate', '$add_debt_amount', '$add_debt_notes', '$add_debt_is_paid'); ";

        if(mysqli_query($conn, $add_debt_query)){
            $add_debt_select_query = "SELECT id, company, amount, due_date, is_paid FROM debt ORDER BY id ASC;";
            $add_debt_select_result = mysqli_query($conn, $add_debt_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Debt</th>
                        <th>Amount</th>
                        <th>Pay Off</th>
                        <th>Paid</th>
                        <th></th>
                    </tr>';
                while($add_debt_select_row = mysqli_fetch_array($add_debt_select_result)) {
                    $output .= '
                    <tr id="'.$add_debt_select_row["id"].'">
                        <td data-target="debt_list_company">
                            '.$add_debt_select_row["company"].'
                        </td>
                        <td data-target="debt_list_amount">
                            '.$add_debt_select_row["amount"].'
                        </td>
                        <td data-target="debt_list_due_date">
                            '.$add_debt_select_row["due_date"].'
                        </td>';
                        if($add_debt_select_row["is_paid"] == 0)
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
                            <button data-id="'.$add_debt_select_row["id"].'" class="menuButton view_debts btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$add_debt_select_row["id"].'" class="menuButton edit_debts btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$add_debt_select_row["id"].'" class="menuButton delete_debt btn btn-danger">
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
?>
