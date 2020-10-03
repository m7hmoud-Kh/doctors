<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo $css; ?>/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>/fontawes/font1/css/all.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>/front.css" />
    <title><?php  gettilte() ; ?></title>
  </head>
  <body>
      <!--start the nav-->
    <nav>
       <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <img src="../doctors/include/template/layout/img/logo.png"alt="" />
                </div>
                <div class="col-lg-9 text-right">
                    <ul class="list-unstyled links">
                    <li> <a href="index.php">home</a></li>
                    <li date-scroll=".sec1">about us</li>
                    <li date-scroll=".sec2">our services</li>
                    <li date-scroll=".sec3">our team</li>
                    <li date-scroll=".sec4">contact us</li>
                    <li><a href="../../../../php_mah/doctors/admincp/login.php">Admin</a></li>
                    </ul>
                    <div class="trangile">
                    <i class="fa fa-bars icon"></i>
                    </div>
                    <div class="menu-bar">
                        <ul class="list-unstyled menulist">
                            <i class="fas fa-times cross"></i>
                            <li><a href="index.php">home</a></li>
                            <li date-scroll=".sec1">about us</li>
                            <li date-scroll=".sec2">our services</li>
                            <li date-scroll=".sec3">our team</li>
                            <li date-scroll=".sec4">contact us</li>
                            <li><a href="../../../../php_mah/doctors/admincp/login.php">Admin</a></li>
                            </ul>
                    </div>

                </div>
            </div>
       </div>
    </nav>