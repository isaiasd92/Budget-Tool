<?php
    include 'db.php';
    
    $thisEmailMonthName = $_POST["thisMonth"];
    $thisEmailMonthhNum = $_POST["currMonth"];
    $thisEmailYearNum = $_POST["currYear"];

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/Exception.php';
    require 'phpmailer/SMTP.php';

    $email_bills = "SELECT * FROM bills WHERE MONTH(due_date) = ".$thisEmailMonthhNum." AND YEAR(due_date) = ".$thisEmailYearNum."; ";
    $email_bills_query = mysqli_query($conn, $email_bills);
    $email_bills_summary_query = mysqli_query($conn, $email_bills);

    $email_income = "SELECT * FROM income WHERE MONTH(pay_date) = ".$thisEmailMonthhNum." AND YEAR(pay_date) = ".$thisEmailYearNum."; ";
    $email_income_query = mysqli_query($conn, $email_income);
    $email_income_summary_query = mysqli_query($conn, $email_income);

    $email_debt = "SELECT * FROM debt; ";
    $email_debt_query = mysqli_query($conn, $email_debt);

    while($email_bills_query_summary_row = mysqli_fetch_array($email_bills_summary_query)){
        $bill_summary_total += $email_bills_query_summary_row["amount"];
    }

    while($email_income_query_summary_row = mysqli_fetch_array($email_income_summary_query)){
        $income_summary_total += $email_income_query_summary_row["amount"];
    }

    $email_summary_leftOvers = $income_summary_total - $bill_summary_total;

    $mail = new PHPMailer();                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'isaandvalbudgettool@gmail.com';    // SMTP username
        $mail->Password = 'C@nela2018';                       // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom('isaandvalbudgettool@gmail.com', 'Isa and Val Budget Tool');
        $mail->addAddress('isaiasdelgado03@gmail.com', 'Isaias Delgado');     // Add a recipient
        $mail->addReplyTo('isaandvalbudgettool@gmail.com', 'Isa and Val Budget Tool');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Budget Summary for '.$thisEmailMonthName.'';
        $email_body    = '
        <html>
            <head>
            <style>
                body{
                    font-family: arial;
                }
                th{
                    color: green;
                }
                h1{
                    text-align: center;
                }
                h3{
                    background-color: lightblue;
                }
                table, th, td {
                    border: 1px solid black;
                    text-align: center;
                }
            </style>
                <title>
                    '.$thisEmailMonthName.' Budget Summary
                </title>
            </head>
            <body>
                <h1>
                    QUICK SUMMARY
                </h1>
                <h3>
                    Income Total : $'.number_format($income_summary_total, 2, '.','').'
                </h3>
                <h3>
                    Bill Total : $'.number_format($bill_summary_total, 2, '.','').'
                </h3>
                <h3>
                    Left Overs : $'.number_format($email_summary_leftOvers, 2, '.','').'
                </h3>
                <br>
                <h1>
                    BILLS
                </h1>
                <table>
                    <tr>
                        <th>
                            Company
                        </th>
                        <th>
                            Due Date
                        </th>
                        <th>
                            Amount
                        </th>
                    </tr>';
                   
                    while($email_bills_query_row = mysqli_fetch_array($email_bills_query)){
                        $email_bill_date = new DateTime($email_bills_query_row["due_date"]);
    $email_bills_results .= '<tr>
                                <td>'.$email_bills_query_row["company"].'</td>
                                <td>'.$email_bill_date->format('m/d').'</td>
                                <td>'.$email_bills_query_row["amount"].'</td>
                            </tr>';
                    }
    $email_body .= $email_bills_results;
$email_body .= '</table>
                <h1>
                    INCOME
                </h1>
                <table>
                    <tr>
                        <th>
                            Company
                        </th>
                        <th>
                            Pay Date
                        </th>
                        <th>
                            Amount
                        </th>
                    </tr>';
                   
                    while($email_income_query_row = mysqli_fetch_array($email_income_query)){
                        $email_income_date = new DateTime($email_income_query_row["pay_date"]);
    $email_income_results .=    '<tr>
                                    <td>'.$email_income_query_row["name"].'</td>
                                    <td>'.$email_income_date->format('m/d').'</td>
                                    <td>'.$email_income_query_row["amount"].'</td>
                                </tr>';
                    }
    $email_body .= $email_income_results;
$email_body    .= 
                '</table>
                <h1>
                    DEBT
                </h1>
                <table>
                    <tr>
                        <th>
                            Company
                        </th>
                        <th>
                            Due Date
                        </th>
                        <th>
                            Amount
                        </th>
                    </tr>';
                   
                    while($email_debt_query_row = mysqli_fetch_array($email_debt_query)){
                        $email_debt_date = new DateTime($email_debt_query_row["due_date"]);
    $email_debt_results .=  '<tr>
                                <td>'.$email_debt_query_row["company"].'</td>
                                <td>'.$email_debt_date->format('m/d').'</td>
                                <td>'.$email_debt_query_row["amount"].'</td>
                            </tr>';
                    }
    $email_body .= $email_debt_results;
$email_body    .= 
                '</table>
            </body>
        </html>
        ';
        $mail->Body = $email_body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        if($mail->send())
        {
            $output = "sent";
        }
    } 
    catch (Exception $e) {
        //$output = "fail";
        //echo $e->getMessage(); //Boring error messages from anything else!
    }
    mysqli_close($conn); 
    echo $output;
?>