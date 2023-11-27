<?php
    require_once '../../config.php';

    ////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////// NUEVAS FUNCIONES ///////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    // CURSOS EN PLATAFORMA
    function get_courses($downloadable = true){
        $courses_platform = get_courses_platform($with_activity = true, STUDENT_ROLES); 
        if($downloadable){
            $headers = ['course_id','fullname','has_activity'];
            $file_name = "Cursos plataforma";
            export_csv($courses_platform, $headers, $file_name);
        }
        return $courses_platform;
    }
    function count_courses(){
        $cursos = count(get_courses());
        return $cursos;
    }
    function get_courses_platform(){
        global $DB;

        $consulta = "
            SELECT c.id, c.fullname
            FROM {course} c
            ORDER BY c.id"; 
        $cursos = $DB->get_records_sql($consulta);
        return $cursos;
    }

    // USUARIOS PLATAFORMA
    function get_users($downloadable = true){
        $user_platform = get_users_platform($with_activity = true, STUDENT_ROLES); 
        if($downloadable){
            $headers = ['user_id','username', 'firstname', 'lastname', 'email' ,'has_activity'];
            $file_name = "Usuario plataforma";
            export_csv($user_platform, $headers, $file_name);
        }
        return $user_platform;
    }
    function count_users(){
        $active_student = count(get_users());
        return $active_student;
    }
    function get_users_platform(){
        global $DB;

        $consulta = "
            SELECT u.username as username, u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, u.lastaccess
            FROM {user} u
            ORDER BY u.id"; 
        $usuarios = $DB->get_records_sql($consulta);
        return $usuarios;
    }

    // CERTIFICADOS PLATAFORMA
    function get_certificate($downloadable = true){
        $certiificate_platform = get_certificate_platform($with_activity = true, STUDENT_ROLES); 
        if($downloadable){
            $headers = ['id','userid', 'timecreated'];
            $file_name = "Certificados plataforma";
            export_csv($certiificate_platform, $headers, $file_name);
        }
        return $certiificate_platform;
    }
    function count_certificate(){
        $active_student = count(get_certificate());
        return $active_student;
    }
    function get_certificate_platform(){
        global $DB;

        $consulta = "
            SELECT c.id, c.userid, c.timecreated
            FROM {certificates} c
            ORDER BY c.id"; 
        $usuarios = $DB->get_records_sql($consulta);
        return $usuarios;
    }

    // USUARIOS POR CURSO
    function get_user_per_course($downloadable = true){
        $user_platform = get_users_course($with_activity = true, STUDENT_ROLES); 
        if($downloadable){
            $headers = ['username','user_id','firstname', 'lastname', 'email' , 'lastaccess', 'has_activity'];
            $file_name = "Usuarios curso";
            export_csv($user_platform, $headers, $file_name);
        }
        return $user_platform;
    }
    function count_get_usr(){
        $active_student = count(get_user_per_course());
        return $active_student;
    }
    function get_users_course($downloadable = true) {
        global $DB;

        $consulta = "
            SELECT u.username as username, u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, u.lastaccess
            FROM {role_assignments} ra, {user} u, {course} c, {context} cxt
            WHERE ra.userid = u.id AND ra.contextid = cxt.id AND cxt.contextlevel = 50
            AND cxt.instanceid = c.id AND c.id = ? AND roleid = 5
            ORDER BY u.firstname"; 
        $usuarios = $DB->get_records_sql($consulta, array(14));
        // print_object($usuarios);
        return $usuarios;
    }

    ////////////////////////////////////////////////////////////////////////////////////

    function export_csv($rows, $headers,  $ouput_name){
        $now = time();
        $file_name = "{$now} - {$ouput_name}.csv";
        $path = fopen("./downloads/{$file_name}", "w");       
        fprintf($path, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($path, $headers,"\t");       
        foreach($rows as $row){ 
            $row = extract_value($row); 
            fputcsv($path, $row, "\t");
        }       
        fclose($path);
        $link = "downloads/{$file_name}";
        $this->download_links[$ouput_name] = $link;
    }

    function extract_value($row){
        $values = array();
        if(gettype($row) == 'object'){
            $row = (array)$row;
            $row = array_values($row);
        }
        if(gettype($row) == 'array'){
            foreach($row as $value){
                array_push($values, $value);
            }
        }else{
            $values = $row;
        }
        return $values;
    }

    function get_download_links(){
        return $this->download_links;
    }

    function zip_download_link(){
        if(!extension_loaded('zip')){
            return null;
        }
        $now = time();
        $za = new ZipArchive;
        $ouput_name = "downloads/Reportes - {$now}.zip"; 
        $za->open($ouput_name, ZipArchive::CREATE|ZipArchive::OVERWRITE);
        foreach($this->download_links as $link){
            $za->addFile($link);
        }
        $za->close();
        return $ouput_name;
    }