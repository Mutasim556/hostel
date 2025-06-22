//add role
$('#add_role_form').submit(function (e) {
    e.preventDefault();
    $('#add_role_form .err-mgs').each(function(id,val){ 
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    
    $.ajax({
        type: "post",
        url: form_url,
        data: $(this).serialize(), 
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (datam) {

            $('button[type=submit]', '#add_role_form').html('Submit');
            $('button[type=submit]', '#add_role_form').removeClass('disabled');
            let data = datam.role;
            // console.log(data);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'role create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#add_role_form').trigger('reset');
                $('#add_role_form #permission-switch').prop('checked',true).trigger('click');
                $('button[type=button]', '#add_role_form').click();
                let permission = [];
                $.each(datam.permissions,function(idx,val){
                    permission = permission+'<span class="badge badge-success">'+val.name+'</span>';
                });
                if(datam.hasAnyPermission){

                }
                let delete_option = '';
                let edit_option = '';
                let action_option = '';
                if(datam.hasEditPermission){
                    edit_option = `<button id="edit_button" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-role-modal" class="btn btn-primary px-2 py-1"><i class="fa fa-pencil-square-o"></i></button>`;
                }
                if(datam.hasDeletePermission){
                    delete_option = `<button id="delete_button" class="btn btn-danger px-2 py-1"><i class="fa fa-trash"></i></button>`;
                }
                if(datam.hasAnyPermission){
                    action_option = edit_option+" "+delete_option;
                }
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.id}</td>
                    <td>${data.name}</td>
                    <td>
                        ${permission.length>0?permission:'<span class="badge badge-danger">no permission</span>'}
                    </td>
                    <td>${action_option}</td>
                </tr>`)
                new Switchery($('#tr-'+data.id).find('input')[0], $('#tr-'+data.id).find('input').data());
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_role_form').html('Submit');
            $('button[type=submit]', '#add_role_form').removeClass('disabled');
            $('#add_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_role_form #'+idx).addClass('border-danger is-invalid') 
                $('#add_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

$(document).on('click','#edit_button',function(){
    let edit_id = $(this).closest('tr').data('id');
    $.ajax({
        method : 'get',
        url : 'role/'+edit_id+"/edit",
        success :function(data){
            $('#edit_role_form #role_name').val(data.role.name);
            $('#edit_role_form #role_id').val(data.role.id);
            $('#edit_role_form #edit_permission').empty();
            $.each(data.permissions,function(group,permission){
                let permissionList =[];
                $.each(permission,function(idx,item){
                    let check = '';
                    if(data.rolePermissions.includes(item.name)){
                        check = 'checked';
                    }
                    permissionList = permissionList+`<input data-status="" id="permission-switch" type="checkbox" data-toggle="switchery" data-color="green" data-secondary-color="red" data-size="small" value="${item.name}" name="permissions[]" ${check}/>
                    <span class="mx-2">${item.name}</span>`;
                })
                $('#edit_role_form #edit_permission').append(`
                <div class="col-lg-12 mt-4">
                    <label for="user_permission">${group}</label><br>
                    ${permissionList}
                </div>
            `);
            })
            $('#edit_role_form [data-toggle="switchery"]').each(function(idx, obj) {
                new Switchery($(this)[0], $(this).data());
            });
        },
        error : function(err){
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            var err_message = err.responseJSON.message.split("(");
            if(err.status===403){
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_role_form').click();
                });
                
            }
            $('#edit_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_role_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//update data
$('#edit_role_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#role_id', this).val();
    $.ajax({
        type: "put",
        url: 'role/' + $('#role_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.role.id);
            $('td:nth-child(2)',trid).html(data.role.name);
            let permission = [];
            $.each(data.rolePermissions,function(idx,val){
                permission = permission+'<span class="badge badge-success">'+val+'</span>';
            });

            $('td:nth-child(3)',trid).html(permission.length>0?permission:'<span class="badge badge-danger">no permission</span>');
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_role_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_role_form').trigger('reset');
                $('button[type=button]', '#edit_role_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_role_form').html('Submit');
            $('button[type=submit]', '#edit_role_form').removeClass('disabled');
            $('#edit_role_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_role_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_role_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});


//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this role",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'role/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmTextButton,
                    }).then(function () {
                        $('#tr-'+delete_id).hide(300,function(){$(this).remove()});
                    });
                },
                error: function (err) {
                    var err_message = err.responseJSON.message.split("(");
                    if(err.status===403){
                        swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err_message[0],
                            confirmButtonText: "Ok",
                        }).then(function(){
                            $('button[type=button]', '#edit_user_form').click();
                        });
                        
                    }else{
                        swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err_message[0],
                            confirmButtonText: "Ok",
                        });
                    }
                }
            });
           
        } else {
            swal("Delete request canceld successfully");
        }
    })
});

//specific permission
$('#add_specific_user_permission_form #user_id').change(function(){
    if($(this).val()==''){
        $('#add_specific_user_permission_form #role_and_permission').empty();
    }else{
        $('#add_specific_user_permission_form #role_and_permission').empty().append(getting_permission)
        $.ajax({
            method:'GET',
            url : 'role/get-user-permissions/'+$(this).val(),
            success : function(data){
                $('#add_specific_user_permission_form #role_and_permission').empty();
                $.each(data.permissions,function(group,permission){
                    let permissionList =[];
                    $.each(permission,function(idx,item){
                        let check = '';
                        console.log('');
                        if(data.userPermissions.includes(item.name)){
                            check = 'checked';
                        }
                        permissionList = permissionList+`<input data-status="" id="permission-switch" type="checkbox" data-toggle="switchery" data-color="green" data-secondary-color="red" data-size="small" value="${item.name}" name="permissions[]" ${check}/>
                        <span class="mx-2">${item.name}</span>`;
                    });
                    $('#add_specific_user_permission_form #role_and_permission').append(`
                        <div class="col-lg-12 mt-4">
                            <label for="user_permission">${group}</label><br>
                            ${permissionList}
                        </div>
                    `);
                });
                $('#add_specific_user_permission_form [data-toggle="switchery"]').each(function(idx, obj) {
                    new Switchery($(this)[0], $(this).data());
                });
            },
            error : function(err){

            }
        });
    }
});


$('#add_specific_user_permission_form').submit(function(e){
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');

    $.ajax({
        type: "post",
        url: 'role/give-user-permissions',
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#add_specific_user_permission_form').html(submit_btn_before);
            $('button[type=submit]', '#add_specific_user_permission_form').removeClass('disabled');
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmTextButton,
            }).then(function(){
                // $("#add_specific_user_permission_form .js-example-basic-single3").select2("val", "");
                $("#add_specific_user_permission_form .js-example-basic-single3").val('').trigger('change');
                $('#add_specific_user_permission_form').trigger('reset');
                $('button[type=button]', '#add_specific_user_permission_form').click();
            });
            
        },
        error : function (err){
            $('button[type=submit]', '#add_specific_user_permission_form').html(submit_btn_before);
            $('button[type=submit]', '#add_specific_user_permission_form').removeClass('disabled');

            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
            
            
        },
    });
});

