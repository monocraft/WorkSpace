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

		<title>WorkSpace | Form Submission</title>
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
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="assets/vendor/dropzone/css/basic.css" />
		<link rel="stylesheet" href="assets/vendor/dropzone/css/dropzone.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
		<link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />
		<link rel="stylesheet" href="assets/vendor/summernote/summernote-bs3.css" />
		<link rel="stylesheet" href="assets/vendor/codemirror/lib/codemirror.css" />
		<link rel="stylesheet" href="assets/vendor/codemirror/theme/monokai.css" />

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
									<li>
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
                                    <li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Form</span>
										</a>
										<ul class="nav nav-children">
											<li class="nav-active">
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
						<h2 class="alternative-font">Form Submission</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="main">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li>
									<span>
										Form
									</span>
								</li>
								<li>
									<span>
										Submission Form
									</span>
								</li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<form class="form-horizontal form-bordered" action="#">
						<div class="row">
    						<div class="col-sm-12 col-md-12 col-lg-3 col-xl-2">
    
    							<section class="panel">
    								<div class="panel-body">
    									<div class="thumb-info mb-xs">
                                            <a name="Step1"><img src="assets/images/Step1.png" class="rounded img-responsive"></a>
                                            <div class="thumb-info-title">
    											<span class="thumb-info-inner">Step 1</span>
    											<span class="thumb-info-type">Company Info</span>
    										</div>
    									</div>
    
    									<hr class="dotted short">
                                        <div>
                                            <p class="drop-caps text-muted">Please provide your contact info to the right so that we can reach you. Be sure to include as much information as you can. The company name, owner's name, and email address are all mandatory in order to continue. </p>
                                        </div>    
    									<div class="social-icons-list">
    										<a rel="tooltip" data-placement="bottom" target="" href="#top" data-original-title="Step 1"><span>Step 1</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step2" data-original-title="Step 2"><span>Step 2</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step3" data-original-title="Step 3"><span>Step 3</span></a>
                                            <a rel="tooltip" data-placement="bottom" href="#Step4" data-original-title="Step 4"><span>Step 4</span></a>
    									</div>
    
    								</div>
    							</section>
    						</div>
							<div class="col-xs-12 col-md-12 col-lg-9 col-xl-6">

								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
										</div>
						
										<p class="lead alternative-font mb-none">Company <span class="word-rotate" data-plugin-options='{ "delay": 3000 }'>
                                        <span class="word-rotate-items">
                                            <span class="text-left">Information</span>
                                            <span class="text-left">Address</span>
                                            <span class="text-left">Business Owner</span>
                                            <span class="text-left">Point of Contact</span>
                                        </span>
                                        </span>
                                        </p>
									</header>
									<div class="panel-body">

											<div class="form-group">
												<label class="col-md-3 control-label">Company Name <span class="required">*</span></label>
												<div class="col-md-8">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-asterisk"></i></span>
														</span>
														<input name="CoName" class="form-control" placeholder="Company Name" type="text" />
													</div>
												</div>
											</div>
                                            <div class="form-group">
                                                <div class="map_canvas col-md-12"></div>
                                                <label class="col-md-3 control-label">Company Address <span class="required">*</span></label>
                                                <div class="col-md-8">
                                                	<div class="input-group input-group-icon mb-xs">
                                                		<span class="input-group-addon">
                                                			<span class="icon"><i class="fa fa-map-marker"></i></span>
                                                		</span>
                                                		<input id="geocomplete" class="form-control" placeholder="Type in your business address" type="text" />
                                                        <input type="hidden"  type="text" value="" name="lat" />
                                                        <input type="hidden"  type="text" value="" name="lng" />
                                                        <input type="hidden"  type="text" value="" name="location" />
                                                	</div>
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-5">
                                               	    <input name="name" class="form-control" placeholder="Street" type="text" />
                                                </div>
                                                <div class="col-md-3 mb-xs">
                                               	    <input name="unit" class="form-control" placeholder="Unit" type="text" />
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-4 mb-xs">
                                               	    <input name="locality" class="form-control" placeholder="City" type="text" />
                                                </div>
                                                <div class="col-md-2 mb-xs">
                                               	    <input name="administrative_area_level_1" class="form-control" placeholder="State" type="text" />
                                                </div>
                                                <div class="col-md-2 mb-xs">
                                               	    <input name="postal_code" class="form-control" placeholder="Zipcode" type="text" />
                                                </div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Company Website</label>
												<div class="col-md-8">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-cloud"></i></span>
														</span>
														<input name="CoWebsite" class="form-control" placeholder="Company Website" type="url" />
													</div>
												</div>
											</div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-8 mb-xs">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="mailing" name="mailing" onclick="AutoMailing(this.form)" type="checkbox" />
                                                        <label for="mailing">Mailing Address is the same</label>
                                                    </div>
                                                </div>
                                                <label class="col-md-3 control-label">Mailing Address</label>
                                                <div class="col-md-8">
                                                	<div class="input-group input-group-icon mb-xs">
                                                		<span class="input-group-addon">
                                                			<span class="icon"><i class="fa fa-map-marker"></i></span>
                                                		</span>
                                                		<input id="maddress" data-geo="" name="maddress" class="form-control" placeholder="Mailing Address" type="text" />
                                                        <input type="hidden"  type="text" value="" data-geo="lat" name="mlat" />
                                                        <input type="hidden"  type="text" value="" data-geo="lng" name="mlng" />
                                                        <input type="hidden"  type="text" value="" data-geo="location" name="mlocation" />
                                                	</div>
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-5">
                                               	    <input name="mname" data-geo="name" class="form-control" placeholder="Street" type="text" />
                                                </div>
                                                <div class="col-md-3 mb-xs">
                                               	    <input name="munit" data-geo="" class="form-control" placeholder="Unit" type="text" />
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-4 mb-xs">
                                               	    <input name="mlocality" data-geo="locality" class="form-control" placeholder="City" type="text" />
                                                </div>
                                                <div class="col-md-2 mb-xs">
                                               	    <input name="madministrative_area_level_1" data-geo="administrative_area_level_1" class="form-control" placeholder="State" type="text" />
                                                </div>
                                                <div class="col-md-2 mb-xs">
                                               	    <input name="mpostal_code" data-geo="postal_code" class="form-control" placeholder="Zipcode" type="text" />
                                                </div>
											</div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Business Owner <span class="required">*</span></label>
                                                <div class="col-md-8">
                                                	<div class="input-group input-group-icon">
                                                		<span class="input-group-addon">
                                                			<span class="icon"><i class="fa fa-male"></i></span>
                                                		</span>
                                                		<input name="BoName" class="form-control" placeholder="Name" type="text" />
                                                	</div>
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-4 control-label mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-phone"></i>
														</span>
														<input name="BoPhone" data-plugin-masked-input data-input-mask="(999) 999-9999? x9999" placeholder="Business Phone" class="form-control" />
													</div>
                                                </div>
                                                <div class="col-md-4 control-label mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-phone"></i>
														</span>
														<input name="BoCell" data-plugin-masked-input data-input-mask="(999) 999-9999? x9999" placeholder="Cell Phone" class="form-control" />
													</div>
                                                </div>
                                                <label class="col-md-3 control-label">Email <span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                    <input name="BoEmail" class="form-control" placeholder="eg.: email@email.com" type="email" />
                                                    </div>
                                                </div>
											</div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-8 mb-xs">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="mpoc" name="mpoc" onclick="AutoMPOC(this.form)" type="checkbox" />
                                                        <label for="mpoc">Business Owner and Main Point of Contact are the same</label>
                                                    </div>
                                                </div>
                                                <label class="col-md-3 control-label">Main Contact <span class="required">*</span></label>
                                                <div class="col-md-8">
                                                	<div class="input-group input-group-icon">
                                                		<span class="input-group-addon">
                                                			<span class="icon"><i class="fa fa-male"></i></span>
                                                		</span>
                                                		<input id="mpoc_name" name="mpoc_name" class="form-control" placeholder="Name" type="text" />
                                                	</div>
                                                </div>
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-4 control-label mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-phone"></i>
														</span>
														<input name="mpoc_phone" data-plugin-masked-input="" data-input-mask="(999) 999-9999? x9999" placeholder="Business Phone" class="form-control" />
													</div>
                                                </div>
                                                <div class="col-md-4 control-label mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-phone"></i>
														</span>
														<input name="mpoc_cell" data-plugin-masked-input="" data-input-mask="(999) 999-9999? x9999" placeholder="Cell Phone" class="form-control" />
													</div>
                                                </div>
                                                <label class="col-md-3 control-label">Email <span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                    <input name="mpoc_email" class="form-control" placeholder="eg.: email@email.com" type="email" />
                                                    </div>
                                                </div>
											</div>
									</div>
								</section>
							</div>
						</div>
                        <div class="row">
    						<div class="col-sm-12 col-md-12 col-lg-3 col-xl-2">
    
    							<section class="panel">
    								<div class="panel-body">
    									<div class="thumb-info mb-xs">
                                            <a name="Step2"><img src="assets/images/Step2.png" class="rounded img-responsive"></a>
                                            <div class="thumb-info-title">
    											<span class="thumb-info-inner">Step 2</span>
    											<span class="thumb-info-type">Organization Info</span>
    										</div>
    									</div>
    
    									<hr class="dotted short" />
                                        <div>
                                            <p class="drop-caps text-muted">Briefly show us your organization establishment, license, info and provide us an overview of your specialties as well as the services you are provide in statewide area.</p>
                                        </div>    
    									<div class="social-icons-list">
    										<a rel="tooltip" data-placement="bottom" target="" href="#top" data-original-title="Step 1"><span>Step 1</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step2" data-original-title="Step 2"><span>Step 2</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step3" data-original-title="Step 3"><span>Step 3</span></a>
                                            <a rel="tooltip" data-placement="bottom" href="#Step4" data-original-title="Step 4"><span>Step 4</span></a>
    									</div>
    
    								</div>
    							</section>
    						</div>
							<div class="col-xs-12 col-md-12 col-lg-9 col-xl-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
										</div>
										<p class="lead alternative-font mb-none">Organization <span class="word-rotate" data-plugin-options='{ "delay": 3000 }'>
                                        <span class="word-rotate-items">
                                            <span class="text-left">Info</span>
                                            <span class="text-left">License</span>
                                            <span class="text-left">States</span>
                                            <span class="text-left">Experiences</span>
                                            <span class="text-left">Specialties</span>
                                            <span class="text-left">Insurance</span>
                                        </span>
                                        </span>
                                        </p>
									</header>
									<div class="panel-body">
                                        <div class="form-group">
												<label class="col-md-3 control-label">Business Classification <span class="required">*</span></label>
												<div class="col-md-8 mb-xs">
													<select name="OI_BClass" data-plugin-selectTwo class="form-control populate">
															<option value="Corporation">Corporation</option>
															<option value="Partnership">Partnership</option>
															<option value="LLC">LLC</option>
															<option value="Joint Venture">Joint Venture</option>
															<option value="Sole Proprietor">Sole Proprietor</option>
															<option value="Other">Other</option>
													</select>
												</div>
												<label class="col-md-3 control-label">If Other, please specify</label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-question-circle"></i></span>
														</span>
														<input name="OI_BCOther" class="form-control" placeholder="Other" type="text" />
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-3 control-label">Date Business Founded</label>
												<div class="col-md-4 mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input name="OI_DateFound" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" />
													</div>
												</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">State of Incorporation</label>
											<div class="col-md-8">
												<select name="OI_StateInc" multiple data-plugin-selectTwo class="form-control populate mb-xs">
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV">Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
											</div>
											<label class="col-md-3 control-label" for="fc_inputmask_1">Federal ID</label>
											<div class="col-md-4">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-gavel"></i>
													</span>
													<input name="OI_FedID" data-plugin-masked-input data-input-mask="99-99999999" placeholder="__-________" class="form-control" />
												</div>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-md-3 control-label">Dunn & Bradstreet</label>
											<div class="col-md-8 mb-xs">
												<div class="input-group input-group-icon">
													<span class="input-group-addon">
														<span class="icon"><i class="fa fa-link"></i></span>
													</span>
													<input name="OI_Dunn" class="form-control" placeholder="If Applicable" type="text" />
												</div>
											</div>
											<label class="col-md-3 control-label">Business License</label>
											<div class="col-md-8 mb-xs">
												<div class="input-group input-group-icon">
													<span class="input-group-addon">
														<span class="icon"><i class="fa fa-wrench"></i></span>
													</span>
													<input name="OI_License" class="form-control" placeholder="License Info" type="text" />
												</div>
											</div>
											<label class="col-md-3 control-label">License Expiration Date</label>
											<div class="col-md-4 mb-xs">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input name="OI_LicExp" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Business State(s)</label>
											<div class="col-md-8">
												<select name="OI_States" multiple data-plugin-selectTwo class="form-control populate mb-xs">
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV">Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
                                                <p>
                                                    Please select all <code>state(s)</code> you are currently do business.
												</p>
											</div>
											<label for="tags-input" class="col-md-3 control-label">Service Counties</label>
											<div class="col-md-8">
												<input name="OI_Counties" id="tags-input" data-role="tagsinput" data-tag-class="label label-primary" class="form-control" value="Orange County,Los Angeles County,Riverside County" />
												<p>
                                                    Please list the counties that you service.  If statewide, please enter <code>statewide</code>.
												</p>
											</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-3 control-label">Primary Business <span class="required">*</span></label>
												<div class="col-md-8 mb-xs">
													<select name="OI_Primary" data-plugin-selectTwo class="form-control populate">
															<option value="Renovations/Rehabs">Renovations/Rehabs</option>
															<option value="Handyman/Small Repairs">Handyman/Small Repairs</option>
															<option value="Property Preservation">Property Preservation</option>
															<option value="Property Maintenance">Property Maintenance</option>
															<option value="Inspections">Inspections</option>
															<option value="Commercial Property Maintenance & Repairs">Commercial Property Maintenance & Repairs</option>
													</select>
												</div>
												<label class="col-md-3 control-label">Years of Experience</label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 50 }'>
														<div class="input-group input-small">
															<input name="OI_PrimaryYears" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-3 control-label">Other Type of Service</label>
												<div class="col-md-8 mb-xs">
													<select name="OI_Service" data-plugin-selectTwo class="form-control populate">
															<option value="Renovations/Rehabs">Renovations/Rehabs</option>
															<option value="Handyman/Small Repairs">Handyman/Small Repairs</option>
															<option value="Property Preservation">Property Preservation</option>
															<option value="Property Maintenance">Property Maintenance</option>
															<option value="Inspections">Inspections</option>
															<option value="Commercial Property Maintenance & Repairs">Commercial Property Maintenance & Repairs</option>
													</select>
												</div>
												<label class="col-md-3 control-label">Years of Experience</label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 50 }'>
														<div class="input-group input-small">
															<input name="OI_ServiceYears" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-3 control-label">Other</label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-question-circle"></i></span>
														</span>
														<input name="OI_Other" class="form-control" placeholder="Type of Service" type="text" />
													</div>
												</div>
												<label class="col-md-3 control-label">Years of Experience</label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 50 }'>
														<div class="input-group input-small">
															<input name="OI_OtherYears" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Please Identify Specialties</label>
											<div class="col-md-8">
												<select name="OI_Specialties" multiple data-plugin-selectTwo class="form-control populate mb-xs">
                                                        <optgroup label="General">
														<option value="General Contractor (Commercial/Municipal)">General Contractor (Commercial/Municipal)</option>
														<option value="General Contractor (Residential)">General Contractor (Residential)</option>
                                                        </optgroup>
                                                        <optgroup label="Home">
														<option value="Home Repair Contractor">Home Repair Contractor</option>
														<option value="Home Construction Contractor">Home Construction Contractor</option>
														<option value="Handyman">Handyman</option>
                                                        </optgroup>
                                                        <optgroup label="Specialized">
														<option value="Carpentry Contractor">Carpentry Contractor</option>
														<option value="Electrical Contractor">Electrical Contractor</option>
														<option value="Flooring Contractor">Flooring Contractor</option>
														<option value="HVAC Contractor">HVAC Contractor</option>
														<option value="Masonry Contractor">Masonry Contractor</option>
														<option value="Painting Contractor">Painting Contractor</option>
														<option value="Plumbing Contractor">Plumbing Contractor</option>
														<option value="Roofing Contractor">Roofing Contractor</option>
                                                        </optgroup>
												</select>
                                                <p>
                                                    Please select all <code>specialties</code> for your business.
												</p>
											</div>
											<label for="tags-input" class="col-md-3 control-label">Other Specialties</label>
											<div class="col-md-8">
												<input name="OI_OtherSp" data-role="tagsinput" data-tag-class="label label-primary" class="form-control" value="" />
												<p>
                                                    Please list other specialties that is <code>not</code> listed above. Hit <code>Enter</code> after each specialty.
												</p>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-md-9 control-label">Are you licensed, as required by your state/county/city, in the trade(s) you perform? <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_LicByState" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
											<label class="col-md-3 control-label">License Number</label>
											<div class="col-md-8 mb-xs">
												<div class="input-group input-group-icon">
													<span class="input-group-addon">
														<span class="icon"><i class="fa fa-wrench"></i></span>
													</span>
													<input name="OI_StateLic" class="form-control" placeholder="License Info" type="text" />
												</div>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-md-9 control-label">Do you have commercial General Liability insurance? <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_Insurance" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
											<label class="col-md-3 control-label">Amount of Insurance</label>
											<div class="col-md-8 mb-xs">
												<div class="input-group input-group-icon">
													<span class="input-group-addon">
														<span class="icon"><i class="fa fa-medkit"></i></span>
													</span>
													<input id="OI_InsAmount" type="text" name="OI_InsAmount" class="form-control" placeholder="e.g: 1,000,000.00" />
												</div>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-md-9 control-label">Do you have Workers' Compensation insurance (if/as required)? <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_WorkerComp" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
										</div>
                                        <div class="alert alert-info fade in nomargin">
    										<h4><i class="fa fa-warning"></i> Vendor Notice!</h4>
    										<p>We require job photos <strong class="text-danger">(before and after completion photos)</strong> for each work order you are assigned and for jobs and items that you are bidding.  Bids and invoices <strong class="text-danger">will not be approved</strong> without photo documentation.</p>
			                            </div>
                                        <div class="form-group">
											<label class="col-md-9 control-label">Are you able to provide photos to US Best Repairs for each job? <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_Photos" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
											<label class="col-md-9 control-label">Do you have a smartphone?  <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_Ysmart" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
											<label class="col-md-9 control-label">Does your job supervisors/crew leader/foreman/superintendent carry a smartphone? <span class="required">*</span></label>
											<div class="col-md-2 mb-xs">
												<select name="OI_Bsmart" data-plugin-selectTwo class="form-control populate">
														<option value="No">No</option>
														<option value="Yes">Yes</option>
												</select>
											</div>
										</div>

									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-3 col-xl-2">
    
    							<section class="panel">
    								<div class="panel-body">
    									<div class="thumb-info mb-xs">
                                            <a name="Step3"><img src="assets/images/Step3.png" class="rounded img-responsive"></a>
                                            <div class="thumb-info-title">
    											<span class="thumb-info-inner">Step 3</span>
    											<span class="thumb-info-type">Work Experience</span>
    										</div>
    									</div>
    
    									<hr class="dotted short">
                                        <div>
                                            <p class="drop-caps text-muted">Fill in as much information as possible pertain to your company employees and history status.  All information are kept confidential and will not be disclosed with anyone.</p>
                                        </div>    
    									<div class="social-icons-list">
    										<a rel="tooltip" data-placement="bottom" target="" href="#top" data-original-title="Step 1"><span>Step 1</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step2" data-original-title="Step 2"><span>Step 2</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step3" data-original-title="Step 3"><span>Step 3</span></a>
                                            <a rel="tooltip" data-placement="bottom" href="#Step4" data-original-title="Step 4"><span>Step 4</span></a>
    									</div>
    
    								</div>
    							</section>
    						</div>
							<div class="col-xs-12 col-md-12 col-lg-9 col-xl-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
										</div>

										<p class="lead alternative-font mb-none">Work <span class="word-rotate" data-plugin-options='{ "delay": 3000 }'>
                                        <span class="word-rotate-items">
                                            <span class="text-left">Experience</span>
                                            <span class="text-left">History</span>
                                            <span class="text-left">Status</span>
                                            <span class="text-left">References</span>
                                        </span>
                                        </span>
                                        </p>
									</header>
									<div class="panel-body">
                                        <div class="form-group">
												<label class="col-md-6 control-label">How many people does your firm presently employ? <span class="required">*</span></label>
												<div class="col-md-5 mb-xs">
													<select name="WE_EmpAmnt" data-plugin-selectTwo class="form-control populate">
														<optgroup label="Small Group">
															<option value="1-4">1 to 4 employees</option>
															<option value="5-9">5 to 9 employees</option>
														</optgroup>
														<optgroup label="Midsize Group">
                                                            <option value="10-19">10 to 19 employees</option>
															<option value="20-99">20 to 99 employees</option>
														</optgroup>
														<optgroup label="Large Group">
															<option value="100-499">100 to 499 employees</option>
                                                            <option value="500-More">500 employees or more</option>
														</optgroup>
													</select>
												</div>
												<label class="col-md-3 control-label">Subcontractors? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Sub" data-plugin-selectTwo class="form-control populate">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
												<label class="col-md-4 control-label">If yes, how many Subcontractors?</label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 500 }'>
														<div class="input-group input-small">
															<input name="WE_SubAmnt" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">How many projects are you currently working on? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 1000 }'>
														<div class="input-group input-small">
															<input name="WE_Current" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
												<label class="col-md-9 control-label">How many projects/jobs have you completed in the past 3 months? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "min": 0, "max": 1000 }'>
														<div class="input-group input-small">
															<input name="WE_Month" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
												<label class="col-md-9 control-label">How many projects/jobs have you completed in the past year? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<div data-plugin-spinner data-plugin-options='{ "value":0, "step": 5, "min": 0, "max": 10000 }'>
														<div class="input-group input-small">
															<input name="WE_Year" type="text" class="spinner-input form-control" />
															<div class="spinner-buttons input-group-btn btn-group-vertical">
																<button type="button" class="btn spinner-up btn-xs btn-default">
																	<i class="fa fa-angle-up"></i>
																</button>
																<button type="button" class="btn spinner-down btn-xs btn-default">
																	<i class="fa fa-angle-down"></i>
																</button>
															</div>
														</div>
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Have you ever walked away from an job that was incomplete? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_WInc" data-plugin-selectTwo class="form-control populate">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
												<label class="col-md-3 control-label" for="textareaAutosize">If yes, please explain</label>
												<div class="col-md-8">
													<textarea name="WE_WINote" class="form-control" rows="3" placeholder="Your brief explanation here..." data-plugin-textarea-autosize></textarea>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Have any Owners, officers, major stockholders, or senior management of your Company ever been indicted or convicted of any felony or other criminal conduct? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Convict" data-plugin-selectTwo class="form-control populate mt-md">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Has your Company ever petitioned for bankruptcy, failed in a business endeavor, defaulted or been terminated on a contract? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Bankrupt" data-plugin-selectTwo class="form-control populate mt-md">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Has any entity ever made a claim in a court of law, against your Company for defective, improper or nonconforming work, or for failing to comply with warranty obligations? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Court" data-plugin-selectTwo class="form-control populate mt-md">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Are there any outstanding Judgments or Claims against your Company? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Claim" data-plugin-selectTwo class="form-control populate">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Has any entity made a claim in a court of law, against your Company for failing to make payments to that or any other entity? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_Entity" data-plugin-selectTwo class="form-control populate mt-md">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-9 control-label">Has your company worked for US Best Repair Service in the past? <span class="required">*</span></label>
												<div class="col-md-2 mb-xs">
													<select name="WE_USBest" data-plugin-selectTwo class="form-control populate">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
													</select>
												</div>
                                                <label class="col-md-3 control-label" for="textareaAutosize">Please provide work references</label>
												<div class="col-md-8">
													<textarea name="WE_Ref" class="form-control" rows="3" placeholder="Please enter 3 references if possible" data-plugin-textarea-autosize></textarea>
												</div>
										</div>
									</div>
								</section>
							</div>
						</div>
						
						<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-3 col-xl-2">
    
    							<section class="panel">
    								<div class="panel-body">
    									<div class="thumb-info mb-xs">
                                            <a name="Step4"><img src="assets/images/Step4.png" class="rounded img-responsive"></a>
                                            <div class="thumb-info-title">
    											<span class="thumb-info-inner">Step 4</span>
    											<span class="thumb-info-type">Business Classification</span>
    										</div>
    									</div>
    
    									<hr class="dotted short">
                                        <div>
                                            <p class="drop-caps text-muted">Clarify your type of business and specify which agency and certification number with expiration date if you list as small or disadvantaged business.</p>
                                        </div>    
    									<div class="social-icons-list">
    										<a rel="tooltip" data-placement="bottom" target="" href="#top" data-original-title="Step 1"><span>Step 1</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step2" data-original-title="Step 2"><span>Step 2</span></a>
    										<a rel="tooltip" data-placement="bottom" href="#Step3" data-original-title="Step 3"><span>Step 3</span></a>
                                            <a rel="tooltip" data-placement="bottom" href="#Step4" data-original-title="Step 4"><span>Step 4</span></a>
    									</div>
    
    								</div>
    							</section>
    						</div>
							<div class="col-xs-12 col-md-12 col-lg-9 col-xl-6">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
										</div>
						
										<h2 class="panel-title alternative-font">Business Classification</h2>
									</header>
									<div class="panel-body">
                                        <div class="form-group">
												<label class="col-md-3 control-label">Business Classification <span class="required">*</span></label>
												<div class="col-md-8 mb-xs">
													<select name="BC_Class" data-plugin-selectTwo class="form-control populate">
														<optgroup label="Large Business Enterprise">
															<option value="Large Business Enterprise">Large Business Enterprise</option>
															<option value="Minority-Owned Large Business Enterprise">Minority-Owned Large Business Enterprise</option>
														</optgroup>
														<optgroup label="Small Business Enterprise">
															<option value="Hubzone Small Business Enterprise">Hubzone Small Business Enterprise</option>
															<option value="Minority-Owned Small Business Enterprise">Minority-Owned Small Business Enterprise</option>
														</optgroup>
														<optgroup label="Disadvantaged Business">
															<option value="Disables Veteran Business Enterprise">Disables Veteran Business Enterprise</option>
															<option value="Local Small Disadvantaged Business Enterprise">Local Small Disadvantaged Business Enterprise</option>
															<option value="MWBDE">MWBDE</option>
                                                            <option value="Other">Other</option>
														</optgroup>
													</select>
												</div>
												<label class="col-md-3 control-label">If Other, please specify</label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-question-circle"></i></span>
														</span>
														<input name="BC_Other" class="form-control" placeholder="Other" type="text" />
													</div>
												</div>
										</div>
                                        <div class="form-group">
												<label class="col-md-3 control-label">Certifying Agency</label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-bookmark-o"></i></span>
														</span>
														<input name="BC_Agency" class="form-control" placeholder="Agency Name or Self-Certified" type="text" />
													</div>
												
													<p>
														If you listed your company as a <code>small</code> or <code>disadvantaged</code> business
													</p>
                                                </div>
												<label class="col-md-3 control-label">Certification Number</label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-gavel"></i></span>
														</span>
														<input name="BC_CertNum" class="form-control" placeholder="Certification Number" type="text" />
													</div>
												</div>
												<label class="col-md-3 control-label">Expiration Date</label>
												<div class="col-md-4 mb-xs">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input name="BC_ExpDate" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" />
													</div>
												</div>
										</div>
									</div>
								</section>
							</div>
						</div>
						<div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-2">

    						</div>
							<div class="col-xs-12 col-md-12 col-lg-9 col-xl-6">
								<section class="panel">
									<header class="panel-heading">
										<h2 class="panel-title alternative-font">Completion and Submit</h2>
									</header>
									<div class="panel-body">
                                        <div class="alert alert-info fade in nomargin">
    										<h4><i class="fa fa-warning"></i> Submission Notice and Abibe</h4>
    										<p>Before submit, please double check all requested information had been fill out completely and accurately.</br>
                                            Personally identifying information, such as your address, telephone number, and email address, that is submitted on the registration application becomes part of USBest Repairs record. Some information will be viewable in the USBest's databases that are available on the Internet. For this reason, you should provide only the information requested. </br>
                                            Please do NOT provide any additional personal information that is not requested or not want to disclosed.</br>
                                            Any falsify information will result in a disqualification of your term of aggrement in working for USBest Repairs.</p>
                                        </div>
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-9 mb-xs">
                                            <div class="checkbox-custom chekbox-primary">
                                                <input id="agreement" value="agreement" name="agreement" required="" type="checkbox">
                                                <label for="agreement">Agree and accept that all information provided are accurate.</label>
                                            </div>
                                        </div>
									</div>
                                    <footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-4">
												<button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Submission Form (Disabled)"><i class="fa fa-sign-out"></i> Submit Form</button>
												<button type="reset" value="Reset" onclick="window.location.href='#top'" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Reset form back to blank"><i class="fa fa-refresh"></i> Reset Form</button>
											</div>
										</div>
									</footer>
								</section>
							</div>
						</div>
                 	</form>
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
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
		<script src="assets/vendor/fuelux/js/spinner.js"></script>
		<script src="assets/vendor/dropzone/dropzone.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
		<script src="assets/vendor/codemirror/lib/codemirror.js"></script>
		<script src="assets/vendor/codemirror/addon/selection/active-line.js"></script>
		<script src="assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="assets/vendor/codemirror/mode/javascript/javascript.js"></script>
		<script src="assets/vendor/codemirror/mode/xml/xml.js"></script>
		<script src="assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="assets/vendor/summernote/summernote.js"></script>
		<script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="assets/vendor/ios7-switch/ios7-switch.js"></script>
		<script src="assets/vendor/jquery-idletimer/dist/idle-timer.js"></script>
		<script src="assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
        <script src="assets/vendor/jquery-geocomplete/jquery.geocomplete.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Dashboard -->
		<script src="assets/javascripts/forms/advanced.form.js" /></script>
	</body>
</html>