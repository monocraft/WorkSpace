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
			<title>WorkSpace | Active Vendor</title>
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
										<li class="nav-active">
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
							<h2 class="alternative-font">
								Active Vendors
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
											Active Vendors
										</span>
									</li>
								</ol>
								<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
							</div>
						</header>
						<!-- start: page -->
                        	<?php
                        	$xcrud->table_name('Lead & Current On The Jobs');
                        	$xcrud->table('tblVendors');
                            $xcrud->default_tab('Company Info');
                        	$xcrud->where('VendorStatus', array('1','14','15','16'));
                            $xcrud->relation('VendorStatus', 'tblVenStatus', 'StatusID', 'VendorStatus');
                            $xcrud->relation('US_Best_Representative','tblEmployees', 'EmployeeID', array('FirstName', 'LastName'));
                            $xcrud->join('VendorID','tblVenInfo','VendorID')->join('VendorID','tblVenWorkExp','VendorID')->join('VendorID','tblVenBusiness','VendorID');
                            $xcrud->fields('VendorID,Received_Date,US_Best_Representative,VendorStatus,Company_Name, Physical_Street_Address_1, Physical_Street_Address_2, Physical_City, Physical_State, Physical_Zipcode, Company_Website, Mailing_Street_Address_1, Mailing_Street_Address_2, Mailing_City, Mailing_State, Mailing_Zipcode, BO_Name, BO_Office_Phone, BO_Cell_Phone, BO_Email, MPOC_Name, MPOC_Office_Phone, MPOC_Cell_Phone, MPOC_Email, Geoservice, Lat, Lng', false, 'Company Info');
                            $xcrud->fields('tblVenInfo.OI_BClass,tblVenInfo.OI_BCOther,tblVenInfo.OI_DateFound,tblVenInfo.OI_StateInc,tblVenInfo.OI_FedID,tblVenInfo.OI_Dunn,tblVenInfo.OI_License,tblVenInfo.OI_LicExp,tblVenInfo.OI_States,tblVenInfo.OI_Counties,tblVenInfo.OI_Primary,tblVenInfo.OI_PrimaryYears,tblVenInfo.OI_Service,tblVenInfo.OI_ServiceYears,tblVenInfo.OI_Other,tblVenInfo.OI_OtherYears,tblVenInfo.OI_Specialties,tblVenInfo.OI_OtherSp,tblVenInfo.OI_LicByState,tblVenInfo.OI_StateLic,tblVenInfo.OI_Insurance,tblVenInfo.OI_InsAmount,tblVenInfo.OI_WorkerComp,tblVenInfo.OI_Photos,tblVenInfo.OI_Ysmart,tblVenInfo.OI_Bsmart,tblVenInfo.LastUpdated', false, 'Organization Info');
                            $xcrud->fields('tblVenWorkExp.WE_EmpAmnt,tblVenWorkExp.WE_Sub,tblVenWorkExp.WE_SubAmnt,tblVenWorkExp.WE_Current,tblVenWorkExp.WE_Month,tblVenWorkExp.WE_Year,tblVenWorkExp.WE_WInc,tblVenWorkExp.WE_WINote,tblVenWorkExp.WE_Convict,tblVenWorkExp.WE_Bankrupt,tblVenWorkExp.WE_Court,tblVenWorkExp.WE_Claim,tblVenWorkExp.WE_Entity,tblVenWorkExp.WE_USBest,tblVenWorkExp.WE_Ref,tblVenWorkExp.LastUpdated', false, 'Work Experience');
                            $xcrud->fields('tblVenBusiness.BC_Class, tblVenBusiness.BC_Other, tblVenBusiness.BC_Agency, tblVenBusiness.BC_CertNum, tblVenBusiness.BC_ExpDate, tblVenBusiness.LastUpdated', false, 'Business Classification');
                           	
                            $xcrud->columns('Received_Date,US_Best_Representative,VendorStatus,Company_Name,Physical_State,BO_Name,BO_Office_Phone,BO_Email',false);
                            $xcrud->label(array(
                            'VendorID' => 'Vendor Assigned ID',
                            'Received_Date' => 'Received Date',
                            'US_Best_Representative' => 'USBest Rep.',
                            'VendorStatus' => 'Vendor Status',
                            'Company_Name' => 'Company Name',
                            'Physical_Street_Address_1' => 'Physical Address',
                            'Physical_Street_Address_2' => 'Physical Address 2',
                            'Physical_City' => 'City',
                            'Physical_State' => 'State',
                            'Physical_Zipcode' => 'Zipcode',
                            'Company_Website' => 'Website',
                            'Mailing_Street_Address_1' => 'Mailing Address',
                            'Mailing_Street_Address_2' => 'Mailing Address 2',
                            'Mailing_City' => 'Mailing City',
                            'Mailing_State' => 'Mailing State',
                            'Mailing_Zipcode' => 'Mailing Zipcode',
                            'BO_Name' => 'Business Owner',
                            'BO_Office_Phone' => 'Office Phone',
                            'BO_Cell_Phone' => 'Cell Phone',
                            'BO_Email' => 'Email',
                            'MPOC_Name' => 'Main Contact',
                            'MPOC_Office_Phone' => 'Office Phone',
                            'MPOC_Cell_Phone' => 'Cell Phone',
                            'MPOC_Email' => 'Email',
                            'Geoservice' => 'Geo Service',
                            'Lat' => 'Latitude',
                            'Lng' => 'Longitude',
                            'tblVenInfo.OI_BClass' => 'Business Classification',
                            'tblVenInfo.OI_BCOther' => 'Other',
                            'tblVenInfo.OI_DateFound' => 'Date Business Founded',
                            'tblVenInfo.OI_StateInc' => 'State of Incorporation',
                            'tblVenInfo.OI_FedID' => 'Federal ID',
                            'tblVenInfo.OI_Dunn' => 'Dunn & Bradstreet',
                            'tblVenInfo.OI_License' => 'Business License',
                            'tblVenInfo.OI_LicExp' => 'License Expiration Date',
                            'tblVenInfo.OI_States' => 'Business State(s)',
                            'tblVenInfo.OI_Counties' => 'Service Counties',
                            'tblVenInfo.OI_Primary' => 'Primary Business',
                            'tblVenInfo.OI_PrimaryYears' => 'Years of Experience',
                            'tblVenInfo.OI_Service' => 'Other Type of Service',
                            'tblVenInfo.OI_ServiceYears' => 'Years of Experience',
                            'tblVenInfo.OI_Other' => 'Other',
                            'tblVenInfo.OI_OtherYears' => 'Years of Experience',
                            'tblVenInfo.OI_Specialties' => 'Specialties',
                            'tblVenInfo.OI_OtherSp' => 'Other Specialties',
                            'tblVenInfo.OI_LicByState' => 'Are you Licensed?',
                            'tblVenInfo.OI_StateLic' => 'License Number',
                            'tblVenInfo.OI_Insurance' => 'General Liability Insurance?',
                            'tblVenInfo.OI_InsAmount' => 'Amount of Insurance',
                            'tblVenInfo.OI_WorkerComp' => 'Workers\' Compensation Insurance',
                            'tblVenInfo.OI_Photos' => 'Are you able to provide photos to US Best Repairs for each job?',
                            'tblVenInfo.OI_Ysmart' => 'Do you have a smartphone?',
                            'tblVenInfo.OI_Bsmart' => 'Does your job supervisors/crew leader/foreman/superintendent carry a smartphone?',
                            'tblVenInfo.LastUpdated' => 'Last Updated',
                            'tblVenWorkExp.WE_EmpAmnt' => 'How many people does your firm presently employ?',
                            'tblVenWorkExp.WE_Sub' => 'Subcontractors?',
                            'tblVenWorkExp.WE_SubAmnt' => 'How many Subcontractors?',
                            'tblVenWorkExp.WE_Current' => 'How many projects are you currently working on?',
                            'tblVenWorkExp.WE_Month' => 'How many projects/jobs have you completed in the past 3 months?',
                            'tblVenWorkExp.WE_Year' => 'How many projects/jobs have you completed in the past year?',
                            'tblVenWorkExp.WE_WInc' => 'Have you ever walked away from an job that was incomplete?',
                            'tblVenWorkExp.WE_WINote' => 'Explaination',
                            'tblVenWorkExp.WE_Convict' => 'Have any Owners, officers, major stockholders, or senior management of your Company ever been indicted or convicted of any felony or other criminal conduct?',
                            'tblVenWorkExp.WE_Bankrupt' => 'Has your Company ever petitioned for bankruptcy, failed in a business endeavor, defaulted or been terminated on a contract?',
                            'tblVenWorkExp.WE_Court' => 'Has any entity ever made a claim in a court of law, against your Company for defective, improper or nonconforming work, or for failing to comply with warranty obligations?',
                            'tblVenWorkExp.WE_Claim' => 'Are there any outstanding Judgments or Claims against your Company?',
                            'tblVenWorkExp.WE_Entity' => 'Has any entity made a claim in a court of law, against your Company for failing to make payments to that or any other entity?',
                            'tblVenWorkExp.WE_USBest' => 'Has your company worked for US Best Repair Service in the past?',
                            'tblVenWorkExp.WE_Ref' => 'Work Reference/Notes',
                            'tblVenWorkExp.LastUpdated' => 'Last Updated',
                            'tblVenBusiness.BC_Class' => 'Business Classification',
                            'tblVenBusiness.BC_Other' => 'Other',
                            'tblVenBusiness.BC_Agency' => 'Certifying Agency',
                            'tblVenBusiness.BC_CertNum' => 'Certification Number',
                            'tblVenBusiness.BC_ExpDate' => 'Expiration Date',
                            'tblVenBusiness.LastUpdated' => 'Last Updated'));
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
                            //Hide when resize
                            $xcrud->column_class('Received_Date', 'text-right hidden-xs hidden-sm');
                            $xcrud->column_class('Physical_State', 'text-center hidden-xs hidden-sm');
                            $xcrud->column_class('BO_Office_Phone', 'text-right hidden-xs hidden-sm');
                            $xcrud->column_class('BO_Email', 'text-left hidden-xs hidden-sm');
                            
                            $xcrud->column_width('Physical_State','30px');
                            $xcrud->column_width('Received_Date','125px');
                            $xcrud->column_width('BO_Office_Phone','100px');
                            $xcrud->column_width('US_Best_Representative','150px');
                            $xcrud->column_width('VendorStatus,BO_Name','175px');
                            $xcrud->column_width('Company_Name','275px');
							$xcrud->buttons_position('left');
                            //$xcrud->change_type('geoservice', 'point', '33.692654,-117.844136', array('text' => 'Enter Your Address'));
                            $xcrud->column_callback('Received_Date', 'alter_date');
                            $xcrud->column_pattern('VendorStatus','<a href="javascript:void(0);" class="xcrud-action" data-task="view" data-primary="{VendorID}"><span class="status-{VendorStatus}">&nbsp;&nbsp;{value}</span></a>');
                            //Display data
                            echo $xcrud->render();
                        	?>
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