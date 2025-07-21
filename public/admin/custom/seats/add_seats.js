$(document).on('change','#add_seat_form #hostel',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-hostel',
        success : function (data){
            if(data.buildings.length>0){
                $('#add_seat_form #building').prop('disabled',false);
                var building = `<option value="">Select Please</option>`;

                $.each(data.buildings,function(key,val){
                    building = building + `<option value="${val.id}">${val.building_number}</option>`
                });

                $('#add_seat_form #building').empty().append(building);
            }else{
                $('#add_seat_form #building').prop('disabled',true);
                 var floor = `<option value="">Select Please</option>`;
                $.each(data.floors,function(key,val){val
                    floor = floor + `<option value="${val.floor}">${val.floor}</option>`
                })

                $('#add_seat_form #floor').empty().append(floor);
            }


        }
    })
});

$(document).on('change','#edit_seat_form #hostel',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-hostel',
        success : function (data){
            if(data.buildings.length>0){
                $('#edit_seat_form #building').prop('disabled',false);
                var building = `<option value="">Select Please</option>`;

                $.each(data.buildings,function(key,val){
                    building = building + `<option value="${val.id}">${val.building_number}</option>`
                });

                $('#edit_seat_form #building').empty().append(building);
            }else{
                $('#edit_seat_form #building').prop('disabled',true);
                 var floor = `<option value="">Select Please</option>`;
                $.each(data.floors,function(key,val){val
                    floor = floor + `<option value="${val.floor}">${val.floor}</option>`
                })

                $('#edit_seat_form #floor').empty().append(floor);
            }


        }
    })
});

$(document).on('change','#add_seat_form #building',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-building',
        success : function (data){
            var floor = `<option value="">Select Please</option>`;
            $.each(data.floors,function(key,val){val
                floor = floor + `<option value="${val.floor}">${val.floor}</option>`
            })

            $('#add_seat_form #floor').empty().append(floor);
        }
    })
});

$(document).on('change','#edit_seat_form #building',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-building',
        success : function (data){
            var floor = `<option value="">Select Please</option>`;
            $.each(data.floors,function(key,val){val
                floor = floor + `<option value="${val.floor}">${val.floor}</option>`
            })

            $('#edit_seat_form #floor').empty().append(floor);
        }
    })
});

$(document).on('change','#add_seat_form #floor',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-floor-'+$('#add_seat_form #hostel').val()+"-"+$('#add_seat_form #building').val(),
        success : function (data){
            if(data.blocks.length>0){
                $('#add_seat_form #block').prop('disabled',false);
                var block = `<option value="">Select Please</option>`;
                $.each(data.blocks,function(key,val){val
                    block = block + `<option value="${val.block}">${val.block}</option>`
                })

                $('#add_seat_form #block').empty().append(block);
            }else{
                $('#add_seat_form #room').prop('disabled',true);
                var room = `<option value="">Select Please</option>`;
                $.each(data.rooms,function(key,val){val
                room = room + `<option value="${val.id}">${val.room_number}</option>`
                })

                $('#add_seat_form #room').empty().append(room);
            }

        }
    })
})

$(document).on('change','#edit_seat_form #floor',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-floor-'+$('#edit_seat_form #hostel').val()+"-"+$('#edit_seat_form #building').val(),
        success : function (data){
            if(data.blocks.length>0){
                $('#edit_seat_form #block').prop('disabled',false);
                var block = `<option value="">Select Please</option>`;
                $.each(data.blocks,function(key,val){val
                    block = block + `<option value="${val.block}">${val.block}</option>`
                })

                $('#edit_seat_form #block').empty().append(block);
            }else{
                $('#edit_seat_form #room').prop('disabled',true);
                var room = `<option value="">Select Please</option>`;
                $.each(data.rooms,function(key,val){val
                room = room + `<option value="${val.id}">${val.room_number}</option>`
                })

                $('#edit_seat_form #room').empty().append(room);
            }

        }
    })
})

$(document).on('change','#add_seat_form #block',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-block-'+$('#add_seat_form #hostel').val()+"-"+$('#add_seat_form #building').val()+"-"+$('#add_seat_form #floor').val(),
        success : function (data){
            var room = `<option value="">Select Please</option>`;
            $.each(data.rooms,function(key,val){val
            room = room + `<option value="${val.id}">${val.room_number+"-"+val.block}( ${val.room_type} )</option>`
            })

            $('#add_seat_form #room').empty().append(room);
        }
    })
});

$(document).on('change','#edit_seat_form #block',function(){
    $.ajax({
        type:'get',
        url : ''+$(this).val()+'-block-'+$('#edit_seat_form #hostel').val()+"-"+$('#edit_seat_form #building').val()+"-"+$('#edit_seat_form #floor').val(),
        success : function (data){
            var room = `<option value="">Select Please</option>`;
            $.each(data.rooms,function(key,val){val
            room = room + `<option value="${val.id}">${val.room_number+"-"+val.block}( ${val.room_type} )</option>`
            })

            $('#edit_seat_form #room').empty().append(room);
        }
    })
});

$('#add_seat_form').submit(function (e) {
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
            $('button[type=submit]', '#add_seat_form').html(submit_btn_before);
            $('button[type=submit]', '#add_seat_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                 $('#add_seat_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).prev('span').find('.select2-selection--single').attr('id','')
                    $(this).empty();
                 })

            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_seat_form').html(submit_btn_before);
            $('button[type=submit]', '#add_seat_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_seat_form').click();
                });

            }

            $('#add_seat_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_seat_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');

                $('#add_seat_form #'+exp).addClass('border-danger is-invalid')
                $('#add_seat_form #'+exp2).addClass('border-danger is-invalid')
                $('#add_seat_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#add_seat_form #'+exp).next('.err-mgs').empty().append(val);

                $('#add_seat_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});

$('#edit_seat_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(update_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: baseUrl+'/admin/seats/'+$('#edit_seat_form #room').val(),
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            $('button[type=submit]', '#edit_seat_form').html(update_btn_before);
            $('button[type=submit]', '#edit_seat_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                 $('#edit_seat_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).prev('span').find('.select2-selection--single').attr('id','')
                    $(this).empty();
                 })

            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_seat_form').html(update_btn_before);
            $('button[type=submit]', '#edit_seat_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_seat_form').click();
                });

            }

            $('#edit_seat_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#add_seat_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');

                $('#edit_seat_form #'+exp).addClass('border-danger is-invalid')
                $('#edit_seat_form #'+exp2).addClass('border-danger is-invalid')
                $('#edit_seat_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#edit_seat_form #'+exp).next('.err-mgs').empty().append(val);

                $('#edit_seat_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});
