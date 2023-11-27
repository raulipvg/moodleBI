<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Informes Campus Abierto</title>
        <style>
            body{
                background-color: #ffffff;
            }
            .bg-purple {
                background-color: #6f42c1;
                /*background-color: #7952b3;*/
            }
            /* .invisible {
                height: 20px !important;
            } */
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
        

        <nav class="fixed-top navbar navbar-light bg-campus-blue navbar-expand moodle-has-zindex" aria-label="Navegación del sitio">
            <a href="https://campusabierto.udec.cl/aulaabierta" class="navbar-brand has-logo">
                    <span class="logo d-none d-sm-inline">
                        <img src="https://campusabierto.udec.cl/aulaabierta/pluginfile.php/1/core_admin/logo/0x200/1635176411/CAMPUS%20ABIERTO_BLANCO.png" alt="campus-abierto-udec">
                    </span>
            </a>
        </nav>

        <main class="container">
            <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
                <img class="me-3" src="images/logo-campusabierto.svg" alt="" width="120" height="50">
                <div class="lh-1">
                    <h1 class="h4 mb-0 text-white lh-1">Contadores generales</h1>
                    <small>Informes generales</small>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <?php  /*print_object($report->get_download_links());*/ foreach($report->get_download_links() as $name => $url):
                $index++;
                if($index <= 3):
                ?>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal"><?php echo $name; ?></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">
                            <?php switch ( $name ):
                            case 'Usuario plataforma':
                                echo $report->count_users();
                                break;
                            case 'Cursos plataforma':
                                echo $report->count_courses();
                                break;
                            case 'Certificados plataforma':
                                echo $report->count_certificate();
                                break;
                            endswitch; ?>
                            </h1>
                            <div class="alert alert-primary" role="alert">Este informe detalla el numero de cursos creados en la plataforma, para mas detalles de los cursos pinche el botón descargar</div>
                            <?php echo "<br/><a class='btn btn-outline-primary' href='/aulaabierta/reportes/bi/{$url}' target='__blank'>$name</a><br/>"; ?>
                        </div>
                    </div>
                </div>
                <?php endif;
                endforeach; ?>
            </div>

            <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
                <img class="me-3" src="images/logo-campusabierto.svg" alt="" width="120" height="50">
                <div class="lh-1">
                    <h1 class="h4 mb-0 text-white lh-1">Contadores por curso</h1>
                    <small>Informes generales</small>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <div class="col">
                    <div class="card mb-6 rounded-6 shadow">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Usuarios curso</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"></h1>
                            <div class="alert alert-primary" role="alert">Este informe detalla el numero de usuarios matriculados en un curso, para mas detalles pinche el botón</div>
                            <?php echo "<br/><a class='btn btn-outline-primary' href='/aulaabierta/reportes/bi/course_users.php'>Ver detalle</a><br/>"; ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-6 rounded-6 shadow">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Certificados curso</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"></h1>
                            <div class="alert alert-primary" role="alert">Este informe detalla el numero de certificados emitidos por cursos, para mas detalles pinche el botón</div>
                            <?php echo "<br/><a class='btn btn-outline-primary' href='/aulaabierta/reportes/bi/course_certificates.php'>Ver detalle</a><br/>"; ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-6 rounded-6 shadow">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Usuarios curso por año</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"></h1>
                            <div class="alert alert-primary" role="alert">Este informe detalla el numero de usuarios matriculados en cada curso y detallado por año, para mas detalles pinche el botón</div>
                            <?php echo "<br/><a class='btn btn-outline-primary' href='/aulaabierta/reportes/bi/course_users_per_year.php'>Ver detalle</a><br/>"; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <?php foreach($report->get_download_links() as $name => $url):
                $index2++;
                if($index2 > 3):
                ?>
                <div class="col">
                    <div class="card mb-6 rounded-6 shadow">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal"><?php echo $name; ?></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"></h1>
                            <div class="alert alert-primary" role="alert">Este informe detalla el numero de cursos creados en la plataforma, para mas detalles de los cursos pinche el botón descargar</div>
                            <?php echo "<br/><a class='btn btn-outline-primary' href='/aulaabierta/reportes/bi/{$url}' target='__blank'>$name</a><br/>"; ?>
                        </div>
                    </div>
                </div>
                <?php endif;
                endforeach;
                ?>
            </div> -->

            <!-- <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
                <img class="me-3" src="images/logo-campusabierto.svg" alt="" width="120" height="50">
                <div class="lh-1">
                    <h1 class="h4 mb-0 text-white lh-1">Graficos</h1>
                    <small>Graficos por curso</small>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-2 text-center">
                <div class="col">
                    <div class="card mb-6 rounded-6 shadow">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
        </main>
        
        <?php
            // if($report->zip_download_link()){
            //     echo "<br/><a href='/campusabierto/reportes/business/{$report->zip_download_link()}' target='__blank'>Descargar todos</a><br/>";
            // } 

            $data = array ( 1 => "['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']", 2 => [12, 19, 3, 5, 2, 3] );
        ?>
        <!-- <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script> -->
    </body>
</html>