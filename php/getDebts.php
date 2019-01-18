<?php
/*
	This script returns the debt info into a modal in debt.php
*/

	include 'db.php';

	if(isset($_POST["debt_id"]))
	{
		$output = '';
		$debt_query = 'SELECT id, company, due_date, amount, notes, is_paid FROM debt WHERE id = "'.$_POST["debt_id"].'"';
		$debt_result = mysqli_query($conn, $debt_query);
		$output .= '
		<div class="table-responsive">
			<table class="table table-bordered">';
		while($debt_row = mysqli_fetch_array($debt_result))
		{
			$output .= '
				<tr>
					<td class="results" ><label>Company</label></td>
					<td><label>'.$debt_row["company"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Pay Off</label></td>
					<td><label>'.date("m/d/Y", strtotime($debt_row["due_date"])).'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Amount</label></td>
					<td><label>'.$debt_row["amount"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Notes</label></td>
					<td><label>'.$debt_row["notes"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Paid</label></td>';
				
				if($debt_row["is_paid"] == 0)
					$output .= '<td><label> No </label></td>';
				else
					$output .= '<td><label> Yes </label></td>';

				$output .= 
				'</tr>
				<tr>
					<td class="results" ><label>ID</label></td>
					<td><label>'.$debt_row["id"].'</label></td>
				</tr>
			';
		}
		$output .= '</table></div>';
		echo $output;
	}
?>

