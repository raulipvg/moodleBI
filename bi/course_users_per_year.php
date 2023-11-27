<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Informes Campus Abierto</title>
        <style>
            body{
                background-color: #ffffff;
            }
            .bg-purple {
                background-color: #6f42c1;
            }
            .bg-campus-blue {
                background-color: #1b2fa6!important;
            }
            nav {
                max-height: 300px;
                margin-bottom: 3rem;
            }
            nav.navbar .logo img {
                max-height: 70px;
            }
            .navbar-brand {
                margin-left: 2rem;
            }
            main {
                margin-top: 4rem;
                margin-bottom: 4rem;
            }
            table {
            	margin-top: 150px;
            }
        </style>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit','-1');
        set_time_limit(0);

        require_once '../../config.php';
        require_once 'ReportClass.php';
        ?>
        <div class="invisible">
            <?php
                $start = isset($_GET['start']) ? $_GET['start'] : 1586145600;
                $end = isset($_GET['end']) ? $_GET['end'] : time();
                $report = new Report($start, $end);

                // Link descarga
                /*$report->get_users($download = true);
                $report->get_courses($download = true);
                $report->get_certificate($download = true);
                $report->get_user_per_course($download = true);
                $report->get_certificate_per_course($download = true);
                $report->get_user_per_course_age($download = true);
                $data_chart = $report->get_data_grafic();*/
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
			      		<th scope="col">Id Curso</th>
					    <th scope="col">Mooc</th>
					    <th scope="col">Fecha inicio</th>
					    <th scope="col">Total usuarios</th>
                        <th scope="col">2019</th>
                        <th scope="col">2020</th>
                        <th scope="col">2021</th>
                        <th scope="col">2022</th>
                        <th scope="col">2023</th>
                        <th scope="col">Detalle por semestre</th>
			    	</tr>
			  	</thead>
			  	<tbody>
			  		<?php foreach ($report->get_user_per_course_age() as $key => $course): ?>
			  			<tr>
				      		<td><?php echo $course->id;?></td>
					      	<td><?php echo $course->fullname;?></td>
					      	<td><?php echo $course->to_char;?></td>
                            <td><?php echo $course->totalusers;?></td>
					      	<td><?php echo (!empty($course->diecinueve)) ? $course->diecinueve : '-'; ?></td>
                            <td><?php echo (!empty($course->veinte)) ? $course->veinte : '-'; ?></td>
                            <td><?php echo (!empty($course->veintiuno)) ? $course->veintiuno : '-'; ?></td>
                            <td><?php echo (!empty($course->ventidos)) ? $course->ventidos : '-'; ?></td>
                            <td><?php echo (!empty($course->ventitres)) ? $course->ventitres : '-'; ?></td>
                            <td><a class='btn btn-primary' href=<?php echo '/aulaabierta/reportes/bi/user_certificates_per_semester.php?id='.$course->id ?> >Ver detalle</a></td>
				    	</tr>	
			  		<?php endforeach ?>	
				</tbody>
			</table>

			<?php
				foreach($report->get_download_links() as $name => $url){
					if($name == 'Usuarios curso por año'){ ?>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                            <a class='btn btn-primary' href='/aulaabierta/reportes/bi'>Volver</a>
						    <a class='btn btn-primary' href='/aulaabierta/reportes/bi/<?php echo $url;?>'>Descargar detalle</a>
                        </div>
					<?php }
				}
			?>
        </main>
    </body>
</html>