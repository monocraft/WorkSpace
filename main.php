<?php
/*
 * Copyright (C) 2014 USBest WorkSpace
 *
 */
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'xcrud.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
// last request was more than 30 minutes ago
session_unset();     // unset $_SESSION variable for the run-time 
session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
sec_session_start();
$xcrud = Xcrud::get_instance();

if (login_check($mysqli) == false) {
	header("Location: /index");
	exit();
}

?>
	<!doctype html>
	<!--boxed|fixed|scroll sidebar-left-collapsed-->
	<html class="fixed">
		<head>
			<!-- Basic -->
		<meta charset="UTF-8">

		<title>WorkSpace | USBest Repairs</title>
		<meta name="keywords" content="WorkSpace | USBest Repairs" />
		<meta name="description" content="WorkSpace | USBest Repairs">
		<meta name="author" content="Tung Nguyen">
        <link rel="shortcut icon" href="/favicon.ico" />
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/logo.png" height="50" alt="WorkSpace" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-tasks" aria-label="Toggle sidebar"></i>
					</div>
				</div>
				<!-- start: search & user box -->
				<div class="header-right">
					<span class="separator">
					</span>
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">
						<figure class="profile-picture">
						<img src="assets/images/!logged-user.jpg" alt="<?php echo $_SESSION['fname'];?>  <?php echo $_SESSION['lname']; ?>" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
						</figure>
						<div class="profile-info" data-lock-name="<?php echo $_SESSION['fname'];?>  <?php echo $_SESSION['lname']; ?>" data-lock-email="<?php echo $_SESSION['email'];?>">
						<span class="name"><?php echo $_SESSION['fname'];?>  <?php echo $_SESSION['lname']; ?></span>
						<span class="role"><?php echo $_SESSION['accesstype'];?></span>
						</div>
						<i class="fa custom-caret"></i>
						</a>
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider">
								</li>
								<li>
									<a role="menu" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menu" tabindex="-1" href="includes/logout"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->
			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-dedent" aria-label="Toggle sidebar">
							</i>
						</div>
					</div>
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="main">
										<i class="fa fa-home" aria-hidden="true"></i>
										<span>WorkSpace</span>
										</a>
									</li>
                                    <?php	if (!check_access(5)):?>
									<li>
										<a href="recruit">
										<span class="pull-right label label-primary"><?php echo getActiveVendors(12,13); ?></span>
										<i class="fa fa-users" aria-hidden="true"></i>
										<span>Vendor Recruitment</span>
										</a>
									</li>
                                    <?php endif; ?>
									<li>
										<a href="active">
										<span class="pull-right label label-success"><?php echo getActiveVendors(1); ?></span>
										<i class="fa fa-truck" aria-hidden="true"></i>
										<span>Active Vendors</span>
										</a>
									</li>
									<li>
										<a href="banish">
										<span class="pull-right label label-danger"><?php echo getBanishVendors(2); ?></span>
										<i class="fa fa-eye-slash" aria-hidden="true"></i>
										<span>Banished Vendors</span>
										</a>
									</li>
                                    <li class="nav-parent">
										<a>
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Form</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="submission">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    <span>Submission Form <em class="not-included">(View)</em></span>
												</a>
											</li>
											<li>
												<a href="infochange">
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                    <span>Information Change <em class="not-included">(View)</em></span>
												</a>
											</li>
											<li>
												<a href="vendorrequest">
                                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                                    <span>Request Form <em class="not-included">(View)</em></span>
												</a>
											</li>
                                            <li>
												<a href="qcform">
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <span>QC Form <em class="not-included">(Development)</em></span>
												</a>
											</li>
										</ul>
									</li>
									<li>
										<a href="maps-google-maps.html">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
										<span>Map <em class="not-included">(Development)</em></span>
										</a>
									</li>
                                    <?php	if (check_access(1) || check_access(2) ):?>
									<li>
										<a href="employees">
										<span class="pull-right label label-success"><?php echo getEmployees(1); ?></span>
										<i class="fa fa-star" aria-hidden="true"></i>
										<span>Employees</span>
										</a>
									</li>
                                    <?php endif; ?>
								</ul>
							</nav>
							<hr class="separator" />
							<div class="sidebar-widget widget-stats">
								<div class="widget-header">
									<h6>
										Current Stats
									</h6>
									<div class="widget-toggle">
										+
									</div>
								</div>
								<div class="widget-content">
			
								</div>
							</div>
						</div>
					</div>
				</aside>
				<!-- end: sidebar -->
                
				<section role="main" class="content-body">
					<header class="page-header">
						<h2 class="alternative-font">WorkSpace</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="main">
										<i class="fa fa-home"></i>
									</a>
								</li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
						<div class="col-md-12 col-lg-6 col-xl-12">
							<div class="alert alert-default">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<strong><?php echo $_SESSION['fname'];?>  <?php echo $_SESSION['lname']; ?>!</strong> Welcome! <a href="" class="alert-link"></a>
							</div>
						</div>
						<div class="col-md-6 col-lg-12 col-xl-12">
							<div class="row">
								<div class="col-md-12 col-lg-6 col-xl-3">
									<section class="panel">
										<div class="panel-body bg-primary">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-tencent-weibo"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Today's New Submissions</h4>
														<div class="info">
															<strong class="amount"><?php echo getActiveVendors(12,13); ?></strong>
															<span class="text-default">(<?php echo getActiveVendors(13); ?> untouch)</span>
														</div>
													</div>
													<div class="summary-footer">
														<a href="recruit" class="text-uppercase">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-md-12 col-lg-6 col-xl-3">
									<section class="panel panel-featured-left panel-featured-secondary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-secondary">
														<i class="fa fa-eye-slash"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Monthly Banished Vendors</h4>
														<div class="info">
															<strong class="amount"><?php echo getBanishVendors(2); ?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="banish" class="text-muted text-uppercase">(View All)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-md-12 col-lg-6 col-xl-3">
									<section class="panel panel-featured-left panel-featured-tertiary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-tertiary">
														<i class="fa fa-truck"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Current Active Vendors</h4>
														<div class="info">
															<strong class="amount"><?php echo getActiveVendors(1); ?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="active" class="text-muted text-uppercase">(View All)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-md-12 col-lg-6 col-xl-3">
									<section class="panel panel-featured-left panel-featured-quartenary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-quartenary">
														<i class="fa fa-users"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Today's Visitors</h4>
														<div class="info">
															<strong class="amount"><?php echo getBanishVendors(13); ?></strong>
														</div>
													</div>
													<div class="summary-footer">
														<a href="recruit" class="text-muted text-uppercase">(Report)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<section class="panel panel-featured panel-featured-info">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
										<a href="#" class="fa fa-times"></a>
									</div>

									<h2 class="panel-title">Vendor Assessment</h2>
									<p class="panel-subtitle">Vendor recruitments statistic</p>
								</header>
								<div class="panel-body">

									<!-- Flot: Basic -->
									<div class="chart chart-md" id="flotDashBasic"></div>
									<script>

										var flotDashBasicData = [{
											data: [
												[0, 170],
												[1, 169],
												[2, 173],
												[3, 188],
												[4, 147],
												[5, 113],
												[6, 128],
												[7, 169],
												[8, 173],
												[9, 128],
												[10, 128]
											],
											label: "New Submission",
											color: "#0088cc"
										}, {
											data: [
												[0, 115],
												[1, 124],
												[2, 114],
												[3, 121],
												[4, 115],
												[5, 83],
												[6, 102],
												[7, 148],
												[8, 147],
												[9, 103],
												[10, 113]
											],
											label: "Active Vendors",
											color: "#2baab1"
										}, {
											data: [
												[0, 70],
												[1, 69],
												[2, 73],
												[3, 88],
												[4, 47],
												[5, 13],
												[6, 28],
												[7, 69],
												[8, 73],
												[9, 28],
												[10, 28]
											],
											label: "Banished Vendors",
											color: "#734ba9"
										}];

										// See: assets/javascripts/dashboard/dashboard.js for more settings.

									</script>

								</div>
							</section>
						</div>
						<div class="col-md-6">
							<section class="panel panel-featured panel-featured-danger">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="fa fa-caret-down"></a>
									</div>
									<h2 class="panel-title">Server Usage</h2>
									<p class="panel-subtitle">Current server load from active queries</p>
								</header>
								<div class="panel-body">

									<!-- Flot: Curves -->
									<div class="chart chart-md" id="flotDashRealTime"></div>

								</div>
							</section>
						</div>
					</div>
					<!-- end: page -->
				</section>
			</div>

				<!-- Start: sidebar-right -->
				<aside id="sidebar-right" class="sidebar-right">
					<div class="nano">
						<div class="nano-content">
							<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
							</a>
							<div class="sidebar-right-wrapper">
								<div class="sidebar-widget widget-calendar">
									<h6>
										WorkSpace Calendar
									</h6>
									<div data-plugin-datepicker data-plugin-skin="dark" data-plugin-options='{ "todayHighlight": "true" }'>
									</div>
									<!--<ul>
									<li>
									<time datetime="2014-12-19T00:00+00:00">12/19/2014</time>
									<span></span>
									</li>
									</ul>-->
								</div>
								<div class="sidebar-copyright">
									<span>
										© Copyright 2014. All Rights Reserved.
									</span>
								</div>
							</div>
						</div>
					</div>
				</aside>
			</section>
		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script> 
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jquery-idletimer/dist/idle-timer.js"></script>
        		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Dashboard -->
		<script src="assets/javascripts/dashboard/dashboard.js"></script>
	</body>
</html>