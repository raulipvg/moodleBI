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
						<a href="../../demo6/dist/index.html" class="d-flex align-items-center">
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
								<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item here show py-2">
									<!--begin:Menu link-->
									<span class="menu-link menu-center">
										<span class="menu-icon me-0">
											<i class="ki-outline ki-home-2 fs-2x"></i>
										</span>
										<span class="menu-title">Inicio <?php echo $CFG->wwwroot ?></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu content-->
											<div class="menu-content">
												<span class="menu-section fs-5 fw-bolder ps-1 py-1">Home</span>
											</div>
											<!--end:Menu content-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link active" href="../../demo6/dist/index.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Default</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="../../demo6/dist/dashboards/ecommerce.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">eCommerce</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="../../demo6/dist/dashboards/projects.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Projects</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="../../demo6/dist/dashboards/online-courses.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Online Courses</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="../../demo6/dist/dashboards/marketing.html">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Marketing</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_dashboards_collapse">
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/bidding.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Bidding</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/pos.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">POS System</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/call-center.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Call Center</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/logistics.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Logistics</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/website-analytics.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Website Analytics</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/finance-performance.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Finance Performance</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/store-analytics.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Store Analytics</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/social.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Social</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/delivery.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Delivery</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/crypto.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Crypto</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/school.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">School</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/dashboards/podcast.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Podcast</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
											<!--begin:Menu item-->
											<div class="menu-item">
												<!--begin:Menu link-->
												<a class="menu-link" href="../../demo6/dist/landing.html">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Landing</span>
												</a>
												<!--end:Menu link-->
											</div>
											<!--end:Menu item-->
										</div>
										<div class="menu-item">
											<div class="menu-content">
												<a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse" data-kt-toggle-text="Show Less">
													<span data-kt-toggle-text-target="true">Show 12 More</span>
													<i class="ki-outline ki-minus-square toggle-on fs-2 me-0"></i>
													<i class="ki-outline ki-plus-square toggle-off fs-2 me-0"></i>
												</a>
											</div>
										</div>
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								
								
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Aside Menu-->
					</div>
					<!--end::Aside menu-->
					<!--begin::Footer-->
					<div class="aside-footer flex-column-auto" id="kt_aside_footer">
						<!--begin::Menu-->
						<div class="d-flex justify-content-center">
							<button type="button" class="btn btm-sm btn-icon btn-custom btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Quick actions">
								<i class="ki-outline ki-notification-status fs-1"></i>
							</button>
							<!--begin::Menu 2-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu separator-->
								<div class="separator mb-3 opacity-75"></div>
								<!--end::Menu separator-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="#" class="menu-link px-3">New Ticket</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="#" class="menu-link px-3">New Customer</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
									<!--begin::Menu item-->
									<a href="#" class="menu-link px-3">
										<span class="menu-title">New Group</span>
										<span class="menu-arrow"></span>
									</a>
									<!--end::Menu item-->
									<!--begin::Menu sub-->
									<div class="menu-sub menu-sub-dropdown w-175px py-4">
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3">Admin Group</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3">Staff Group</a>
										</div>
										<!--end::Menu item-->
										<!--begin::Menu item-->
										<div class="menu-item px-3">
											<a href="#" class="menu-link px-3">Member Group</a>
										</div>
										<!--end::Menu item-->
									</div>
									<!--end::Menu sub-->
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<a href="#" class="menu-link px-3">New Contact</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu separator-->
								<div class="separator mt-3 opacity-75"></div>
								<!--end::Menu separator-->
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<div class="menu-content px-3 py-3">
										<a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
									</div>
								</div>
								<!--end::Menu item-->
							</div>
							<!--end::Menu 2-->
						</div>
						<!--end::Menu-->
					</div>
					<!--end::Footer-->
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
								<!--begin::Toolbar wrapper-->
								<div class="d-flex align-items-stretch flex-shrink-0">
									<!--begin::Activities-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Drawer toggle-->
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
											<i class="ki-outline ki-notification-bing fs-1"></i>
										</div>
										<!--end::Drawer toggle-->
									</div>
									<!--end::Activities-->
									<!--begin::Quick links-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu wrapper-->
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-outline ki-tablet-ok fs-1"></i>
										</div>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
											<!--begin::Heading-->
											<div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
												<!--begin::Title-->
												<h3 class="text-white fw-semibold mb-3">Quick Links</h3>
												<!--end::Title-->
												<!--begin::Status-->
												<span class="badge bg-primary text-inverse-primary py-2 px-3">25 pending tasks</span>
												<!--end::Status-->
											</div>
											<!--end::Heading-->
											<!--begin:Nav-->
											<div class="row g-0">
												<!--begin:Item-->
												<div class="col-6">
													<a href="../../demo6/dist/apps/projects/budget.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
														<i class="ki-outline ki-dollar fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
														<span class="fs-7 text-gray-400">eCommerce</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="../../demo6/dist/apps/projects/settings.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
														<i class="ki-outline ki-sms fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
														<span class="fs-7 text-gray-400">Console</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="../../demo6/dist/apps/projects/list.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
														<i class="ki-outline ki-abstract-41 fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
														<span class="fs-7 text-gray-400">Pending Tasks</span>
													</a>
												</div>
												<!--end:Item-->
												<!--begin:Item-->
												<div class="col-6">
													<a href="../../demo6/dist/apps/projects/users.html" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
														<i class="ki-outline ki-briefcase fs-3x text-primary mb-2"></i>
														<span class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
														<span class="fs-7 text-gray-400">Latest cases</span>
													</a>
												</div>
												<!--end:Item-->
											</div>
											<!--end:Nav-->
											<!--begin::View more-->
											<div class="py-2 text-center border-top">
												<a href="../../demo6/dist/pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
												<i class="ki-outline ki-arrow-right fs-5"></i></a>
											</div>
											<!--end::View more-->
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::Quick links-->
									<!--begin::Heaeder menu toggle-->
									<div class="d-flex align-items-center d-lg-none ms-2 me-n2" title="Show header menu">
										<div class="btn btn-icon btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
											<i class="ki-outline ki-burger-menu-2 fs-1"></i>
										</div>
									</div>
									<!--end::Heaeder menu toggle-->
								</div>
								<!--end::Toolbar wrapper-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->