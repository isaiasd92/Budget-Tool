<?php
/*
	This script updates bill data to the database from a form in bills.php
*/

	include 'db.php';

	if(isset($_POST['update_bill_company'])){
        $output = '';
        $update_bill_company = $_POST["update_bill_company"];
        $update_bill_dueDate = $_POST["update_bill_due_date"];
        $update_bill_amount = $_POST["update_bill_amount"];
        $update_bill_notes = $_POST["update_bill_notes"];
        $update_bill_id = $_POST["update_bill_id"];
        $update_bill_is_paid = $_POST["update_bill_is_paid"];

        $update_bill_query = "UPDATE bills SET company = '$update_bill_company', due_date = '$update_bill_dueDate', amount = '$update_bill_amount', notes = '$update_bill_notes', is_paid = '$update_bill_is_paid' WHERE id = '$update_bill_id';";
        
        if(mysqli_query($conn, $update_bill_query)){
            $update_select_bill_query = "SELECT id, company, amount, due_date, is_paid FROM bills ORDER BY id DESC;";
            $update_select_bill_result = mysqli_query($conn, $update_select_bill_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Bill</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Paid</th>
                        <th></th>
                    </tr>';
                while($update_select_bill_row = mysqli_fetch_array($update_select_bill_result)) {
                    $output .= '
                    <tr id="'.$update_select_bill_row["id"].'">
                        <td data-target="bill_list_company">
                            '.$update_select_bill_row["company"].'
                        </td>
                        <td data-target="bill_list_amount">
                            '.$update_select_bill_row["amount"].'
                        </td>
                        <td data-target="bill_list_due_date">
                            '.$update_select_bill_row["due_date"].'
                        </td>';
                        if($update_select_bill_row["is_paid"] == 0)
                        {
                            $output .= 
                            '<td data-target="bill_list_is_paid">
                                No
                            </td>';
                        }
                        else
                        {
                            $output .= 
                            '<td data-target="bill_list_is_paid" style="background-color: lightgreen;">
                                Yes
                            </td>';
                        }
                        $output .= '
                        <td>
                            <button data-id="'.$update_select_bill_row["id"].'" class="menuButton view_bills btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$update_select_bill_row["id"].'" class="menuButton edit_bills btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$update_select_bill_row["id"].'" class="menuButton delete_bill btn btn-danger">
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