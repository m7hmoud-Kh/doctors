<?php
session_start(); 
include "init.php";
session_unset();
session_destroy();
header("location:login.php");
exit();