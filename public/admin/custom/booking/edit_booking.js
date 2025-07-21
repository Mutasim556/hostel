
function calculate(){
    let total_price = parseFloat($('#booking_total_price').val());
    let total_discount = parseFloat($('#booking_total_discount').val());
    let total_service_cahrge = parseFloat($('#booking_total_service_charge').val());
    let total_payable = parseFloat((total_price-total_discount)+total_service_cahrge);
    let total_paid = parseFloat($('#booking_total_paid').val());
    let total_due = parseFloat(total_payable-total_paid);

    $('#booking_total_payable').val(total_payable);
    $('#booking_total_due').val(total_due);
}
$(document).on('change','#booking_service_type',function(){
    if($(this).val()!=''){
        $.ajax({
            type:'get',
            url : base_url+'/admin/seats/get/service/type/charge/'+$(this).val()+"/"+$('#booking_total_days').val()+"/"+total_booking_rooms,
            success : function (data){
                $('#booking_total_price').val(data);
                calculate();
            }
        })
    }
})