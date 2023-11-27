<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'constant.php';
require_once '../../config.php';
date_default_timezone_set("America/Santiago");

class Report{
    const STUDENT_ROLES = [STUDENT, ALUMNO_AYUDANTE];
    const TEACHER_ROLES = [EDITINGTEACHER, TEACHER, PROFESOR_GESTOR, TUTOR];
    const DEFAULT_DAYS_AGO = 7; 
    const CATEGORY_SELECTED = 2;
    private $courses;
    private $date;
    private $download_links;

    function __construct($start = null, $end = null, $clean_previous_downloads = true){
        self::init_dates($start, $end);
        self::init_courses();
        $this->download_links = array();
        if($clean_previous_downloads){
            self::remove_old_files();
        }
    }

    private function init_dates($start = null, $end = null){
        $now = time();
        $this->date = new StdClass();
        $this->date->start = $start;
        $this->date->end = $end;
        if(empty($start)){
            $time_ago = strtotime("-".self::DEFAULT_DAYS_AGO." day", $now);
            $this->date->start = $time_ago;    
        }
        if(empty($end)){
            $this->date->end = $now;
        }
    }
    private function init_courses(){
        global $DB;
        $sql = "select id, category, sortorder, fullname, shortname, idnumber, format, showgrades, 
                newsitems, startdate, enddate, marker, maxbytes, legacyfiles, showreports, visible, 
                visibleold, groupmode, groupmodeforce, defaultgroupingid, lang, calendartype, theme, 
                timecreated, timemodified, requested, enablecompletion, completionnotify, cacherev 
                from {course} where timecreated >= ? and timecreated <= ?";
        $params = [$this->date->start, $this->date->end];
        $courses = $DB->get_records_sql($sql, $params);
        $this->courses = $courses;
    }
    private function init_courses_general(){
        global $DB;
        $sql = "select id, category, sortorder, fullname, shortname, idnumber, format, showgrades, 
                newsitems, startdate, enddate, marker, maxbytes, legacyfiles, showreports, visible, 
                visibleold, groupmode, groupmodeforce, defaultgroupingid, lang, calendartype, theme, 
                timecreated, timemodified, requested, enablecompletion, completionnotify, cacherev 
                from {course}";
        $params = [$this->date->start, $this->date->end];
        $courses = $DB->get_records_sql($sql, $params);
        $this->courses = $courses;
    }

    ////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////// NUEVAS FUNCIONES ///////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    // CURSOS EN PLATAFORMA
    public function get_courses($downloadable = true){
        $course_platform = self::get_courses_platform($with_activity = true, self::STUDENT_ROLES); 
        if($downloadable){
            $headers = ['course_id','fullname','timecreated'];
            $file_name = "Cursos plataforma";
            self::export_csv($course_platform, $headers, $file_name);
        }
        return $course_platform;
    }
    public function count_courses(){
        $cursos = count(self::get_courses());
        return $cursos;
    }
    public function get_courses_platform(){
        global $DB;

        $consulta = " 
            SELECT c.id, c.fullname, to_char(to_timestamp( c.timecreated ), 'YYYY-MM-DD HH:MM')
            FROM {course} c
            WHERE c.visible = 1  AND c.id != 1
            ORDER BY c.id"; 
        $cursos = $DB->get_records_sql($consulta);
        
        return $cursos;
    }

    // USUARIOS PLATAFORMA
    public function get_users($downloadable = true){
        $user_platform = self::get_users_platform($with_activity = true, self::STUDENT_ROLES); 
        if($downloadable){
            $headers = ['user_id','username', 'firstname', 'lastname', 'email' ,'lastaccess'];
            $file_name = "Usuario plataforma";
            self::export_csv($user_platform, $headers, $file_name);
        }
        return $user_platform;
    }
    public function count_users(){
        //$active_student = count(self::get_users());
        $active_student = count(self::get_users_platform());
        return $active_student;
    }
    public function get_users_platform(){
        global $DB;

        //OBTENER LOS USUARIOS DE ROL ID 5 (ESTUDIANTES)
        $consulta = "
            SELECT u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, to_char(to_timestamp( u.lastaccess ), 'YYYY-MM-DD')
            FROM {user} u, {role_assignments} ra
            WHERE u.id = ra.userid  AND ra.roleid=5
            ORDER BY u.id";

        $consulta2 ="SELECT
                        u.id as userid,
                        LOWER(u.firstname) as nombre,
                        LOWER(u.lastname) as apellido,
                        u.email as mail,
                        u.institution as facultad,
                        CASE
                            WHEN u.institution ~ '^[0-9]' THEN u.institution
                            ELSE ''
                        END as facultad,
                        CASE
                            WHEN u.lastaccess IS NOT NULL AND u.lastaccess <> 0
                            THEN to_char(to_timestamp(u.lastaccess), 'YYYY-MM-DD')
                            ELSE NULL 
                        END as to_char,
                        CASE
                            WHEN u.email LIKE '%@udec.cl%' THEN
                                CASE
                                    WHEN u.idnumber IS NOT NULL AND u.idnumber <> '' THEN 'UDEC-AL'
                                    WHEN u.idnumber IS NULL OR u.idnumber = '' THEN 'UDEC'
                                END
                            ELSE 'EXTERNO'
                        END as tipo_usuario
                    FROM {user} u
                    JOIN {role_assignments} ra ON u.id = ra.userid
                    WHERE ra.roleid = 5
                    ORDER BY u.id;"; 
        $usuarios = $DB->get_records_sql($consulta2);
        return $usuarios;
    }

    // CERTIFICADOS PLATAFORMA
    public function get_certificate($downloadable = true){
        $certiificate_platform = self::get_certificate_platform($with_activity = true, self::STUDENT_ROLES); 
        if($downloadable){
            $headers = ['id','userid', 'firstname', 'lastname', 'email', 'timecreated'];
            $file_name = "Certificados plataforma";
            self::export_csv($certiificate_platform, $headers, $file_name);
        }
        return $certiificate_platform;
    }
    public function count_certificate(){
        $active_student = count(self::get_certificate());
        return $active_student;
    }
    private function get_certificate_platform(){
        global $DB;

        $consulta = "
            SELECT c.id, c.userid, u.firstname, u.lastname, u.email, to_char(to_timestamp( c.timecreated ) as fecha, 'YYYY-MM-DD HH:MM')
            FROM {certificates} c, {user} u
            WHERE c.userid = u.id
            ORDER BY c.id"; 
        $usuarios = $DB->get_records_sql($consulta);
        return $usuarios;
    }

    // USUARIOS POR CURSO
    public function get_user_per_course($downloadable = true){
        $user_platform = self::course_students($with_activity = true ); 
        if($downloadable){
            $headers = ['course_id','fullname','timecreated', 'numbersuser'];
            $file_name = "Usuarios curso";
            self::export_csv($user_platform, $headers, $file_name);
        }
        return $user_platform;
    }
    public function count_get_usr(){
        $active_student = count(self::get_user_per_course());
        return $active_student;
    }


    // USUARIOS POR CURSO Y AÑO
    public function get_user_per_course_age($downloadable = true){
        $valid_courses = self::get_valid_courses();

        foreach( $valid_courses as $key => $course){
            $erids = self::get_enrolid_course($course->id);
            $ceua = self::count_enrol_user_age($erids);
            
            $course->totalusers = '';
            $course->diecinueve = '';
            $course->veinte = '';
            $course->veintiuno = '';
            $course->ventidos = '';
            $course->ventitres = '';

            foreach($ceua as $index => $ua){
                $course->totalusers = $course->totalusers + $ua->count;
                // print_object($ceua);
                if($ua->date_enrol == 2019){
                    $course->diecinueve = $ua->count;
                } elseif($ua->date_enrol == 2020){
                    $course->veinte = $ua->count;
                } elseif($ua->date_enrol == 2021){
                    $course->veintiuno = $ua->count;
                }elseif($ua->date_enrol == 2022){
                    $course->ventidos = $ua->count;
                }elseif($ua->date_enrol == 2023){
                    $course->ventitres = $ua->count;
                }
            }
        }

        if($downloadable){
            $headers = ['id','fullname','date_start','numbersuser','2019','2020','2021','2022','2023'];
            $file_name = "Usuarios curso por año";
            self::export_csv($valid_courses, $headers, $file_name);
        }
        return $valid_courses;
    }

    public function get_curso_por_ano($CursoId){
        $valid_courses = self::get_valid_courses();

            $erids = self::get_enrolid_course($CursoId);
            $ceua = self::count_enrol_user_age($erids);

            $prueba=  self::get_certificado_por_curso($CursoId);

        return [$ceua,$prueba];
    }


    public function get_user_per_course_age_select($courseid, $anio){
        $userCourse = self::get_enrolid_course($courseid);
        //$ceua = self::count_enrol_user_age($userCourse);
        $ceua = self::count_enrol_user_semester($userCourse,$courseid,$anio);
        
        return $ceua;
    }
    public function count_get_usr_age(){
        $active_student = count(self::get_user_per_course_age());
        return $active_student;
    }
    private function get_valid_courses(){
        global $DB;

        $consulta = "
            SELECT id, fullname, to_char(to_timestamp(startdate), 'DD-MM-YYYY')
            FROM {course}
            WHERE category = ?
            ORDER BY id"; 
        $courses_valid = $DB->get_records_sql($consulta, array(self::CATEGORY_SELECTED));

        return $courses_valid;
    }
    private function get_enrolid_course($courseid){
        global $DB;

        $consulta = "
            SELECT id
            FROM {enrol}
            WHERE courseid = ?
            ORDER BY id"; 
        $enrols_id = $DB->get_records_sql($consulta, array($courseid));

        //print_object($enrols_id);
        return $enrols_id;
    }
    private function count_enrol_user_age($enrolsid){
        global $DB;
        // print_object($enrolsid);
        $where = '';
        $long = count($enrolsid);
        $count = 0;
        // echo 'largo array => '.$long;
        foreach( $enrolsid as $valor => $enrolid){
            $count++;
            $where .= 'enrolid = '. $enrolid->id;
            if( $long > $count ) { $where .= ' OR ';}
        }

        // echo $where.'<br>';

        $query = "
            SELECT to_char(to_timestamp( timestart ), 'YYYY') as date_enrol, COUNT(*)
            FROM {user_enrolments}
            where $where
            GROUP BY date_enrol
            ORDER BY date_enrol
        ";
    
        $count_users = $DB->get_records_sql($query);
        
        //print_object($count_users);
        return $count_users;
        /*
            SELECT to_char(to_timestamp( timestart ), 'YYYY') as date_enrol, COUNT(*)
            FROM mdlmoocu_user_enrolments
            where enrolid = 5 OR enrolid = 6 OR enrolid = 7
            GROUP BY date_enrolq    
            ORDER BY date_enrol
        */

    }
    private function count_enrol_user_semester($enrolsid, $courseid, $anio){
        global $DB;

        $where = '';
        $long = count($enrolsid);
        $count = 0;
        
        foreach( $enrolsid as $valor => $enrolid){
            $count++;
            $where .= 'enrolid = '. $enrolid->id;
            if( $long > $count ) { $where .= ' OR ';}
        }
        // CONTAR los usuarios de un curso por MEs
        $query = "
            SELECT CONCAT(to_char(to_timestamp( timestart ), 'YYYY'),'-',to_char(to_timestamp( timestart ), 'MM')) as semester, COUNT(*)
            FROM {user_enrolments}
            where ($where) AND (to_timestamp(timestart) >= '$anio-01-01' AND to_timestamp(timestart) <= '$anio-12-31')
            GROUP BY semester
            ORDER BY semester
        ";
               
        $count_users = $DB->get_records_sql($query);
        
  
        $lista = [];
        $cant1= 0;
        $cant2= 0;
        $flag=true;

        foreach ($count_users as $key => $users_month) {
            $year = explode('-',$users_month->semester)[0];
            $month = explode('-',$users_month->semester)[1];
            if($flag){
                $flag= false;
                $resp1 = new stdClass();
                $resp2 = new stdClass();
                
                $resp1->anio = $year;
                $resp1->semestre = $year."-1";
                $resp1->certificados=10;
                $resp2->anio = $year;
                $resp2->semestre = $year."-2";
                $resp2->certificados=20;     
            }
            if($month <= 6){
                $cant1= $cant1 +$users_month->count;          
            }else{
                $cant2= $cant2 +$users_month->count;
            }
        }
        $resp1->usuarios = $cant1;
        $resp2->usuarios = $cant2;

        //CONTAR POR MES TODOS LOS CERTIFICADOS 
        $consulta2 = " 
        SELECT to_char(to_timestamp(ce.timecreated), 'YYYY-MM') as fecha, COUNT(*)
        FROM {adc} a, {course} c, {certificates} ce, {user} u
        WHERE ce.certificateuid = a.certificateuid AND a.course = c.id AND ce.userid = u.id AND c.id = ? 
                AND (to_timestamp(ce.timecreated) >= '$anio-01-01' AND to_timestamp(ce.timecreated) <= '$anio-12-31') 
        GROUP BY fecha
        ORDER BY fecha ASC"; 

        $count_certificates = $DB->get_records_sql($consulta2,array($courseid));
        $cant1 = 0;
        $cant2 = 0;
        foreach ($count_certificates as $key => $users_month) {
            $year = explode('-',$users_month->fecha)[0];
            $month = explode('-',$users_month->fecha)[1];
            
            if($month <= 6){
                $cant1= $cant1 +$users_month->count;
            }else{
                $cant2= $cant2 +$users_month->count;
            }
        }
        $resp1->certificados=$cant1;
        $resp2->certificados=$cant2;

        // CONTAR los usuarios UDEC de un curso por MES 
        $query = "
            SELECT CONCAT(to_char(to_timestamp( ue.timestart ), 'YYYY'),'-',to_char(to_timestamp(ue.timestart ), 'MM')) as semester, COUNT(*)
            FROM {user_enrolments} ue , {user} u
            WHERE u.id = ue.userid AND u.email LIKE '%@udec.cl' AND (  ($where) AND (to_timestamp(timestart) >= '$anio-01-01' AND to_timestamp(timestart) <= '$anio-12-31') )
            GROUP BY semester
            ORDER BY semester
        ";
               
        $count_users_udec = $DB->get_records_sql($query);
        
  
        $cant1= 0;
        $cant2= 0;
        foreach ($count_users_udec as $key => $users_month) {
            $month = explode('-',$users_month->semester)[1];
            if($month <= 6){
                $cant1= $cant1 +$users_month->count;          
            }else{
                $cant2= $cant2 +$users_month->count;
            }
        }
        $resp1->usuarios_udec = $cant1;
        $resp2->usuarios_udec = $cant2;




        //CONTAR POR MES TODOS LOS CERTIFICADOS DE USUARIOS @UDEC.CL
        $consulta = " 
        SELECT to_char(to_timestamp(ce.timecreated), 'YYYY-MM') as fecha, COUNT(*)
        FROM {adc} a, {course} c, {certificates} ce, {user} u
        WHERE ce.certificateuid = a.certificateuid AND a.course = c.id AND ce.userid = u.id AND c.id = ? 
                AND (to_timestamp(ce.timecreated) >= '$anio-01-01' AND to_timestamp(ce.timecreated) <= '$anio-12-31')
                AND u.email LIKE '%@udec.cl'
        GROUP BY fecha
        ORDER BY fecha ASC"; 


        $count_certificates_udec = $DB->get_records_sql($consulta,array($courseid));
        $cant1 = 0;
        $cant2 = 0;
        foreach ($count_certificates_udec as $key => $users_month) {
            $month = explode('-',$users_month->fecha)[1];
            
            if($month <= 6){
                $cant1= $cant1 +$users_month->count;
            }else{
                $cant2= $cant2 +$users_month->count;
            }
        }

        $resp1->certificados_udec=$cant1;
        $resp2->certificados_udec=$cant2;
        
        $resp1->usuarios_externos= $resp1->usuarios - $resp1->usuarios_udec ;
        $resp1->certificados_externos= $resp1->certificados - $resp1->certificados_udec;

        $resp2->usuarios_externos= $resp2->usuarios - $resp2->usuarios_udec ;
        $resp2->certificados_externos= $resp2->certificados - $resp2->certificados_udec;

        $lista[] = $resp1;
        $lista[] = $resp2;

        return $lista;
    }

    /////////////////////////////////////////////////////////////////////////////////

    public function get_users_course($downloadable = true, $courseid) {
        global $DB;

        $consulta = "
            SELECT u.username as username, u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, u.lastaccess
            FROM {role_assignments} ra, {user} u, {course} c, {context} cxt
            WHERE ra.userid = u.id AND ra.contextid = cxt.id AND cxt.contextlevel = 50
            AND cxt.instanceid = c.id AND c.id = ? AND roleid = 5
            ORDER BY u.firstname"; 
        $usuarios = $DB->get_records_sql($consulta, array($courseid));
        // print_object($usuarios);
        return $usuarios;
    }
    public function get_users_course2($courseid) {
        global $DB;

        $consulta = "
            SELECT u.username as username, u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, u.lastaccess
            FROM {role_assignments} ra, {user} u, {course} c, {context} cxt
            WHERE ra.userid = u.id AND ra.contextid = cxt.id AND cxt.contextlevel = 50
            AND cxt.instanceid = c.id AND c.id = ? AND roleid = 5
            ORDER BY u.firstname"; 

        $consulta2= "SELECT 
                        LOWER(u.firstname) AS nombre,
                        LOWER(u.lastname) AS apellido,
                        u.email AS mail,
                        u.lastaccess,
                    CASE
                        WHEN u.institution ~ '^[0-9]' THEN u.institution
                        ELSE ''
                    END as facultad,
                    CASE
                    WHEN u.email LIKE '%@udec.cl%' THEN
                        CASE
                            WHEN u.idnumber IS NOT NULL AND u.idnumber <> '' THEN 'UDEC-AL'
                            WHEN u.idnumber IS NULL OR u.idnumber = '' THEN 'UDEC'
                        END
                        ELSE 'EXTERNO'
                    END as tipousuario
                    FROM
                        {course} c
                        JOIN {context} cxt ON cxt.contextlevel = 50 AND cxt.instanceid = c.id
                        JOIN {role_assignments} ra ON ra.contextid = cxt.id
                        JOIN {user} u ON ra.userid = u.id
                    
                    WHERE
                        c.id = ?
                        AND roleid = 5
                    ORDER BY u.firstname";

               
        $usuarios = $DB->get_records_sql($consulta2, array($courseid));
        // print_object($usuarios);
        return $usuarios;
    }

    public function course_students($downloadable = true){

        $course_platform = self::get_courses_platform($with_activity = true); 
        foreach ($course_platform as $key => $value) {
            $courseid = $value->id;
            $course_students = self::get_users_course($with_activity = true, $courseid );
            $value->numberuser = count($course_students);
        }

        return $course_platform;
    }

    // CERTIFICADOS POR CURSO
    public function get_certificate_per_course($downloadable = true){
        $user_platform = self::get_number_certificate($with_activity = true ); 
        if($downloadable){
            $headers = ['course_id','fullname','timecreated', 'numbercertificate'];
            $file_name = "Certificados curso";
            self::export_csv($user_platform, $headers, $file_name);
        }
        return $user_platform;
    }
    public function get_certificate_course(){
        global $DB;

        $consulta = " 
            SELECT ce.id, ce.certificateuid, a.course, c.fullname
            FROM {adc} a, {course} c, {certificates} ce
            WHERE ce.certificateuid = a.certificateuid AND a.course = c.id
            ORDER BY ce.id"; 
        $certificates = $DB->get_records_sql($consulta);
        
        return $certificates;
    }
    public function get_certificado_por_curso($idCurso){
        global $DB;

        $consulta = " 
            SELECT ce.id, ce.certificateuid, CONCAT(u.firstname,' ', u.lastname) as alumno, u.email, to_char(to_timestamp(ce.timecreated), 'YYYY-MM-DD') as fecha
            FROM {adc} a, {course} c, {certificates} ce, {user} u
            WHERE ce.certificateuid = a.certificateuid AND a.course = c.id 
                    AND ce.userid = u.id AND c.id = ?
            ORDER BY fecha DESC"; 

            $consulta3 = "SELECT
                            ce.id,
                            ce.certificateuid,
                            CONCAT(LOWER(u.firstname), ' ', LOWER(u.lastname)) as nombre,
                            u.email,
                            to_char(to_timestamp(u.timecreated), 'YYYY-MM-DD') as fecha,
                            c.fullname as curso,
                            CASE
                                WHEN u.institution ~ '^[0-9]' THEN u.institution
                                ELSE ''
                            END as facultad,
                            CASE
                                WHEN u.email LIKE '%@udec.cl%' THEN
                                    CASE
                                        WHEN u.idnumber IS NOT NULL AND u.idnumber <> '' THEN 'UDEC-AL'
                                        WHEN u.idnumber IS NULL OR u.idnumber = '' THEN 'UDEC'
                                    END
                                ELSE 'EXTERNO'
                            END as tipo_usuario
                        FROM {adc} a
                        JOIN {course} c ON a.course = c.id
                        JOIN {certificates} ce ON ce.certificateuid = a.certificateuid
                        JOIN {user} u ON ce.userid = u.id
                        ORDER BY nombre DESC";

        $consulta2 = "SELECT
                            ce.id,
                            ce.certificateuid,
                            CONCAT(LOWER(u.firstname), ' ',LOWER(u.lastname)) as alumno,
                            u.email,
                            to_char(to_timestamp(ce.timecreated), 'YYYY-MM-DD') as fecha,
                            CASE
                                WHEN u.institution ~ '^[0-9]' THEN u.institution
                                ELSE ''
                            END as facultad,
                            CASE
                                WHEN u.email LIKE '%@udec.cl%' THEN
                                    CASE
                                        WHEN u.idnumber IS NOT NULL AND u.idnumber <> '' THEN 'UDEC-AL'
                                        WHEN u.idnumber IS NULL OR u.idnumber = '' THEN 'UDEC'
                                    END
                                ELSE 'EXTERNO'
                            END as tipo_usuario
                        FROM {adc} a, {course} c, {certificates} ce, {user} u
                        WHERE
                            ce.certificateuid = a.certificateuid
                            AND a.course = c.id
                            AND ce.userid = u.id
                            AND c.id = ?
                        ORDER BY alumno DESC";
        $certificates = $DB->get_records_sql($consulta2,[$idCurso]);
        
        return $certificates;
    }
    public function get_certificate_course_emitido(){
        global $DB;

        $consulta = " 
            SELECT ce.id, ce.certificateuid, CONCAT(u.firstname,' ', u.lastname) as nombre,u.email, to_char(to_timestamp(u.timecreated), 'YYYY-MM-DD') as fecha
            FROM {adc} a, {course} c, {certificates} ce, {user} u
            WHERE ce.certificateuid = a.certificateuid AND a.course = c.id AND ce.userid = u.id 
            ORDER BY fecha DESC"; 

        $consulta2 = "SELECT
                            ce.id,
                            ce.certificateuid,
                            CONCAT(LOWER(u.firstname), ' ', LOWER(u.lastname)) as nombre,
                            u.email,
                            to_char(to_timestamp(u.timecreated), 'YYYY-MM-DD') as fecha,
                            c.fullname as curso,
                            CASE
                                WHEN u.institution ~ '^[0-9]' THEN u.institution
                                ELSE ''
                            END as facultad,
                            CASE
                                WHEN u.email LIKE '%@udec.cl%' THEN
                                    CASE
                                        WHEN u.idnumber IS NOT NULL AND u.idnumber <> '' THEN 'UDEC-AL'
                                        WHEN u.idnumber IS NULL OR u.idnumber = '' THEN 'UDEC'
                                    END
                                ELSE 'EXTERNO'
                            END as tipo_usuario
                        FROM {adc} a
                        JOIN {course} c ON a.course = c.id
                        JOIN {certificates} ce ON ce.certificateuid = a.certificateuid
                        JOIN {user} u ON ce.userid = u.id
                        ORDER BY nombre DESC";

        $certificates = $DB->get_records_sql($consulta2);
        
        return $certificates;
    }
    public function get_certificate_course_emitido2(){
        global $DB;

        
        $consulta = " 
            SELECT ce.id, u.id as userid,  CONCAT(u.firstname,' ', u.lastname) as nombrealumno, c.id as courseid, c.fullname as nombrecurso, to_char(to_timestamp(u.timecreated), 'YYYY-MM-DD') as fecha
            FROM {adc} a, {course} c, {certificates} ce, {user} u
            WHERE ce.certificateuid = a.certificateuid AND a.course = c.id AND ce.userid = u.id 
            ORDER BY u.id"; 
        $certificates = $DB->get_records_sql($consulta);
        
        return $certificates;
    }

    public function get_certificate_course_pendientes(){
        global $DB;

        $consulta = "SELECT
                        mdlmoocu_user.id AS userid,
                        CONCAT(LOWER(mdlmoocu_user.firstname), ' ', LOWER(mdlmoocu_user.lastname)) AS nombre,
                        mdlmoocu_course.id AS courseid,
                        mdlmoocu_course.fullname AS nombrecurso,
                        mdlmoocu_user.email,
                        CASE
                                WHEN mdlmoocu_user.institution ~ '^[0-9]' THEN mdlmoocu_user.institution
                                ELSE ''
                        END as facultad,
                        CASE
                                WHEN mdlmoocu_user.email LIKE '%@udec.cl%' THEN
                                    CASE
                                        WHEN mdlmoocu_user.idnumber IS NOT NULL AND mdlmoocu_user.idnumber <> '' THEN 'UDEC-AL'
                                        WHEN mdlmoocu_user.idnumber IS NULL OR mdlmoocu_user.idnumber = '' THEN 'UDEC'
                                    END
                                ELSE 'EXTERNO'
                        END as tipo
                    FROM mdlmoocu_user
                    INNER JOIN mdlmoocu_role_assignments
                    ON (mdlmoocu_user.id = mdlmoocu_role_assignments.userid)
                    INNER JOIN mdlmoocu_context
                    ON (mdlmoocu_role_assignments.contextid = mdlmoocu_context.id)
                    INNER JOIN mdlmoocu_course
                    ON (mdlmoocu_context.instanceid = mdlmoocu_course.id)
                    INNER JOIN mdlmoocu_course_categories
                    ON (mdlmoocu_course.category = mdlmoocu_course_categories.id)
                    WHERE mdlmoocu_context.contextlevel = 50
                        AND mdlmoocu_role_assignments.roleid = 5
                    ORDER BY mdlmoocu_user.id;"; 


        $usuariosMatriculados = $DB->get_records_sql($consulta);

        // print_object($usuarios);
        $usuariosCertificados = self::get_certificate_course_emitido2();

        foreach ($usuariosMatriculados as $key1 => $matriculado) {
            foreach ($usuariosCertificados as $key2 => $certificado) {

                if( ($matriculado->userid == $certificado->userid &&
                      $matriculado->courseid == $certificado->courseid) ){
                    unset($usuariosMatriculados[$key1]);

                }
            }
        }
        return $usuariosMatriculados;
    }
    
    public function get_number_metricas_certificados(){
        $usuariosPendientes = self::get_certificate_course_pendientes();
        $usuariosCertificados= self::get_certificate_course_emitido2();

        $metricas = new stdClass();
        $metricas->pendientes = count($usuariosPendientes);
        $metricas->certificados = count($usuariosCertificados);
        return $metricas;
    }

    private function get_number_certificate(){
        $courses_platform = self::get_courses_platform($with_activity = true); 
        $certificates_course = self::get_certificate_course();
        
        foreach ($courses_platform as $key => $course) {
            $count_certificado = 0;
            foreach ($certificates_course as $key => $certificate) {
                if($course->id == $certificate->course){
                    $count_certificado ++;
                }
            }
            $course->numbercertificates = $count_certificado;
        }
        return $courses_platform;
    }
    
    // DATOS GRAFICO
    function get_data_grafic(){
        $data = array ( 1 => "['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']", 2 => [12, 19, 3, 5, 2, 3] );
        if($downloadable){
            $headers = ['label','data'];
            $file_name = "Datos grafico";
            self::export_csv($data, $headers, $file_name);
        }
        return  $data;
    }

    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////


    public function get_active_student($downloadable = false){
        $active_student = self::get_users($with_activity = true, self::STUDENT_ROLES); 
        if($downloadable){
            $headers = ['course_id', 'course_name', 'user_id','username', 'firstname', 'lastname', 'email' ,'has_activity'];
            $file_name = "Listado de estudiantes activos";
            self::export_csv($active_student, $headers, $file_name);
        }
        return $active_student;
    }

    public function get_student_general($downloadable = false){
        $active_student = self::get_users_general($with_activity = true, self::STUDENT_ROLES); 
        if($downloadable){
            $headers = ['course_id', 'course_name', 'user_id','username', 'firstname', 'lastname', 'email' ,'has_activity'];
            $file_name = "Listado de estudiantes activos";
            self::export_csv($active_student, $headers, $file_name);
        }
        return $active_student;
    }

    public function count_active_students(){
        $active_student = count(self::get_active_student());
        return $active_student;
    }

    private function get_users_general($with_activity, $role){
        global $DB;
        $users = array();
        if(empty($role)){
            return $users;
        }
        // list($in_role, $invalues_role) = $DB->get_in_or_equal($role);
        // $dates = array($this->date->start, $this->date->end);
        // $params = array_merge($dates, $invalues_role);
        // $params = array_merge($params, $dates);
        // $with_activity = $with_activity ? ' > 0' :  ' = 0'; 
        // $sql_has_activity = "SELECT count(*) FROM {logstore_standard_log} WHERE courseid = c.id AND userid = u.id 
        //                      AND timecreated >= ? AND timecreated <= ?";
        $sql = "SELECT c.id as course_id, c.fullname as course_name, u.id as user_id, u.username, u.firstname, u.lastname, u.email
                FROM {course} as c, {role_assignments} AS ra, {user} AS u, {context} AS ct WHERE c.id = ct.instanceid
                AND ra.userid = u.id AND ct.id = ra.contextid";
        $rows = $DB->get_recordset_sql($sql, $params);
        foreach($rows as $row){
            array_push($users, $row);
        }
        // print_object($users);
        return $users;
    }

    public function count_viewed_courses(){
        $viewed = self::get_viewed_courses();
        $counted = count($viewed);
        return $counted;
    }

    public function get_viewed_courses($downloadable = false){
        $viewed = self::viewed_courses();
        if($downloadable){
            $headers = ['id', 'category', 'sortorder', 'fullname', 'shortname', 'idnumber', 
                        'showgrades', 'newsitems', 'startdate', 'enddate', 'marker', 'maxbytes', 
                        'legacyfiles', 'showreports', 'visible', 'visibleold', 'groupmode', 'groupmodeforce',
                        'defaultgroupingid', 'lang', 'calendartype','theme','timecreated', 'timemodified', 
                        'interactions', 'category_name'];
            $file_name = "Listado de cursos con intereacciones";
            self::export_csv($viewed, $headers, $file_name);
        }
        return $viewed;
    }

    private function viewed_courses(){
        global $DB;
        $sql = "SELECT c.id, c.category, c.sortorder, c.fullname, c.shortname, c.idnumber, 
                c.showgrades, c.newsitems, c.startdate, c.enddate, c.marker, c.maxbytes, 
                c.legacyfiles, c.showreports, c.visible, c.visibleold, c.groupmode, c.groupmodeforce,
                c.defaultgroupingid, c.lang, c.calendartype, c.theme, c.timecreated, c.timemodified, 
                count(*) AS interactions, ct.name AS category_name
                FROM {logstore_standard_log} lsl, {course} c, {course_categories} ct
                WHERE lsl.courseid = c.id AND c.category = ct.id AND lsl.timecreated >= ? AND lsl.timecreated <= ? AND lsl.courseid > 1 GROUP BY c.id, ct.id";
        $params = [$this->date->start, $this->date->end];
        $courses = $DB->get_records_sql($sql, $params); 
        return $courses;
    }
    /////////////////////////////////////////////////////////////////////////
    private function remove_old_files(){
        $files = glob('./downloads/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
    }

    private function export_csv($rows, $headers,  $ouput_name){
        $now = time();
        $file_name = "{$now} - {$ouput_name}.csv";
        $path = fopen("./downloads/{$file_name}", "w");       
        fprintf($path, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($path, $headers,"\t");       
        foreach($rows as $row){ 
            $row = self::extract_value($row); 
            fputcsv($path, $row, "\t");
        }       
        fclose($path);
        $link = "downloads/{$file_name}";
        $message = 'Mensaje prueba jm';
        $this->download_links[$ouput_name] = $link;
    }

    private function extract_value($row){
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

    public function get_download_links(){
        return $this->download_links;
    }

    public function zip_download_link(){
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
    
    /************************************
            Funciones no utilizadas
    ************************************/ 
    /*
    private function get_course_ids(){
        $ids = array();
        foreach($this->courses as $course){
            array_push($ids, $course->id);
        }
        return $ids;
    }

    public function get_active_teachers($downloadable = false){
        $active_teachers = self::get_users($with_activity = true, self::TEACHER_ROLES); 
        if($downloadable){
            $headers = ['course_id', 'course_name', 'user_id','username', 'firstname', 'lastname', 'email' ,'has_activity'];
            $file_name = "Listado de docentes activos";
            self::export_csv($active_teachers, $headers, $file_name);
        }
        return $active_teachers;
    }

    public function count_active_teachers(){
        $active_teachers = count(self::get_active_teachers());
        return $active_teachers;
    }

    private function remove_old_files(){
        $files = glob('./downloads/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
    }    

    public function count_resources(){
        $count_type_resource = self::get_number_resources_by_type();
        return $count_type_resource;
    }

    private function get_log_resources(){
        global $DB;
        $sql = "SELECT id, courseid,userid,objecttable,timecreated FROM {logstore_standard_log} WHERE timecreated >= ? AND timecreated <= ? AND target = ? AND objecttable != ?";
        $params = [$this->date->start, $this->date->end, 'course_module', 'course_modules'];
        $rows = $DB->get_recordset_sql($sql, $params);
        $resources = array();
        foreach($rows as $row){
            array_push($resources, $row);
        }
        return $resources;
    }

    private function get_number_resources_by_type(){
        $logs = self::get_log_resources();
        $resource_array = array();
        foreach($logs as $log){
            array_push($resource_array, $log->objecttable);
        }
        
        $count_resource = array_count_values($resource_array);
        $count_type_resource = count($count_resource);

        return $count_type_resource;
    } 

    public function get_number_of_times_resource_is_used(){
        $resource = self::count_for_type_resource();
        return $resource;
    }

    private function count_for_type_resource(){
        $logs = self::get_log_resources();
        $resource_array = array();
        foreach($logs as $log){
            array_push($resource_array, $log->objecttable);
        }
        
        $count_resource = array_count_values($resource_array);

        return $count_resource;
    }

    public function get_detail_resource($downloadable = false){
        $resource = self::get_log_resources();
        if($downloadable){
            $headers = ['id', 'courseid', 'userid', 'objecttable', 'timecreated'];
            $file_name = "Listado de recursos utlizado";
            self::export_csv($resource, $headers, $file_name);
        }
        return $resource;
    }
    */
}