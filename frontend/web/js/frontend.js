$(document).ready(function () {

    $('.menos-modal').click(function () {
        var cantidadActual = $(this).next().val();
        if (cantidadActual > 1) {
            $(this).next().val(cantidadActual - 1);
        }
    });
    $('.mas-modal').click(function () {
        var cantidadActual = $(this).prev().val();
        $(this).prev().val(parseInt(cantidadActual) + parseInt(1));
    });
    
    
    $('#select-tall-color').change(function(){
        var color =$($($($('#select-tall-color option:selected')[0])[0]['attributes'])[1]).val();
        if(color == 'No Aplica'){
            $('#icono-color').attr('style','color:transparent; font-size:35px;')
        }else{
            $('#icono-color').attr('style','color:'+color+'; font-size:35px;')
        }
       
    })
});