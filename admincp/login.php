<?php 
session_start();
$titlepage = "Login Admin"; 
include "init.php";
include $nav;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $formerr = array();
    $admin = $_POST["admin"];
    $pass  = $_POST["pass"];

    if(empty($admin))
    {
        $formerr[] = "username can't be <b>Empty</b>";
    }
    if(empty($pass))
    {
        $formerr[] = "password can't be <b>Empty</b>";
    }
    if(empty($formerr))
    {
        $stmt = $con->prepare("SELECT * FROM `admin` WHERE username = ? AND `password` = ? ");
        $stmt->execute(array($admin,$pass));
        $infoadmin = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0)
        {
            header("location:dashbord.php");
            $_SESSION["admin"]    = $admin ;
            $_SESSION["idadmin"]  = $infoadmin["ID"] ;
            $_SESSION["speical"]  = $infoadmin["spiecal"];
        }
        else
        {
            $formerr[] = "You Are Not <b>Admin</b>";
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="adminform">
            <i class="fas fa-crown tagg"></i>
            <h1 class="text-center">Login Admin</h1>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
                <div>
                    <input class="form-control" type="text" name="admin" placeholder="type your name" autocomplete="off">
                </div>
                <div>
                    <input class="form-control" type="password" name="pass" placeholder="type your password" autocomplete="new-password">
                </div>
                <input type="submit" value="login" class="btn btn-primary login"> 
                <?php
                if(!empty($formerr))
                {
                    foreach($formerr as $err)
                    {
                     ?>
                     <div class="alert alert-danger warn"><?php echo $err; ?></div>
                     <?php
                    }
                }
                ?>
            </form>
        </div>
    </div>
</div>
<?php
include $footer ;
?>