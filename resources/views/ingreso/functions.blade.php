@push('script')
<script>
  consultarIngresosDeUnNodo({{request()->user()->getNodoUser()}});
  $('#filter_ingresos').click(function() {
    let nodo = "{{request()->user()->getNodoUser()}}";
    if (nodo == null) {
      nodo = $('#filter_nodo_ingresos').val();
    }
    consultarIngresosDeUnNodo(nodo);
  });
  $('#download_excel_visitas').click(function(){
    let nodo = "{{request()->user()->getNodoUser()}}";
    let start_date = $('#txtstart_date_ingresos').val();
    let end_date = $('#txtend_date_ingresos').val();
    if (nodo == "") {
      nodo = $('#filter_nodo_ingresos').val();
    }
    
    let query = {
      nodo: nodo,
      start_date: start_date,
      end_date: end_date
    }
    let url = host_url + "/ingreso/export?" + $.param(query)
    window.location = url;
});
</script>
@endpush