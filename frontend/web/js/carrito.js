$(document).ready(function () {

    $(document).ajaxStart(function () {
        $('#loading-screen').removeClass('hidden');
    });

    $(document).ajaxComplete(function () {
        $('#loading-screen').addClass('hidden');
        $('.btn-add-cart').attr('disabled',false).find('i').remove();
    });

    $("#modal,#modalsucess,#validation_cart").iziModal({
        title: 'Carrito Compras',
        subtitle: 'Mensaje de confirmación Jagao',
        headerColor:'#59B210'
    });
    $("#modalerror").iziModal({
        title: 'Carrito Compras',
        subtitle: 'Mensaje',
        headerColor: '#59B210'
    });
    $("#politicadatos").iziModal({
        title: 'Política de datos',
        subtitle: 'Aceptación de política de datos',
        headerColor: '#59B210'
    });

    /**
     * Eliminación al modificar el producto a 0.
     */
    $('.le-quantity a').click(function(e){
        e.preventDefault();
        var currentQty= $(this).parent().parent().find('input').val();
        if( $(this).hasClass('minus') && currentQty>0){
            let current = parseInt(currentQty, 10);
            $(this).parent().parent().find('input').val((current-1));
            if( (current - 1)  == 0){
                if(!$(this).hasClass('not_detail')){
                    var letting = deleting_cart(e,$(this).siblings('input').attr('data-refactory'));
                    if(!letting){
                        $(this).parent().parent().find('input').val((current));
                    }
                }                
            }else{
                $( ".change_cart" ).submit();
            }                    
        }else{
            if( $(this).hasClass('plus')){
                $(this).parent().parent().find('input').val(parseInt(currentQty, 10) + 1);
                $( ".change_cart" ).submit();
            }
        }
    });
    /**
     * Agregar productos al carrito
     */
    $('.cart').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url_+'/producto/agregar-carrito',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                try {
                    return ( !(typeof data.error === 'undefined') ) ?  show_error(data.error) : ($('.count').text(data.count),$('.value').text(data.tot),$('#modal').iziModal('open'));
                } catch (error) {
                    show_error('Ocurrió un error inesperado con la cantidad digitada. Contacte con el administrador.');
                }       
            }
        }).error(function(e){
            show_error('Ocurrió un error inesperado. Por favor, contacte con el administrador.');
        });
    });
    /**
     * Cambiar valores carrito de compra
     */
    $('.change_cart').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url_+'/producto/cambiar-carrito',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                try {
                  if( !(typeof data.error === 'undefined') ) {
                    show_error(data.error.text) 
                    var act_input = $('input[data-refactory="'+data.error.id+'"]').val();
                    $('input[data-refactory="'+data.error.id+'"]').val(parseInt(act_input, 10) - 1);
                  }else{
                    $.each(data.prop, function(i, item) {
                        $(`.price[data-protected='${item.key}']`).html(`COP $${item.cost}`);
                     });
                     $('.subtotal').html(`$${data.subtotal}`);
                     $('.total_cost').html(`$${data.total}`);
                     $('.shipping').html(`$${data.envio}`);
                  }
                } catch (error) {
                    show_error('Ocurrió un error inesperado con la cantidad digitada. Contacte con el administrador.');
                }                   
            }
        }).error(function(e){
            show_error('Ocurrió un error inesperado. Por favor, contacte con el administrador.');
        });
    });

    /**
     * Carrito en popup
     */
    $('.top-cart-holder').click (function(e){
        $.ajax({
            url: url_ +'/producto/mostrar-carrito',
            method: 'GET',
            success: function (data) {
                if(data.length > 0 ) $('.carrito').fadeIn(0);
                $( '.produts' ).html(
                    $.map(data, function(value, key) {
                        return $( '<li />').append(
                            $( '<div />', { 'class': 'basket-item' } ).append(
                                $( '<div />', { 'class': 'row' } ).append([
                                    $( '<div />', { 'class': 'col-xs-4 col-sm-4 no-margin text-center' } ).append( 
                                        $( '<div />', { 'class': 'thumb' } ).append(
                                            $('<img/>',{'src':`${value.descripcion}`}) 
                                        )
                                    ),
                                    $('<div/>',{'class':'col-xs-8 col-sm-8'}).append([
                                        $('<div/>',{'class':'title'}).html(`${value.nombre}`),
                                        $('<div/>',{'class':'price'}).html(`$${value.precio_pesos}`),
                                        $('<div/>',{'class':'brand'}).html(`<div class='color-brand' style='background-color:${value.color};'>Color: ${value.color}</div>Talla: ${value.talla}`)
                                    ])
                                ] )
                            )
                        )
                    })
                );
            }
        });
    });
    /**
     * Cuando se compra los prodcutos redirige pasarela
     */
    $('#pay_cart').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url_+'/informacion-compra/create',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                try {
                  if( !(typeof data.error === 'undefined') ) {
                    show_error('Ocurrió un error: <br>'+ data.error);
                  }else{
                    var handler = ePayco.checkout.configure({key: '8b360ceb3af898f41d1455eb21a4c084',test: true });
                    var data={
                        name: data.info.name,
                        description: data.info.description,
                        invoice: data.info.invoice,
                        currency: data.info.currency,
                        amount: data.info.amount,
                        tax_base: data.info.tax_base,
                        tax: data.info.tax,
                        country: data.info.country,
                        lang: data.info.lang,
                        external: data.info.external,
                        confirmation: data.info.confirmation,
                        response: data.info.response,
                        name_billing: data.info.name_billing,
                        number_doc_billing: data.info.number_doc_billing,
                        }
                        handler.open(data);
                  }
                } catch (error) {
                    show_error('Ocurrió un error inesperado con la cantidad digitada. Contacte con el administrador.');
                }                   
            }
        }).error(function(e){
            show_error('Ocurrió un error inesperado. Por favor, contacte con el administrador.');
        });
        
    });
    /**
     * Valida si usuario está logueado
     */
    $('.validate_user').click(function(e){
        e.preventDefault();
        $.ajax({
            url: url_ +'/producto/validate-user',
            method: 'GET',
            success: function (data) {
                if( !(typeof data.error === 'undefined') ) {
                    show_error(data.message);
                }else{
                    location.href= url_+'/checkout';
                }
            }
        });  
    });

    $(document).on('click', '.close-btn', function (e) {
        e.preventDefault();
        var boton = $(this);
        var idProducto = boton.attr("data-trucate");
        deleting_cart(e, idProducto);
    });

    $('.qty-text').change(function () {
        var cantidad = $(this);
        var idProducto = $(this).parent().parent().parent().children().last().children().children().first().val();
        var valorTotal = $(this).parent().parent().next().children();
        $.ajax({
            url: url_+'/producto/actualizar-producto?idProducto=' + idProducto +'&cantidad='+cantidad.val(),
            method: 'POST',
            data: {},
            success: function (data) {
                toastr.success('¡Producto actualizado con éxito!');
                valorTotal.text(data);
//                    setTimeout(function () {
//                        location.reload();
//                    }, 2000);
            }
        });
    });

    $('.qty-up-detalle').click(function(){
        var valorActual = $('.input-cantidad-detalle').val();
        console.log(valorActual);
        if(valorActual == ''){
            $('.input-cantidad-detalle').val(1);
        }else{
            $('.input-cantidad-detalle').val(valorActual++);
        }
        
    })
    
    var show_error = function (message){
        $('#data_error').html(message); $('#modalerror').iziModal('open');
        $('.bi').attr("disabled",false).find('i').remove();
    }
    
    var show_sucess = function (message){
        $('#data_success').html(message);$('#modalsucess').iziModal('open');
        $('.bi').attr("disabled",false).find('i').remove();
    }

    var deleting_cart = function (e, idProducto){
        $('#validation_cart').iziModal('open');
        $('#data_refact').html("¿Realmente deseas eliminar este producto de tu carrito de compras?");
        $('#refactory').val(idProducto);   
    }

    var truncate_product = function(e){
        let $get_id_pro  = $('#refactory').val();
        $.ajax({
            url: '../producto/eliminar-producto?idProducto=' + $get_id_pro,
            method: 'POST',
            data: {},
            success: function (data) {
                show_sucess('¡Producto eliminado con éxito!');
                location.reload();
            }
        }); 
    } 
    
    document.getElementById("aceptar-delete").addEventListener("click", truncate_product);
});