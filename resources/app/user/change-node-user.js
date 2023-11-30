// $(document).on('submit', 'form#form-update-role-nodo', function (event) {
//     $('button[type="submit"]').attr('disabled', 'disabled');
//     event.preventDefault();
//     var form = $(this);
//     var data = new FormData($(this)[0]);
//     var url = form.attr("action");
//     $.ajax({
//         type: form.attr('method'),
//         url: url,
//         data: data,
//         cache: false,
//         contentType: false,
//         dataType: 'json',
//         processData: false,
//         success: function (data) {

//             $('button[type="submit"]').removeAttr('disabled');
//             $('button[type="submit"]').prop("disabled", false);
//             $('.error').hide();
//             if (data.fail) {
//                 for (control in data.errors) {
//                     $('#' + control + '-error').html(data.errors[control]);
//                     $('#' + control + '-error').show();
//                 }
//             }
//             if (data.state == 'error' && data.url == false)
//             {
//                 Swal.fire({
//                     title: 'El Usuario no se ha modificado, por favor inténtalo de nuevo',
//                     text: "Recuerde que si lo elimina no lo podrá recuperar.",
//                     icon: 'warning',
//                     text: data.message,
//                     showCancelButton: true,
//                     confirmButtonColor: '#3085d6',
//                     cancelButtonColor: '#d33',
//                     confirmButtonText: 'ok',
//                     cancelButtonText: 'Ver actividades sin finalzar',
//                 }).then((result) => {
//                     if (result.value) {

//                     }else if ( result.dismiss === Swal.DismissReason.cancel ) {
//                         let activitiesFinalizar ="";
//                         $.each( data.activities, function( key, val ) {
//                             activitiesFinalizar += '</br><b> ' + key + ' - ' + val + ' </b> ';
//                         });
//                         Swal.fire({
//                             title: 'actividades sin finalzar',
//                             html: activitiesFinalizar,
//                             icon: 'info',
//                             showCancelButton: false,
//                             confirmButtonColor: '#3085d6',
//                             confirmButtonText: 'Ok'
//                         });

//                     }
//                 })
//             }
//             if (data.state == 'success' && data.url != false) {
//                 Swal.fire({
//                     title: 'Modifciación Exitosa',
//                     text: `El Usuario `+data.user.nombres+ ` ` +data.user.apellidos+`  ha sido modificado satisfactoriamente`,
//                     icon: 'success',
//                     showCancelButton: false,
//                     confirmButtonColor: '#3085d6',
//                     confirmButtonText: 'Ok'
//                 });
//                 setTimeout(function(){
//                     window.location.href = data.url;
//                 }, 1000);
//             }
//         },
//         error: function (xhr, textStatus, errorThrown) {
//             alert("Error: " + errorThrown);
//         },
//     });
// });

$(document).on('submit', 'form#form-update-role-nodo', function (event) {
    // $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");

    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        success: function (response) {
            $('button[type="submit"]').removeAttr('disabled');
            $('.error').hide();
            printErrorsForm(response.data);
            if(!response.data.fail){

                Swal.fire({
                    title: 'Modifciación Exitosa',
                    text: `Cuenta de usuario actualizada exitosamente.`,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });

                setTimeout(function () {
                    window.location.href = response.data.url;
                }, 1000);
            }else{
                Swal.fire({
                    title: 'Modifciación Errónea',
                    text: `Cuenta de usuario no actualizada, por favor intente nuevamente.`,
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            $('button[type="submit"]').removeAttr('disabled');
            alert("Error: " + errorThrown);
        }
    });
});

function printErrorsForm(data) {
    if (data.fail) {
        let errores = "";
        for (control in data.errors) {
            errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
        }
    }
}
