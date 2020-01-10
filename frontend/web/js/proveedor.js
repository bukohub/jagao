$(document).ready(function () {
    var returning_banks = function(e){
        $.ajax({
            url: 'https://secure.payco.co/restpagos/pse/bancos.json?public_key=66a339b1ee142c7f2e67b7dc6ca9df9a',
            method: 'GET',
            success: function (data) {
               if(data){
                    $.map(data.data, function(value, key) {
                        if(value.bankCode!="0"){
                            return $( '#proveedor-banco').append(
                                $('<option/>',{'value':value.bankCode}).append(value.bankName)
                            );
                        }
                    });
               }
            }
        });
    }
    
    $('.inactivar').click(function(e){
        e.preventDefault();
        let $get_href = $(this).attr("data-trunc"); 
        $("input[name='id_prov_ina']").val($get_href);
        $('#ina_pro').modal('show');
    });

    $('#aceptar_ina').click(function(e){
        let $id_prov = $('input[name="id_prov_ina"]').val();
        let $observ  = $('textarea[name="observacion_ina"]').val();
        if($observ.length == 0){
            alert("Por favor, ingrese una descripción.");
            return;
        }
        location.href= `${url_}/proveedor/inactivar?id=${$id_prov}&observacion=${$observ}`;
    })
    
    returning_banks();
    
});