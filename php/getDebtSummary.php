<?php
/*
	This script gets the debt summary and outputs the data into a doughnut chart in debt.php
*/

    include 'db.php';
    
    $output = '';
    $debt_summary_month = $_POST["thisMonth"];

    $debt_summary_select_query = "SELECT id, company, amount, due_date FROM debt;";
    $debt_summary_select_query_results = mysqli_query($conn, $debt_summary_select_query);
    $debt_summary_select_query_results2 = mysqli_query($conn, $debt_summary_select_query);
    $debt_summary_select_query_results_count = mysqli_num_rows($debt_summary_select_query_results);
    $debt_summary_select_query_results_count2 = $debt_summary_select_query_results_count;
    
    $debt_date_labels_counter = 1;
    $debt_date_datasets_counter = 1;
    
    // Generates a random color for the chart 
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
    /*
    $output .= 
            'var myDebtChart = new Chart(document.getElementById("line_chart").getContext("2d"), {
                type: "line",
                data: {
                    labels:
                        [';
                            while($debt_summary_select_query_results_row1 = mysqli_fetch_array($debt_summary_select_query_results)){
                                if($debt_summary_select_query_results_count == $debt_date_labels_counter){
                                    $output .= '"'.$debt_summary_select_query_results_row1["due_date"].'"';
                                }
                                else{
                                    $output .= '"'.$debt_summary_select_query_results_row1["due_date"].'", ';
                                }
                                $debt_date_labels_counter++;
                            }
            $output .=  '],
                        datasets: 
                        [';
        while($debt_summary_select_query_results_row2 = mysqli_fetch_array($debt_summary_select_query_results2)){
                            $output .= '
                            { 
                                data: 
                                [';
                                    $debt_payments_summary_select_query = "SELECT debt_id, amount, date_paid, prev_amount FROM debt_payments WHERE debt_id = ".$debt_summary_select_query_results_row2['id'].";";
                                    $debt_payments_summary_select_query_results = mysqli_query($conn, $debt_payments_summary_select_query);
                                    $debt_payments_summary_select_query_results_count = mysqli_num_rows($debt_payments_summary_select_query_results);

                                    if($debt_payments_summary_select_query_results_count > 0){
                                        while($debt_payments_summary_select_query_row = mysqli_fetch_array($debt_payments_summary_select_query_results)){
                                            $output .= $debt_payments_summary_select_query_row["prev_amount"].', '.$debt_summary_select_query_results_row2["amount"];
                                            if($debt_payments_summary_select_query_results_count == $debt_date_datasets_counter){
                                                $output .= '';
                                            }
                                            else{
                                                $output .= ',';
                                            }
                                        }
                                    }
                                    else{
                                        $output .= $debt_summary_select_query_results_row2["amount"];
                                    }
                    $output .= '],
                                label: "'.$debt_summary_select_query_results_row2["company"].'",
                                borderColor: "'.rand_color().'",
                                fill: false';
            if($debt_summary_select_query_results_count2 == $debt_date_datasets_counter){
                $output .= '}';
            }
            else{
                $output .= '},';
            }
            $debt_date_datasets_counter++;
        }
            $output .=  ']
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
            document.getElementById("debt_chart_legend").innerHTML = myDebtChart.generateLegend();
    ';
    */

    $output .= 
            'var myDebtChart = new Chart(document.getElementById("line_chart").getContext("2d"), {
                type: "polarArea",
                data: {
                    labels:
                        [';
                            while($debt_summary_select_query_results_row1 = mysqli_fetch_array($debt_summary_select_query_results)){
                                if($debt_summary_select_query_results_count == $debt_date_labels_counter){
                                    $output .= '"'.$debt_summary_select_query_results_row1["company"].'"';
                                }
                                else{
                                    $output .= '"'.$debt_summary_select_query_results_row1["company"].'", ';
                                }
                                $debt_date_labels_counter++;
                            }
            $output .=  '],
                        datasets: 
                        [{';
        
                        $output .= '
                            backgroundColor: 
                            [';
                            for ($x = 0; $x <= $debt_summary_select_query_results_count2; $x++) {
                                if($debt_summary_select_query_results_count2 == $x){
                                    $output .= '"'.rand_color().'"';
                                }
                                else{
                                    $output .= '"'.rand_color().'", ';
                                }
                            }
                $output .= '],
                            data: 
                            [';
                                while($debt_summary_select_query_results_row2 = mysqli_fetch_array($debt_summary_select_query_results2)){
                                    if($debt_summary_select_query_results_count2 == $debt_date_datasets_counter){
                                        $output .= $debt_summary_select_query_results_row2["amount"];
                                    }
                                    else{
                                        $output .= $debt_summary_select_query_results_row2["amount"].', ';
                                    }
                                    $debt_date_datasets_counter++;
                                }
                $output .= ']
                        }]
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
                        display: false
                    }
                }
            });
            document.getElementById("debt_chart_legend").innerHTML = myDebtChart.generateLegend();
    ';

    if($debt_date_labels_counter < 1){
        $output = "Fail";
    }
    echo $output;
    mysqli_close($conn); 
?>