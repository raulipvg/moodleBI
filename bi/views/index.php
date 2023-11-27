<?php include_once('../layout/header.php'); 
	$pag= 1;


?>
<div class="invisible">
            <?php
                $start = isset($_GET['start']) ? $_GET['start'] : 1586145600;
                $end = isset($_GET['end']) ? $_GET['end'] : time();
                $report = new Report($start, $end);

                // Link descarga
                //$report->get_users($download = true);
                //$report->get_courses($download = true);
                //$report->get_certificate($download = true);
                //$report->get_user_per_course($download = true);
                //$report->get_certificate_per_course($download = true);
                //$report->get_user_per_course_age($download = true);
                //$data_chart = $report->get_data_grafic();
                
                // $report->get_courses($download = true);
                // $report->get_active_student($download = true);
                // $report->get_viewed_courses($download = true);
                // $report->get_users($download = true);
                // $report->get_users_course($download = true);
                // $report->get_usr($download = true);
                
            ?>
        </div>
					
				

					<!--begin::Content-->
					<div class="d-flex flex-column flex-column-fluid" style="margin-top: -5%;">
						<div class="card bg-light shadow-sm m-2">
							<!--begin::Container-->
							<div class="d-flex flex-wrap flex-center justify-content-lg-between mx-auto w-xl-900px">
								<!--begin::Item-->
								<div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Listar todos los usuarios">
									<div id="lista-usuario" class="d-flex flex-column flex-center h-100px w-100px h-lg-125px w-lg-125px m-3 bg-info rounded-circle btn" data-bs-toggle="modal" data-bs-target="#modalUsuario">
										<!--begin::Symbol-->
										<i class="ki-duotone ki-user fs-3x pe-0">
										<span class="path1"></span>
										<span class="path2"></span>
										</i>
										<!--end::Symbol-->

										<!--begin::Info-->
										<div class="mb-0 text-center">
											<!--begin::Value-->
											<div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center" style="line-height: 90%;">
												<div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?php echo $report->count_users() ?>" data-kt-countup-suffix="">0</div>
											</div>
											<!--end::Value-->

											<!--begin::Label-->
											<span class="text-white fw-semibold fs-5 lh-0">Usuarios</span>
											<!--end::Label-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								<!--end::Item-->

								<!--begin::Item-->
								<div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Listar todos los cursos">
									<div id="lista-curso" class="d-flex flex-column flex-center h-100px w-100px h-lg-125px w-lg-125px m-3 bg-info rounded-circle btn" data-bs-toggle="modal" data-bs-target="#modalCurso">
										<!--begin::Symbol-->
										<i class="ki-duotone ki-book-open fs-3x pe-0">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</i>
										<!--end::Symbol-->

										<!--begin::Info-->
										<div class="mb-0 text-center">
											<!--begin::Value-->
											<div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center text-center" style="line-height: 90%;">
												<div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?php echo $report->count_courses() ?>" data-kt-countup-suffix="">0</div>
											</div>
											<!--end::Value-->

											<!--begin::Label-->
											<span class="text-white fw-semibold fs-5 lh-0">Cursos</span>
											<!--end::Label-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								<!--end::Item-->

								<!--begin::Item-->
								<div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Listar todos los certificados">
									<div id="lista-certificado" class="d-flex flex-column flex-center h-100px w-100px h-lg-125px w-lg-125px m-3 bg-info rounded-circle btn" data-bs-toggle="modal" data-bs-target="#modalCertificado">
										<!--begin::Symbol-->
										<i class="ki-duotone ki-scroll fs-3x">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
										<!--end::Symbol-->

										<!--begin::Info-->
										<div class="mb-0 text-center">
											<!--begin::Value-->
											<div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center text-center" style="line-height: 90%;">
												<div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="<?php echo $report->count_certificate(); ?>" data-kt-countup-suffix="">0</div>
											</div>
											<!--end::Value-->

											<!--begin::Label-->
											<span class="text-white fw-semibold fs-5 lh-0">Certificados</span>
											<!--end::Label-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								<!--end::Item-->
							</div>						
							<!--end::Container-->
						</div>
						<!--
						<div class="d-flex p-2">
							<div class="me-2 border border-dashed border-3 border-gray-400 rounded">
								<div class="d-flex flex-row align-items-center">
									<div class="ps-2 text-gray-600 fw-semibold fs-6 me-2">Seleccione Curso: </div>
									<div>
										<select id="criterio-curso2" name="criterio-video" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Criterio" data-hide-search="true">
											<option value=""></option>
											<option value="1" selected>Curso 1</option>
											<option value="2">Curso 2</option>
											<option value="3">Curso 3</option>
											<option value="4">Curso 4</option>
											<option value="5">Curso 5</option>
											<option value="7">Curso 6</option>
											<option value="8">Curso 7</option>
										</select>
									</div>
								</div>

								
							</div>
						</div>
						-->
						<div class="d-flex flex-row flex-wrap">
							<div id="curso-ano" class="col-md-6 col-12 mb-2 px-2">
								<div class="card bg-light shadow-sm">
									<div class="card-header">
											<h3 id="titulo-curso" class="card-title text-primary text-uppercase fw-bolder "></h3>
											
											<div class="card-toolbar">
												<div class="d-flex flex-row align-items-center">
													<div class="text-gray-600 fw-semibold fs-6 me-2">Curso: </div>
													<div class="w-200px">
														<select id="criterio-curso" name="criterio-video" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Criterio" data-hide-search="false">
															<option value=""></option>
														</select>
													</div>
												</div>
												<small id="fecha-curso" class="text-muted fs-7 fw-semibold my-1">#Inicio 12-09-2022</small>
											
											</div>
										
										
									</div>
									<div class="card-body p-1 p-md-2">
										<div id="chartdiv"></div>
									</div>
									<div class="card-footer p-3 text-center">
										<div class="d-flex flex-row justify-content-center"> 
											<div class="mx-2 mb-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Listar los usuarios del curso">
												<button id="lista-usuario-curso" class="btn btn-sm btn-info fs-7 text-white p-2" data-bs-toggle="modal" data-bs-target="#modalUsuario">TOTAL USUARIOS: 5000</span>
											</div>
											<div class="mx-2 mb-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Listar los certificados emitidos del curso">
												<button id="lista-certificado-curso" class="btn btn-sm btn-light-info fs-7  p-2" data-bs-toggle="modal" data-bs-target="#modalCertificadoEmitido">TOTAL CERTIFICADOS: 2000</span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div id="curso-detalle-1" class="col-md-6 col-12 px-2" style="display: none;">
								<div id="curso-detalle-2" class="card bg-light shadow-sm">
									<div class="card-header">
										<h3 id="titulo-curso-anio" class="card-title text-primary text-uppercase fw-bolder ">Curso 1 por Año</h3>
										<div class="card-toolbar">
											<button type="button" class="btn btn-sm btn-light" onclick="exportarExcel()">
												Exportar
											</button>
										</div>
									</div>
									<div id="body-curso-anio" class="card-body card-scroll h-465px p-2 p-md-7">
										
										<!-- BEGIN::CURSO POR AÑO 
										<div class="col-12 border border-2 rounded mb-2">
											<div class="d-flex flex-row">
												<div class="flex-column">
													<div class="close-tab">
														<div class="btn btn-icon btn-sm btn-active-light-primary" aria-label="Close">
															<i class="ki-duotone ki-cross fs-3x">
																<span class="path1"></span>
																<span class="path2"></span>
															</i>
														</div>
													</div>
													<div class="fs-md-2 fs-4 fw-bold text-gray-800 mt-2 ms-2">2020</div>
												</div>
												<div class="flex-fill">
													<div class="d-flex flex-column">
														<div class="p-2 bd-highlight">
															<div class="d-flex flex-row justify-content-center align-items-center">
																<div class="col-md-1 col-2 fw-bold fs-md-4 fs-7">2020-1</div>
																<div class="col-md-11 col-10">
																	
																	<div class="accordion" id="acordion2020">
    																	<div class="accordion-item">
        																	<h2 class="accordion-header" id="acordion_header_2020_1">
																				<button class="accordion-button fs-4 fw-semibold collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#acordion_body_2020_1" aria-expanded="false" aria-controls="acordion_body_2020_1">
																					<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"> 
																						<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" type="button" style="width:32%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">250</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-4 fw-bolder ms-auto h-100 px-3 position-relative z-index-2 text-white" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">800</div>
																					</div>
																				</button>
        																	</h2>
																			<div id="acordion_body_2020_1" class="accordion-collapse collapse" aria-labelledby="acordion_header_2020_1" data-bs-parent="#acordion">
																				<div class="accordion-body p-1 pb-0">
																					<div class="rounded-pill bg-light-danger d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: 37.5%;"> 
																						<div class="position-absolute rounded-pill d-block bg-danger start-0 top-0 h-100 z-index-1" type="button" style="width:32%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Udec"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">150</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Udec">300</div>
																					</div>
																					<div class="rounded-pill bg-light-success d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: 62.5%;"> 
																						<div class="position-absolute rounded-pill d-block bg-success start-0 top-0 h-100 z-index-1" type="button" style="width:32%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Externos"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">100</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Externos">500</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																															
																</div>			
															</div>	
														</div>

														<div class="p-2 bd-highlight">
															<div class="d-flex flex-row justify-content-center align-items-center">
																<div class="col-md-1 col-2 fw-bold fs-md-4 fs-7">2020-2</div>
																<div class="col-md-11 col-10">
																	
																	<div class="accordion" id="acordion2020">
    																	<div class="accordion-item">
        																	<h2 class="accordion-header" id="acordion_header_2020_1">
																				<button class="accordion-button fs-4 fw-semibold collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#acordion_body_2020_1" aria-expanded="false" aria-controls="acordion_body_2020_1">
																					<div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"> 
																						<div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" type="button" style="width:32%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">370</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-4 fw-bolder ms-auto h-100 px-3 position-relative z-index-2 text-white" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos">650</div>
																					</div>
																				</button>
        																	</h2>
																			<div id="acordion_body_2020_1" class="accordion-collapse collapse" aria-labelledby="acordion_header_2020_1" data-bs-parent="#acordion">
																				<div class="accordion-body p-1 pb-0">
																					<div class="rounded-pill bg-light-danger d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: 46%;"> 
																						<div class="position-absolute rounded-pill d-block bg-danger start-0 top-0 h-100 z-index-1" type="button" style="width:33.3%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Udec"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">100</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Usuarios Inscritos Udec">300</div>
																					</div>
																					<div class="rounded-pill bg-light-success d-flex align-items-center position-relative h-30px p-2 mb-1 overflow-hidden" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" style="width: 54%;"> 
																						<div class="position-absolute rounded-pill d-block bg-success start-0 top-0 h-100 z-index-1" type="button" style="width:34%;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Certificados Emitidos Externos"></div>
																						<div class="d-flex align-items-center position-relative z-index-2">
																							<a href="#" class="fw-bold text-white text-hover-dark">120</a>
																						</div>
																						<div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="usuarios Inscritos Externos">350</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	
																</div>			
															</div>										
														</div>
																										
													</div>										
												</div>

											</div>										
											
										</div>
										 END::CURSO POR AÑO -->


										
									</div>
									<!--
									<div class="card-footer p-3">
										Footer
									</div>
									-->
								</div>
							</div>
						</div>

				</div>
					<!--end::Content-->

					<!--begin::Modal Usuario -->
					<div class="modal modal-xl fade" tabindex="-1" id="modalUsuario" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header p-2">
									<h3 class="modal-title px-5">Lista de Usuarios - Alumnos</h3>
									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2 modal-close" data-bs-dismiss="modal" aria-label="Close">
										<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>
									</div>
									<!--end::Close-->
								</div>

								<div class="modal-body px-3 py-2">
										<table id="tabla-usuario" class="datatable table  table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th>Nombre</th>
													<th>Email</th>													
													<th>Tipo</th>
													<th>Facultad</th>
												</tr>
											</thead>
											<tbody>
																											
															
											</tbody>
										</table>
								</div>

								<div class="modal-footer p-1">
									<button type="button" class="btn btn-primary modal-close" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<!--end::Modal Usuario -->

					<!--begin::Modal Curso -->
					<div class="modal modal-xl fade" tabindex="-1" id="modalCurso" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header p-2">
									<h3 class="modal-title px-5">Lista de Cursos</h3>
									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2 modal-close" data-bs-dismiss="modal" aria-label="Close">
										<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>
									</div>
									<!--end::Close-->
								</div>

								<div class="modal-body px-3 py-2">
									<table id="tabla-curso" class="datatable table  table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th>#</th>
													<th>Curso</th>
													<th>Fecha Inicio</th>
												</tr>
											</thead>
											<tbody>
												<!--
															<tr>
																<th>1</th>
																<td>LALA</td>
																<td>LELE</td>
																
															</tr> 
												-->
															
															
											</tbody>
										</table>
								</div>

								<div class="modal-footer p-1">
									<button type="button" class="btn btn-primary modal-close" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<!--end::Modal Curso -->

					<!--begin::Modal Certificado -->
					<div class="modal modal-xl fade" tabindex="-1" id="modalCertificado" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header p-2">
									<h3 class="modal-title px-5">Lista de Certificados</h3>

									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2 modal-close" data-bs-dismiss="modal" aria-label="Close">
										<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>
									</div>
									<!--end::Close-->
								</div>

								<div class="modal-body">

								<!--begin::Chart container-->
								<div id="grafico" class="d-flex justify-content-center">
									<div id="kt_charts" class="w-50 h-150px"></div>
								</div>
								<!--end::Chart container-->
								<div class="div-loading border border-dashed border-3 rounded p-1">
									<h1 id="titulo-certificado" class="text-dark text-center fs-4 my-1">Certificados Emitidos </h1>
									<table id="tabla-certificado" class="datatable table  table-row-dashed table-hover rounded gy-2 gs-md-3">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th class="col-3">Nombre</th>
													<th class="col-3">Email</th>
													<th class="col-3">Curso</th>
													<th class="col-1">TIPO</th>
													<th class="col-2">Facultad</th>
												</tr>
											</thead>
											<tbody>
												
													<!--
															<tr>
																<th>1</th>
																<td>LALA</td>
																<td>LELE</td>
																<td>LILI</td>
																<td class="text-center p-0">
																	<a class="btn btn-primary btn-sm" href="#">Ver</a>
																</td>
															</tr> 
															<tr>
																<th>2</th>
																<td>LALA</td>
																<td>LELE</td>
																<td>LILI</td>
																<td class="text-center p-0">
																	<a class="btn btn-primary btn-sm" href="#">Ver</a>
																</td>
															</tr> 
													-->
															
											</tbody>
										</table>
									</div>
								</div>

								<div class="modal-footer p-1">
									<button type="button" class="btn btn-primary modal-close" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<!--end::Modal Certificado -->

					<!--begin::Modal Certificado Emitido -->
					<div class="modal modal-xl fade" tabindex="-1" id="modalCertificadoEmitido" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header p-2">
									<h3 class="modal-title px-5">Curso 1 - Certificados Emititos</h3>
									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
										<i class="ki-duotone ki-cross fs-3x"><span class="path1"></span><span class="path2"></span></i>
									</div>
									<!--end::Close-->
								</div>

								<div class="modal-body">
										<table id="tabla-certificado-curso" class="datatable table  table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
											<thead>
												<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
													<th>Nombre</th>
													<th>Email</th>
													<th>Tipo</th>
													<th>Facultad</th>
												</tr>
											</thead>
											<tbody>
												<!--
															<tr>
																<th>1</th>
																<td>LALA</td>
																<td>LELE</td>
																<td>LILI</td>
																<td class="text-center p-0">
																	<a class="btn btn-primary btn-sm" href="#">Ver</a>
																</td>
															</tr> 
												-->
															
											</tbody>
										</table>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
					<!--end::Modal Certificado Emitido -->


<?php include_once('../layout/footer.php'); ?>

