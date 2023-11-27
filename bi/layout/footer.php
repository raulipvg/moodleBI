					
                    <!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-semibold me-1">2023&copy;</span>
								<a href="#" target="_blank" class="text-gray-800 text-hover-primary">CFRD</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Menu-->
							<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2">Sobre</a>
								</li>
							</ul>
							<!--end::Menu-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->


				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->

		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-outline ki-arrow-up"></i>
		</div>
		<!--end::Scrolltop-->

		<!--begin::Modals-->
	
		<!--end::Modals-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="../assets/js/plugins.bundle.js"></script>
		<script src="../assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
        
        <?php if($pag == 1){ ?>
        <!-- Datatables y Configuracion de la Tabla -->
        <script src="../assets/js/datatables/datatables.bundle.js"></script>
        <script src="../assets/js/datatables/contenido/general.js?id=1"></script>

        <!-- amcharts -->
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

        <!--- Eventos de la pagina -->
		<script src="../assets/js/amcharts/certificado.js?id=1"></script>
		<script src="../assets/js/amcharts/curso.js?id=7"></script>
        <script src="../assets/js/eventos/general.js?id=1"></script>
        

        <?php } ?>


		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>