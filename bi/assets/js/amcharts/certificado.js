// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl

const loading = '<div id="loading">' +
                    '<div class="text-center m-7 p-7">' +
                        '<div class="spinner-grow text-info me-2" role = "status">' +
                        '</div>' +
                        '<div class="spinner-grow text-info me-2" role = "status">' +
                        '</div>' +
                        '<div class="spinner-grow text-info" role="status">' +
                        '</div>' +
                    '</div></div>';

let AjaxCertificadoEmitido = () => {
    
    $(".div-loading").hide();
    $("#titulo-certificado").html("Certificados Emitidos")
    $('#grafico').after(loading)
    miTabla.clear().draw(); 
    $.ajax({
        type: "POST",
        url: '../ReportClassHandler.php',
        data: { action: 'get_certificate_course_emitido' },
        dataType: "json",
        success: function (data) {
            
            $("#loading").remove();
            //console.log(data);
            if (data) {
                $(".div-loading").show();
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
                                            "0": data[persona].nombre,
                                            "1": data[persona].email,
                                            "2": data[persona].curso,
                                            "3": badge,
                                            "4": data[persona].facultad     
                                        } ).node();
                        $(rowNode).find('td:eq(0)').addClass('text-capitalize fw-bold text-gray-600');
                        $(rowNode).find('td:eq(1)').addClass('text-gray-800 fw-bolder');
                        $(rowNode).find('td:eq(4)').addClass('fw-bold text-gray-600');
                        //$( rowNode ).find('td').eq(3).addClass('text-center p-0');
                    }
                }
                miTabla
                .columns()
                .every(function () {               
                    var column = this;
                    //console.log(column.index())
                        if(column.index() == 3){
                            var select = $('<select id="filtro-certificado"  class="selectfiltro-certificado form-select form-select-sm form-select-solid w-md-125px w-200px mb-2"><option value="">TODO</option></select>')
                                            .prependTo($(".filtro3"))
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
                        }else if(column.index() == 4 ){
                            var select = $('<select id="filtro-facultad" class="selectfiltro12 form-select form-select-sm form-select-solid w-200px me-2 mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                            .prependTo($(".filtro3"))
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
                    dropdownParent: $('#modalCertificado')
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
    });   
}

let AjaxCertificadoPendiente = () => {
    
    $(".div-loading").hide()
    $("#titulo-certificado").html("Certificados Pendientes")
    $('#grafico').after(loading)
    miTabla.clear().draw(); 
    $.ajax({
        type: "POST",
        url: '../ReportClassHandler.php',
        data:  { action: 'get_certificate_course_pendientes' },
        dataType: "json",
        success: function (data) {
            
            $("#loading").remove();
            //console.log(data);
            if (data) {
                $(".div-loading").show();
                for (const persona in data) {
                    if (data.hasOwnProperty(persona)) {
                        var badge;
                        if(data[persona].tipo == "UDEC"){
                            badge = '<span class="badge badge-light-info">UDEC</span>';
                        }else if(data[persona].tipo == "UDEC-AL"){
                            badge = '<span class="badge badge-light-info">UDEC-AL</span>';
                        }else{
                            badge = '<span class="badge badge-light-warning">EXTERNO</span>';
                        }
                        //console.log("Nombre:", data[persona].username);
                        var rowNode =  miTabla.row.add( {
                                            "0": data[persona].nombre,
                                            "1": data[persona].email, //email
                                            "2": data[persona].nombrecurso, //curso
                                            "3": badge, //tipo
                                            "4": data[persona].facultad      //fecha
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
                    if(column.index() == 3){
                        var select = $('<select id="filtro-certificado"  class="selectfiltro-certificado form-select form-select-sm form-select-solid w-md-125px w-200px mb-2"><option value="">TODO</option></select>')
                                        .prependTo($(".filtro3"))
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
                    }else if(column.index() == 4 ){
                        var select = $('<select id="filtro-facultad" class="selectfiltro12 form-select form-select-sm form-select-solid w-200px me-2 mb-2" data-control="select2" data-hide-search="true"><option value="">TODO</option></select>')
                                        .prependTo($(".filtro3"))
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
                    dropdownParent: $('#modalCertificado')
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
    });   
}


var KTChartsWidget17 = {
    init: function() {
        if ("undefined" !== typeof am5) {
            var e = document.getElementById("kt_charts");
            if (e) {
                var t, a = function() {
                    t = am5.Root.new(e);
                    t.setThemes([am5themes_Animated.new(t)]);
                    var chart = t.container.children.push(am5percent.PieChart.new(t, {
                        startAngle: 180,
                        endAngle: 360,
                        layout: t.verticalLayout,
                        innerRadius: am5.percent(50)
                    }));

                    var series = chart.series.push(am5percent.PieSeries.new(t, {
                        startAngle: 180,
                        endAngle: 360,
                        valueField: "value",
                        categoryField: "category",
                        alignLabels: false
                    }));

                    let flag1= true;
                    let flag2=true;
                    // Añadir un evento de clic a los segmentos del gráfico
                    series.slices.template.events.on("click", function(ev) {
                        //console.log("Segmento clickeado:", ev.target.dataItem.dataContext.category);
                        var seccion = ev.target.dataItem.dataContext.category;
                        //console.log($("#filtro-certificado").next('span'))
                        
                        if( seccion == "Emitidos" && flag1 ){
                            flag1=false;
                            flag2=true;
                            $("#filtro-certificado").next('span').addBack().remove();
                            $("#filtro-certificado").remove();
                            $("#filtro-facultad").next('span').addBack().remove();
                            $("#filtro-facultad").remove();
                            AjaxCertificadoEmitido();           
                        }else if( seccion == "Pendientes" && flag2){
                            flag2=false;
                            flag1=true;
                            $("#filtro-certificado").next('span').addBack().remove();
                            $("#filtro-certificado").remove();
                            $("#filtro-facultad").next('span').addBack().remove();
                            $("#filtro-facultad").remove();
                            AjaxCertificadoPendiente();
                            //$(".div-loading").show();
                        }
                        // Agrega aquí la lógica que deseas ejecutar al hacer clic en un segmento
                    });

                    series.labels.template.setAll({
                        fontWeight: "400",
                        fontSize: 13,
                        fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-800")),
                        text: "[bold]{category}: {valuePercentTotal.formatNumber('0.0')}%[/] ({value})" ,
                    });

                    series.slices.template.setAll({
                        cornerRadius: 5
                    });

                    $.ajax({
                        type: "POST",
                        url: '../ReportClassHandler.php',
                        data: { action: 'get_number_metricas_certificados' },
                        dataType: "json",
                        success: function (data) {
                            
                            $("#loading").remove();
                            //console.log(data);
                            if (data) {
                               // $(".div-loading").show();
                                series.data.setAll([{
                                    value: data.certificados,
                                    category: "Emitidos",
                                    fill: am5.color(KTUtil.getCssVariableValue("--bs-primary"))
                                }, {
                                    value: data.pendientes,
                                    category: "Pendientes",
                                    fill: am5.color("#000000")
                                }]);
            
                                chart.appear(1000, 100);
                
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
                    });

                    
                };
                am5.ready(function() {
                    a();
                });
                KTThemeMode.on("kt.thememode.change", function() {
                    t.dispose(), a();
                });
                
            }
        }
    }
};


"undefined" != typeof module && (module.exports = KTChartsWidget17),
KTUtil.onDOMContentLoaded((function() {
    KTChartsWidget17.init()
}));