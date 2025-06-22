//add chamber
$('#add_chamber_form').submit(function (e) {
    e.preventDefault();
    $('#add_chamber_form .err-mgs').each(function(id,val){
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
            $('button[type=submit]', '#add_chamber_form').html('Submit');
            $('button[type=submit]', '#add_chamber_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'chamber create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#add_chamber_form').trigger('reset');
                $('button[type=button]', '#add_chamber_form').click();
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.chamber_name}</td>
                    <td>${data.chamber_phone}</td>
                    <td>${data.chamber_address}</td>
                    <td class="text-center">
                        <span class="mx-2">${data.chamber_status}</span><input
                            data-status="${data.chamber_status == 'Active' ? 'Inactive' : 'Active'}"
                            id="status_change" type="checkbox" data-toggle="switchery"
                            data-color="green" data-secondary-color="red" data-size="small"
                            ${data.chamber_status == 'Active' ? 'checked' : ''} />
                    </td>
                    <td>
                        <div class="dropdown">
                            <button
                                class="btn btn-info text-white px-2 py-1 dropbtn">Action
                                <i class="fa fa-angle-down"></i></button>
                            <div class="dropdown-content">
                                <a data-bs-toggle="modal" style="cursor: pointer;"
                                    data-bs-target="#edit-chamber-modal" class="text-primary"
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
            $('button[type=submit]', '#add_chamber_form').html('Submit');
            $('button[type=submit]', '#add_chamber_form').removeClass('disabled');
            $('#add_chamber_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_chamber_form #'+idx).addClass('border-danger is-invalid')
                $('#add_chamber_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
})

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var parent_td = $(this).parent();
    parent_td.empty().append(`<div class="loader-box"><div class="loader-35"></div></div>`);
    $.ajax({
        type: "get",
        url: 'chamber/update/status/'+update_id+"/"+status,
        success: function (data) {
            parent_td.empty().append(`<span class="mx-2">${data.chamber_status}</span><input data-status="${data.chamber_status=='Active'?'Inactive':'Active'}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.chamber_status=='Active'?'checked':''} />`);
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
    $('#edit_chamber_form').trigger('reset');
    $('#edit_chamber_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let chamber_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'chamber/' + chamber_id + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_chamber_form #chamber_id').val(data.id);
            $('#edit_chamber_form #chamber_name').val(data.chamber_name);
            $('#edit_chamber_form #chamber_phone').val(data.chamber_phone);
            $('#edit_chamber_form #chamber_address').val(data.chamber_address);
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
$('#edit_chamber_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#chamber_id', this).val();
    $.ajax({
        type: "put",
        url: 'chamber/' + $('#chamber_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_chamber_form').html('Submit');
            $('button[type=submit]', '#edit_chamber_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.chamber_name);
            $('td:nth-child(2)',trid).html(data.chamber_phone);
            $('td:nth-child(3)',trid).html(data.chamber_address);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'chamber data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_chamber_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_chamber_form').trigger('reset');
                $('button[type=button]', '#edit_chamber_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_chamber_form').html('Submit');
            $('button[type=submit]', '#edit_chamber_form').removeClass('disabled');
            $('#edit_chamber_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_chamber_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_chamber_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this chamber",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'chamber/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Chamber deleted successfully',
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