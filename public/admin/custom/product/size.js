$('#add_size_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
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
        success: function (data) {
            $('button[type=submit]', '#add_size_form').html('Submit');
            $('button[type=submit]', '#add_size_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'size create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function(){
                $('#basic-1 tbody').append(`<tr id="trid-${data.size_id}" data-id="${data.size_id}"><td>${data.size_name}</td><td class="text-center"><span class="mx-2">${data.size_status}</span><input
                data-status="Inactive"
                id="status_change" type="checkbox" data-toggle="switchery"
                data-color="green" data-secondary-color="red" data-size="small" checked /></td><td><div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content"> <a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-size-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a> <a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a> </div></div></td></tr>`);

                new Switchery($('#trid-'+data.size_id).find('input')[0], $('#trid-'+data.size_id).find('input').data());
                $('#add_size_form').trigger('reset');
                $('button[type=button]','#add_size_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_size_form').html('Submit');
            $('button[type=submit]', '#add_size_form').removeClass('disabled');
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
    $('#edit_size_form').trigger('reset');
    let size = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'size/' + size + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_size_form #size_id').val(data.size_id);
            $('#edit_size_form #size_name').val(data.size_name);
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
$('#edit_size_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#size_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'size/' + $('#size_id','#edit_size_form').val(),
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
            $('button[type=submit]', '#edit_size_form').html('Submit');
            $('button[type=submit]', '#edit_size_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.size_name);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'size data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_size_form').trigger('reset');
                $('button[type=button]', '#edit_size_form').click();
                

            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_size_form').html('Submit');
            $('button[type=submit]', '#edit_size_form').removeClass('disabled');
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
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'size/update/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.size_status}</span><input data-status="${data.size_status=='Active'?'Inactive':'Active'}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.size_status=='Active'?'checked':''} />`);
            // parent_td.children('input').each(function (idx, obj) {
            //     new Switchery($(this)[0], $(this).data());
            // });
            new Switchery(cat_td.find('input')[0], cat_td.find('input').data());
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
        text: "Once deleted, you will not be able to recover this size",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'size/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Size deleted successfully',
                        confirmButtonText: "Ok",
                    }).then(function () {
                        $('#trid-'+delete_id).hide();
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