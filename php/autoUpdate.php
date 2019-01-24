<?php
/*
	This script duplicates the bills for each month automatically
*/

	include 'db.php';

    $output = '';
    $auto_billMonth = $_POST["billMonth"];
    $auto_update_select_query = "SELECT id, company, due_date, amount, notes, is_paid, duplicated FROM bills WHERE MONTH(due_date) = '$auto_billMonth'; ";
    $auto_bill_result = mysqli_query($conn, $auto_update_select_query);

    $auto_update_select_checker_query = "SELECT auto_update, send_emails, email_day FROM settings ;";
    $auto_checker_query_results = mysqli_query($conn, $auto_update_select_checker_query);

    while($auto_checker_row = mysqli_fetch_array($auto_checker_query_results))
    {
        if($auto_checker_row["auto_update"] == 1){
            while($auto_bill_row = mysqli_fetch_array($auto_bill_result))
            {
                $newID = $auto_bill_row['id'];
                $newCompany = $auto_bill_row['company'];
                $newMonth = new DateTime($auto_bill_row["due_date"]);
                $newMonth->modify('+1 month');
                $newDate = $newMonth->format('Y-m-d');
                $newAmount = $auto_bill_row['amount'];
                $newNotes = $auto_bill_row['notes'];

                if($auto_billMonth == $newMonth){
                    $auto_update_update_query = "UPDATE bills SET duplicated = 1 WHERE id = '$newID'; ";
                    mysqli_query($conn, $auto_update_update_query);
                }

                if($auto_bill_row["duplicated"] == 0){
                    $auto_insert_bills_query = "INSERT INTO bills (company, due_date, amount, notes, is_paid) VALUES ('$newCompany', '$newDate', $newAmount, '$newNotes', 0, 0); ";
                    mysqli_query($conn, $auto_insert_bills_query);
                }

                /* For Testing Purposes */
                //$output .= $auto_insert_bills_query;
                //$output .= $auto_update_update_query;
            }
        }
    }
    
    /* For Testing Purposes */
    //echo $output;
    
    mysqli_close($conn); 
?>
