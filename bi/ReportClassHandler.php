<?php
require 'ReportClass.php';  // Reemplaza con la ruta correcta a tu archivo report.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'];

    switch ($action) {
        case 'get_users_platform': //LISTAR TODOS LOS USUARIOS
            $report = new Report();
             // Llamar a la función get_certificate y descargar el certificado
            echo json_encode($report->get_users_platform());  // Esto descargará el certificado
            break;

        case 'get_courses_platform': // LISTAR TODOS LOS CURSOS
            $report = new Report();
            echo json_encode($report->get_courses_platform());  
            break;

        case 'get_certificate_course_emitido': // LISTAR TODOS LOS CERTIFICADOS EMITIDOS
            $report = new Report();
            echo json_encode($report->get_certificate_course_emitido());
            break;

        case 'get_number_metricas_certificados':
            $report = new Report();
            echo json_encode($report->get_number_metricas_certificados()); 
            break;

        case 'get_certificate_course_pendientes': //LISTAR TODOS LOS PENDIENTES
            $report = new Report();
            echo json_encode(($report->get_certificate_course_pendientes()));
            break;
        case 'get_curso_por_ano': // PARA UN CURSO ID, DAR LA CANTIDAD DE USUARIOS POR AÑO SELECT2
            $cursoId= $_POST['data'];
            $report = new Report();
            echo json_encode($report->get_curso_por_ano($cursoId));
            break;
        case 'get_users_course': // MEDIANDO EL CURSO ID, DAR TODOS LOS USUARIOS DEL CURSO
            $cursoId= $_POST['data'];
            $report = new Report();
            echo json_encode($report->get_users_course2($cursoId));
            break;
        case 'get_user_per_course_age_select':
            $cursoId= $_POST['data']['curso'];
            $anio= $_POST['data']['anio'];
            $report = new Report();
            echo json_encode($report->get_user_per_course_age_select($cursoId,$anio));
            break;
        default:
            // Acción por defecto si no coincide con ninguna opción
            echo "Acción no válida";
            break;
    }

 
}
?>