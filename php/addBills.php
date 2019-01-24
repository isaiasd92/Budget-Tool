<?php
/*
	This script adds bill data to the database from a form in bills.php
*/

	include 'db.php';

	if(isset($_POST['bill_add_company'])){
        $output = '';
        $add_bill_company = $_POST["bill_add_company"];
        $add_bill_dueDate = $_POST["bill_add_due_date"];
        $add_bill_amount = $_POST["bill_add_amount"];
        $add_bill_notes = $_POST["bill_add_notes"];
        $add_bill_is_paid = $_POST["bill_add_is_paid"];

        $add_bill_query = "INSERT INTO bills(company, due_date, amount, notes, is_paid) VALUES('$add_bill_company', '$add_bill_dueDate', '$add_bill_amount', '$add_bill_notes', '$add_bill_is_paid'); ";

        if(mysqli_query($conn, $add_bill_query)){
            $add_bill_select_query = "SELECT id, company, amount, due_date, is_paid FROM bills ORDER BY id ASC;";
            $add_bill_select_result = mysqli_query($conn, $add_bill_select_query);
            $output .= '
                <table class="table table-bordered">
                    <tr class="results" >
                        <th>Bill</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Paid</th>
                        <th></th>
                    </tr>';
                while($add_bill_select_row = mysqli_fetch_array($add_bill_select_result)) {
                    $output .= '
                    <tr id="'.$add_bill_select_row["id"].'">
                        <td data-target="bill_list_company">
                            '.$add_bill_select_row["company"].'
                        </td>
                        <td data-target="bill_list_amount">
                            '.$add_bill_select_row["amount"].'
                        </td>
                        <td data-target="bill_list_due_date">
                            '.$add_bill_select_row["due_date"].'
                        </td>';
                        if($add_bill_select_row["is_paid"] == 0)
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
                            <button data-id="'.$add_bill_select_row["id"].'" class="menuButton view_bills btn btn-secondary">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </button>
                            <button data-id="'.$add_bill_select_row["id"].'" class="menuButton edit_bills btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button data-id="'.$add_bill_select_row["id"].'" class="menuButton delete_bill btn btn-danger">
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