<?php
/*
	This script returns the user info into a modal in index.php
*/

	include 'db.php';

	if(isset($_POST["emp_id"]))
	{
		$output = '';
		$idQuery = 'SELECT * FROM wp_users WHERE id = "'.$_POST["emp_id"].'"';
		$idResult = mysqli_query($conn, $idQuery);
		$output .= '
		<div class="table-responsive">
			<table class="table table-bordered">';
		while($row = mysqli_fetch_array($idResult))
		{
			$output .= '
				<tr>
					<td><label>ID</label></td>
					<td><label>'.$row["ID"].'</label></td>
				</tr>
				<tr>
					<td><label>Name</label></td>
					<td><label>'.$row["user_login"].'</label></td>
				</tr>
				<tr>
					<td><label>Email</label></td>
					<td><label>'.$row["user_email"].'</label></td>
				</tr>
			';
		}
		$output .= "</table></div>";
		echo $output;
	}
	mysqli_close($conn); 
?>