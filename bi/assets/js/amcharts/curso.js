let chart;
let xAxis;
let series;

let flag = [];

let listaCursoDetalle = [];

am5.ready(function() {

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("chartdiv");
    
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
      am5themes_Animated.new(root)
    ]);
    
    
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    chart = root.container.children.push(am5xy.XYChart.new(root, {
      panX: true,
      panY: true,
      wheelX: "panX",
      wheelY: "zoomX",
      pinchZoomX: true
    }));
    
    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    const cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);
    
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    const xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
    xRenderer.labels.template.setAll({
      rotation: -90,
      centerY: am5.p50,
      centerX: am5.p100,
      paddingRight: 15
    });
    
    xRenderer.grid.template.setAll({
      location: 1
    })
    
    xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
      maxDeviation: 0.3,
      categoryField: "anio",
      renderer: xRenderer,
      tooltip: am5.Tooltip.new(root, {})
    }));

    xAxis.children.push(am5.Label.new(root, {
        text: 'Año',
        textAlign: 'center',
        x: am5.p50,
        fontWeight: 'bold'
      }));
    
    const yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
      maxDeviation: 0.3,
      renderer: am5xy.AxisRendererY.new(root, {
        strokeOpacity: 0.1
      })
    }));

    yAxis.children.unshift(am5.Label.new(root, {
        text: 'Usuario',
        textAlign: 'center',
        y: am5.p50,
        rotation: -90,
        fontWeight: 'bold'
      }));
    
    
    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "usuario",
      sequencedInterpolation: true,
      categoryXField: "anio",
      tooltip: am5.Tooltip.new(root, {
        labelText: "{valueY}"
      })
    }));

   

     // Configurar evento de clic para cada barra
     
    series.columns.template.events.on("click", function(ev) {
        
        //console.log(ev)
        if(ev.target.defaultPrevented){
          return;
        }
        var dataItem = ev.target.dataItem.dataContext.anio;
        //console.log("Haz hecho clic en la barra. Valor Y: " + dataItem)

        if(!flag.includes(dataItem)){
          flag.push(dataItem);
          let curso= $('#criterio-curso').select2('data')[0].id
          let cursoNombre= $('#criterio-curso').select2('data')[0].text
          let anio = dataItem;
          getCursoAnio(curso, anio, cursoNombre)
        }
       
        
      });
     

    series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
    series.columns.template.adapters.add("fill", function(fill, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });
    
    series.columns.template.adapters.add("stroke", function(stroke, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });
    
   
    // Set data
    /*var data = [
        { anio: "2018", usuario: 2025 },
        { anio: "2019", usuario: 1882 },
        { anio: "2020", usuario: 1809 },
        { anio: "2021", usuario: 1322 },
        { anio: "2022", usuario: 1122 },
        { anio: "2023", usuario: 1114 }
      ];
    
    xAxis.data.setAll(data);
    series.data.setAll(data); 
    
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);    
    */
    
}); // end am5.ready()

function actualizarData(data){

  xAxis.data.setAll(data);
  series.data.setAll(data);
          
  // Make stuff animate on load
  series.appear(1000);
  chart.appear(1000, 100); 

}

function getCursoAnio(curso, anio, cursoNombre){

  criterio= {
        curso: curso,
        anio: anio
      }

  $("#curso-detalle-1").show();
  $("#titulo-curso-anio").html(cursoNombre+" - Por Semestre")
  $("#body-curso-anio").prepend(loading);
  //console.log("barra");
 
  $.ajax({
    type: "POST",
    url: '../ReportClassHandler.php',
    data: { action: 'get_user_per_course_age_select', data: criterio },
    dataType: "json",
    beforeSend: function() {

    },
    success: function (data) {
        $("#loading").remove();
        //console.log(data);

        if (data) {
          listaCursoDetalle.push(data);
          //console.log(listaCursoDetalle);
          var html = Renderizar(data)
          $("#body-curso-anio").prepend(html);
          //Inicilizo Tooltip
          $('[data-bs-toggle="tooltip"]').tooltip();
          
            //actualizarData(data)

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

function Renderizar(data){
    prueba = data

    var procentaje1=  Math.floor((data[0].certificados/data[0].usuarios)*100)
    var procentaje2=  Math.floor((data[1].certificados/data[1].usuarios)*100)
    let html = 
    '<div id="'+data[0].anio+'" class="col-12 border border-2 rounded  mb-2">'+
    '<div class="d-flex flex-row p-1 justify-content-center align-items-center">'+
      '<div class="col-md-2 col-3">'+
        '<div style="margin-top: -30px;">'+
          '<div class="btn btn-icon btn-sm btn-active-light-primary close-tab"  aria-label="Close">'+
            '<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>'+
          '</div>'+
        '</div>'+
        '<div class="fs-2hx fw-bold text-gray-800 text-center">'+data[0].anio+'</div>'+
      '</div>'+
      '<div class="col-md-10 col-9 p-1">'+
        '<div class="d-flex flex-column">'+
          '<div class="p-2 bd-highlight">'+
            '<div class="d-flex flex-row justify-content-center align-items-center">'+
              '<div class="col-md-2 col-3 fw-semibold fs-4">'+data[0].semestre+'</div>'+
              '<div class="col-md-10 col-9">'+
                '<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">'+                
                  '<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" type="button" style="width:'+procentaje1+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>'+
                  '<div class="d-flex align-items-center position-relative z-index-2">'+
                    '<a href="#" class="fw-bold text-white text-hover-dark">'+data[0].certificados+'</a>'+
                  '</div>'+
                  '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">'+
                    data[0].usuarios+
                  '</div>'+
                '</div>'+
              '</div>'+			
            '</div>'+	
          '</div>'+
          '<div class="p-2 bd-highlight">'+
            '<div class="d-flex flex-row justify-content-center align-items-center">'+
              '<div class="col-md-2 col-3 fw-semibold fs-4">'+data[1].semestre+'</div>'+
              '<div class="col-md-10 col-9">'+
                '<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">'+																	
                  '<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" style="width:'+procentaje2+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>'+
                  '<div class="d-flex align-items-center position-relative z-index-2">'+
                    '<a href="#" class="fw-bold text-white text-hover-dark">'+data[1].certificados+'</a>'+
                  '</div>'+
                  '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">'+
                    data[1].usuarios+
                  '</div>'+
                '</div>'+
              '</div>'+			
            '</div>'+										
          '</div>'+                            
        '</div>'+										
      '</div>'+
    '</div>'+										  
  '</div>'


  var porcentajeCertificado1=  Math.floor((data[0].certificados/data[0].usuarios)*100)

  var porcentajeUdec1= Math.floor((data[0].usuarios_udec/data[0].usuarios)*100)
  if(porcentajeUdec1 < 20)porcentajeUdec1 =20;
  var porcentajeCertificadoUdec1 = Math.floor((data[0].certificados_udec/data[0].usuarios_udec)*100)
  var porcentajeExterno1= Math.floor((data[0].usuarios_externos/data[0].usuarios)*100)
  if(porcentajeExterno1 < 20)porcentajeExterno1 =20;
  var porcentajeCertificadoExterno1 = Math.floor((data[0].certificados_externos/data[0].usuarios_externos)*100)

  var porcentajeCertificado2=  Math.floor((data[1].certificados/data[1].usuarios)*100)
  var porcentajeUdec2= Math.floor((data[1].usuarios_udec/data[1].usuarios)*100)
  if(porcentajeUdec2 < 20)porcentajeUdec2 =20;
  var porcentajeCertificadoUdec2 = Math.floor((data[1].certificados_udec/data[1].usuarios_udec)*100)
  var porcentajeExterno2= Math.floor((data[1].usuarios_externos/data[1].usuarios)*100)
  if(porcentajeExterno2 < 20)porcentajeExterno2 =20;
  var porcentajeCertificadoExterno2 = Math.floor((data[1].certificados_externos/data[1].usuarios_externos)*100)

  let html2= 
  '<div id="'+data[0].anio+'" class="col-12 border border-2 rounded mb-2">'+ 
    '<div class="d-flex flex-row">'+ 
      '<div class="flex-column">'+ 
        '<div class="close-tab">'+ 
          '<div class="btn btn-icon btn-sm btn-active-light-primary" aria-label="Close">'+ 
            '<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>'+ 
          '</div>'+ 
        '</div>'+ 
        '<div class="fs-md-2 fs-4 fw-bold text-gray-800 mt-2 ms-2">'+data[0].anio+'</div>'+ 
      '</div>'+ 
      '<div class="flex-fill">'+ 
        '<div class="d-flex flex-column">'+ 
          '<div class="p-2 bd-highlight">'+ 
            '<div class="d-flex flex-row justify-content-center align-items-center">'+ 
              '<div class="col-md-2 col-3 fw-bold fs-md-4 fs-4">'+data[0].semestre+'</div>'+ 
              '<div class="col-md-10 col-9">'+ 
                '<div class="accordion" id="acordion'+data[0].anio+'">'+ 
                    '<div class="accordion-item">'+ 
                        '<h2 class="accordion-header" id="acordion_header_'+data[0].anio+'_1">'+ 
                      '<button class="accordion-button fs-4 fw-semibold collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#acordion_body_'+data[0].anio+'_1" aria-expanded="false" aria-controls="acordion_body_'+data[0].anio+'_1">'+ 
                        '<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">'+  
                          '<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificado1+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[0].certificados+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-4 fw-bolder ms-auto h-100 px-3 position-relative z-index-2 text-white" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">'+data[0].usuarios+'</div>'+ 
                        '</div>'+ 
                      '</button>'+ 
                        '</h2>'+ 
                    '<div id="acordion_body_'+data[0].anio+'_1" class="accordion-collapse collapse" aria-labelledby="acordion_header_'+data[0].anio+'_1" data-bs-parent="#acordion'+data[0].anio+'">'+ 
                      '<div class="accordion-body p-1 pb-0">'+ 
                        '<div class="rounded-pill bg-light-success d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: '+porcentajeUdec1+'%;">'+  
                          '<div class="position-absolute rounded-pill d-block bg-success start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificadoUdec1+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Udec"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[0].certificados_udec+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Udec">'+data[0].usuarios_udec+'</div>'+ 
                        '</div>'+ 
                        '<div class="rounded-pill bg-light-danger d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: '+porcentajeExterno1+'%;">'+  
                          '<div class="position-absolute rounded-pill d-block bg-danger start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificadoExterno1+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Externos"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[0].certificados_externos+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Externos">'+data[0].usuarios_externos+'</div>'+ 
                        '</div>'+ 
                      '</div>'+ 
                    '</div>'+ 
                  '</div>'+ 
                '</div>'+ 													
              '</div>'+ 			
            '</div>'+ 	
          '</div>'+ 
          '<div class="p-2 bd-highlight">'+ 
            '<div class="d-flex flex-row justify-content-center align-items-center">'+ 
              '<div class="col-md-2 col-3 fw-bold fs-md-4 fs-4">'+data[1].semestre+'</div>'+ 
              '<div class="col-md-10 col-9">'+ 
                '<div class="accordion" id="acordion'+data[0].anio+'">'+ 
                    '<div class="accordion-item">'+ 
                        '<h2 class="accordion-header" id="acordion_header_'+data[0].anio+'_1">'+ 
                      '<button class="accordion-button fs-4 fw-semibold collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#acordion_body_'+data[0].anio+'_1" aria-expanded="false" aria-controls="acordion_body_'+data[0].anio+'_1">'+ 
                        '<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">'+  
                          '<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificado2+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[1].certificados+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-4 fw-bolder ms-auto h-100 px-3 position-relative z-index-2 text-white" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">'+data[1].usuarios+'</div>'+ 
                        '</div>'+ 
                      '</button>'+ 
                        '</h2>'+ 
                    '<div id="acordion_body_'+data[0].anio+'_1" class="accordion-collapse collapse" aria-labelledby="acordion_header_'+data[0].anio+'_1" data-bs-parent="#acordion'+data[0].anio+'">'+ 
                      '<div class="accordion-body p-1 pb-0">'+ 
                        '<div class="rounded-pill bg-light-success d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: '+porcentajeUdec2+'%;">'+  
                          '<div class="position-absolute rounded-pill d-block bg-success start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificadoUdec2+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Udec"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[1].certificados_udec+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Udec">'+data[1].usuarios_udec+'</div>'+ 
                        '</div>'+ 
                        '<div class="rounded-pill bg-light-danger d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: '+porcentajeExterno2+'%;">'+  
                          '<div class="position-absolute rounded-pill d-block bg-danger start-0 top-0 h-100 z-index-1" type="button" style="width:'+porcentajeCertificadoExterno2+'%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Externos"></div>'+ 
                          '<div class="d-flex align-items-center position-relative z-index-2">'+ 
                            '<a href="#" class="fw-bold text-white text-hover-dark">'+data[1].certificados_externos+'</a>'+ 
                          '</div>'+ 
                          '<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Externos">'+data[1].usuarios_externos+'</div>'+ 
                        '</div>'+ 
                      '</div>'+ 
                    '</div>'+ 
                  '</div>'+ 
                '</div>'+ 
              '</div>'+ 			
            '</div>'+ 										
          '</div>'+                         
        '</div>'+ 										
      '</div>'+ 
    '</div>'+ 										 
  '</div>'

  return html2;

}

function exportarExcel() {

  var titulo = $('#titulo-curso').text();

 // listaCursoDetalle
  var data = [
    ['Año', 'Semestre', 'Usuario Totales', 'Certificados Totales', 'Usuarios Externos', 'Certificados Externos','Usuarios UDEC', 'Certificados UDEC' ]
  ]
  for (const clave in listaCursoDetalle) {
      for (const clave2 in listaCursoDetalle[clave]) {
        if (listaCursoDetalle[clave].hasOwnProperty(clave2)) {
          //const valor = listaCursoDetalle[clave][clave2].anio;
          //console.log(`Clave: ${clave}, Valor: ${valor}`);

          var nuevoDato = [
            listaCursoDetalle[clave][clave2].anio, 
            listaCursoDetalle[clave][clave2].semestre,
            listaCursoDetalle[clave][clave2].usuarios,
            listaCursoDetalle[clave][clave2].certificados,
            listaCursoDetalle[clave][clave2].usuarios_externos,
            listaCursoDetalle[clave][clave2].certificados_externos,
            listaCursoDetalle[clave][clave2].usuarios_udec,
            listaCursoDetalle[clave][clave2].certificados_udec
          ];

          data.push(nuevoDato);
        }
      }
  }

  // Crear un nuevo libro de Excel
  const workbook = XLSX.utils.book_new();
  let sheetName = titulo; // Nombre de la hoja

  if (sheetName.length > 31) {
    sheetName = sheetName.substring(0, 31); // Corta la cadena desde el inicio hasta el carácter 31
  }
  // Convertir la lista a un objeto de hoja de cálculo
  const worksheet = XLSX.utils.aoa_to_sheet(data);

  // Agregar la hoja al libro
  XLSX.utils.book_append_sheet(workbook, worksheet, sheetName);

  // Crear un archivo binario (blob) desde el libro de Excel
  const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

  // Convertir el archivo binario a un Blob y crear una URL para descargarlo
  const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
  const url = URL.createObjectURL(blob);

  // Crear un enlace de descarga y simular clic para descargar el archivo
  const a = document.createElement('a');
  a.href = url;
  a.download = titulo+'.xlsx'; // Nombre del archivo
  a.click();
}