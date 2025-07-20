$('#edit_room_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: baseUrl+'/admin/rooms/update/'+$('#room_id').val(),
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (rdata) {
            $('button[type=submit]', '#edit_room_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_room_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                 $('#edit_room_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).prev('span').find('.select2-selection--single').attr('id','')
                    $(this).empty();
                 })
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_room_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_room_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_room_form').click();
                });

            }

            $('#edit_room_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id','')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                // console.log('#edit_room_form #'+idx);
                var exp = idx.replace('.','_');
                var exp2 = exp.replace('_0','');

                $('#edit_room_form #'+exp).addClass('border-danger is-invalid')
                $('#edit_room_form #'+exp2).addClass('border-danger is-invalid')
                $('#edit_room_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                $('#edit_room_form #'+exp).next('.err-mgs').empty().append(val);

                $('#edit_room_form #'+exp+"_err").empty().append(val);
            })
        }
    });
});

$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var parent_td = $(this).parent();
    parent_td.empty().append(`<div class="loader-box"><div class="loader-35"></div></div>`);
    $.ajax({
        type: "get",
        url: 'rooms/update/status/'+update_id+"/"+status,
        success: function (data) {
            console.log(data);
            parent_td.empty().append(`<span class="mx-2">${data.status==1?'Active':'Inactive'}</span><input data-status="${data.status=='1'?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status=='1'?'checked':''} />`);
            new Switchery(parent_td.find('input')[0], parent_td.find('input').data());
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
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this hostel",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'rooms/delete/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Room deleted successfully',
                        confirmButtonText: "Ok",
                    }).then(function () {
                        $('#trid-'+delete_id).remove();
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
            swal("Delete request canceld successfully");
        }
    })
});
