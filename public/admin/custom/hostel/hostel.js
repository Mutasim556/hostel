
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