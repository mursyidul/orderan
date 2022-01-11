<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?php echo $this->config->item('site_name'); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/yourlogo.png') ?>" />
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
        .loginCover {
            background-image: url("assets/images/tampilan_point.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        .leftLogin {
            background-image: url("assets/images/yourlogo.png");
            background-size: contain;
            background-position: center;
            border-right: 2px;
            width: 265px;
            height: 100px;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="gray-bg loginCover">

    <div class="middle-box text-center loginscreen animated fadeInDown">

        <div class="ibox-content" style="border-radius: 25px; margin-top: 80px; border-bottom-left-radius: 25px; border-bottom-right-radius:25px;">
            <div>
                <!-- <h1 class="logo-name">IN+</h1> -->
            </div>
            <!-- <i class="fa fa-train fa-5x"></i> -->
            <div class="leftLogin"></div>
            <!-- <h3><b>ORDER MANAGEMENT</b></h3> -->
            <!-- <p>Login in. To see it in action.</p> -->
            <form class="m-t" role="form" action="<?php echo base_url("login/action") ?>" method="POST">
                <?php if($this->session->flashdata("error")){ ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                        <?php
                            echo $this->session->flashdata("error");
                            unset($_SESSION["error"]);
                        ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <input type="email" class="form-control" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="myInput" placeholder="Password" required="">
                <div class="custom-control custom-checkbox custom-control-inline" style="text-align: left; margin-top: 10px;">
                    <input id="chk1" onclick="myFunction()" type="checkbox" name="chk" class="custom-control-input">
                    <label for="chk1" class="custom-control-label text-sm">Show password</label>
                </div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <!-- <button type="submit" class="btn btn-success block full-width m-b">Register</button> -->
            </form>
            <p class="m-t"> <small>Order Management<br>Developed By <a href="http://www.emcorpstudio.com/" target="_blank">Emcorp Studio</a> &copy; <?php echo date("Y"); ?></small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= base_url('assets/js/jquery-2.1.1.js') ?>"></script>

    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
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
   <!--  <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script> -->

</body>

</html>
