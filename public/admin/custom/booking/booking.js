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
                let seats = ``;
                $.each(val.seats,function(k,v){
                    seats = seats + ` <span class="badge badge-success p-2 mt-3" style="cursor:pointer">Seat ${v.seat_number}</span>`;
                })
                $('#append_room_div').after(`
                        <div class="col-md-4 p-3 rounded" style="box-shadow:0px 0px 10px grey">
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
