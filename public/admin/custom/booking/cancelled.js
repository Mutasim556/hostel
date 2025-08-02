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
        url: base_url+'admin/get/booking/payment/receipt/' + receipt,
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
