
$(document).on('change','#add_hostel_form #translate_autometic',function(){
    if($(this).is(':checked') && $('#add_hostel_form #hostel_name').val()){
        $.ajax({
            type: "get",
            url: translate_url,
            dataType: 'JSON',
            data : {'tdata':$('#add_hostel_form #hostel_name').val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

               $.each(data.langs,function(key,val){
                    $('#add_hostel_form #hostel_name_'+val.lang).val(data.tdata[key]);
               })
            },
            error: function (err) {
                if(err.status===403){
                    let err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    }).then(function(){
                        $('button[type=button]', '#add_hostel_form').click();
                    });

                }else{
                    let err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }

});


$(document).on('change','#edit_hostel_form #translate_autometic',function(){
    if($(this).is(':checked') && $('#edit_hostel_form #hostel_name').val()){
        $.ajax({
            type: "get",
            url: translate_url,
            dataType: 'JSON',
            data : {'tdata':$('#edit_hostel_form #hostel_name').val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

               $.each(data.langs,function(key,val){
                    $('#edit_hostel_form #hostel_name_'+val.lang).val(data.tdata[key]);
               })
            },
            error: function (err) {
                if(err.status===403){
                    let err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    }).then(function(){
                        $('button[type=button]', '#add_hostel_form').click();
                    });

                }else{
                    let err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    });
                }
            }
        });
    }

});

$('#add_hostel_form').submit(function (e) {
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
            $('button[type=submit]', '#add_hostel_form').html(submit_btn_before);
            $('button[type=submit]', '#add_hostel_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let data = rdata.hostel;
                console.log(data);
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    update_status_btn = `<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input
                    data-status="${data.status==0?1:0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-hostel-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                // let cat_image = data.hostel_image?'<img style="height: 50px;width:50px;" src="'+base_url+'/'+data.hostel_image+'">':no_file;

                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${data.hostel_name}</td><td>${data.hostel_type}</td><td>${data.hostel_phone}</td><td>${data.hostel_email}</td><td>${data.hostel_address}</td><td>${data.concern_person_name}</td><td>${data.concern_person_phone}</td><td>${data.concern_person_email}</td>
                <td class="text-center">${update_status_btn}</td>
                <td>${action_option}</td></tr>`);

                new Switchery($('#trid-'+data.id).find('input')[0], $('#trid-'+data.id).find('input').data());

                $('#add_hostel_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_hostel_form').trigger('reset');
                $('button[type=button]','#add_hostel_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_hostel_form').html(submit_btn_before);
            $('button[type=submit]', '#add_hostel_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_hostel_form').click();
                });

            }

            $('#add_hostel_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_hostel_form #'+idx).addClass('border-danger is-invalid')
                $('#add_hostel_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

$(document).on('click', '#edit_button', function () {
    $('#edit_hostel_form').trigger('reset');
    $('#edit_hostel_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'hostel/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
             $('#edit_hostel_form #hostel_id').val(data.id);
            $.each(data.translations,function(key,val){
                if(val.locale=='en'){
                    $('#edit_hostel_form #hostel_name').val(data.hostel_name);
                }else{
                    $('#edit_hostel_form #hostel_name_'+val.locale).val(val.value);
                }
            })
            
            $('#edit_hostel_form #hostel_type').val(data.hostel_type);
            $('#edit_hostel_form #hostel_phone').val(data.hostel_phone);
            $('#edit_hostel_form #hostel_email').val(data.hostel_email);
            $('#edit_hostel_form #hostel_address').val(data.hostel_address);
            $('#edit_hostel_form #hostel_address').val(data.hostel_address);
            $('#edit_hostel_form #concern_person_name').val(data.concern_person_name);
            $('#edit_hostel_form #concern_person_phone').val(data.concern_person_phone);
            $('#edit_hostel_form #concern_person_email').val(data.concern_person_email);

        },
        error: function (err) {
            if(err.status===403){
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_hostel_form').click();
                });

            }else{
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
        }
    });

});

$('#edit_hostel_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#hostel_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'hostel/' + $('#hostel_id','#edit_hostel_form').val(),
        data: formData,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_hostel_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_hostel_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.hostel.hostel_name);
            $('td:nth-child(2)',trid).html(data.hostel.hostel_type);
            $('td:nth-child(3)',trid).html(data.hostel.hostel_phone);
            $('td:nth-child(4)',trid).html(data.hostel.hostel_email);
            $('td:nth-child(5)',trid).html(data.hostel.hostel_address);
            $('td:nth-child(6)',trid).html(data.hostel.concern_person_name);
            $('td:nth-child(7)',trid).html(data.hostel.concern_person_email);
            $('td:nth-child(8)',trid).html(data.hostel.concern_person_phone);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_hostel_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_hostel_form').trigger('reset');
                $('button[type=button]', '#edit_hostel_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_hostel_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_hostel_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_hostel_form').click();
                });
                
            }

            $('#edit_hostel_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            
            $.each(err.responseJSON.errors,function(idx,val){
                
                $('#edit_hostel_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_hostel_form #'+idx).next('.err-mgs').empty().append(val);
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
        url: 'hostel/update/status/'+update_id+"/"+status,
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
                url: 'hostel/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Hostel deleted successfully',
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
