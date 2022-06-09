var roleUserSession = {
    setRoleSession:function (role) {
        let nameRole = $(role).val();
        let nombre = $("#change-role option:selected").val();
        $.ajax({
            dataType:'json',
            type:'POST',
            data: {
        	    'role': nombre,
        	    '_token'  : $('meta[name="csrf-token"]').attr('content'),
            },
            url: host_url+'/cambiar-role'
        }).done(function(response){
        	if (response.role != null) {
        		location.href= response.url;
        	}else{
        		Swal.fire('Error!', 'Por favor, cierre sesión y vuelve a ingresar al sistema!', 'error');
        	}
      }); 
   }
};

