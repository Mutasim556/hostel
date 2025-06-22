function getTransData(form,tid){
    $.ajax({
        type: "get",
        url: translate_url,
        dataType: 'JSON',
        data : {'tdata':$('#'+form+' #'+tid).val()},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
           
           $.each(data.langs,function(key,val){
                $('#'+form+' #'+tid+'_'+val.lang).val(data.tdata[key]);
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
                    $('button[type=button]', '#'+form).click();
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

$(document).ready(function(){
    $('#name').val('English');
    $('#slug').val('en');
    getTransData('add_language_form','name')
})
$('#add_language_form #language').change(function(){
    $('#add_language_form #name').val($('#add_language_form #language option:selected').text());
    $('#add_language_form #slug').val($(this).val());
    getTransData('add_language_form','name')
    
});
$('#edit_language_form #language').change(function(){
    $('#edit_language_form #name').val($('#edit_language_form #language option:selected').text());
    $('#edit_language_form #slug').val($(this).val());
    getTransData('edit_language_form','name')
});

//add language
$('#add_language_form').submit(function (e) {
    e.preventDefault();
    $('#add_language_form .err-mgs').each(function(id,val){
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
        success: function (res) {
            $('button[type=submit]', '#add_language_form').html('Submit');
            $('button[type=submit]', '#add_language_form').removeClass('disabled');
            swal({
                icon: "success",
                title: res.title,
                text: res.text,
                confirmButtonText: res.confirmButtonText,
                timer: 1500,
            }).then(function () {
                // $('#add_language_form').trigger('reset');
                let data = res.language;

                let lang_status = `<span class="badge badge-danger">No Permision</span>`;
                if(res.hasEditPermission){
                    lang_status = ` <span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input
                    data-status="${data.status == 1 ? 0 : 1}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small"
                    ${data.status == 1 ? 'checked' : ''} />`;
                }
                let lang_edit = '';
                let lang_delete = '';
                let lang_action = `<span class="badge badge-danger">No Permision</span>`;
                if(res.hasEditPermission){
                    lang_edit = ` <a data-bs-toggle="modal" style="cursor: pointer;"
                    data-bs-target="#edit-language-modal" class="text-primary"
                    id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                }
                if(res.hasDeletePermission){
                    lang_delete = ` <a class="text-danger" id="delete_button"
                    style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                    Delete</a>`;
                }
                if(res.hasAnyPermission){
                    lang_action = `<div class="dropdown">
                        <button
                            class="btn btn-info text-white px-2 py-1 dropbtn">Action
                            <i class="fa fa-angle-down"></i></button>
                        <div class="dropdown-content">
                            ${lang_edit}

                            ${lang_delete}
                        </div>
                    </div>`;
                }

                $('button[type=button]', '#add_language_form').click();
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.name}</td>
                    <td>${data.slug}</td>
                    <td>${data.default==1?'<span class="badge badge-success">Yes</span>':'<span class="badge badge-danger">No</span>'}</td>
                    <td class="text-center">
                       ${lang_status}
                    </td>
                    <td class="text-center">
                        ${lang_action}
                    </td>
                </tr>`)
                new Switchery($('#tr-'+data.id).find('input')[0], $('#tr-'+data.id).find('input').data());
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_language_form').html('Submit');
            $('button[type=submit]', '#add_language_form').removeClass('disabled');
            $('#add_language_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_language_form #'+idx).addClass('border-danger is-invalid')
                $('#add_language_form #'+idx).next('.err-mgs').empty().append(val);
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
        url: 'language/update/status/'+update_id+"/"+status,
        success: function (data) {
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

// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_language_form').trigger('reset');
    $('#edit_language_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let language_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'language/' + language_id + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_language_form #language_id').val(data.id);
            $('#edit_language_form #language').val(data.lang).trigger('change');
            $('#edit_language_form #name').val(data.name);
            $('#edit_language_form #slug').val(data.slug);
            if(data.default==1){
                // console.log($('#edit_language_form #defalut').prop('checked'));
                $('#edit_language_form #default').prop('checked',true);
            }else{
                $('#edit_language_form #default').prop('checked',false);
            }
            if(data.status==1){
                $('#edit_language_form #status').prop('checked',true);
            }else{
                $('#edit_language_form #status').prop('checked',false);
            }

        },
        error: function (err) {
            $('#edit_language_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_language_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_language_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });

});


//update data
$('#edit_language_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#language_id', this).val();
    $.ajax({
        type: "put",
        url: 'language/' + $('#language_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_language_form').html('Submit');
            $('button[type=submit]', '#edit_language_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.language_name);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
                timer: 1500,
            }).then(function () {
                $('td:nth-child(1)',trid).html(data.name);
                $('td:nth-child(2)',trid).html(data.slug);
                $('td:nth-child(3)',trid).html(`${data.default==1?'<span class="badge badge-success">Yes</span>':'<span class="badge badge-danger">No</span>'}`);
                $('#edit_language_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                // $('#edit_language_form').trigger('reset');
                $('button[type=button]', '#edit_language_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_language_form').html('Submit');
            $('button[type=submit]', '#edit_language_form').removeClass('disabled');
            $('#edit_language_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_language_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_language_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});



//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this language",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'language/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: "Congratulations !",
                        text: 'Language deleted successfully',
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



