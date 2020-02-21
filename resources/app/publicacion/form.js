$('#txtcontenido').summernote({
  lang: 'es-ES',
  height: 300
});

$('#txtfecha_inicio').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});

$('#txtfecha_fin').bootstrapMaterialDatePicker({
  time:false,
  date:true,
  shortTime:true,
  format: 'YYYY-MM-DD',
  // minDate : new Date(),
  language: 'es',
  weekStart : 1, cancelText : 'Cancelar',
  okText: 'Guardar'
});
