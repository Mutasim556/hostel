//add speciality
$('#add_speciality_form').submit(function (e) {
    e.preventDefault();
    $('#add_speciality_form .err-mgs').each(function(id,val){
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
        success: function (data) {
            $('button[type=submit]', '#add_speciality_form').html('Submit');
            $('button[type=submit]', '#add_speciality_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Speciality create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#add_speciality_form').trigger('reset');
                $('button[type=button]', '#add_speciality_form').click();
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.speciality}</td>
                    <td class="text-center">
                        <span class="mx-2">${data.speciality_status}</span><input
                            data-status="${data.speciality_status == 'Active' ? 'Inactive' : 'Active'}"
                            id="status_change" type="checkbox" data-toggle="switchery"
                            data-color="green" data-secondary-color="red" data-size="small"
                            ${data.speciality_status == 'Active' ? 'checked' : ''} />
                    </td>
                    <td>
                        <div class="dropdown">
                            <button
                                class="btn btn-info text-white px-2 py-1 dropbtn">Action
                                <i class="fa fa-angle-down"></i></button>
                            <div class="dropdown-content">
                                <a data-bs-toggle="modal" style="cursor: pointer;"
                                    data-bs-target="#edit-speciality-modal" class="text-primary"
                                    id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>

                                <a class="text-danger" id="delete_button"
                                    style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                    Delete</a>
                            </div>
                        </div>

                    </td>
                </tr>`)
                new Switchery($('#tr-'+data.id).find('input')[0], $('#tr-'+data.id).find('input').data());
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_speciality_form').html('Submit');
            $('button[type=submit]', '#add_speciality_form').removeClass('disabled');
            $('#add_speciality_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_speciality_form #'+idx).addClass('border-danger is-invalid')
                $('#add_speciality_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var parent_td = $(this).parent();
    parent_td.empty().append(`<div class="loader-box"><div class="loader-35"></div></div>`);
    $.ajax({
        type: "get",
        url: 'speciality/update/status/'+update_id+"/"+status,
        success: function (data) {
            console.log(data);
            parent_td.empty().append(`<span class="mx-2">${data.speciality_status}</span><input data-status="${data.speciality_status=='Active'?'Inactive':'Active'}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.speciality_status=='Active'?'checked':''} />`);
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

// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_speciality_form').trigger('reset');
    $('#edit_speciality_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let speciality_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'speciality/' + speciality_id + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_speciality_form #speciality_id').val(data.id);
            $('#edit_speciality_form #speciality').val(data.speciality);
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

//update data
$('#edit_speciality_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#speciality_id', this).val();
    $.ajax({
        type: "put",
        url: 'speciality/' + $('#speciality_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_speciality_form').html('Submit');
            $('button[type=submit]', '#edit_speciality_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.speciality);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'speciality data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_speciality_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_speciality_form').trigger('reset');
                $('button[type=button]', '#edit_speciality_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_speciality_form').html('Submit');
            $('button[type=submit]', '#edit_speciality_form').removeClass('disabled');
            $('#edit_speciality_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_speciality_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_speciality_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});


//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this speciality",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'speciality/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Speciality deleted successfully',
                        confirmButtonText: "Ok",
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
