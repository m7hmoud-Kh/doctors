<?php
$titlepage = "Dashbord Admin" ;
session_start();
include "init.php";
include $men;
if(isset($_SESSION["admin"])){
    $stmt = $con->prepare("SELECT * FROM `admin` WHERE username = ? ");
    $stmt->execute(array($_SESSION["admin"]));
    $infoadmin = $stmt->fetch();

    $stmt2 = $con->prepare("SELECT COUNT(ID) FROM doctors");
    $stmt2->execute();
    $countdoc = $stmt2->fetchcolumn();


    $stmt3 = $con->prepare("SELECT COUNT(ID) FROM sick");
    $stmt3->execute();
    $countsick = $stmt3->fetchcolumn();
?>
<div class="allinfo">
    <div class="container">
        <div class="row">
            <div class=" doc">
            <i class="fas fa-user-md"></i> <a href="docto.php"> doctors <span> <?php echo  $countdoc ?></span></a>  <a href="docto.php?do=add"><i class="fa fa-plus adddoc"></i></a>
            </div>
            <div class=" sic">
            <i class="fas fa-user-injured"></i> <a href="sick.php">sick people  <span> <?php echo  $countsick ?></span></a>
            </div>
        </div>
    </div>
</div>
<?php
include $footer;
}
else
{
    header("location:login.php");
}