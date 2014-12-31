<?php /* * Copyright (C) 2014 USBest WorkSpace * */ include_once 'includes/db_connect.php'; include_once 'includes/functions.php'; include_once 'xcrud.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
// last request was more than 30 minutes ago
session_unset();     // unset $_SESSION variable for the run-time 
session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
sec_session_start(); $xcrud=Xcrud::get_instance();
if (login_check($mysqli)==false) { header( "Location: /index"); exit(); } ?>
	<!doctype html>
	<!--boxed|fixed|scroll sidebar-left-collapsed-->
	<html class="fixed">
		<head>
			<!-- Basic -->
			<meta charset="UTF-8">
			<title>
				WorkSpace | Form Submission
			</title>
			<meta name="keywords" content="WorkSpace | USBest Repairs" />
			<meta name="description" content="WorkSpace | USBest Repairs">
			<meta name="author" content="Tung Nguyen">
			<link rel="shortcut icon" href="/favicon.ico" />
			<!-- Mobile Metas -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
			<!-- Web Fonts -->
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
			<script src="assets/vendor/modernizr/modernizr.js">
			</script>
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
							<i class="fa fa-tasks" aria-label="Toggle sidebar">
							</i>
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
										<?php if (!check_access(5)):?>
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
														<li>
															<a href="submission">
															<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
															<span>Submission Form <em class="not-included">(View)</em></span>
															</a>
														</li>
														<li class="nav-active">
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
												<?php if (check_access(1) || check_access(2) ):?>
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
							<h2 class="alternative-font">
								Vendor Information Change Update
							</h2>
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
											Vendor Information Change Update
										</span>
									</li>
								</ol>
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>
						<!-- start: page -->
						<form class="form-horizontal form-bordered" action="#">
							<div class="row">
								<div class="col-xs-12 col-md-12 col-lg-8 col-xl-6">
									<section class="panel">
										<header class="panel-heading">
											<div class="panel-actions">
												<a href="#" class="fa fa-caret-down"></a>
											</div>
        
											<h2 class="panel-title alternative-font">
												Information Update
											</h2>
										</header>
										<div class="panel-body">
                                            <div class="alert alert-info fade in nomargin">
        										<h4><i class="fa fa-warning"></i> Vendor Notice!</h4>
        										<p>Please enter information below if <strong class="text-danger">vendor information</strong> needs to be updated or if you have received updated vendor information.</p>
    			                            </div>
											<div class="form-group">
												<label class="col-md-3 control-label">Name of Vendor <span class="required">*</span></label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-asterisk"></i></span>
														</span>
														<input class="form-control" placeholder="Name of Vendor" type="text">
													</div>
												</div>
												<label class="col-md-3 control-label">Vendor ID <span class="required">*</span></label>
												<div class="col-md-3  mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-tags"></i></span>
														</span>
														<input class="form-control" placeholder="Assigned ID" type="text">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Coordinator Name <span class="required">*</span></label>
												<div class="col-md-8 mb-xs">
													<div class="input-group input-group-icon">
														<span class="input-group-addon">
															<span class="icon"><i class="fa fa-user"></i></span>
														</span>
														<input class="form-control" placeholder="Your state coordinator" type="text">
													</div>
												</div>
											</div>
											<div class="form-group">
                                                <label class="col-md-3 control-label" for="textareaAutosize">Information</label>
												<div class="col-md-8">
													<textarea class="form-control" rows="3" placeholder="Updated Info" id="textareaAutosize" data-plugin-textarea-autosize></textarea>
					                                <p>Please note the <code>information</code> that needs to be updated</p>
                                                </div>
											</div>
										</div>
                                        <footer class="panel-footer">
    										<div class="row">
    											<div class="col-sm-9 col-sm-offset-4">
    												<button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Submission Form (Disabled)"><i class="fa fa-sign-out"></i> Submit Form</button>
    												<button type="reset" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Reset form back to blank"><i class="fa fa-refresh"></i> Reset Form</button>
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
			<script src="assets/vendor/jquery/jquery.js">
			</script>
			<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js">
			</script>
			<script src="assets/vendor/bootstrap/js/bootstrap.js">
			</script>
			<script src="assets/vendor/nanoscroller/nanoscroller.js">
			</script>
			<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js">
			</script>
			<script src="assets/vendor/magnific-popup/magnific-popup.js">
			</script>
			<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js">
			</script>
			<!-- Specific Page Vendor -->
			<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js">
			</script>
			<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js">
			</script>
			<script src="assets/vendor/select2/select2.js">
			</script>
			<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js">
			</script>
			<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.js">
			</script>
			<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js">
			</script>
			<script src="assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js">
			</script>
			<script src="assets/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js">
			</script>
			<script src="assets/vendor/fuelux/js/spinner.js">
			</script>
			<script src="assets/vendor/dropzone/dropzone.js">
			</script>
			<script src="assets/vendor/bootstrap-markdown/js/markdown.js">
			</script>
			<script src="assets/vendor/bootstrap-markdown/js/to-markdown.js">
			</script>
			<script src="assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js">
			</script>
			<script src="assets/vendor/codemirror/lib/codemirror.js">
			</script>
			<script src="assets/vendor/codemirror/addon/selection/active-line.js">
			</script>
			<script src="assets/vendor/codemirror/addon/edit/matchbrackets.js">
			</script>
			<script src="assets/vendor/codemirror/mode/javascript/javascript.js">
			</script>
			<script src="assets/vendor/codemirror/mode/xml/xml.js">
			</script>
			<script src="assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js">
			</script>
			<script src="assets/vendor/codemirror/mode/css/css.js">
			</script>
			<script src="assets/vendor/summernote/summernote.js">
			</script>
			<script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js">
			</script>
			<script src="assets/vendor/ios7-switch/ios7-switch.js">
			</script>
			<script src="assets/vendor/jquery-idletimer/dist/idle-timer.js">
			</script>
			<script src="assets/vendor/jquery-autosize/jquery.autosize.js">
			</script>
			<!-- Theme Base, Components and Settings -->
			<script src="assets/javascripts/theme.js">
			</script>
			<!-- Theme Custom -->
			<script src="assets/javascripts/theme.custom.js">
			</script>
			<!-- Theme Initialization Files -->
			<script src="assets/javascripts/theme.init.js">
			</script>
			<!-- Dashboard -->
			<script src="assets/javascripts/forms/advanced.form.js" />
			</script>
		</body>
	
	</html>