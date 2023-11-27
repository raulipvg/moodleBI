// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl
$("#curso-detalle-1").hide();
let Cursos=[];
let cursoNombre, cursoId, cursoFecha;
const target2 = document.querySelector("#curso-ano");
const blockUI2 = new KTBlockUI(target2) 



CargarSelect2();
//CargaInicialCurso();
   

$(document).ready(function() {

    const loading = '<div id="loading">'+
                        '<div class="text-center m-7 p-7">' +
                        '<div class="spinner-grow text-info me-2" role = "status">' +
                        '<span class="visually-hidden">...</span>' +
                        '</div >' +
                        '<div class="spinner-grow text-info me-2" role = "status" >' +
                        '<span class="visually-hidden" >...</span >' +
                        '</div>' +
                        '<div class="spinner-grow text-info" role="status">' +
                        '<span class="visually-hidden">...</span>' +
                        '</div>' +
                        '</div></div>';

    $(".div-loading").hide();
   
    $(".modal-close").click(function(e) {
        //e.preventDefault();
        destruirTabla();
        //console.log('destruida')
    });
    
   

   // Función para manejar el clic en el botón
    $("#lista-usuario").click(function(e) {
        e.preventDefault();

        inicializarTabla(1)
        $("#tabla-usuario").hide()
        $("#tabla-usuario").parent().prepend(loading)

        $.ajax({
            type: 'POST',
            url: '../ReportClassHandler.php',  // Reemplaza con la ruta correcta a tu archivo PHP
            data: { action: 'get_users_platform' },
            success: function(data) {
                data =  JSON.parse(data)
                //console.log(data);
                $("#loading").remove();
                $("#tabla-usuario").show()
                for (const persona in data) {
                    if (data.hasOwnProperty(persona)) {
                        //console.log("Nombre:", data[persona].username);
                        var badge;
                        if(data[persona].tipo_usuario == "UDEC"){
                            badge = '<span class="badge badge-light-info">UDEC</span>';
                        }else if(data[persona].tipo_usuario == "UDEC-AL"){
                            badge = '<span class="badge badge-light-info">UDEC-AL</span>';
                        }else{
                            badge = '<span class="badge badge-light-warning">EXTERNO</span>';
                        }

                        var rowNode =  miTabla.row.add( {
                                            "0": data[persona].nombre+' '+data[persona].apellido,
                                            "1": data[persona].mail,
                                            "2": badge,
                                            "3": data[persona].facultad    
                                        } ).node();
                        $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                        $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                        $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');                
                        //$( rowNode ).find('td').eq(3).addClass('text-center p-0');
                    }
                }
                miTabla
                .columns()
                .every(function () {               
                    var column = this;
                    //console.log(column.index())
                    if(column.index() == 2){
                            var select = $('<select id="filtro-alumno" class="selectfiltro12 form-select form-select-sm form-select-solid w-md-125px w-200px mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                            .prependTo($(".filtro2"))
                                            .on('change', function () {
                                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                                //console.log('val: '+val)
                                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                                            });
                                column
                                    .data()
                                    .unique()
                                    .sort( function(a, b) {
                                        return a - b;
                                    })
                                    .each(function (d, j) {
                                        //console.log('d2:'+ d)
                                        var tempElement = document.createElement('div');
                                        // Establecer el HTML de ese elemento como el valor de d
                                        tempElement.innerHTML = d;
                                        // Obtener el texto contenido en el elemento
                                        var textoExtraido = tempElement.innerText
                                        //console.log(textoExtraido)
                                        select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                    });           
                    }else if(column.index() == 3 ){
                        var select = $('<select id="filtro-facultad" class="selectfiltro12 form-select form-select-sm form-select-solid w-200px me-2 mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                        .prependTo($(".filtro2"))
                                        .on('change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                            //console.log('val: '+val)
                                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        });
                            column
                                .data()
                                .unique()
                                .sort( function(a, b) {
                                    return a - b;
                                })
                                .each(function (d, j) {
                                    //console.log('d2:'+ d)
                                    var tempElement = document.createElement('div');
                                    // Establecer el HTML de ese elemento como el valor de d
                                    tempElement.innerHTML = d;
                                    // Obtener el texto contenido en el elemento
                                    var textoExtraido = tempElement.innerText
                                    //console.log(textoExtraido)
                                    if(textoExtraido != ""){
                                        //textoExtraido="SIN FACULTAD";
                                        //select.append('<option value="">' + textoExtraido + '</option>');
                                        select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');

                                    }
                                });           
                }
                });
                //table.draw();
                miTabla.draw();
                $("#filtro-alumno").select2({
                    minimumResultsForSearch: -1
                });
                $("#filtro-facultad").select2({
                    dropdownParent: $('#modalUsuario')
                });

                //miTabla.draw();             
            },
            error: function(error) {
              console.error('Error al llamar a la función PHP:', error);
            }
          });

       //$("#tabla-usuario").width('100%')
        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });

    // Función para manejar el clic en el botón
    $("#lista-curso").click(function(e) {
        e.preventDefault();
        inicializarTabla(2)
        
        $("#tabla-curso").hide()
        $("#tabla-curso").parent().prepend(loading)

        $.ajax({
            type: 'POST',
            url: '../ReportClassHandler.php',  // Reemplaza con la ruta correcta a tu archivo PHP
            data: { action: 'get_courses_platform' },
            success: function(data) {
                data =  JSON.parse(data)
                //console.log(data);
                $("#loading").remove();
                $("#tabla-curso").show()
                miTabla.clear();
                for (const persona in data) {
                    if (data.hasOwnProperty(persona)) {
                        //console.log("Nombre:", data[persona].username);
                        var rowNode =  miTabla.row.add( {
                                            "0": data[persona].id,
                                            "1":  data[persona].fullname,
                                            "2":  data[persona].to_char      
                                        } ).node();
                        //$( rowNode ).find('td').eq(3).addClass('text-center p-0');
                        $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                        $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                        $(rowNode).find('td:eq(2)').addClass('fw-bold text-gray-600');
                    }
                }
                miTabla.draw();             
            },
            error: function(error) {
              console.error('Error al llamar a la función PHP:', error);
            }
          });


        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });


    // Función para manejar el clic en el botón
    $("#lista-certificado").click(function(e) {
        e.preventDefault();

       inicializarTabla(3);
        //$("#tabla-certificado").width('100%')
        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });

    $("#lista-usuario-curso").click(function(e) {
        e.preventDefault();

        var titulo = $("#titulo-curso").text()
        $('#modalUsuario').find('.modal-title').html(titulo+" - Lista de Usuarios");

        inicializarTabla(1);
        $("#tabla-usuario").hide()
        $("#tabla-usuario").parent().prepend(loading)
        //$("#tabla-usuario").parent().prepend(loading)

        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
        cursoId = $("#criterio-curso").select2('data')[0].id;
        $.ajax({
            type: "POST",
            url: '../ReportClassHandler.php',
            data: { action: 'get_users_course', data: cursoId },
            dataType: "json",
            success: function (data) {
                
                //$("#loading").remove();
                //console.log(data);
                if (data) {
                   // $(".div-loading").show();

                   for (const certificado in data) {
                        if (data.hasOwnProperty(certificado)) {
                            //console.log("Nombre:", data[persona].username);
                            // Crea un objeto Date a partir del timestamp

                            var date = new Date(data[certificado].lastaccess  * 1000); // Multiplicamos por 1000 para convertir segundos a milisegundos

                            // Obtiene el año, mes y día de la fecha
                            var year = date.getFullYear();
                            var month = String(date.getMonth() + 1).padStart(2, '0'); // El mes es 0-based
                            var day = String(date.getDate()).padStart(2, '0');

                            // Formatea la fecha en "yyyy-mm-dd"
                            var formattedDate = `${year}-${month}-${day}`;

                            var badge;
                            if(data[certificado].tipousuario == "UDEC"){
                                badge = '<span class="badge badge-light-info">UDEC</span>';
                            }else if(data[certificado].tipousuario == "UDEC-AL"){
                                badge = '<span class="badge badge-light-info">UDEC-AL</span>';
                            }else{
                                badge = '<span class="badge badge-light-warning">EXTERNO</span>';
                            }
                            var rowNode =  miTabla.row.add( {
                                                "0": data[certificado].nombre+" "+data[certificado].apellido,
                                                "1": data[certificado].mail,
                                                "2": badge,
                                                "3": data[certificado].facultad   
                                            } ).node();
                                            
                            $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                            $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                            $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');

                            
                        }
                    }

                    miTabla
                        .columns()
                        .every(function () {               
                            var column = this;
                            //console.log(column.index())
                            if(column.index() == 2){
                                var select = $('<select id="filtro-certificado"  class="selectfiltro-certificado form-select form-select-sm form-select-solid w-md-125px w-200px mb-2"><option value="">TODO</option></select>')
                                                .prependTo($(".filtro2"))
                                                .on('change', function () {
                                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                                    console.log('val: '+val)
                                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                                });
                                        column
                                                .data()
                                                .unique()
                                                .sort( function(a, b) {
                                                    return a - b;
                                                })
                                                .each(function (d, j) {
                                                    //console.log('d2:'+ d)
                                                    var tempElement = document.createElement('div');
                                                    // Establecer el HTML de ese elemento como el valor de d
                                                    tempElement.innerHTML = d;
                                                    // Obtener el texto contenido en el elemento
                                                    var textoExtraido = tempElement.innerText
                                                    //console.log(textoExtraido)
                                                    select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                                });
                            }else if(column.index() == 3 ){
                                var select = $('<select id="filtro-facultad" class="selectfiltro12 form-select form-select-sm form-select-solid w-200px me-2 mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                                .prependTo($(".filtro2"))
                                                .on('change', function () {
                                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                                    //console.log('val: '+val)
                                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                                });
                                    column
                                        .data()
                                        .unique()
                                        .sort( function(a, b) {
                                            return a - b;
                                        })
                                        .each(function (d, j) {
                                            //console.log('d2:'+ d)
                                            var tempElement = document.createElement('div');
                                            // Establecer el HTML de ese elemento como el valor de d
                                            tempElement.innerHTML = d;
                                            // Obtener el texto contenido en el elemento
                                            var textoExtraido = tempElement.innerText
                                            //console.log(textoExtraido)
                                            if(textoExtraido != ""){
                                            select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                            }
                                        });           
                            }
                            
                        });
                        //table.draw();
                        miTabla.draw();
                        $("#filtro-certificado").select2({
                            minimumResultsForSearch: -1
                        });
                        $("#filtro-facultad").select2({
                            dropdownParent: $('#modalUsuario')
                        });
                
                } else {                 
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
                $("#loading").remove();
                $("#tabla-usuario").show()
                //blockUI2.release();
            },
            error: function (xhr, status, error) {
                //console.log("Error: " + status + " - " + error);
                $("#loading").remove();
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
                //blockUI2.release();
            },           
        });



    });

    $("#lista-certificado-curso").click(function(e) {
        e.preventDefault();

        var titulo = $("#titulo-curso").text()
        $('#modalCertificadoEmitido').find('.modal-title').html(titulo+" - Certificados Emitidos");

       // inicializarTabla(4);
        

        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });
    
     //EVENTO SELECT2 DE CURSO
     $('#criterio-curso').on("select2:selecting", function(e) {
        let criterio =  e.params.args.data.id;
        let curso = e.params.args.data.text;

        var elementoBuscado = Cursos.find(function(elemento) {
            return elemento.id == criterio;
        });
        destruirTabla();
        blockUI2.block();

        $.ajax({
            type: "POST",
            url: '../ReportClassHandler.php',
            data: { action: 'get_curso_por_ano', data: criterio },
            dataType: "json",
            success: function (data) {
                
                //$("#loading").remove();
                //console.log(data);
                if (data) {
                    listaCursoDetalle.splice(0, listaCursoDetalle.length);
                    $("#titulo-curso").html(curso)
                    $("#fecha-curso").text("#Inicio "+cursoFecha)
                    flag.splice(0);
                    $("#curso-detalle-1").hide();
                    $("#body-curso-anio").empty();

                    var data2 = [];
                    var totalUsuarios=0;
              for (const curso in data[0]) {
                if (data[0].hasOwnProperty(curso)) {
                    //console.log("Nombre:", data[persona].username);
                   // data[persona].id
                    aux={};
                    aux.anio= data[0][curso].date_enrol;
                    aux.usuario = parseInt(data[0][curso].count);
                    totalUsuarios= totalUsuarios+ aux.usuario;
                    data2.push(aux);
                }
            }
                var cantidadCertificados =  Object.keys(data[1]).length;
               actualizarData(data2)
               $("#lista-usuario-curso").text("TOTAL USUARIOS: "+totalUsuarios);
               $("#lista-certificado-curso").text("TOTAL CERTIFICADOS: "+cantidadCertificados);

               inicializarTabla(4);

               for (const certificado in data[1]) {
                    if (data[1].hasOwnProperty(certificado)) {
                        //console.log("Nombre:", data[persona].username);
                        var badge;
                        if(data[1][certificado].tipo_usuario == "UDEC"){
                            badge = '<span class="badge badge-light-info">UDEC</span>';
                        }else if(data[1][certificado].tipo_usuario == "UDEC-AL"){
                            badge = '<span class="badge badge-light-info">UDEC-AL</span>';
                        }else{
                            badge = '<span class="badge badge-light-warning">EXTERNO</span>';
                        }

                        var rowNode =  miTabla.row.add( {
                                            "0": data[1][certificado].alumno,
                                            "1":  data[1][certificado].email,
                                            "2":  badge,
                                            "3":  data[1][certificado].facultad
                                        } ).node();
                        $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                        $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                        $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');
                    }
                }
                miTabla
                .columns()
                .every(function () {               
                    var column = this;
                    //console.log(column.index())
                    if(column.index() == 2){
                        var select = $('<select id="filtro-certificado-1"  class="selectfiltro-certificado form-select form-select-sm form-select-solid w-md-125px w-200px mb-2"><option value="">TODO</option></select>')
                                        .prependTo($(".filtro4"))
                                        .on('change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                            //console.log('val: '+val)
                                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        });
                                column
                                        .data()
                                        .unique()
                                        .sort( function(a, b) {
                                            return a - b;
                                        })
                                        .each(function (d, j) {
                                            //console.log('d2:'+ d)
                                            var tempElement = document.createElement('div');
                                            // Establecer el HTML de ese elemento como el valor de d
                                            tempElement.innerHTML = d;
                                            // Obtener el texto contenido en el elemento
                                            var textoExtraido = tempElement.innerText
                                            //console.log(textoExtraido)
                                            select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                        });
                    }else if(column.index() == 3 ){
                        var select = $('<select id="filtro-facultad-1" class="selectfiltro12 form-select form-select-sm form-select-solid w-200px me-2 mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                        .prependTo($(".filtro4"))
                                        .on('change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                            //console.log('val: '+val)
                                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        });
                            column
                                .data()
                                .unique()
                                .sort( function(a, b) {
                                    return a - b;
                                })
                                .each(function (d, j) {
                                    //console.log('d2:'+ d)
                                    var tempElement = document.createElement('div');
                                    // Establecer el HTML de ese elemento como el valor de d
                                    tempElement.innerHTML = d;
                                    // Obtener el texto contenido en el elemento
                                    var textoExtraido = tempElement.innerText
                                    //console.log(textoExtraido)
                                    if(textoExtraido != ""){
                                    select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                    }
                                });           
                    }
                    
                });
                //table.draw();
                miTabla.draw();
                $("#filtro-certificado-1").select2({
                    minimumResultsForSearch: -1
                });
                $("#filtro-facultad-1").select2({
                    dropdownParent: $('#modalCertificadoEmitido')
                });
                } else {                 
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
                blockUI2.release();
            },
            error: function (xhr, status, error) {
                //console.log("Error: " + status + " - " + error);
                //$("#loading").remove();
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
                blockUI2.release();
            },           
        });
    });
    
    $('#body-curso-anio').on('click','.close-tab', function(e) {
        //console.log("accion de eliminar")
        
        var CursoAnio = $(this)[0].closest('.col-12').id
        if(flag.includes(CursoAnio)){
            //console.log('si está en la lista')
            let index = flag.indexOf(CursoAnio);
            if (index !== -1) {
                flag.splice(index, 1); // Elimina 1 elemento en la posición 'index'
              } 
           $(this).closest('.col-12').remove();
        }
        
    })

});



function CargarSelect2(){
    blockUI2.block();
        $.ajax({
            type: "POST",
            url: '../ReportClassHandler.php',
            data: { action: 'get_courses_platform' },
            dataType: "json",
            success: function (data) {
                
               // $("#loading").remove();
                //console.log(data);
                if (data) {
                    var select = $('#criterio-curso');
                    // Agrega las opciones al select
                    flag2 =true;
                    for (const curso in data) {
                        if (data.hasOwnProperty(curso)) {
                            if(!flag2){
                                var option = new Option(data[curso].fullname, data[curso].id);
                                
                            }else{
                                var option = new Option(data[curso].fullname, data[curso].id,true, true);
                                cursoNombre= data[curso].fullname;
                                cursoId = data[curso].id;                                
                            }
                            var fechaString = data[curso].to_char;
                            var fechaObjeto = new Date(fechaString);
                            // Obtener los componentes de la fecha
                            var año = fechaObjeto.getFullYear();
                            var mes = fechaObjeto.getMonth() + 1; // Sumamos 1 porque los meses comienzan desde 0
                            var día = fechaObjeto.getDate();
                            var fechaFormateada = día + "-" + (mes < 10 ? "0" + mes : mes) + "-" + año;
                            if(flag2){
                                cursoFecha = fechaFormateada;
                                flag2=false;
                            }
                            
                            option.setAttribute("data-fecha", fechaFormateada);
                            select.append(option);
    
                            aux={};
                            aux.id= data[curso].id;
                            aux.fecha = fechaFormateada;
                            Cursos.push(aux)
                        }
                    }
                    //select.select2();
                    // actualizarData(data)
                    CargaInicialCurso()
                } else {
                    
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                //console.log("Error: " + status + " - " + error);
                $("#loading").remove();
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            },
            complete: function(){
                //blockUI2.release()
            }           
        });

        
}

function CargaInicialCurso(){

    //var curso = "Proceso Constituyente";
    var prueba = $('#criterio-curso').find(':selected');
    //console.log(prueba)
        let criterio =  cursoId;
        let curso =cursoNombre;

    $.ajax({
        type: "POST",
        url: '../ReportClassHandler.php',
        data: { action: 'get_curso_por_ano', data: criterio },
        dataType: "json",
        success: function (data) {
            
            //$("#loading").remove();
            //console.log(data);
            if (data) {
               // $(".div-loading").show();
               $("#titulo-curso").html(curso)
               $("#fecha-curso").text("#Inicio "+cursoFecha)
               flag.splice(0);
               $("#curso-detalle-1").hide();
               $("#body-curso-anio").empty();

              var data2 = [];
              var totalUsuarios=0;
              for (const curso in data[0]) {
                if (data[0].hasOwnProperty(curso)) {
                    //console.log("Nombre:", data[persona].username);
                   // data[persona].id
                    aux={};
                    aux.anio= data[0][curso].date_enrol;
                    aux.usuario = parseInt(data[0][curso].count);
                    totalUsuarios= totalUsuarios+ aux.usuario;
                    data2.push(aux);
                }
            }
                var cantidadCertificados =  Object.keys(data[1]).length;
               actualizarData(data2)
               $("#lista-usuario-curso").text("TOTAL USUARIOS: "+totalUsuarios);
               $("#lista-certificado-curso").text("TOTAL CERTIFICADOS: "+cantidadCertificados);

               inicializarTabla(4);

               for (const certificado in data[1]) {
                    if (data[1].hasOwnProperty(certificado)) {
                        //console.log("Nombre:", data[persona].username);
                        var badge;
                        if(data[1][certificado].tipo_usuario == "UDEC"){
                            badge = '<span class="badge badge-light-info">UDEC</span>';
                        }else{
                            badge = '<span class="badge badge-light-warning">EXTERNO</span>';
                        }

                        var rowNode =  miTabla.row.add( {
                                            "0": data[1][certificado].alumno,
                                            "1":  data[1][certificado].email,
                                            "2":  badge,
                                            "3":  data[1][certificado].fecha
                                        } ).node();
                        $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                        $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                        $(rowNode).find('td:eq(3)').addClass('fw-bold text-gray-600');
                    }
                }
                miTabla
                .columns()
                .every(function () {               
                    var column = this;
                    //console.log(column.index())
                        if(column.index() == 2){
                            var select = $('<select class="selectfiltro12 form-select form-select-sm form-select-solid" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                            .prependTo($(".filtro4"))
                                            .on('change', function () {
                                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                                //console.log('val: '+val)
                                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                                            });
                            if( column.index() != 1){
                                column 
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        //console.log('d:'+ d)
                                        var tempElement = document.createElement('div');
                                        // Establecer el HTML de ese elemento como el valor de d
                                        tempElement.innerHTML = d;
                                        var textoExtraido = tempElement.innerText;
                                        //console.log(textoExtraido)
                                        select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                    });
                            }else{
                                column
                                    .data()
                                    .unique()
                                    .sort( function(a, b) {
                                        return a - b;
                                    })
                                    .each(function (d, j) {
                                        //console.log('d2:'+ d)
                                        var tempElement = document.createElement('div');
                                        // Establecer el HTML de ese elemento como el valor de d
                                        tempElement.innerHTML = d;
                                        // Obtener el texto contenido en el elemento
                                        var textoExtraido = tempElement.innerText
                                        //console.log(textoExtraido)
                                        select.append('<option value="' + textoExtraido + '">' + textoExtraido + '</option>');
                                    });
                            }
                                                
                            
                    }
                });
                //table.draw();
                miTabla.draw();
                $(".selectfiltro12").select2({
                    minimumResultsForSearch: -1
                });
            
            } else {                 
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            }
            blockUI2.release();
        },
        error: function (xhr, status, error) {
            //console.log("Error: " + status + " - " + error);
            //$("#loading").remove();
            Swal.fire({
                text: "Error",
                icon: "error",
                buttonsStyling: false,
                allowOutsideClick: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-danger btn-cerrar"
                }
            });
            blockUI2.release();
        },           
    });
}