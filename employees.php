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
			<title>WorkSpace | Users Administration</title>
			<meta name="keywords" content="Vendor Recruitment" />
			<meta name="description" content="Vendor Recruitment">
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
			<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
			<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
            
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
										<li class="nav-active">
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
					<!-- end: sidebar -->                    <?php if (login_check($mysqli) == true && check_access(1) OR check_access(2)) : ?>
					<section role="main" class="content-body">

						<header class="page-header">
							<h2 class="alternative-font">
								Employees
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
											Main
										</span>
									</li>
									<li>
										<span>
											Employees
										</span>
									</li>
								</ol>
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>
						<!-- start: page -->
                        	<?php
                        	$xcrud->table_name('Employees Administration');
                        	$xcrud->table('tblEmployees');
                            $xcrud->default_tab('Employee Info');
                            $vendor_list = $xcrud->nested_table('Assigned Vendors','EmployeeID','tblVendors','US_Best_Representative'); // nested table
                            $vendor_list->relation('VendorStatus', 'tblVenStatus', 'StatusID', 'VendorStatus');
                            $vendor_list->table_name('Assigned Vendors');
                            $vendor_list->unset_add(); // nested table instance access
                            $vendor_list->relation('US_Best_Representative','tblEmployees', 'EmployeeID', array('FirstName', 'LastName'));
                           	$vendor_list->columns('Received_Date,US_Best_Representative,VendorStatus,Company_Name,Physical_State,BO_Name,BO_Office_Phone,BO_Email',false,false,'edit');
                            $vendor_list->label(array(
							'Received_Date' => 'Received Date',
                            'US_Best_Representative' => 'USBest Rep.',
                            'VendorStatus' => 'Vendor Status',
                            'Company_Name' => 'Company Name',
                            'Physical_State' => 'State',
                            'BO_Name' => 'Business Owner',
                            'BO_Office_Phone' => 'Office Phone',
                            'BO_Email' => 'Email Address'));
                            $vendor_list->order_by('Received_Date','desc');
                        	if (!check_access(1)){
                        		$vendor_list->unset_add();
                        	}
                        	if (check_access(5)){
                        		$vendor_list->unset_edit();
                        		$vendor_list->unset_remove();
                        	}
                        	if (check_access(4)){
                        		$vendor_list->unset_remove();
                        	}
                            //Hide when resize
                            $vendor_list->column_class('Received_Date', 'text-right hidden-xs hidden-sm');
                            $vendor_list->column_class('Physical_State', 'text-center hidden-xs hidden-sm');
                            $vendor_list->column_class('BO_Office_Phone', 'text-right hidden-xs hidden-sm');
                            $vendor_list->column_class('BO_Email', 'text-left hidden-xs hidden-sm');
                            
                            $vendor_list->column_width('Physical_State','30px');
                            $vendor_list->column_width('Received_Date','125px');
                            $vendor_list->column_width('BO_Office_Phone','100px');
                            $vendor_list->column_width('US_Best_Representative','150px');
                            $vendor_list->column_width('VendorStatus,BO_Name','175px');
                            $vendor_list->column_width('Company_Name','275px');
							$vendor_list->buttons_position('left');
                            //$xcrud->change_type('geoservice', 'point', '33.692654,-117.844136', array('text' => 'Enter Your Address'));
                            $vendor_list->column_callback('Received_Date', 'alter_date');
                            $vendor_list->column_pattern('VendorStatus','<a href="javascript:void(0);" class="xcrud-action" data-task="view" data-primary="{VendorID}"><span class="status-{VendorStatus}">&nbsp;&nbsp;{value}</span></a>');
                                                       
                            
                        	$xcrud->relation('Role','tblRoles','RoleID', 'AccessType');
                        	$xcrud->columns('Photo, LastName, FirstName, Title, Role, Status, LoginName, LoginPassword, WorkEmail, WorkPhone, Extension, LastLogin',false,false,'edit');
                        	$xcrud->label(array('LastName' => 'Last Name','FirstName' => 'First Name',
                        	'Title' => 'Title','Role' => 'Role',
                        	'Status' => 'Active','LoginName' => 'Login Name','LoginPassword' => 'Login Password',
                        	'WorkEmail' => 'Work Email','WorkPhone' => 'Work Phone',
                        	'Extension' => 'EXT','LastLogin' => 'Last Login'));
                        	$xcrud->unset_remove(true,'LoginName','=','nuen'); // 'nuen' row can't be editable
                        	$xcrud->buttons_position('left');
                        	$xcrud->column_width('LastName, FirstName, Role, LoginName, WorkPhone','100px');
                        	$xcrud->column_width('Title, WorkEmail','250px');
                        	$xcrud->column_width('Status, Extension','75px');
                        	$xcrud->column_width('Notes','450px');
                        	$xcrud->before_insert('salt_password');
                        	$xcrud->before_update('password_update');
                        	$xcrud->readonly('Salt,LastLogin');
                            $xcrud->column_pattern('WorkEmail','{value} <i class="fa fa-external-link"></i>');
                        	$xcrud->change_type('LoginPassword', 'password');
                            $xcrud->change_type('Photo', 'image', false, array('width' => 450,'path' => '/uploads/gallery','thumbs' => array(array('height' => 55,'width' => 120,'crop' => true,'marker' => '_th'))));
                        	$xcrud->fields('Salt,LastLogin', true);
                        	$xcrud->validation_required('LastName',2)->validation_required('FirstName',2)->validation_required('LoginName')->validation_required('Role')->validation_required('Status');
                        	$xcrud->create_action('status_set', 'status_set');
        	                $xcrud->column_pattern('Status','<a href="javascript:void(0);" class="xcrud-action" data-task="action" data-action="status_set" data-primary="{EmployeeID}"><span class="act-{Status}">{value}</span></a>');
                            $xcrud->column_pattern('Role','<span class="role-{Role}">{value}&nbsp;&nbsp;</span>');
                        	if (!check_access(1)){
                        		$xcrud->unset_add();
                        	}
                        	if (check_access(5)){
                        		$xcrud->unset_edit();
                        		$xcrud->unset_remove();
                        	}
                        	if (check_access(4)){
                        		$xcrud->unset_remove();
                        	}
                            //Display data
                            echo $xcrud->render();
                        	?>
						<!-- end: page -->
					</section>
                    
                	<?php else : ?>
                        <section role="main" class="content-body">
            			<div class="panel col-md-6 col-lg-6 col-xl-6">
            
            					<div class="alert alert-danger">
            						<strong><?php echo $_SESSION['fname'];?></strong> , you are not authorized to access this page. </br>Please <a href="includes/logout">logout</a>  and login with right credential.
            					</div>
            
            			</div>
                        </section>
                   <?php endif; ?>
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
		<!--<script src="assets/vendor/jquery/jquery.js"></script> NOT COMPATIBLE -->
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
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>
		</body>
	
	</html>