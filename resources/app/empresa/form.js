var EmpresaCreate = {
    getCiudad: function() {
      let id;
      id = $('#txtdepartamento_empresa').val();
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/getciudad/' + id
      }).done(function(response) {
        $('#txtciudad_id_empresa').empty();
        $('#txtciudad_id_empresa').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          // console.log(e.id);
          $('#txtciudad_id_empresa').append('<option  value="' + e.id + '">' + e.nombre + '</option>');
        })
        $('#txtciudad_id_empresa').material_select();
      });
    },
  }