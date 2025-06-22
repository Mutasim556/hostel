$('#add_category_form').submit(function (e) {
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
            $('button[type=submit]', '#add_category_form').html('Submit');
            $('button[type=submit]', '#add_category_form').removeClass('disabled');
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Parent category create suvccessfully',
                confirmButtonText: "Ok",
            }).then(function(){
                let cat_image = data.category_image?'<img src="/'+data.category_image+'">':"No File";
                $('#basic-1 tbody').append(`<tr id="trid-${data.category_id}" data-id="${data.category_id}"><td>${data.category_name}</td><td>${data.category_parent_category_id?data.parent_category_name:'N/A'}</td><td>${cat_image}</td><td>${data.name}</td><td class="text-center"><span class="mx-2">${data.category_status}</span><input
                data-status="Inactive"
                id="status_change" type="checkbox" data-toggle="switchery"
                data-color="green" data-secondary-color="red" data-size="small" checked /></td><td><div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content"> <a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a> <a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a> </div></div></td></tr>`);

                new Switchery($('#trid-'+data.category_id).find('input')[0], $('#trid-'+data.category_id).find('input').data());
                $('#add_category_form').trigger('reset');
                $('button[type=button]','#add_category_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_category_form').html('Submit');
            $('button[type=submit]', '#add_category_form').removeClass('disabled');
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
    $('#edit_category_form').trigger('reset');
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'category/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_category_form #category_id').val(data.category_id);
            $('#edit_category_form #category_name').val(data.category_name);
            $('#edit_category_form #parent_category').val(data.category_parent_category_id);
            $('#edit_category_form #parent_category').trigger('change');
            if(data.category_image==''){
                $('#edit_category_form #image_preview').empty().append(`No Image`);
            }else{
                $('#edit_category_form #image_preview').empty().append(`<img src="/${data.category_image}">`);
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
$('#edit_category_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#category_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'category/' + $('#category_id','#edit_category_form').val(),
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
            $('button[type=submit]', '#edit_category_form').html('Submit');
            $('button[type=submit]', '#edit_category_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.category_name);
            $('td:nth-child(2)',trid).html(data.category_parent_category_id?data.parent_category_name:'N/A');
            $('td:nth-child(3)',trid).html(data.category_image?`<img src="/${data.category_image}">`:'No Image');
            $('td:nth-child(4)',trid).html(data.name);
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'User data updated suvccessfully',
                confirmButtonText: "Ok",
            }).then(function () {
                $('#edit_category_form').trigger('reset');
                $('button[type=button]', '#edit_category_form').click();
                

            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_category_form').html('Submit');
            $('button[type=submit]', '#edit_category_form').removeClass('disabled');
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
        url: 'category/update/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.category_status}</span><input data-status="${data.category_status=='Active'?'Inactive':'Active'}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.category_status=='Active'?'checked':''} />`);
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
        text: "Once deleted, you will not be able to recover this category",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'category/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Category deleted successfully',
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