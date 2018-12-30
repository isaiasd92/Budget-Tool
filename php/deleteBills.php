<?php
/*
	This script removes bills from the database via bills.php
*/

    include 'db.php';

    if(isset($_POST["delete_bill_id"])){
        $output = '';
        $delete_bill_select_query = "SELECT id, company, amount, due_date, is_paid FROM bills ORDER BY id DESC;";
        $delete_bill_select_result = mysqli_query($conn, $delete_bill_select_query);
        $total_bill_rows = mysqli_num_rows($delete_bill_select_result);
          
        if($total_bill_rows > 0){
            $delete_bill_query = 'DELETE FROM bills WHERE id = "'.$_POST["delete_bill_id"].'";';
            mysqli_query($conn, $delete_bill_query);
        }

        $delete_bill_results = mysqli_query($conn, $delete_bill_select_query);

        $output .= '
            <table class="table table-bordered">
                <tr class="results" >
                    <th>Bill</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Paid</th>
                    <th></th>
                </tr>';
        while($delete_bill_select_rows = mysqli_fetch_array($delete_bill_results)) {
            $output .= '
                <tr id="'.$delete_bill_select_rows["id"].'">
                    <td data-target="bill_list_company">
                        '.$delete_bill_select_rows["company"].'
                    </td>
                    <td data-target="bill_list_amount">
                        '.$delete_bill_select_rows["amount"].'
                    </td>
                    <td data-target="bill_list_due_date">
                        '.$delete_bill_select_rows["due_date"].'
                    </td>';
                    if($delete_bill_select_rows["is_paid"] == 0)
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
                        <button data-id="'.$delete_bill_select_rows["id"].'" class="menuButton view_bills btn btn-secondary">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </button>
                        <button data-id="'.$delete_bill_select_rows["id"].'" class="menuButton edit_bills btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button data-id="'.$delete_bill_select_rows["id"].'" class="menuButton delete_bill btn btn-danger">
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