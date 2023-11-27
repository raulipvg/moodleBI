<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/styles.css">
        <title>Informes Campus Abierto</title>
    </head>
    <body>
        <div class="invisible">
            <?php
                require_once '../../config.php';
                require_once 'ReportClass.php';
                $start = isset($_GET['start']) ? $_GET['start'] : 1586145600;
                $end = isset($_GET['end']) ? $_GET['end'] : time();
                $report = new Report($start, $end);
            ?>
        </div>

        <nav class="fixed-top navbar navbar-light bg-campus-blue navbar-expand moodle-has-zindex" aria-label="Navegación del sitio">
            <a href="https://campusabierto.udec.cl/aulaabierta" class="navbar-brand has-logo">
                <span class="logo d-none d-sm-inline">
                    <img src="https://campusabierto.udec.cl/aulaabierta/pluginfile.php/1/core_admin/logo/0x200/1635176411/CAMPUS%20ABIERTO_BLANCO.png" alt="campus-abierto-udec">
                </span>
            </a>
        </nav>

        <main class="container">
           
        	<table class="table">
				<thead>
			    	<tr>
			      		<th>Id Curso</th>
					    <th>Mooc</th>
					    <th>Fecha inicio curso</th>
					    <th>Semestre</th>
					    <th>Numero usuarios</th>
					    <th>Certificados emitidos</th>
			    	</tr>
			  	</thead>
			  	<tbody>
                    <tr>
                        <th>3</th>
                        <th>Proceso Constituyente</th>
                        <th>06-01-2020</th>
                        <th>2019-1</th>
                        <th>0</th>
                        <th>0</th>
                    </tr>
                    <tr>
                        <th>3</th>
                        <th>Proceso Constituyente</th>
                        <th>06-01-2020</th>
                        <th>2019-2</th>
                        <th>2</th>
                        <th>0</th>
                    </tr>
                    <tr>
                        <th>3</th>
                        <th>Proceso Constituyente</th>
                        <th>06-01-2020</th>
                        <th>2020-1</th>
                        <th>1200</th>
                        <th>231</th>
                    </tr>
                    <tr>
                        <th>3</th>
                        <th>Proceso Constituyente</th>
                        <th>06-01-2020</th>
                        <th>2020-2</th>
                        <th>1308</th>
                        <th>402</th>
                    </tr>
			  		<?php foreach ($report->get_user_per_course_age() as $key => $course): /*print_object($course);*/ ?>
			  			<!--<tr>
				      		<th scope="row"><?php echo $key; ?></th>
					      	<td><?php echo $course->fullname; ?></td>
					      	<td><?php echo $course->to_char; ?></td>
                            <td><?php echo $course->totalusers; ?></td>
					      	<td><?php echo $course->diecinueve; ?></td>
                            <td><?php echo $course->veinte; ?></td>
                            <td><?php echo $course->veintiuno; ?></td>
                            <td><?php echo $course->ventidos; ?></td>
                            <td><?php echo $course->ventitres; ?></td>
				    	</tr>-->	
			  		<?php endforeach ?>
				</tbody>
			</table>
			<?php
				foreach($report->get_download_links() as $name => $url){
                    if($name == 'Usuarios curso por año'){ ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                            <a class='btn btn-primary' href='/aulaabierta/reportes/bi/course_users_per_year.php'>Volver</a>
						    <a class='btn btn-primary' href='/aulaabierta/reportes/bi/<?php echo $url;?>'>Descargar detalle</a>
                        </div>
                        <?php }
				}
                ?>
        <?php
            echo 'Curso seleccionado => '.$_GET['id']; 
            print_object( $report->get_user_per_course_age_select($_GET['id'],true) ); 
        ?>
        </main>
    </body>
</html>