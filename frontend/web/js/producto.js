$(document).ready(function () {
   
    $(document).on('click', '.try', function () {
        alert("hola");
    });
    $('.btn-eliminar-imagen').click(function (e) {
        e.preventDefault();
        var btn = $(this);
        var valor = $(this).attr('id-imagen');
        $.ajax({
            url: 'producto/eliminar-imagen-segundaria?idImagen=' + valor,
            method: 'POST',
            data: {},
            success: function (data) {
                if (data) {
                    btn.parent().parent().parent().remove();
                    toastr.success('Imagen eliminada');
                } else {
                    toastr.error('Ocurrio un error al momento de la eliminación, contactese con los\n\
                                    administradores.');
                }
            }
        });

    });

    $(document).on('click', '.not_color', function () {
        $(this).parent().parent().find('input').val('No Aplica');
        $(this).parent().parent().find('.sp-preview-inner').css('background-color','transparent');
    });

    $('.btn-guardar').click(function () {

        var nombre = $('#producto-nombre').val();
        var cantidad = 0;
        var descripcion   = $('#producto-descripcion').val();
        var categorias    = $('#producto-subcategorias').select2('data');        
        let category      = categorias.map(a => a.text).toString();
        var cantidadStock = $("input[name*='[cantidad]']").map((e, i) => cantidad += parseInt(i.value || 0 ));
        var precioPesos = $('#precio-pesos-disp').val();
        $('.nombre').text(nombre);
        $('.descripcion').text(descripcion);
        $('.categorias').text(category);
        $('.cantidad').text(cantidad);
        $('.pesos').text(precioPesos);
    });
    mostrarRowRopa();
    function mostrarRowRopa() {
        if ($('#producto-es_ropa_calzado').val() != '') {
            if ($('#producto-es_ropa_calzado').val() == 1) {
                $('.es_ropa').removeClass('hidden');
                $('.no_es_ropa').addClass('hidden');
            }
            if ($('#producto-es_ropa_calzado').val() == 0) {
                $('.no_es_ropa').removeClass('hidden');
                $('.es_ropa').addClass('hidden');
            }
        }

    }
    $('#producto-es_ropa_calzado').change(function () {
        mostrarRowRopa();
    });
    $('input:radio[name="Producto[aplica_envio]"]').change(
        function(){
            if ($(this).is(':checked') && $(this).val() == '1') {
                $('.envio_').fadeIn(100);
            }else{
                $('.envio_').fadeOut(100);
            }
    });

    /**
     * Transformación de pesos colombianos a estadounidenses.
     */
   /* $('#precio-pesos-disp,#precio-dolares-disp').keyup(function(e){
        try {
            let get_money = parseInt($(this).inputmask('unmaskedvalue'));
            let set_value = 'COP';
            let key       = '2304|1SWK5YeDx*YJtq*OUHVGHqvNiw6fQG7z';
            let pre       = $(this).attr("id") =='precio-pesos-disp';
            if(get_money!=0){
                $.ajax({
                    type: 'GET',
                    dataType: 'jsonp',
                    crossDomain: true, 
                    jsonpCallback: 'callback',
                    url: `https://api.cambio.today/v1/quotes/USD/${set_value}/jsonp?quantity=${get_money}&key=${key}`
                }).done(function(e){
                    return pre ? $('#precio-dolares-disp').val((get_money/e.result.value)) : $('#precio-pesos-disp').val((get_money*e.result.value));
                });
            }
        } catch (error) {
            console.log(error);
        }
    });*/

});