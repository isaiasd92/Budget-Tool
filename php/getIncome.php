<?php
/*
	This script returns the bill info into a modal in bills.php
*/

	include 'db.php';

	if(isset($_POST["income_id"]))
	{
		$output = '';
		$view_income_query = 'SELECT id, name, pay_date, amount FROM income WHERE id = "'.$_POST["income_id"].'"';
		$view_income_result = mysqli_query($conn, $view_income_query);
		$output .= '
		<div class="table-responsive">
			<table class="table table-bordered">';
		while($view_income_row = mysqli_fetch_array($view_income_result))
		{
			$output .= '
				<tr>
					<td class="results" ><label>Name</label></td>
					<td><label>'.$view_income_row["name"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Pay Date</label></td>
					<td><label>'.date("m/d/Y", strtotime($view_income_row["pay_date"])).'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>Amount</label></td>
					<td><label>'.$view_income_row["amount"].'</label></td>
				</tr>
				<tr>
					<td class="results" ><label>ID</label></td>
					<td><label>'.$view_income_row["id"].'</label></td>
				</tr>
			';
		}
		$output .= '</table></div>';
		echo $output;
	}
?>