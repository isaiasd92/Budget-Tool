<?php
/*
	This script returns the debt payment info into a modal in debt.php
*/

    include 'db.php';
    
    $this_debt_payment_id = $_POST["view_payment_id"];

	if(isset($_POST["view_payment_id"]))
	{
        $output = '';
        $debt_payment_info_query = "SELECT id, company, due_date, amount, notes, is_paid FROM debt WHERE id = '$this_debt_payment_id'";
        $debt_payment_info_result = mysqli_query($conn, $debt_payment_info_query);

        while($debt_payment_info_row = mysqli_fetch_array($debt_payment_info_result))
		{
            $debt_payment_info_id = $debt_payment_info_row["id"];
            $debt_payment_query = "SELECT amount, date_paid FROM debt_payments WHERE debt_id = '$debt_payment_info_id';";
           
            $debt_payment_query_result = mysqli_query($conn, $debt_payment_query);
            $debt_payment_row_count = mysqli_num_rows($debt_payment_query_result);

            if($debt_payment_row_count > 0){
                $output .= '
                <div class="modal-header" style="text-align: center; font-size: 30px;">
                    <label>'.$debt_payment_info_row["company"].'</label>
                </div>
                <div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="payment-header-row">
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date Payment Made</th>
                                </tr>
                            </thead>
                            <tbody>';
                                while($debt_payment_query_row = mysqli_fetch_array($debt_payment_query_result))
                                {
                                $output .= '
                                <tr>
                                    <td><label>'.$debt_payment_query_row["amount"].'</label></td>
                                    <td><label>'.$debt_payment_query_row["date_paid"].'</label></td>
                                </tr>';
                                }
                                $output .= 
                            '</tbody>
                        </table>
                    </div>
                </div>';
            }
            else{
                    $output .= '
                <div class="modal-header" style="text-align: center; font-size: 30px;">
                    <label>'.$debt_payment_info_row["company"].'</label>
                </div>
                <div class="text-center">
                    <h1>
                        No Payments Made
                    </h1>
                </div>';
            }
                $output .= '
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" style="width: 100%; opacity: 1">
                        <span class="btn btn-success glyphicon glyphicon-ok" style="width: 150px"></span>
                    </button>
                </div>';
        }
        echo $output;
	}
	mysqli_close($conn); 
?>