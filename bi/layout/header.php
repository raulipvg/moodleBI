<!DOCTYPE html>
<html lang="es">
	<!--begin::Head-->
	<head><base href=""/>
		<title>Informes Campus Abierto</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="es_US" />
		<meta property="og:type" content="article" />
		<meta property="og:site_name" content="Campus Abierto" />
		<link rel="shortcut icon" href="../assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="../assets/css/plugins.bundle.css?id=1" rel="stylesheet" type="text/css" />
		<link href="../assets/css/style.bundle.css?id=1" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
       
        <link href='../assets/css/datatables/datatables.bundle.css?id=1' rel='stylesheet' type="text/css"/>
        <link href="../assets/css/style.css?id=1" rel="stylesheet" type="text/css">


		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed app-default" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on">
		<!--begin::Theme mode setup on page load-->

		<!--begin::Page loading(append to body)-->
		<div class="page-loader">
			<span class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Cargando...</span>
			</span>
		</div>
		
		<!--end::Page loading-->
		<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit','-1');
        set_time_limit(0);

        require_once '../../../config.php';
        require_once '../ReportClass2.php';
		?>
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Aside-->
				<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<!--begin::Brand-->
					<div class="aside-logo py-8" id="kt_aside_logo">
						<!--begin::Logo-->
						<a href="<?php echo $CFG->wwwroot."/reportes/bi/views" ?>" class="d-flex align-items-center">
							<img alt="Logo" src="../assets/media/logos/logo.png" class="h-45px logo" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside menu-->
					<div class="aside-menu flex-column-fluid" id="kt_aside_menu">
						<!--begin::Aside Menu-->
						<div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
							<!--begin::Menu-->
							<div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
								<!--begin:Menu item-->
								<div class="menu-item here show py-2">
									<!--begin:Menu link-->
									<a href="<?php echo $CFG->wwwroot."/reportes/bi/views" ?>" class="menu-link menu-center">
										<span class="menu-icon me-0">
											<i class="ki-outline ki-home-2 fs-2x"></i>
										</span>
										<span class="menu-title">Inicio</span>
									</a>
									<!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								
								
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Aside Menu-->
					</div>
					<!--end::Aside menu-->
					
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Aside mobile toggle-->
							<div class="d-flex align-items-center d-lg-none ms-n1 me-2" title="Show aside menu">
								<div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
									<i class="ki-outline ki-abstract-14 fs-1"></i>
								</div>
							</div>
							<!--end::Aside mobile toggle-->
							<!--begin::Mobile logo-->
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<a href="../../demo6/dist/index.html" class="d-lg-none">
									<img alt="Logo" src="../assets/media/logos/logo1.png" class="h-25px" />
								</a>
							</div>
							<!--end::Mobile logo-->
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
								<img alt="Logo" src="../assets/media/logos/logo2.png" class="img-fluid p-1" />
								</div>
								<!--end::Navbar-->
								
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->