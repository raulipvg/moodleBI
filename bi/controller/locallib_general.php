<?php 
//Comprobamos que el valor no venga vacío
if(isset( $_POST['accion']) && !empty($_POST['accion']) &&
    isset( $_POST['data']) && !empty($_POST['data'] )) {
    $funcion = $_POST['accion'];
    $data = $_POST['data'];
    //En función del parámetro que nos llegue ejecutamos una función u otra
    switch($funcion) {
        case '1': 
            certificadosEmitidos();
            break;
        case '2': 
            certificadosPendientes();
            break;
        case '3':
            getCurso($data);
            break;
        case '4':
            getCursoAnio($data);
            break;        
    }
}

function certificadosEmitidos(){
    echo 1;
}
function certificadosPendientes(){
    echo 1;
}
function getCurso($curso){

   $data = array(
                array('anio' => '2018', 'usuario' => 2025),
                array('anio' => '2019', 'usuario' => 1882),
                array('anio' => '2020', 'usuario' => 1809),
                array('anio' => '2021', 'usuario' => 1322),
                array('anio' => '2022', 'usuario' => 1122),
                array('anio' => '2023', 'usuario' => 1114)
            );
    echo json_encode($data);
}

function getCursoAnio($curso){
    $curso1 = $curso['curso'];
    $anio1 =  $curso['anio'];          

    $data = array(
        array('anio' => $anio1, 
                'semestre' => $anio1.'-1', 
                'usuarios' => 800, 
                'certificados' => 250, 
                'usuarios_udec' => 300, 
                'certificados_udec' => 150, 
                'usuarios_externos' => 500, 
                'certificados_externos' => 100 ),

        array('anio' => $anio1, 
                'semestre' => $anio1.'-2', 
                'usuarios' => 650, 
                'certificados' => 370, 
                'usuarios_udec' => 300, 
                'certificados_udec' => 100, 
                'usuarios_externos' => 350, 
                'certificados_externos' => 125 )
    );

    echo json_encode($data);
}