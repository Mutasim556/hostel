// Show payments on payment modal
$(document).on('click', '#show_payments', function () {
    let invoice = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: base_url+'admin/get/booking/payments/' + invoice,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data[0].invoice.payment_status == 1) {
                $('#pills-makepayment-tab').addClass('disabled')
            } else {
                $('#pills-makepayment-tab').removeClass('disabled')
            }
            let padded = invoice.toString().padStart(8, '0');
            $('#invoice_id_append').empty().append('#' + padded);

            let append_payments = ``;
            $.each(data, function (key, value) {
                append_payments = append_payments + `
                    <tr id="paytrid-${value.id}" data-id="${value.id}" class="text-center">
                        <td>${value.payment_date}</td>
                        <td>${value.pay_amount} BDT</td>
                        <td>${value.payment_method}</td>
                        <td>${value.created_by.name}</td>
                        <td class="text-center">
                            <a href="#" class="mx-1 text-primary" style="font-size: 22px;" data-bs-toggle="modal" data-bs-target="#print-payment-modal" id="print_receipt" data-paymentid="${value.id}"><i class="fa fa-print"></i></a>
                            <a href="#" class="mx-1 text-danger" style="font-size: 22px;" id="delete_button" data-paymentid="${value.id}"><i class="fa fa-minus-square"></i></a>
                        </td>
                    </tr>
                `;
            })
            $('#append_payments').empty().append(append_payments);

            $('#payment_invoice_id').val(data[0].invoice_id);
            $('#payable_amount').val(data[0].invoice.total_due);
            $('#paying_amount').val(data[0].invoice.total_due);
            $('#remaining_due').val(0);

        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });

});

$(document).on('click', '#print_receipt', function () {
    let receipt = $(this).data('paymentid');
    $.ajax({
        type: "get",
        url: 'get/booking/payment/receipt/' + receipt,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#print_hostel_name').empty().append(data.bookings.hostel.hostel_name);
            $('#hostel_contact_info').empty().append(data.bookings.hostel.hostel_email + " | " + data.bookings.hostel.hostel_phone);
            let invoiceId = data.invoice_id.toString().padStart(8, '0');
            $('#print_invoice_number').empty().append('#' + invoiceId);
            let receiptNo = data.id.toString().padStart(10, '0');
            $('#print_receipt_number').empty().append('#' + receiptNo);

            $('#print_payment_date').empty().append(data.payment_date);
            $('#print_paid_by').empty().append(data.invoice.bookingperson.booking_person_name);
            $('#print_booking_phone').empty().append(data.invoice.bookingperson.booking_phone_number);
            $('#print_received_by').empty().append(data.created_by.name);
            $('#print_payment_method').empty().append(data.payment_method);
            $('#print_total_payable').empty().append("BDT " + data.payable_amount);
            $('#print_total_paid').empty().append("BDT " + data.pay_amount);
            $('#print_total_due').empty().append("BDT " + data.due_amount);

        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });

});

$('#printBtn').on('click', function () {
    var content = $('#printArea').html();
    var win = window.open('', '', 'width=1000,height=800');
    win.document.write(`
        <html>
        <head>
            <title></title>
            <style>
            body { font-family: Arial; padding: 20px; }
            h2 { color: #333; }
            .receipt-container {
             max-width: 600px;
             margin: auto;
             background: #fff;
             padding: 30px;
             border-radius: 10px;
             box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
         }

         .receipt-header {
             text-align: center;
             margin-bottom: 30px;
         }

         .receipt-header h2 {
             margin: 0;
         }

         .receipt-details {
             width: 100%;
             margin-bottom: 20px;
         }

         .receipt-details th,
         .receipt-details td {
             text-align: left;
             padding: 8px 0;
         }

         .receipt-details th {
             width: 40%;
             color: #555;
         }

         .total {
             font-weight: bold;
             font-size: 1.1em;
             margin-top: 20px;
         }

         .receipt-footer {
             text-align: center;
             margin-top: 30px;
             font-size: 0.9em;
             color: #777;
         }

         .line {
             border-top: 1px dashed #ccc;
             margin: 20px 0;
         }

         .paid-stamp {
             text-align: right;
             margin-top: 10px;
             color: green;
             font-weight: bold;
             font-size: 1.2em;
         }
             @page { size: auto;  margin: 0mm; }
            </style>
        </head>
        <body>${content}</body>
        </html>
    `);
    win.document.close();
    win.focus();
    win.print();
    win.close();
});

$(document).on('input', '#paying_amount', function () {
    if (parseFloat($(this).val()) > parseFloat($('#payable_amount').val())) {
        alert('Invalid Amount');
        $(this).val($('#payable_amount').val());
    } else {
        let payable = parseFloat($('#payable_amount').val());
        let paying = parseFloat($(this).val());
        $('#remaining_due').val(payable - paying);
    }
});


$('#make_payment_form').submit(function (e) {
    e.preventDefault();


    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: payment_form_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#make_payment_form').html(submit_btn_before);
            $('button[type=submit]', '#make_payment_form').removeClass('disabled');
            // $('#append_room_div_main .col-md-4').each(function() {
            //     $(this).remove();
            // });

            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                append_payments = `
                    <tr id="paytrid-${data.payment.id}" data-id="${data.payment.id}" class="text-center">
                        <td>${data.payment.payment_date}</td>
                        <td>${data.payment.pay_amount} BDT</td>
                        <td>${data.payment.payment_method}</td>
                        <td>${data.payment.created_by.name}</td>
                        <td class="text-center">
                            <a href="#" class="mx-1 text-primary" style="font-size: 22px;" data-bs-toggle="modal" data-bs-target="#print-payment-modal" id="print_receipt" data-paymentid="${data.payment.id}"><i class="fa fa-print"></i></a>
                            <a href="" class="mx-1 text-danger" style="font-size: 22px;"><i class="fa fa-minus-square"></i></a>
                        </td>
                    </tr>
                `;
                $('#append_payments').prepend(append_payments);
                $('#payable_amount').val(data.payment.invoice.total_due);
                $('#paying_amount').val(data.payment.invoice.total_due);
                $('#remaining_due').val(0);
                $('td:nth-child(10)','#trid-'+data.payment.invoice.id).html(data.payment.invoice.total_paid);
                $('td:nth-child(11)','#trid-'+data.payment.invoice.id).html(data.payment.invoice.total_due);

                var tab = new bootstrap.Tab(document.getElementById('pills-payments-tab'));
                tab.show();
                $('#append_print_btn').empty().append(`<button type="btn" data-bs-toggle="modal" data-bs-target="#print-payment-modal" id="print_receipt" data-paymentid="${data.payment.id}" class="dds"></button>`)

                $('#append_print_btn #print_receipt').click();

                if (data.payment.invoice_status == 1) {
                    $('#pills-payments-tab').addaClass('disabled')
                }


            });

        },
        error: function (err) {
            $('button[type=submit]', '#make_payment_form').html(submit_btn_before);
            $('button[type=submit]', '#make_payment_form').removeClass('disabled');
            if (err.status === 403) {
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function () {
                    $('button[type=button]', '#make_payment_form').click();
                });

            }

            $('#make_payment_form .err-mgs').each(function (id, val) {
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id', '')
                $(this).empty();
            })
            // console.log(err.responseJSON.errors);

            $.each(err.responseJSON.errors, function (idx, val) {
                // console.log('#make_payment_form #'+idx);
                var exp = idx.replace('.', '_');
                var exp2 = exp.replace('_0', '');

                $('#make_payment_form #' + exp).addClass('border-danger is-invalid')
                $('#make_payment_form #' + exp2).addClass('border-danger is-invalid')
                $('#make_payment_form #' + exp).next('span').find('.select2-selection--single').attr('id', 'invalid-selec2')
                $('#make_payment_form #' + exp).next('.err-mgs').empty().append(val);

                $('#make_payment_form #' + exp + "_err").empty().append(val);
            })
        }
    });
});


$(document).on('click', '#edit_receipt', function () {
    let receipt = $(this).data('paymentid');
    $.ajax({
        type: "get",
        url: 'get/booking/payment/receipt/' + receipt,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {

            $('#epayable_amount').val(data.payable_amount);
            $('#epaying_amount').val(data.pay_amount);
            $('#eremaining_due').val(data.due_amount);

        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });

});


$(document).on('click','#delete_button',function(){
    let delete_id = $(this).data('paymentid');
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'get/booking/payment/delete/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#payable_amount').val(data.invoice.total_due);
                        $('#paying_amount').val(data.invoice.total_due);
                        $('#remaining_due').val(0);
                        $('td:nth-child(10)','#trid-'+data.invoice.id).html(data.invoice.total_paid);
                        $('td:nth-child(11)','#trid-'+data.invoice.id).html(data.invoice.total_due);
                        $('#paytrid-'+delete_id).hide();
                    });
                },
                error: function (err) {
                    var err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            });

        } else {
            swal(delete_swal_cancel_text);
        }
    })
});

$(document).on('click','#cancel_btn',function(e){
    let invoice_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'get/booking/cancel/data/' + invoice_id,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {

            $('#cancel_form #cpayment_invoice_id').val(data.invoice.id);
            $('#cancel_form #cpayable_amount').val(data.invoice.total_payable);
            $('#cancel_form #cpaid_amount').val(data.invoice.total_paid);
            $('#cancel_form #refund_service_charge').val(data.refund_sc_amount);
            $('#cancel_form #refund_amount').val(data.refund_amount);

            var number =data.invoice.id;
            var padded = number.toString().padStart(8, '0');
            console.log(padded);

            $('#cinvoice_id_append').empty().append(' #'+padded);

            if(parseFloat(data.refund_amount)<0){
                $('#append_if_due').removeClass('d-none');
                $('#cancel_form #cpaying_amount').val(Math.abs(parseFloat(data.refund_amount)));
            }else{
                $('#append_if_due').addClass('d-none');
            }



        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });
})

$(document).on('click','#send_cancel_otp_btn',function(e){
    $.ajax({
        type: "get",
        url: 'get/otp/'+"booking_cancellation/"+$('#cpayment_invoice_id').val(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#cancel_otp').val(data);
        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });
})
$(document).on('submit','#cancel_form',function(e){
    e.preventDefault();
    let invoice_id = $('#cpayment_invoice_id',this).val();
    var formData = $(this).serialize();
     swal({
        title: cancel_swal_title,
        text: cancel_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "put",
                url: 'post/booking/cancel/'+invoice_id,
                data: formData,
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        window.location.reload();
                    });
                },
                error: function (err) {
                    var err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            });

        } else {
            swal(cancelswal_cancel_text);
        }
    })
});


$(document).on('click','#checkout_btn',function(e){
    let invoice_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'get/booking/checkout/data/' + invoice_id,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {

            $('#checkout_form #chpayment_invoice_id').val(data.id);
            $('#checkout_form #chpayable_amount').val(data.total_payable);
            $('#checkout_form #chpaid_amount').val(data.total_paid);
            $('#checkout_form #chdue_amount').val(data.total_due);

            var number =data.id;
            var padded = number.toString().padStart(8, '0');
            console.log(padded);

            $('#chinvoice_id_append').empty().append(' #'+padded);

            if(parseFloat(data.total_due)>0){
                $('#append_if_chdue').removeClass('d-none');
                $('#checkout_form #chpaying_amount').val(Math.abs(parseFloat(data.total_due)));
            }else{
                $('#append_if_chdue').addClass('d-none');
            }



        },
        error: function (err) {
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    });
})


$(document).on('submit','#checkout_form',function(e){
    e.preventDefault();
    let invoice_id = $('#chpayment_invoice_id',this).val();
    var formData = $(this).serialize();
     swal({
        title: checkout_swal_title,
        text: checkout_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "put",
                url: 'post/booking/checkout/'+invoice_id,
                data: formData,
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        window.open(
                            base_url + 'admin/get/checkout/clearance/' + invoice_id,
                            '_blank'
                        );
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    });
                },
                error: function (err) {
                    var err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            });

        } else {
            swal(checkoutswal_cancel_text);
        }
    })
});

$(document).on('input','#chpenalty_amount',function(){
    let tot_amount = parseInt($('#checkout_form #chdue_amount').val())+parseInt($(this).val());
    $('#checkout_form #chpaying_amount').val(tot_amount);
})
