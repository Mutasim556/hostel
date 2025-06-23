$(document).on('change','#floor',function(){
    $.ajax({
        type: "get",
        url: 'get-floot-details/'+$('#hotel').val()+"/"+$(this).val()+"/"+$('#block').val(),
        success: function (data) {
            $('#room_number').val(data);
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

$(document).on('change','#block',function(){
    if($('#floor').val()!=''){
        $.ajax({
            type: "get",
            url: 'get-floot-details/'+$('#hotel').val()+"/"+$('#floor').val()+"/"+$('#block').val(),
            success: function (data) {
                $('#room_number').val(data);
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
    }

});
$(document).on('change','#is_full_room_bookable',function(){
    if($(this).is(':checked')){
       $('#append_max_price').show('slow');
       $('#append_min_price').show('slow');
    }else{
       $('#append_max_price').hide('slow');
       $('#append_min_price').hide('slow');
    }

});

$(document).on('change','#has_seats',function(){
    if($(this).is(':checked')){
       $('#append_total_seats').show('slow');
       $('#append_total_seats_button').show('slow');
    }else{
       $('#append_total_seats').hide('slow');
       $('#append_total_seats_button').hide('slow');
       $('#append_seat_div').hide('slow');
    }
});

$(document).on('click','#append_seats_btn',function(){
    $('#append_seat_div').show();
    $('#append_seat_div').empty()
    var divVal = ``;
    if($('#floor').val()==''){
        $.notify(
            '<strong>Please select floor first</strong>', {
            type: 'danger',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            placement: {
                from: 'top',
                align: 'right'
            },
            animate: {
                enter: 'animated rotateInDownLeft',
                exit: 'animated zoomOutDown'
            }
        });
    }else if($('#total_seats').val()=='' || $('#total_seats').val()<1){
        $('#total_seats').val('');
        $.notify(
            '<strong>Please enter valid seats number</strong>', {
            type: 'danger',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            placement: {
                from: 'top',
                align: 'right'
            },
            animate: {
                enter: 'animated rotateInDownLeft',
                exit: 'animated zoomOutDown'
            }
        });
    }else{
        for(i=1;i<=$('#total_seats').val();i++){
            divVal = divVal + `
                <div class="row py-2 mb-2" style="box-shadow: 0px 0px 5px grey;border-radius:10px">
                    <h5>Seat  ( <span id="append_seat_number">${$('#room_number').val()}</span> - ${i} )<button class="btn btn-sm btn-danger px-2 py-1" style="float:right" id="remove_btn">Remove</button></h5>
                    <div class="form-group col-md-12 col-xs-6 col-sm-6">
                        <hr>
                    </div>
                    <div class="form-group col-md-6 col-xs-6 col-sm-6">
                        <label for="">Seat Price</label>
                        <input type="text" class="form-control" id="seat_price" name="seat_price">
                    </div>
                    <div class="form-group col-md-6 col-xs-6 col-sm-6">
                        <label for="">Seat Min Price</label>
                        <input type="text" class="form-control" id="seat_min_price" name="seat_min_price">
                    </div>
                </div>
            `
        }
    }


    $('#append_seat_div').append(divVal).slow();
})

$(document).on("click",'#remove_btn',function(){
    // $(this).closest('.row').remove();

});
