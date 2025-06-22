// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_user_form').trigger('reset');
    let user_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'user/' + user_id + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_user_form #user_id').val(data.user.id);
            $('#edit_user_form #user_name').val(data.user.name);
            $('#edit_user_form #username').val(data.user.username);
            $('#edit_user_form #user_role').val(data.role);
            $('#edit_user_form #user_email').val(data.user.email);
            $('#edit_user_form #user_phone').val(data.user.phone);
        },
        error: function (err) {
            // console.log('Hello');
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

})

//update data
$('#edit_user_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#user_id', this).val();
    $.ajax({
        type: "put",
        url: 'user/' + $('#user_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#edit_user_form').html('Submit');
            $('button[type=submit]', '#edit_user_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.user.name);
            $('td:nth-child(2)',trid).html(data.user.email);
            $('td:nth-child(3)',trid).html(data.user.phone);
            $('td:nth-child(4)',trid).html(data.user.username);
            $('td:nth-child(5)',trid).html(data.role);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_user_form').trigger('reset');
                $('button[type=button]', '#edit_user_form').click();


            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_user_form').html('Submit');
            $('button[type=submit]', '#edit_user_form').removeClass('disabled');
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

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var parent_td = $(this).parent();
    // console.log(update_id);
    // console.log(status);
    parent_td.empty().append(`<div class="loader-box"><div class="loader-35"></div></div>`);
    $.ajax({
        type: "GET",
        url: 'user/update/status/'+update_id+"/"+status,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(update_id);
            parent_td.empty().append(`<span class="mx-2">${data.status==1?'Active':'Inactive'}</span><input data-status="${data.status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`);
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
//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this user",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'user/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#tr-'+delete_id).remove();
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


