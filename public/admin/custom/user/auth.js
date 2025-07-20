function countDown() {
    var timer2 = sessionStorage.getItem('count_down');
    var interval = setInterval(function function1() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0 ) {
            sessionStorage.removeItem('count_down');
            $('button[type=submit]', '#forget_password_form').removeClass('disabled');
            $('.countdown').html('');
            clearInterval(interval);
        }
        
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.countdown').html("You can send email after "+minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
        if(minutes >= 0){
            sessionStorage.setItem('count_down',timer2);
        }else{
            $('.countdown').html('');
        }
    }, 1000);
}

$(document).ready(function(){
    if( sessionStorage.getItem('count_down')){
        $('button[type=submit]', '#forget_password_form').addClass('disabled');
        countDown();
    }
})
$(document).on('submit', '#forget_password_form', function (e) {
    e.preventDefault();
    
    if(!sessionStorage.getItem('count_down')){
        $('button[type=submit]', this).html(`${wait_mgs}....`);
        $('button[type=submit]', this).addClass('disabled');
        $.ajax({
            type: "post",
            url: 'forget-password',
            data: $(this).serialize(),
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('button[type=submit]', '#forget_password_form').html(reset);
                sessionStorage.setItem("count_down","01:01")
                countDown();
                swal({
                    icon: "success",
                    title: data.title,
                    text: data.text,
                    confirmButtonText: data.confirmButtonText,
                }).then(function () {
                    $('#forget_password_form').trigger('reset');
                })
            },
            error: function (err) {
                console.log(err);
                $('#forget_password_form .err-mgs').each(function (id, val) {
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $.each(err.responseJSON.errors, function (idx, val) {
                    console.log(val);
                    $('#forget_password_form #' + idx).addClass('border-danger is-invalid')
                    $('#forget_password_form #' + idx).next('.err-mgs').empty().append(val);
                })
                $('button[type=submit]', '#forget_password_form').html(reset);
                $('button[type=submit]', '#forget_password_form').removeClass('disabled');
            }
        })
    }
    
})