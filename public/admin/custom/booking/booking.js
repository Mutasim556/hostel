$(document).on('change','#hostel',function(){
    $.ajax({
        type:'get',
        url : base_url+'/admin/seats/'+$(this).val()+'-hostel',
        success : function (data){
            if(data.buildings.length>0){
                $('#building').prop('disabled',false);
                var building = `<option value="">Select Please</option>`;

                $.each(data.buildings,function(key,val){
                    building = building + `<option value="${val.id}">${val.building_number}</option>`
                });

                $('#building').empty().append(building);
            }else{
                $('#building').prop('disabled',true);
                 var floor = `<option value="">Select Please</option>`;
                $.each(data.floors,function(key,val){val
                    floor = floor + `<option value="${val.floor}">${val.floor}</option>`
                })

                $('#floor').empty().append(floor);
            }


        }
    })
});

$(document).on('change','#building',function(){
    $.ajax({
        type:'get',
        url : base_url+'/admin/seats/'+$(this).val()+'-building',
        success : function (data){
            var floor = `<option value="">Select Please</option>`;
            $.each(data.floors,function(key,val){val
                floor = floor + `<option value="${val.floor}">${val.floor}</option>`
            })

            $('#floor').empty().append(floor);
        }
    })
});

$('#search_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(search_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: search_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#search_form').html(search_btn_before);
            $('button[type=submit]', '#search_form').removeClass('disabled');
            $('#append_room_div_main .col-md-4').each(function() {
                $(this).remove();
            });


            $.each(data,function(key,val){
                $('#append_room_div').show('slow');
                $('#room_card_body').show('slow');
                let seats = ``;
                $.each(val.seats,function(k,v){
                    seats = seats + ` <span class="badge badge-success p-2 mt-3" style="cursor:pointer" data-hostel="${val.hostel_id}" data-building="${val.building_id}" data-floor="${val.floor}" data-block="${val.block}" data-room-id="${val.id}" data-seat-number="${v.seat_number}" data-id="${v.id}" data-seat-min-price="${v.seat_minimum_price}" data-seat-max-price="${v.seat_maximum_price}" data-seat-service-charge="${v.service_charge}" id="booking_seats" >Seat ${v.seat_number}</span>`;
                })
                $('#append_room_div').after(`
                        <div class="col-md-4 p-3 mx-2 rounded" style="box-shadow:0px 0px 10px grey">
                            <h5>Block: ${val.block}</h5>
                            <h5>Room Number : ${val.room_number}</h5>
                            ${seats}
                        </div>
                    `);


            })
        },
        error: function (err) {
            $('button[type=submit]', '#search_form').html(search_btn_before);
            $('button[type=submit]', '#search_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#search_form').click();
                });

            }

            $('#search_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#search_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');

                $('#search_form #'+exp).addClass('border-danger is-invalid')
                $('#search_form #'+exp2).addClass('border-danger is-invalid')
                $('#search_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#search_form #'+exp).next('.err-mgs').empty().append(val);

                $('#search_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});

$(document).on('click','#booking_seats',function(){

    if ($(this).hasClass('selectedClass')) {
        $(this).removeClass('selectedClass');
    }else{
        $(this).addClass('selectedClass');
    }

    if($('.selectedClass','#append_room_div_main').length){
        $('#book_now_btn').prop('disabled',false);
    }else{
        $('#book_now_btn').prop('disabled',true);
    }
})
$(document).on('click','#book_now_btn',function(){
    $('#append_hidden_inputs').empty();
    $('#append_booking_seats').empty();
    var seat_max_price = 0;
    var seat_service_charge = 0;
    $('.selectedClass','#append_room_div_main').each(function(){
        seat_max_price = parseFloat(seat_max_price + parseFloat($(this).data('seat-max-price')))
        seat_service_charge = parseFloat(seat_service_charge + parseFloat($(this).data('seat-service-charge')))
        $('#append_hidden_inputs').append(`
            <input type="hidden" id="h_hostel" name="h_hostel[]" value="${$(this).data('hostel')}">
            <input type="hidden" id="h_building" name="h_building[]" value="${$(this).data('building')}">
            <input type="hidden" id="h_floor" name="h_floor[]" value="${$(this).data('floor')}">
            <input type="hidden" id="h_room_id" name="h_room_id[]" value="${$(this).data('room-id')}">
            <input type="hidden" id="h_seat_id" name="h_seat_id[]" value="${$(this).data('id')}">
        `);
        $('#append_booking_seats').append(`
            <div class="col-lg-3 mt-2">
                <input type="text" name="booking_seat_number[]" class="form-control" value="${$(this).data('seat-number')}" readonly>
            </div>
        `);
    })
    if($('#booking_type').val()=='day'){
        $('#booking_start_date').val($('#start_date').val());
        $('#booking_end_date').val($('#end_date').val());
        $('#booking_total_days').val($('#total_days').val());


        $('#booking_total_price').val(parseFloat(seat_max_price*parseInt($('#total_days').val())));
        $('#booking_total_service_charge').val(seat_service_charge);
        $('#booking_total_payable').val(parseFloat(seat_service_charge+parseFloat(seat_max_price*parseInt($('#total_days').val()))));
        var total_payable_amount = parseFloat(seat_service_charge+parseFloat(seat_max_price*parseInt($('#total_days').val())));

    }

})
$(document).on('input','#booking_total_discount',function(){
    $('#booking_total_payable').val(parseFloat( $('#booking_total_price').val())-parseFloat($(this).val()));
    $('#booking_total_due').val((parseFloat( $('#booking_total_price').val())-parseFloat($(this).val()))-parseFloat($('#booking_total_paid').val()));
})
$(document).on('input','#booking_total_paid',function(){
    $('#booking_total_due').val((parseFloat( $('#booking_total_price').val())-parseFloat($('#booking_total_discount').val()))-parseFloat($(this).val()));
})
$('#add_booking_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: form_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            $('button[type=submit]', '#add_booking_form').html(submit_btn_before);
            $('button[type=submit]', '#add_booking_form').removeClass('disabled');
            // $('#append_room_div_main .col-md-4').each(function() {
            //     $(this).remove();
            // });

            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                 window.location.href =base_url+'/admin/get/booking/invoices/'+rdata.bookingI.id;

            });

        },
        error: function (err) {
            $('button[type=submit]', '#add_booking_form').html(submit_btn_before);
            $('button[type=submit]', '#add_booking_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_booking_form').click();
                });

            }

            $('#add_booking_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_booking_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');

                $('#add_booking_form #'+exp).addClass('border-danger is-invalid')
                $('#add_booking_form #'+exp2).addClass('border-danger is-invalid')
                $('#add_booking_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#add_booking_form #'+exp).next('.err-mgs').empty().append(val);

                $('#add_booking_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});

