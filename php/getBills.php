<?php
/*
	This script returns the bill info into a modal in bills.php
*/

	include 'db.php';

	if(isset($_POST["bill_id"]))
	{
		$output = '';
		$bill_query = 'SELECT id, company, due_date, amount, notes, is_paid FROM bills WHERE id = "'.$_POST["bill_id"].'"';
		$bill_result = mysqli_query($conn, $bill_query);
		$output .= '
		<div class="table-responsive">
			<table class="table table-bordered">';
		while($bill_row = mysqli_fetch_array($bill_result))
		{
			$output .= '
				<tr>
					<td class="results" ><label>Company</label></td>
					<td><label>'.$bill_row["company"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Due Date</label></td>
					<td><label>'.date("m/d/Y", strtotime($bill_row["due_date"])).'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Amount</label></td>
					<td><label>'.$bill_row["amount"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Notes</label></td>
					<td><label>'.$bill_row["notes"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Paid</label></td>';
				
				if($bill_row["is_paid"] == 0)
					$output .= '<td><label> No </label></td>';
				else
					$output .= '<td><label> Yes </label></td>';

				$output .= 
				'</tr>
				<tr>
					<td class="results" ><label>ID</label></td>
					<td><label>'.$bill_row["id"].'</label></td>
				</tr>
			';
		}
		$output .= '</table></div>';
		echo $output;
	}
	mysqli_close($conn); 
?>
