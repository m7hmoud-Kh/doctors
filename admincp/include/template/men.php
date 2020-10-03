<?php 

    $stmt = $con->prepare("SELECT * FROM `admin` WHERE ID = ?");
    $stmt->execute(array($_SESSION["idadmin"]));
    $infoadmin = $stmt->fetch();
$path = "..//..//..//admincp//adminimage//" ;
?>

<i class="fa fa-bars fa-3x menu showadmin"></i>
    <i class="fas fa-times fa-3x menu hideadmin"></i>
    <div class="dashbordmenu">
        <div class="adminamge">
            <img src="<?php echo $path.$infoadmin["image"]; ?>" alt="">
            <span></span>
        </div>
        <div class="nameadmin">  <?php echo $infoadmin["username"]; ?> </div>
        <ul class="list-unstyled">
            <li> <i class="fas fa-user-circle fa-lg"></i> <a href="profile.php">My Porfile</a></li>
            <li> <i class="fa fa-home fa-lg"></i> <a href="dashbord.php">Dashbord</a></li>
            <li> <i class="fa fa-user-md fa-lg"></i> <a href="docto.php">Doctors</a> </li>
            <li> <i class="fa fa-user-plus fa-lg"></i> <a href="docto.php?do=add">Add doctors</a></li>
            <li> <i class="fas fa-user-injured fa-lg"></i> <a href="sick.php">sick pepole</a></li>
            <i class="fa fa-plus showcat"></i> <i class="fa fa-minus hidecat"></i>
            <span class="categorsick">
            <li> <i class="fas fa-user-injured fa-lg"></i> <a href="sick.php?do=heart">heart</a></li>
            <li> <i class="fas fa-user-injured fa-lg"></i> <a href="sick.php?do=brain">brain</a></li>
            <li> <i class="fas fa-user-injured fa-lg"></i> <a href="sick.php?do=lung">lung</a></li>
            <li> <i class="fas fa-user-injured fa-lg"></i> <a href="sick.php?do=knee">knee</a></li>
            </span>
            <li> <i class="fas fa-door-open fa-lg"></i> <a href="logout.php">LogOut</a></li>
        </ul>
    </div>
