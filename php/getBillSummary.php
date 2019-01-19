<?php
/*
	This script gets the budget summary and outputs the data into a doughnut chart in bills.php
*/

	include 'db.php';

	if(isset($_POST['bill_year'])){
        $output = '';
        $bill_month = $_POST["bill_month"];
        $bill_year = $_POST["bill_year"];

        $get_bill_date_company = "SELECT company FROM bills WHERE MONTH(due_date) = ".$bill_month." AND YEAR(due_date) = ".$bill_year.";";
        $get_bill_date_amount = "SELECT amount FROM bills WHERE MONTH(due_date) = ".$bill_month." AND YEAR(due_date) = ".$bill_year.";";

        $get_bill_date_company_results = mysqli_query($conn, $get_bill_date_company);
        $get_bill_date_amount_results = mysqli_query($conn, $get_bill_date_amount);

        $get_bill_date_company_results_count = mysqli_num_rows($get_bill_date_company_results);
        $get_bill_date_amount_results_count = mysqli_num_rows($get_bill_date_amount_results);

        $bill_date_company_counter = 1;
        $bill_date_amount_counter = 1;
        $bill_date_color_counter = 1;

        /* Generates a random color for the chart */
        function rand_color() {
            return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        
        $output .= 
                'var myBillChart = new Chart(document.getElementById("myDoughnutChart").getContext("2d"), {
                    type: "doughnut",
                    data: {
                        labels:
                            [';
                                while($get_bill_date_company = mysqli_fetch_array($get_bill_date_company_results))
                                {
                                    if($get_bill_date_company_results_count == $bill_date_company_counter){
                                        $output .= '"'.$get_bill_date_company["company"].'"';
                                    }
                                    else{
                                        $output .= '"'.$get_bill_date_company["company"].'", ';
                                    }
                                    $bill_date_company_counter++;
                                }
                $output .=  '],
                            datasets: [
                            {
                                backgroundColor: 
                                    [';
                                        for ($x = 0; $x <= $get_bill_date_company_results_count; $x++) {
                                            if($get_bill_date_company_results_count == $x){
                                                $output .= '"'.rand_color().'"';
                                            }
                                            else{
                                                $output .= '"'.rand_color().'", ';
                                            }
                                        }
                        $output .=  '],
                                data: 
                                    [';
                                        while($get_bill_date_amount = mysqli_fetch_array($get_bill_date_amount_results))
                                        {
                                            if($get_bill_date_amount_results_count == $bill_date_amount_counter){
                                                $output .= $get_bill_date_amount["amount"];
                                            }
                                            else{
                                                $output .= $get_bill_date_amount["amount"].', ';
                                            }
                                            $bill_date_amount_counter++;
                                        }
                        $output .= ']
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
                            display:false
                        }
                    }
                });
                document.getElementById("bill-chart-legend").innerHTML = myBillChart.generateLegend();
            ';
        
        if($get_bill_date_company_results_count < 1){
            $output = "Fail";
        }

        echo $output;
    }
?>