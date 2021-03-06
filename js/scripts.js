$(document).ready(function(){

    // ##############################################
    //                  HOME
    // ##############################################

    // View Budget Info for the Month
    $(document).ready(function(){
        var today = new Date();
        var currentMonth = today.getMonth() + 1;
        var currentYear = today.getFullYear();

        $.ajax({
            url:"/php/getBudget.php",
            method:"POST",
            data:{
                currentMonth : currentMonth,
                currentYear : currentYear
                 },
            success: function(data){
                $('#thisBudgetChart').html(data);
            }
        });
    });

    // ##############################################
    //                  BILLS
    // ##############################################

    // Automatically Update Bills
    $(document).ready(function(){
        var todayDate = new Date();
        var billMonth = todayDate.getMonth() + 1;

        $.ajax({
            url:"/php/autoUpdateBills.php",
            method:"POST",
            data:{
                billMonth : billMonth
                 },
            success: function(data){
                console.log(data);
            }
        });
    });

    // View Bill Info
    $(document).on('click', '.view_bills', function(){
        var bill_id = $(this).data("id");
        $.ajax({
            url:"/php/getBills.php",
            method:"POST",
            data:{bill_id: bill_id},
            success: function(data){
                $('#bill_detail').html(data);
                $('#view_bill_modal').modal("show");
            }
        });
    });

    // Add Bill
    $(document).on('click', "#insert_bill", function(){
        if(($('#bill_add_amount').val() != '') && ($('#bill_add_due_date').val() != '') && ($('#bill_add_company').val() != '')) {
            var bill_add_company = $('#bill_add_company').val();
            var bill_add_due_date = $('#bill_add_due_date').val();
            var bill_add_amount = $('#bill_add_amount').val();
            var bill_add_notes = $('#bill_add_notes').val();
            
            if($('#add_bill_is_paid_yes_label').hasClass('active'))
            {
                var bill_add_is_paid = $('#bill_add_is_paid_yes').val();
            }
            else if($('#add_bill_is_paid_no_label').hasClass('active'))
            {
                var bill_add_is_paid = $('#bill_add_is_paid_no').val();
            }

            $.ajax({
                url     : '/php/addBills.php',
                method  : 'POST',
                data    : {
                            bill_add_company : bill_add_company,
                            bill_add_due_date : bill_add_due_date,
                            bill_add_amount : bill_add_amount,
                            bill_add_notes : bill_add_notes,
                            bill_add_is_paid : bill_add_is_paid
                },
                success : function(data){
                    $('#add_bill_modal').modal('hide');
                    $('#bill_added').modal('show');
                    $('#bill_table').html(data);
                    $('#add_bill_form')[0].reset();
                }
            });
        }
        if($('#bill_add_company').val() == '') {
            $('#bill_add_company').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#bill_add_due_date').val() == '') {
            $('#bill_add_due_date').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#bill_add_amount').val() == '') {
            $('#bill_add_amount').attr('style','border-color: red; border-width: 2px; color: red;');
        }
    });

    // Edit Bill
    $(document).on('click', '.edit_bills', function(){
        var edit_bill_id = $(this).data("id");
        $.ajax({
            url: "/php/editBills.php",
            method: "POST",
            data:{edit_bill_id: edit_bill_id},
            success: function(data) {
                $('#bill_edit').html(data);
                $('#edit_bill_modal').modal('show');
            }
        });
    });

    // Update Bill
    $(document).on('click', "#update_bill", function(){
        var update_bill_id = $('#edit_bill_id').val(); 
        var update_bill_company = $('#edit_bill_company').val();
        var update_bill_due_date = $('#edit_bill_due_date').val();
        var update_bill_amount = $('#edit_bill_amount').val();
        var update_bill_notes = $('#edit_bill_notes').val();

        if($('#edit_bill_is_paid_yes_label').hasClass('active'))
        {
            var update_bill_is_paid = $('#bill_add_is_paid_yes').val();
        }
        else if($('#edit_bill_is_paid_no_label').hasClass('active'))
        {
            var update_bill_is_paid = $('#bill_add_is_paid_no').val();
        }

        $.ajax({
            url     : '/php/updateBills.php',
            method  : 'POST', 
            data    : {
                        update_bill_id: update_bill_id,
                        update_bill_company : update_bill_company,
                        update_bill_due_date: update_bill_due_date, 
                        update_bill_amount : update_bill_amount,
                        update_bill_notes : update_bill_notes,
                        update_bill_is_paid : update_bill_is_paid
            },
            success  : function(data){
                $('#edit_bill_modal').modal('hide');
                $('#bill_updated').modal('show');
                $('#bill_table').html(data);
            }
        });
    });

    // Delete Bill
    $(document).on('click', '.delete_bill', function(){
        $("#bills_delete_confirmation").modal('show');
        var delete_bill_id = $(this).data("id");

        // Delete Bills Confirmed
        $("#bills_delete_confirmation_yes").click(function(){
            $("#bills_delete_confirmation").modal('hide');
            $.ajax({
                url:"/php/deleteBills.php",
                method:"POST",
                data:{delete_bill_id: delete_bill_id},
                success: function(data){
                    $('#bill_removed').modal('show');
                    $('#bill_table').html(data);
                }
            });
        });

        $("#bills_delete_confirmation_no").click(function(){
            $("#bills_delete_confirmation").modal('hide');
        });
    });

    // Resets the month and date selection
    $(document).on('click', '#date-title-link', function(){
        $("#bill-months").addClass("hide");
        $("#bill-chart-legend-button").addClass("hide");
        $("#bill-years").removeClass("hide");
        $("#date-title").html("");
        $("#bill-chart-failure").addClass("hide");
        $("canvas#myDoughnutChart").remove();
        $("div.chartjs-size-monitor").remove();
        $("div.doughnut-chart").append('<canvas id="myDoughnutChart" width="100%" height="100%"></canvas>');
        $("#thisChart").remove();

        var script   = document.createElement("script");
        script.setAttribute('id', 'thisChart');
        script.type  = "text/javascript";
        document.body.appendChild(script);
    });

    // Bills Chart Legend click event
    $(document).on('click', '#bill-chart-legend > ul > li', function(e){
        var index = $(this).index();
        $(this).toggleClass("strike");
        var ci = e.view.myBillChart;
        console.log(index);
        var curr = ci.data.datasets[0]._meta[0].data[index];
        curr.hidden = !curr.hidden;
        ci.update();
    });

    // Year Button Click
    $(document).on('click', '.year-button', function(){
        var bill_year = $(this).val();

        $("#bill-months").removeClass("hide");
        $("#bill-years").addClass("hide");
        $("#date-title").html(bill_year);
    });

    // Month Button Click
    $(document).on('click', '.month-button', function(){
        var bill_month = $(this).val();
        var bill_year = $("#date-title").html();
        var bill_date = GetMonthName(bill_month) + " " + bill_year;

        $("#bill-months").addClass("hide");
        $("#date-title").html(bill_date);

        $.ajax({
            url:"/php/getBillSummary.php",
            method:"POST",
            data:{
                    bill_month: bill_month,
                    bill_year: bill_year
            },
            success: function(data){
                if(data == "Fail"){
                    $("#bill-chart-failure").removeClass("hide");
                    $("canvas#myDoughnutChart").remove();
                    $("#thisChart").remove();

                    var script   = document.createElement("script");
                    script.setAttribute('id', 'thisChart');
                    script.type  = "text/javascript";
                    document.body.appendChild(script);
                }
                else{
                    $("canvas#myDoughnutChart").remove();
                    $("div.doughnut-chart").append('<canvas id="myDoughnutChart" width="100%" height="100%"></canvas>');
                    $("#thisChart").html(data);
                    $("#bill-chart-legend-container").removeClass("hide");
                    $("#bill-chart-legend-button").removeClass("hide");
                    $("#bill-chart-legend-container ul").addClass("list-group");
                    $("#bill-chart-legend-container ul li").addClass("list-group-item");
                }
            }
        });
    });

    // Chart Button Click
    $(document).on('click', '#bill-chartButton', function(){
        $("#bill-icon-chartButton").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    // Table Button Click
    $(document).on('click', '#bill-tableButton', function(){
        $("#bill-icon-tableButton").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    // Change Input Style
    $(document).on('click', "#bill_add_company", function(){
        $('#bill_add_company').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#bill_add_due_date", function(){
        $('#bill_add_due_date').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#bill_add_calendar", function(){
        $('#bill_add_due_date').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#bill_add_amount", function(){
        $('#bill_add_amount').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    // ##############################################
    //                  INCOME
    // ##############################################

    // Automatically Update Incomes
    $(document).ready(function(){
        var todayDate = new Date();
        var incomeMonth = todayDate.getMonth() + 1;

        $.ajax({
            url:"/php/autoUpdateIncomes.php",
            method:"POST",
            data:{
                incomeMonth : incomeMonth
                },
            success: function(data){
                console.log(data);
            }
        });
    });

    // View Income Info
    $(document).on('click', '.view_incomes', function(){
        var income_id = $(this).data("id");
        $.ajax({
            url:"/php/getIncome.php",
            method:"POST",
            data:{income_id: income_id},
            success: function(data){
                $('#income_detail').html(data);
                $('#view_income_modal').modal("show");
            }
        });
    });

    // Add Income
    $(document).on('click', "#insert_income", function(){
        if(($('#income_add_amount').val() != '') && ($('#income_add_pay_date').val() != '') && ($('#income_add_name').val() != '')) {
            var income_add_name = $('#income_add_name').val();
            var income_add_pay_date = $('#income_add_pay_date').val();
            var income_add_amount = $('#income_add_amount').val();

            $.ajax({
                url     : '/php/addIncomes.php',
                method  : 'POST',
                data    : {
                            income_add_name : income_add_name,
                            income_add_pay_date : income_add_pay_date,
                            income_add_amount : income_add_amount,
                },
                success : function(data){
                    $('#add_income_modal').modal('hide');
                    $('#income_added').modal('show');
                    $('#income_table').html(data);
                    $('#add_income_form')[0].reset();
                }
            });
        }
        if($('#income_add_name').val() == '') {
            $('#income_add_name').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#income_add_pay_date').val() == '') {
            $('#income_add_pay_date').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#income_add_amount').val() == '') {
            $('#income_add_amount').attr('style','border-color: red; border-width: 2px; color: red;');
        }
    });

    // Edit Income
    $(document).on('click', '.edit_incomes', function(){
        var edit_income_id = $(this).data("id");
        $.ajax({
            url: "/php/editIncomes.php",
            method: "POST",
            data:{edit_income_id: edit_income_id},
            success: function(data) {
                $('#income_edit').html(data);
                $('#edit_income_modal').modal('show');
            }
        });
    });

    // Update Income
    $(document).on('click', "#update_income", function(){
        var update_income_id = $('#edit_income_id').val(); 
        var update_income_name = $('#edit_income_name').val();
        var update_income_pay_date = $('#edit_income_pay_date').val();
        var update_income_amount = $('#edit_income_amount').val();

        $.ajax({
            url     : '/php/updateIncomes.php',
            method  : 'POST', 
            data    : {
                        update_income_id: update_income_id,
                        update_income_name : update_income_name,
                        update_income_pay_date: update_income_pay_date, 
                        update_income_amount : update_income_amount
            },
            success  : function(data){
                $('#edit_income_modal').modal('hide');
                $('#income_updated').modal('show');
                $('#income_table').html(data);
            }
        });
    });

    // Delete Income
    $(document).on('click', '.delete_income', function(){
        $("#income_delete_confirmation").modal('show');
        var delete_income_id = $(this).data("id");

        // Delete Income Confirmed
        $("#income_delete_confirmation_yes").click(function(){
            $("#income_delete_confirmation").modal('hide');
            $.ajax({
                url:"/php/deleteIncomes.php",
                method:"POST",
                data:{delete_income_id: delete_income_id},
                success: function(data){
                    $('#income_removed').modal('show');
                    $('#income_table').html(data);
                }
            });
        });

        $("#income_delete_confirmation_no").click(function(){
            $("#income_delete_confirmation").modal('hide');
        });
    });

    // Change Input Style
    $(document).on('click', "#income_add_name", function(){
        $('#income_add_name').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#income_add_pay_date", function(){
        $('#income_add_pay_date').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#income_add_calendar", function(){
        $('#income_add_calendar').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#income_add_amount", function(){
        $('#income_add_amount').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    // ##############################################
    //                  DEBT
    // ##############################################

     // View Debt Info
     $(document).on('click', '.view_debts', function(){
        var debt_id = $(this).data("id");
        $.ajax({
            url:"/php/getDebts.php",
            method:"POST",
            data:{debt_id: debt_id},
            success: function(data){
                $('#debt_detail').html(data);
                $('#view_debt_modal').modal("show");
            }
        });
    });

    // Add Debt
    $(document).on('click', "#insert_debt", function(){
        if(($('#debt_add_amount').val() != '') && ($('#debt_add_due_date').val() != '') && ($('#debt_add_company').val() != '')) {
            var debt_add_company = $('#debt_add_company').val();
            var debt_add_due_date = $('#debt_add_due_date').val();
            var debt_add_amount = $('#debt_add_amount').val();
            var debt_add_notes = $('#debt_add_notes').val();

            if($('#add_debt_is_paid_yes_label').hasClass('active'))
            {
                var debt_add_is_paid = $('#debt_add_is_paid_yes').val();
            }
            else if($('#add_debt_is_paid_no_label').hasClass('active'))
            {
                var debt_add_is_paid = $('#debt_add_is_paid_no').val();
            }

            $.ajax({
                url     : '/php/addDebts.php',
                method  : 'POST',
                data    : {
                            debt_add_company : debt_add_company,
                            debt_add_due_date : debt_add_due_date,
                            debt_add_amount : debt_add_amount,
                            debt_add_is_paid : debt_add_is_paid,
                            debt_add_notes : debt_add_notes
                },
                success : function(data){
                    $('#add_debt_modal').modal('hide');
                    $('#debt_added').modal('show');
                    $('.debt_table').html(data);
                    $('#add_debt_form')[0].reset();
                }
            });
        }
        if($('#debt_add_company').val() == '') {
            $('#debt_add_company').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#debt_add_due_date').val() == '') {
            $('#debt_add_due_date').attr('style','border-color: red; border-width: 2px; color: red;');
        }
        if($('#debt_add_amount').val() == '') {
            $('#debt_add_amount').attr('style','border-color: red; border-width: 2px; color: red;');
        }
    });

    // Edit Debt
    $(document).on('click', '.edit_debts', function(){
        var edit_debt_id = $(this).data("id");
        $.ajax({
            url: "/php/editDebts.php",
            method: "POST",
            data:{edit_debt_id: edit_debt_id},
            success: function(data) {
                $('#debt_edit').html(data);
                $('#edit_debt_modal').modal('show');
            }
        });
    });

    // Pay Debt
    $(document).on('click', '.pay_debts', function(){
        var pay_debt_id = $(this).data("id");
        $.ajax({
            url: "/php/payDebts.php",
            method: "POST",
            data:{pay_debt_id: pay_debt_id},
            success: function(data) {
                $('#debt_payment').html(data);
                $('#pay_debt_modal').modal('show');
            }
        });
    });

    // Debt Payment
    $(document).on('click', "#update_debt_payment", function(){
        var pay_debt_id = $('#pay_debt_id').val(); 
        var pay_debt_amount = $('#pay_debt_amount').val();

        $.ajax({
            url     : '/php/debtPayment.php',
            method  : 'POST', 
            data    : {
                    pay_debt_id: pay_debt_id,
                    pay_debt_amount : pay_debt_amount
            },
            success  : function(data){
                $('#pay_debt_modal').modal('hide');
                $('#debt_payment_modal').modal('show');
                $('.debt_table').html(data);
            }
        });
    });

    // View Debt Payments
    $(document).on('click', ".view_debts_payments", function(){
        var view_payment_id = $(this).data("id");
        $.ajax({
            url: "/php/getDebtPayments.php",
            method: "POST",
            data:{view_payment_id: view_payment_id},
            success: function(data) {
                $('#view_debt_payment_content').html(data);
                $('#view_debt_payment_modal').modal('show');
            }
        });
    });

    // Update Debt
    $(document).on('click', "#update_debt", function(){
        var update_debt_id = $('#edit_debt_id').val(); 
        var update_debt_company = $('#edit_debt_company').val();
        var update_debt_due_date = $('#edit_debt_due_date').val();
        var update_debt_amount = $('#edit_debt_amount').val();
        var update_debt_notes = $('#edit_debt_notes').val();

        if($('#edit_debt_is_paid_yes_label').hasClass('active'))
        {
            var update_debt_is_paid = $('#debt_add_is_paid_yes').val();
        }
        else if($('#edit_debt_is_paid_no_label').hasClass('active'))
        {
            var update_debt_is_paid = $('#debt_add_is_paid_no').val();
        }

        $.ajax({
            url     : '/php/updateDebts.php',
            method  : 'POST', 
            data    : {
                        update_debt_id: update_debt_id,
                        update_debt_company : update_debt_company,
                        update_debt_due_date: update_debt_due_date, 
                        update_debt_amount : update_debt_amount,
                        update_debt_notes : update_debt_notes,
                        update_debt_is_paid : update_debt_is_paid
            },
            success  : function(data){
                $('#edit_debt_modal').modal('hide');
                $('#debt_updated').modal('show');
                $('.debt_table').html(data);
            }
        });
    });

    // Delete Debt
    $(document).on('click', '.delete_debt', function(){
        $("#debts_delete_confirmation").modal('show');
        var delete_debt_id = $(this).data("id");

        // Delete Debts Confirmed
        $("#debts_delete_confirmation_yes").click(function(){
            $("#debts_delete_confirmation").modal('hide');

            $.ajax({
                url:"/php/deleteDebts.php",
                method:"POST",
                data:{delete_debt_id: delete_debt_id},
                success: function(data){
                    $('#debt_removed').modal('show');
                    $('.debt_table').html(data);            
                }
            });
        });

        $("#debts_delete_confirmation_no").click(function(){
            $("#debts_delete_confirmation").modal('hide');
        });
    });

    // Chart Button Click
    $(document).on('click', '#debt-chartButton', function(){
        $("#debt-icon-chartButton").removeClass("glyphicon-minus").addClass("glyphicon-plus");

        var thisDate = new Date();
        var currMonth = thisDate.getMonth() + 1;
        var thisMonth = GetMonthName(currMonth);

        $.ajax({
            url:"/php/getDebtSummary.php",
            method:"POST",
            data:{
                    thisMonth : thisMonth
            },
            success: function(data){
                if(data == "Fail"){
                    var script   = document.createElement("script");
                    script.setAttribute('id', 'thisDebtChart');
                    script.type  = "text/javascript";
                    document.body.appendChild(script);
                }
                else{
                    $("canvas#line_chart").remove();
                    $("div.debt_line_chart").append('<canvas id="line_chart" width="100%" height="100%"></canvas>');
                    $("#thisDebtChart").html(data);
                    $("#debt-chart-legend-container").removeClass("hide");
                    $("#debt-chart-legend-button").removeClass("hide");
                    $("#debt-chart-legend-container ul").addClass("list-group");
                    $("#debt-chart-legend-container ul li").addClass("list-group-item");
                }
            }
        });
    });

    // Debt Chart Legend click event
    $(document).on('click', '#debt_chart_legend > ul > li', function(e){
        var index = $(this).index();
        $(this).toggleClass("strike");
        var ci = e.view.myDebtChart;
        console.log(index);
        var curr = ci.data.datasets[0]._meta[0].data[index];
        curr.hidden = !curr.hidden;
        ci.update();
    });

    // Table Button Click
    $(document).on('click', '#debt-tableButton', function(){
        $("#debt-icon-tableButton").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    // Change Input Style
    $(document).on('click', "#debt_add_company", function(){
        $('#debt_add_company').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#debt_add_due_date", function(){
        $('#debt_add_due_date').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#debt_add_calendar", function(){
        $('#debt_add_due_date').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    $(document).on('click', "#debt_add_amount", function(){
        $('#debt_add_amount').attr('style','border-color: default; border-width: default; color: default;').val('');
    });

    // ##############################################
    //                  SETTINGS
    // ##############################################

    // Update Settings Button Click
    $(document).on('click', "#update_settings", function(){
        if($('#edit_auto_update_yes_label').hasClass('active'))
        {
            var settings_auto_update = $('#edit_auto_update_yes').val();
        }
        else if($('#edit_auto_update_no_label').hasClass('active'))
        {
            var settings_auto_update = $('#edit_auto_update_no').val();
        }

        if($('#edit_send_emails_yes_label').hasClass('active'))
        {
            var settings_send_emails = $('#edit_send_emails_yes').val();
        }
        else if($('#edit_send_emails_no_label').hasClass('active'))
        {
            var settings_send_emails = $('#edit_send_emails_no').val();
        }

        var settings_day = $('#settings_day').val();

        if(("1" <= settings_day) && (settings_day <= "31")){
            $("#settings_day").removeClass("alert alert-danger");
            $("#invalid_date").modal("hide");

            $.ajax({
                url     : '/php/updateSettings.php',
                method  : 'POST', 
                data    : {
                        settings_auto_update : settings_auto_update,
                        settings_send_emails : settings_send_emails,
                        settings_day : settings_day
                },
                success  : function(data){
                    $("#settings-container").html(data);
                    $("#settings_updated").modal('show');
                }
            });
        }
        else{
            $("#settings_day").addClass("alert alert-danger");
            $("#invalid_date").modal("show");
        }
    });

    // Email Monthly Summary Now
    $(document).on('click', "#email_now", function(){
        var thisDate = new Date();
        var currMonth = thisDate.getMonth() + 1;
        var currYear = thisDate.getFullYear();
        var thisMonth = GetMonthName(currMonth);

        $.ajax({
            url     : '/php/email.php',
            method  : 'POST', 
            data    : {
                    thisMonth : thisMonth,
                    currMonth : currMonth,
                    currYear : currYear
            },
            success  : function(data){
                if(data == "fail"){
                    $("#email_fail").modal('show');
                }
                else if(data == "sent"){
                    $("#email_sent").modal('show');
                }
            }
        });
        $("#email_sent").modal('show');
    });

    // Menu Collapse Icon Changer
    $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    // Converts the month number to the month name
    function GetMonthName(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber - 1];
    }

    // Add Due Date Defaults
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.format = 'yyyy-mm-dd';
});