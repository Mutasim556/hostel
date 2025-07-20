$('#add_parent_category_form').submit(function (e) {
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
            $('button[type=submit]', '#add_parent_category_form').html('Submit');
            $('button[type=submit]', '#add_parent_category_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Parent category create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function(){
                let par_image = data.parent_category_image?'<img src="/'+data.parent_category_image+'">':"No File";
                $('#basic-1 tbody').append(`<tr id="trid-${data.parent_category_id}" data-id="${data.parent_category_id}"><td>${data.parent_category_name}</td><td>${par_image}</td><td>${data.name}</td><td class="text-center"><span class="mx-2">${data.parent_category_status}</span><input
                data-status="Inactive"
                id="status_change" type="checkbox" data-toggle="switchery"
                data-color="green" data-secondary-color="red" data-size="small" checked /></td><td><div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content"> <a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-parent-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a> <a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a> </div></div></td></tr>`);

                new Switchery($('#trid-'+data.parent_category_id).find('input')[0], $('#trid-'+data.parent_category_id).find('input').data());
                $('#add_parent_category_form').trigger('reset');
                $('button[type=button]','#add_parent_category_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_parent_category_form').html('Submit');
            $('button[type=submit]', '#add_parent_category_form').removeClass('disabled');
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
    $('#edit_parent_category_form').trigger('reset');
    let parent_cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'parent-category/' + parent_cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_parent_category_form #parent_category_id').val(data.parent_category_id);
            $('#edit_parent_category_form #parent_category_name').val(data.parent_category_name);
            if(data.parent_category_image==''){
                $('#edit_parent_category_form #image_preview').empty().append(`No Image`);
            }else{
                $('#edit_parent_category_form #image_preview').empty().append(`<img src="/${data.parent_category_image}">`);
            }
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
$('#edit_parent_category_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#parent_category_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'parent-category/' + $('#parent_category_id','#edit_parent_category_form').val(),
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
            $('button[type=submit]', '#edit_parent_category_form').html('Submit');
            $('button[type=submit]', '#edit_parent_category_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.parent_category_name);
            $('td:nth-child(2)',trid).html(data.parent_category_image?`<img src="/${data.parent_category_image}">`:'No Image');
            $('td:nth-child(3)',trid).html(data.name);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'User data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_parent_category_form').trigger('reset');
                $('button[type=button]', '#edit_parent_category_form').click();
                

            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_parent_category_form').html('Submit');
            $('button[type=submit]', '#edit_parent_category_form').removeClass('disabled');
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
    parent_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'parent_category/update/status/'+update_id+"/"+status,
        success: function (data) {
            parent_td.empty().append(`<span class="mx-2">${data.parent_category_status}</span><input data-status="${data.parent_category_status=='Active'?'Inactive':'Active'}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.parent_category_status=='Active'?'checked':''} />`);
            // parent_td.children('input').each(function (idx, obj) {
            //     new Switchery($(this)[0], $(this).data());
            // });
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
        text: "Once deleted, you will not be able to recover this parent category",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'parent-category/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Parent category deleted successfully',
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