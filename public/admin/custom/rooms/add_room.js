// $(document).on('change','#floor',function(){
//     if($('#floor').val()!=''){
//         $.ajax({
//             type: "get",
//             url: 'get-floot-details/'+$('#hotel').val()+"/"+$(this).val()+"/"+$('#block').val(),
//             success: function (data) {
//                 $('#room_number').val(data);
//             },
//             error: function (err) {
//                 var err_message = err.responseJSON.message.split("(");
//                 swal({
//                     icon: "warning",
//                     title: "Warning !",
//                     text: err_message[0],
//                     confirmButtonText: "Ok",
//                 });
//             }
//         });
//     }
// });

$(document).on('change','#has_multiple_block',function(){
    if($(this).is(':checked')){
        $('#append_block_room_div').show('slow');
        $('#append_wblock_room_div').hide('slow');

        $('#room_number','#append_block_room_div').prop('disabled',false);
        $('#block','#append_block_room_div').prop('disabled',false);
        $('#room_type','#append_block_room_div').prop('disabled',false);
        $('#room_dimension','#append_block_room_div').prop('disabled',false);

        $('#room_number','#append_wblock_room_div').prop('disabled',true);
        $('#room_type','#append_wblock_room_div').prop('disabled',true);
        $('#room_dimension','#append_wblock_room_div').prop('disabled',true);
    }else{
        $('#append_block_room_div').hide('slow');
        $('#append_wblock_room_div').show('slow');

        $('#room_number','#append_wblock_room_div').prop('disabled',false);
        $('#room_type','#append_wblock_room_div').prop('disabled',false);
        $('#room_dimension','#append_wblock_room_div').prop('disabled',false);

        $('#room_number','#append_block_room_div').prop('disabled',true);
        $('#block','#append_block_room_div').prop('disabled',true);
        $('#room_type','#append_block_room_div').prop('disabled',true);
        $('#room_dimension','#append_block_room_div').prop('disabled',true);
    }
});
$(document).on('change','#is_full_room_bookable',function(){
    if($(this).is(':checked')){
       $('#append_max_price').show('slow');
       $('#append_min_price').show('slow');
    //    $('#has_seats_div').hide('slow');
    }else{
       $('#append_max_price').hide('slow');
       $('#append_min_price').hide('slow');
    //    $('#has_seats_div').show('slow');
    }

});

// $(document).on('change','#has_seats',function(){
//     if($(this).is(':checked')){
//        $('#append_total_seats').show('slow');
//        $('#append_total_seats_button').show('slow');
//     }else{
//        $('#append_total_seats').hide('slow');
//        $('#append_total_seats_button').hide('slow');
//        $('#append_seat_div').hide('slow');
//     }
// });

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
                    <h5>Seat  ( <span id="append_seat_number">${$('#room_number').val()}-${i}</span> )<button type="button" class="btn btn-sm btn-danger px-2 py-1" style="float:right" id="remove_btn">Remove</button></h5>
                    <div class="form-group col-md-12 col-xs-6 col-sm-6">
                        <hr>
                    </div>
                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                        <label for="">Seat Number</label>
                        <input type="text" class="form-control" id="seat_number" name="seat_number[]" value="${$('#room_number').val()}-${i}" readonly>
                        <span class="text-danger err-mgs" id="seat_number_0_err"></span>
                    </div>
                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                        <label for="">Seat Price</label>
                        <input type="text" class="form-control" id="seat_price" name="seat_price[]">
                        <span class="text-danger err-mgs" id="seat_price_0_err"></span>
                    </div>
                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                        <label for="">Seat Min Price</label>
                        <input type="text" class="form-control" id="seat_min_price" name="seat_min_price[]">
                        <span class="text-danger err-mgs" id="seat_min_price_0_err"></span>
                    </div>
                </div>
            `
        }
    }


    $('#append_seat_div').append(divVal).slow();
})

$(document).on("click",'#remove_btn',function(){
    $(this).closest('.row').remove();
    $('#append_seat_div .row').each(function(key,val){
        $('#append_seat_number',this).empty().append(`
            ${$('#room_number').val()}-${key+1}
        `);
        $('#seat_number',this).val(`${$('#room_number').val()}-${key+1}`);
    })
});


$('#add_room_form').submit(function (e) {
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
            $('button[type=submit]', '#add_room_form').html(submit_btn_before);
            $('button[type=submit]', '#add_room_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                 $('#add_room_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).prev('span').find('.select2-selection--single').attr('id','')
                    $(this).empty();
                 })
                 $('#append_max_price').hide('slow');
                 $('#append_min_price').hide('slow');
                 $('#append_block_room_div').hide('slow');
                $('#append_wblock_room_div').show('slow');

                $('#room_number','#append_wblock_room_div').prop('disabled',false);
                $('#room_type','#append_wblock_room_div').prop('disabled',false);
                $('#room_dimension','#append_wblock_room_div').prop('disabled',false);

                $('#room_number','#append_block_room_div').prop('disabled',true);
                $('#block','#append_block_room_div').prop('disabled',true);
                $('#room_type','#append_block_room_div').prop('disabled',true);
                $('#room_dimension','#append_block_room_div').prop('disabled',true);
                 $('#add_room_form')[0].reset();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_room_form').html(submit_btn_before);
            $('button[type=submit]', '#add_room_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_room_form').click();
                });
                
            }

            $('#add_room_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_room_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');
                
                $('#add_room_form #'+exp).addClass('border-danger is-invalid')
                $('#add_room_form #'+exp2).addClass('border-danger is-invalid')
                $('#add_room_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#add_room_form #'+exp).next('.err-mgs').empty().append(val);

                $('#add_room_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});

// $(document).on('click','#add_another_room_btn',function(){
//             if($('#has_multiple_block').is(':checked')){
//                 // alert('sdfdsdsf');
//                 $('#append_wblock_room_div').empty();
//                 $('#append_block_room_div').append(`
//                     <div class="row">
//                         <div class="form-group col-md-3 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Number') }}</label>
//                             <input type="text" class="form-control" id="room_number" name="room_number[]"  placeholder="{{ __('admin_local.Example') }} : 101">
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                         <div class="form-group col-md-3 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Block') }}</label>
//                             <select class="form-control" id="block" name="block[]">
//                                 <option value="">{{ __('admin_local.Select Please') }}</option>  
//                                 <option value="A">A</option>  
//                                 <option value="B">B</option>  
//                                 <option value="C">C</option>  
//                                 <option value="D">D</option>  
//                                 <option value="E">E</option>  
//                             </select>
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                         <div class="form-group col-md-3 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Type') }} *</label>
//                             <select class="form-control" name="room_type[]" id="room_type">
//                                 <option value="">{{ __('admin_local.Select Please') }}</option>
//                                 <option value="AC">{{ __('admin_local.AC') }}</option>
//                                 <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
//                             </select>
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                         <div class="form-group col-md-3 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Dimension') }} (sqf)</label>
//                             <input type="text" class="form-control" id="room_dimension" name="room_dimension[]" placeholder="{{ __('admin_local.Example') }} : 1200">
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                     </div>
//                 `);
//             }else{
//                 $('#append_block_room_div .row').each(function(k,v){
//                     $(this).remove();
//                 })
//                 $('#append_wblock_room_div').append(`
//                     <div class="row">
//                         <div class="form-group col-md-4 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Number') }}</label>
//                             <input type="text" class="form-control" id="room_number" name="room_number[]"  placeholder="{{ __('admin_local.Example') }} : 101">
//                             <span class="text-danger err-mgs"></span>
//                         </div>
                        
//                         <div class="form-group col-md-4 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Type') }} *</label>
//                             <select class="form-control" name="room_type[]" id="room_type">
//                                 <option value="">{{ __('admin_local.Select Please') }}</option>
//                                 <option value="AC">{{ __('admin_local.AC') }}</option>
//                                 <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
//                             </select>
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                         <div class="form-group col-md-4 col-xs-6 col-sm-6">
//                             <label for="">{{ __('admin_local.Room Dimension') }} (sqf)</label>
//                             <input type="text" class="form-control" id="room_dimension" name="room_dimension[]" placeholder="{{ __('admin_local.Example') }} : 1200">
//                             <span class="text-danger err-mgs"></span>
//                         </div>
//                     </div>
//                 `)
// }});