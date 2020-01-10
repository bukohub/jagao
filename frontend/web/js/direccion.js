$(document).ready(function () {
    
    $('#id_pais').change(function () {
        obtenerValorSelectPais();
    });
    $('#id_depto').change(function () {
        obtenerValorSelectDepto();
    });
    
    function obtenerValorSelectPais() {
        if ($('#id_pais').val() != '') {
            $('#id_depto').removeAttr('disabled');
            $('#id_depto').children().remove();
            cargaSelectDepartamento($('#id_pais').val());
        } else {
            $('#id_depto').attr('disabled', 'disabled');
        }
    }
    function obtenerValorSelectDepto() {
        if ($('#id_depto').val() != '') {
            $('#id_ciudad').removeAttr('disabled');
            $('#id_ciudad').children().remove();
            cargaSelectCiudad($('#id_depto').val());
        } else {
            $('#id_ciudad').attr('disabled', 'disabled');
        }
    }

    function cargaSelectDepartamento(id) {
        console.log(id);
        $.ajax({
            url: url_+'/direccion-cliente/listado-departamento?idPais=' + id,
            method: 'POST',
            data: {},
            success: function (data) {
                 $('#id_depto').append("<option value=''>Seleccione un departamento</option>");
                $('#id_depto').append(data);
            }

        });
    }
    function cargaSelectCiudad(id) {
        $.ajax({
            url: url_+'/direccion-cliente/listado-ciudad?idDepto=' + id,
            method: 'POST',
            data: {},
            success: function (data) {
                $('#id_ciudad').append("<option value=''>Seleccione una ciudad</option>");
                $('#id_ciudad').append(data);
            }

        });
    }
});