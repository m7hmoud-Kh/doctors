<?php 

$connection = "C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\";
include $connection."connect.php";

$function = "C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\include\\functions\\";
include $function."fun.php";

$css = "..//admincp//include//template//layout//css";
$js  = "..//admincp//include//template//layout//js";


$stpl = "C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\include\\template\\";
include $stpl . "header.php";

$nav = $stpl."nav.php";
$men = $stpl."men.php";
$footer = $stpl . "footer.php";