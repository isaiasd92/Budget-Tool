<?php
/*
	This script gets the budget info and outputs the data in index.php
*/

    include 'db.php';
    
    if(isset($_POST['currentMonth'])){
        $output = '';
        $budget_month = $_POST["currentMonth"];
        $budget_year = $_POST["currentYear"];

        $get_month_bill_total = "SELECT SUM(amount) as bill_total FROM bills WHERE MONTH(due_date) = ".$budget_month." AND YEAR(due_date) = ".$budget_year.";";
        $get_month_income_total = "SELECT SUM(amount) as income_total FROM income WHERE MONTH(pay_date) = ".$budget_month." AND YEAR(pay_date) = ".$budget_year.";";

        $get_month_bill_total_results = mysqli_query($conn, $get_month_bill_total);
        $get_month_income_total_results = mysqli_query($conn, $get_month_income_total);

        $get_month_bill_total_results_count = mysqli_num_rows($get_month_bill_total_results);
        $get_month_income_total_results_count = mysqli_num_rows($get_month_income_total_results);

        if($get_month_bill_total_results_count > 0){
            while($get_month_bill_total_row = mysqli_fetch_array($get_month_bill_total_results))
            {
                $budget_total_bills_val = $get_month_bill_total_row['bill_total'];
            }            
            while($get_month_income_total_row = mysqli_fetch_array($get_month_income_total_results))
            {
                $budget_total_income_val = $get_month_income_total_row['income_total'];
            }

            $get_month_leftovers = $budget_total_income_val - $budget_total_bills_val;

            if($get_month_leftovers < 0){
                $get_month_leftovers = 0;
            }
        }

        $output .= '
            var myBudgetChart = new Chart(document.getElementById("myBudgetChart").getContext("2d"), {
                type: "doughnut",
                data: {
                    labels:
                        [
                            "Bills", "Left Overs"
                        ],
                        datasets: [
                        {
                            backgroundColor: 
                                [
                                    "#dc3545", "#43a047"
                                ],
                            data: 
                                ['.number_format($budget_total_bills_val, 2, '.','').','.number_format($get_month_leftovers, 2, '.','').']
                        }
                    ]
                },
                options: {
                    segmentShowStroke : true,
                    segmentStrokeColor : "#fff",
                    segmentStrokeWidth : 2,
                    percentageInnerCutout : 50,
                    animationSteps : 100,
                    animationEasing : "easeOutBounce",
                    animateRotate : true,
                    animateScale : false,
                    responsive: true,
                    maintainAspectRatio: true,
                    showScale: true,
                    animateScale: true,
                    legend: {
                        display:true
                    }
                }
            });';

        echo $output;
    }
    mysqli_close($conn); 
?>