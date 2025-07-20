
$('#add_user_form').submit(function (e) {
    e.preventDefault();
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
            let data = datam.user;
            $('button[type=submit]', '#add_user_form').html('Submit');
            $('button[type=submit]', '#add_user_form').removeClass('disabled');
            swal({
                icon: "success",
                title: datam.title,
                text: datam.text,
                confirmButtonText: datam.confirmButtonText,
            }).then(function () {
                $('#add_user_form').trigger('reset');
                $('button[type=button]', '#add_user_form').click();
                let change_status = `<span class="badge badge-danger">No Permission</span>`;
                if(datam.role==='Super Admin'){
                    change_status = `<span class="badge badge-danger">Not Changeable</span>`;
                }
                let editButton = ''; 
                if(datam.hasEditPermission){
                    change_status = `<span class="mx-2">${data.status==1?'Active':'Inactive'}</span><input
                    data-status="${data.status == 1 ? 0 : 1}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small"
                    ${data.status == 1 ? 'checked' : ''} />`;
                    editButton = `<a data-bs-toggle="modal" style="cursor: pointer;"
                    data-bs-target="#edit-user-modal" class="text-primary"
                    id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                }
                if(datam.role==='Super Admin'){
                    change_status = `<span class="badge badge-danger">Not Changeable</span>`;
                }
                let deleteButton = ''; 
                if(datam.hasDeletePermission){
                    deleteButton = `<a class="text-danger" id="delete_button"
                    style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                    Delete</a>`;
                }
                let dropdownButton = '<span class="badge badge-danger">No Permission</span>';
                if(datam.hasAnyPermission){
                    dropdownButton = `<div class="dropdown">
                                        <button
                                            class="btn btn-info text-white px-2 py-1 dropbtn">Action
                                            <i class="fa fa-angle-down"></i></button>
                                        <div class="dropdown-content">
                                        ${editButton}
                                        ${deleteButton}
                                        </div>
                                    </div>`
                }
                $('#basic-1 tbody').append(`<tr id="tr-${data.id}" data-id="${data.id}">
                    <td>${data.name}</td>
                    <td>${data.email}</td>
                    <td>${data.phone}</td>
                    <td>${data.username}</td>
                    <td>
                        ${datam.role}
                    </td>
                    <td class="text-center">
                        ${change_status}
                    </td>
                    <td>${dropdownButton}</td>
                </tr>`)
                new Switchery($('#tr-'+data.id).find('input')[0], $('#tr-'+data.id).find('input').data());
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_user_form').html('Submit');
            $('button[type=submit]', '#add_user_form').removeClass('disabled');
            var err_message = err.responseJSON.message.split("(");
            swal({
                icon: "warning",
                title: "Warning !",
                text: err_message[0],
                confirmButtonText:"Ok",
            });
        }
    });
})
