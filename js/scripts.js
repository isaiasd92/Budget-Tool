$(document).ready(function(){

    // ##############################################
    //                  HOME
    // ##############################################

     // View Budget Info In Date Range
     $(document).on('click', '#date_range', function(){
        var from_date = $('#from_date').val();
        var through_date = $('#through_date').val();
        $.ajax({
            url:"/php/getBudget.php",
            method:"POST",
            data:{
                    from_date : from_date,
                    through_date : through_date
                 },
            success: function(data){
                $('#budget_table').html(data);
            }
        });
    });

    // ##############################################
    //                  BILLS
    // ##############################################

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
        var delete_bill_id = $(this).data("id");
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

    // Resets the month and date selection
    $(document).on('click', '#date-title-link', function(){
        $("#bill-months").addClass("hide");
        $("#bill-years").removeClass("hide");
        $("#date-title").html("");
    });

    // bills Chart Legend click event
    $(document).on('click', '#bill-chart-legend > ul > li', function(e){
            var index = $(this).index();
            $(this).toggleClass("strike")
            var ci = e.view.myChart;
            console.log(index)
            console.log();
            var curr = ci.data.datasets[0]._meta[0].data[index];
            curr.hidden = !curr.hidden
            ci.update();
    })

    // Converts the month number to the month name
    function GetMonthName(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber - 1];
    }

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
                $("#thisChart").html(data);
                $("#bill-chart-legend-container").removeClass("hide");
                $("#bill-chart-legend-button").removeClass("hide");
                $("#bill-chart-legend-container ul").addClass("list-group");
                $("#bill-chart-legend-container ul li").addClass("list-group-item");
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
        var delete_income_id = $(this).data("id");
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
                    $('#debt_table').html(data);
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
    // End Add Debt

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
                $('#debt_table').html(data);
            }
        });
    });

    // Delete Debt
    $(document).on('click', '.delete_debt', function(){
        var delete_debt_id = $(this).data("id");
        $.ajax({
            url:"/php/deleteDebts.php",
            method:"POST",
            data:{delete_debt_id: delete_debt_id},
            success: function(data){
                $('#debt_removed').modal('show');
                $('#debt_table').html(data);
            }
        });
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

    // Menu Collapse Icon Changer
    $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
    });

    // Add Due Date Defaults
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.format = 'yyyy-mm-dd';
});