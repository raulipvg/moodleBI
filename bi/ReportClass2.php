<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'constant.php';
require_once '../../../config.php';
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
    private function get_courses_platform(){
        global $DB;

        $consulta = " 
            SELECT c.id, c.fullname, to_char(to_timestamp( c.timecreated ), 'YYYY-MM-DD HH:MI:SS')
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
        $active_student = count(self::get_users_platform2());
        return $active_student;
    }
    private function get_users_platform(){
        global $DB;

        $consulta = "
            SELECT u.username as username, u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, to_char(to_timestamp( u.lastaccess ), 'YYYY-MM-DD HH:MI:SS')
            FROM {user} u
            ORDER BY u.id"; 

        $usuarios = $DB->get_records_sql($consulta);
        return $usuarios;
    }
    public function get_users_platform2(){
        global $DB;

        $consulta = "
            SELECT u.id as userid, u.firstname as nombre, u.lastname as apellido, u.email as mail, to_char(to_timestamp( u.lastaccess ), 'YYYY-MM-DD')
            FROM {user} u, {role_assignments} ra
            WHERE u.id = ra.userid  AND ra.roleid=5
            ORDER BY u.id"; 
        $usuarios = $DB->get_records_sql($consulta);
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
            SELECT c.id, c.userid, u.firstname, u.lastname, u.email, to_char(to_timestamp( c.timecreated ), 'YYYY-MM-DD HH:MI:SS')
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
    public function get_user_per_course_age_select($courseid, $downloadable=true){
        $userCourse = self::get_enrolid_course($courseid);
        //$ceua = self::count_enrol_user_age($userCourse);
        $ceua = self::count_enrol_user_semester($userCourse);
        
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
    private function count_enrol_user_semester($enrolsid){
        global $DB;

        $where = '';
        $long = count($enrolsid);
        $count = 0;
        
        foreach( $enrolsid as $valor => $enrolid){
            $count++;
            $where .= 'enrolid = '. $enrolid->id;
            if( $long > $count ) { $where .= ' OR ';}
        }
        
        $query = "
            SELECT CONCAT(to_char(to_timestamp( timestart ), 'YYYY'),'-',to_char(to_timestamp( timestart ), 'MM')) as semester, COUNT(*)
            FROM {user_enrolments}
            where $where
            GROUP BY semester
            ORDER BY semester
        ";

        $count_users = $DB->get_records_sql($query);
        $semester = array();
        //$semester = [2019-1=> 0,2019-2=> 0, 2020-1=> 0,2020-2=> 0,2021-1=> 0,2021-2=> 0,2022-1=> 0,2022-2=> 0,2023-1=> 0,2023-2=> 0 ];
        //print_object($semester); 
        

        foreach ($count_users as $key => $users_month) {
            //echo '<br>';
            $year = explode('-',$users_month->semester)[0];
            $month = explode('-',$users_month->semester)[1];
            //echo 'año => ' . $year;
            //echo ' mes =>'. $month;
            
        }


        //return $count_users;
    }

    /////////////////////////////////////////////////////////////////////////////////

    private function get_users_course($downloadable = true, $courseid) {
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
    private function course_students($downloadable = true){

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
    private function get_certificate_course(){
        global $DB;

        $consulta = " 
            SELECT ce.id, ce.certificateuid, a.course, c.fullname
            FROM {adc} a, {course} c, {certificates} ce
            WHERE ce.certificateuid = a.certificateuid AND a.course = c.id
            ORDER BY ce.id"; 
        $certificates = $DB->get_records_sql($consulta);
        
        return $certificates;
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