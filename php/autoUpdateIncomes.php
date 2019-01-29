<?php
/*
	This script duplicates the incomes for each month automatically
*/

	include 'db.php';

    $output = '';
    $auto_incomeMonth = $_POST["incomeMonth"];
    $auto_update_incomes_select_query = "SELECT id, name, pay_date, amount, duplicated FROM income WHERE MONTH(pay_date) = '$auto_incomeMonth'; ";
    $auto_incomes_result = mysqli_query($conn, $auto_update_incomes_select_query);

    $auto_update_select_checker_query = "SELECT auto_update, send_emails, email_day FROM settings ;";
    $auto_income_checker_query_results = mysqli_query($conn, $auto_update_select_checker_query);

    while($auto_income_checker_row = mysqli_fetch_array($auto_income_checker_query_results))
    {
        if($auto_income_checker_row["auto_update"] == 1){
            while($auto_incomes_row = mysqli_fetch_array($auto_incomes_result))
            {
                $newID_income = $auto_incomes_row['id'];
                $newCompany = $auto_incomes_row['company'];
                $newincomeMonth = new DateTime($auto_incomes_row["due_date"]);
                $newincomeMonth->modify('+30 days');
                $newDate = $newincomeMonth->format('Y-m-d');
                $newAmount = $auto_incomes_row['amount'];
                $newNotes = $auto_incomes_row['notes'];

                if($auto_incomeMonth == $newincomeMonth){
                    $auto_income_update_update_query = "UPDATE bills SET duplicated = 1 WHERE id = '$newID_income'; ";
                    mysqli_query($conn, $auto_income_update_update_query);
                }

                if($auto_incomes_row["duplicated"] == 0){
                    $auto_insert_incomes_query = "INSERT INTO bills (company, due_date, amount, notes, is_paid) VALUES ('$newCompany', '$newDate', $newAmount, '$newNotes', 0, 0); ";
                    mysqli_query($conn, $auto_insert_incomes_query);
                }
            }
        }
    }
    
    mysqli_close($conn); 
?>
