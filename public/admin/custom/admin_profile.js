$('#trigger_user_basic_edit').on("click", function () {
    if (document.getElementById('user_basic_edit').style.display == 'none') {
        // document.getElementById('user_basic_edit').style.display = 'block';
        $('#user_basic_edit').show(300);
        document.getElementById('trigger_user_basic_edit').classList.remove("fa-pen-square");
        document.getElementById('trigger_user_basic_edit').classList.add("fa-minus-square");
        document.getElementById('trigger_user_basic_edit').style.color = 'red';
    } else {
        // document.getElementById('user_basic_edit').style.display = 'none';
        $('#user_basic_edit').fadeOut(300);
        document.getElementById('trigger_user_basic_edit').classList.remove("fa-minus-square");
        document.getElementById('trigger_user_basic_edit').classList.add("fa-pen-square");
        document.getElementById('trigger_user_basic_edit').style.color = '';
    }


    // alert(style)
});

$('#update_basic_info_form').on("submit", function (e) {
    e.preventDefault();
    $('#update_basic_info_button').addClass('disabled');
    $('#update_basic_info_button').html('Updating profile info ......');
    $.ajax({
        type: 'POST',
        url: 'update-basic-info',
        data: $(this).serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'JSON',
        success: function (data) {
            $('#update_basic_info_button').removeClass('disabled');
            $('#update_basic_info_button').html('Update profile Info');
            console.log(data);
            $('input[name=user_name]').val(data.name);
            $('input[name=user_email]').val(data.email);
            $('input[name=user_phone]').val(data.phone);
            $('input[name=username]').val(data.username);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Profile data updated successfully',
                confirmButtonText: "Ok",
            })
        },
        error: function (err) {
            $('#update_basic_info_button').removeClass('disabled');
            $('#update_basic_info_button').html('Update profile Info');
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    })
});

$('#change_password_form').on("submit", function (e) {
    e.preventDefault();
    $('#update_password_button').addClass('disabled');
    $('#update_password_button').html('Updating password ......');
    $.ajax({
        type: 'POST',
        url: 'update-password',
        data: $(this).serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: 'JSON',
        success: function (data) {
            $('#update_password_button').removeClass('disabled');
            $('#update_password_button').html('Change Password');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Password changed successfully',
                confirmButtonText: "Ok",
            }).then(() => {
                $("#change_password_form").trigger("reset");
            })
        },
        error: function (err) {
            $('#update_password_button').removeClass('disabled');
            $('#update_password_button').html('Change Password');
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText: "Ok",
            });
        }
    })
});