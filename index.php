<?php
/*
 * Copyright (C) 2014 USBest WorkSpace
 *
 */
 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
// last request was more than 30 minutes ago
session_unset();     // unset $_SESSION variable for the run-time 
session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
sec_session_start();

if (login_check($mysqli) == true) {
	header("Location: /main");
	exit();
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>WorkSpace - Authentication</title>
        <meta name="generator" content="Authentication" />
        <meta charset="UTF-8">
        <meta name="robots" content="noindex, nofollow">
        <link href="css/pages.css" rel="stylesheet" type="text/css">
        <link href="assets/vendor/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    </head>
    <body onload="startTimer();">
    <div class="login-wrapper ">
        <div class="bg-pic">
            <img id="bgimg" src="assets/images/bg/wallpaper10.jpg" class="lazy">
            <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
                <h2 class="semi-bold text-white">Complete Property Solutions</h2>
                <p class="small">USBest Repair Service Inc.</p>
            </div>
        </div>
    
    
        <div class="login-container bg-white">
            <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
                <img src="assets/images/bg/logo.png" alt="logo" height="100" width="300">
                <p class="p-t-35">Sign into your workspace</p>
                 
                <form id="login_form" name="login_form" method="post" class="p-t-15" role="form" action="includes/process_login.php">
                <div class="alert text-center">
                    <?php echo isset($error) ? $error : null; ?>
                    <?php
                    if (isset($_GET['error'])) {
                    	echo 'Error Logging In!';
                    }
                    ?>
                </div>
                <div class="form-group form-group-default">
                    <label>Login</label>
                    <div class="controls">
                        <input type="hidden" name="<?php echo $action_key_name ?>" value="login"/>
                        <input aria-required="true" name="user_or_email" placeholder="User ID or Email" class="form-control" required="" type="text">
                    </div>
                </div>
                 
                 
                <div class="form-group form-group-default">
                    <label>Password</label>
                    <div class="controls">
                        <input aria-required="true" class="form-control" id="password" name="password" placeholder="Credentials" type="password">
                    </div>
                </div>
                 
                
                 
                    <button class="btn btn-danger btn-cons m-t-10" type="submit" onclick="formhash(this.form, this.form.password);"><i class="fa fa-sign-in"></i> Sign in</button>
                </form>
                <div class="row">
                    <div class="col-md-6 m-t-15">
                        <a href="#" class="text-info small"><i class="fa fa-question-circle"></i> Help - Contact Support</a>
                    </div>
                </div>
                <div class="pull-bottom sm-pull-bottom">
                    <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                        <div class="col-sm-6 col-md-6">
                            <img alt="" class="m-t-5" src="assets/images/bg/pages_icon.png" height="60">
                        </div>
                        <div class="col-sm-9 m-t-10">
                            <p><small>© 2014-2015 USBestWS - All rights reserved.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    </div>
	<!-- Vendor -->
	<script src="assets/vendor/jquery/jquery.js"></script>
	<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
    <script src="js/pages.js"></script>
	</body>
</html>
