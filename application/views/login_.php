<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to <?php echo $this->config->item('site_name'); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/perumahan.jpg') ?>" />
	<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
	<style>
		.loginCover {
			background-image: url("assets/images/bangunan.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center;
			height: 100%;
		}

		.leftLogin {
			background-image: url("assets/images/perumahan.jpg");
			background-size: contain;
			background-position: center;
			border-right: 2px solid #187ca6;
			height: 373px;
			background-repeat: no-repeat;
		}
	</style>
</head>
<body class="gray-bg loginCover">
	<div class="loginColumns animated fadeInDown">
		<div class="ibox-content">
			<div class="row">
				<div class="col-md-6 leftLogin"></div>
				<div class="col-md-6">
					<marquee scrolldelay="70">
					<?php
						date_default_timezone_set("Asia/Jakarta");
						echo $this->session->userdata("pls_login");
						$hour = date('H');
						if((int)($hour) >= 0){
							$greeting = "Morning Sunshine!";
						}
						if((int)($hour) >= 6){
							$greeting = "Good Morning!";
						} 
						if((int)($hour) >= 12){
							$greeting = "Good Afternoon!";
						}
						if((int)($hour) >= 17){
							$greeting = "Good Evening";
						}
						if((int)($hour) >= 22){
							$greeting = "Good Night!";
						}
					?>

					<h3 class="font-bold" style="text-align:center;margin-top:10%;"><?php echo $greeting; ?> Welcome Back.</h3>
					<p style="text-align:center;">Enter your details below here</p>
					</marquee>
					<?php if($this->session->flashdata("error")){ ?>
					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						
						<?php
						echo $this->session->flashdata("error");
                            unset($_SESSION["error"]);
                        ?>
					</div>
					<?php } ?>
					<form class="m-t" role="form" action="<?php echo base_url("login/action") ?>" method="POST">
						<div class="form-group">
                            <input type="email" class="form-control" placeholder="Username" name="username" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" id="myInput" required="">
                            <input type="checkbox" onclick="myFunction()"> Show Password
                        </div>
                        <button type="submit" name="login" class="btn btn-success block full-width m-b">LOGIN</button>
                    </form>
                    <p class="m-t" style="text-align:center;">
                        <small>Tata Ruang Dan Perumahan Rakyat &copy; <?php echo date('Y'); ?></small>
                    </p>
				</div>
			</div>
		</div>
    </div>
    <script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>