$('#turn_on_btn').click(function () {
    var maintenance_code = Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000) + '-' + Math.floor(100000 + Math.random() * 900000);
    $('#turn_on_form #secret_code').val(maintenance_code);
});


$('#turn_on_form').on("submit", function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after + '....');
    $('button[type=submit]', this).addClass('disabled');
    swal({
        title: confirm_swal_title,
        text: confirm_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "post",
                url: form_url_on,
                data: $(this).serialize(),
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#turn_on_form .err-mgs').each(function(id,val){
                            $(this).prev('input').removeClass('border-danger is-invalid')
                            $(this).prev('textarea').removeClass('border-danger is-invalid')
                            $(this).empty();
                        })
                        window.location.reload();
                    });
                },
                error: function (err) {
                    $('button[type=submit]', '#turn_on_form').html('Submit');
                    $('button[type=submit]', '#turn_on_form').removeClass('disabled');
                    $('#turn_on_form .err-mgs').each(function (id, val) {
                        $(this).prev('input').removeClass('border-danger is-invalid')
                        $(this).prev('textarea').removeClass('border-danger is-invalid')
                        $(this).empty();
                    })
                    $.each(err.responseJSON.errors, function (idx, val) {
                        $('#turn_on_form #' + idx).addClass('border-danger is-invalid')
                        $('#turn_on_form #' + idx).next('.err-mgs').empty().append(val);
                    })
                }
            });

        } else {
            swal(confirm_swal_cancel_text).then(function () {
                $('button[type=submit]', '#turn_on_form').html(submit_btn_before);
                $('button[type=submit]', '#turn_on_form').removeClass('disabled');
            });
        }
    })
    
});

$(document).on('click','#delete_button',function(){
    var id = $(this).data('id');
    var tr = $(this).closest('tr');
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "GET",
                url: "secret-code/delete/"+id,
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        tr.remove();
                    });
                },
                error: function (err) {
                   
                }
            });

        } else {
            swal(delete_swal_cancel_text);
        }
    })
});

$(document).on('click','#delete_all_btn',function(){
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "GET",
                url: "secret-code/delete-all",
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                       window.location.reload();
                    });
                },
                error: function (err) {
                    swal(delete_swal_cancel_text);
                }
            });

        } else {
            swal(delete_swal_cancel_text);
        }
    })
});


