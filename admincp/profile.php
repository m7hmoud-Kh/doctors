<?php 
session_start();
$titlepage = "Profile";
include "init.php";
include $men;
if(isset($_SESSION["admin"]))
{
    $do = "";
    if(isset($_GET["do"]))
    {
        $do = $_GET["do"];
    }
    else
    {
        $do = "mange";
    }
    if($do == 'mange')
    {
    $stmt = $con->prepare("SELECT * FROM `admin`");
    $stmt->execute();
    $alladmin = $stmt->fetchAll();
    $path = "..//admincp//adminimage//";
    ?>
       <div class="container">
            <h1 class="text-center headoc"><i class="fas fa-users-cog"></i> admins</h1>
           <table class="main-table table table-bordered">
           <tr>
            <td>ID</td>
            <td>Image</td>
            <td>Username</td>
            <td>control</td>
           </tr>
           <?php
              foreach($alladmin as $admin)
              {
                  ?>
                  <tr>
                    <td><?php echo $admin["ID"]; ?></td>
                    <td>
                      <?php 
                      if($admin["image"] == 0)
                        {
                            echo "no image";
                        }
                        else
                        {
                            ?>
                            <div class="timagedoc">
                            <img src="<?php echo $path.$admin["image"]; ?>" alt="">
                            </div>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php echo $admin["username"]; ?></td>
                    <td>
                    <a href="profile.php?do=edit&id=<?php echo $admin["ID"]; ?>" class="editadmin">
                        <button class="btn btn-success" 
                        <?php if($_SESSION["idadmin"] !== $admin["ID"]){echo "disabled" ;}  ?>>
                        <i class="fa fa-edit"></i> Edit
                        </button>
                    </a>
                    <a href="profile.php?do=dele&id=<?php echo $admin["ID"]; ?>" class="editadmin deleadmin">
                        <button class="btn btn-danger" 
                        <?php if($_SESSION["speical"] == '2'){echo "disabled" ;}  ?>>
                        <i class="fas fa-times"></i> Delete
                        </button>
                       </a>
                    </td>
                  </tr>
                  <?php
              }
           ?>
           </table>
           <a href="profile.php?do=add" class="btn btn-primary added">add admin</a>
        </div>
    <?php 
    }
    elseif($do == 'add')
    {

        if($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            $formerr = array();

            $fname = $_FILES["image"]["name"];
            $ftype = $_FILES["image"]["type"];
            $ftemp = $_FILES["image"]["tmp_name"];
            $fsize = $_FILES["image"]["size"];

            $allowextion = array("jpeg","png","jpg");
            $extion = explode('.' , $fname);
            $extion = end($extion);
            $extion = strtolower($extion);

            
            $name  = filter_var($_POST["admin"] , FILTER_SANITIZE_STRING);
            $pass1 = $_POST["pass1"];
            $pass2 = $_POST["pass2"];
            $spe   = $_POST["special"];

            if(empty($name))
            {
                $formerr[] = "username can't be <b>Empty</b>";
            }
            if(!empty($name))
            {
                if(strlen($name) < 3)
                {
                    $formerr[] = "username must be more than <b>4 char</b>";
                }
                if(strlen($name) > 15)
                {
                    $formerr[] = "username must be less than <b>15 char</b>";
                }
            }
            if(empty($pass1))
            {
                $formerr[] = "password can't be  <b>Empty</b>";
            }
            if(!empty($pass1))
            {
                if($pass1 !== $pass2)
                {
                    $formerr[] = "password not <b>identical</b>";
                }
            }
            if($spe == 0)
            {
                $formerr[] = "type Admin can't be  <b>Empty</b>";
            }
            if(empty($fname))
            {
                $formerr[] = "Image can't be  <b>Empty</b>";
            }
            if(!empty($fname))
            {
                if(!in_array($extion,$allowextion))
                {
                    $formerr[] = "this file is  <b>not allowed</b>";
                }
                if($fsize > 4202500)
                {
                    $formerr[] = "this image can't be less more <b>4MB</b>";
                }
            }
            if(empty($formerr))
            {
                $stmt = $con->prepare("SELECT username FROM `admin` WHERE username = ?");
                $stmt->execute(array($name));
                $count2 = $stmt->rowCount();
                if($count2 > 0)
                {
                    $formerr[] = "This name already <b>exists</b>";
                }
                else
                {
                    $imageadmin = rand(0,10000)."_".$fname;
                    $path = "C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\adminimage\\";
                    move_uploaded_file($ftemp,$path.$imageadmin);

                    $stmt = $con->prepare("INSERT INTO `admin`(username , `password` , `image` ,spiecal)
                                        VALUES(:u , :p , :i , :s)");
                    $stmt->execute(array(
                        'u' => $name,
                        'p' => $pass1,
                        'i' => $imageadmin,
                        's' => $spe
                    ));

                    $count = $stmt->rowCount();
                    if($count > 0)
                    {
                        $success = "<div class='alert alert-success'>This Admin Is Added</div>";
                    }

                }
            }
        }
        ?>
    <div class="container">
    <div class="row">
        <div class="adminform">
            <h1 class="text-center">Add Admin</h1>
            <form action="profile.php?do=add" method="POST" enctype="multipart/form-data">
                <div>
                    <input class="form-control" type="text" name="admin" placeholder="type name" autocomplete="off">
                </div>
                <div>
                    <input class="form-control" type="password" name="pass1" placeholder="type password" autocomplete="new-password">
                </div>
                <div>
                    <input class="form-control" type="password" name="pass2" placeholder="type password again" autocomplete="new-password">
                </div>
                <div>
                    <select name="special" class="form-control" style="width: 513px;margin: auto;">
                        <option value="0">---</option>
                        <option value="1">speical Admin</option>
                        <option value="2">Normale Admin</option>
                    </select>
                </div>
                <div class="fileimageadmin">
                        <input type="file" class="form-control docimage" name="image">
                        <span> <i class="fa fa-upload"></i> upload image</span>
                </div>
                <div>
                <input type="submit" value="Add" class="btn btn-primary login"> 
                </div>
                <?php 
                    if(!empty($formerr))
                    {
                        foreach($formerr as $err)
                        {
                            ?>
                                <div>
                                <div class="alert alert-danger err"><?php echo $err ; ?></div>
                                </div>
                            <?php
                        }
                    }
                    if(isset($success))
                    {
                        echo $success;
                    }
                ?>
        </div>
        </div>
    </div>
        <?php
    }
    elseif($do == "edit")
    {
        $stmt = $con->prepare("SELECT * FROM `admin` WHERE ID = ?");
        $stmt->execute(array($_SESSION["idadmin"]));
        $infoad = $stmt->fetch();
    ?>
    <div class="container">
        <div class="row">
        <div class="adminform">
            <h1 class="text-center">Edit Admin</h1>
            <form action="profile.php?do=insert&id=<?php echo $_SESSION["idadmin"];?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $infoad["ID"]; ?>" name="id">
            <input type="hidden" value="<?php echo $infoad["image"]; ?>" name="oldimage">
            <input type="hidden" value="<?php echo $infoad["spiecal"]; ?>" name="spe">
                <div>
                    <input class="form-control" type="text" name="admin" placeholder="type name" autocomplete="off" value="<?php echo $infoad["username"]; ?>">
                </div>
                <div>
                    <input class="form-control" type="password" name="pass1" placeholder="type password" autocomplete="new-password" value="<?php echo $infoad["password"]; ?>">
                </div>
                <div>
                    <input class="form-control" type="password" name="pass2" placeholder="type password again" autocomplete="new-password"  value="<?php echo $infoad["password"]; ?>">
                </div>
                <div class="fileimageadmin">
                        <input type="file" class="form-control docimage" name="image">
                        <span> <i class="fa fa-upload"></i> upload image</span>
                </div>
                <div>
                <input type="submit" value="save" class="btn btn-primary login"> 
                </div> 
            </div>
            </div>
            </div>
           <?php
    }
    elseif($do == 'insert')
    {
       if(isset($_GET["id"]) && is_numeric($_GET["id"]))
       {
            if($_SERVER["REQUEST_METHOD"] == 'POST')
            {
                
                $idadminedit = $_POST["id"];
                if($idadminedit == $_SESSION["idadmin"])
                {
                    $formerr = array();

                    $fname = $_FILES["image"]["name"];
                    $ftype = $_FILES["image"]["type"];
                    $ftemp = $_FILES["image"]["tmp_name"];
                    $fsize = $_FILES["image"]["size"];
        
                    $allowextion = array("jpeg","png","jpg");
                    $extion = explode('.' , $fname);
                    $extion = end($extion);
                    $extion = strtolower($extion);
        
                    
                    $name     = filter_var($_POST["admin"] , FILTER_SANITIZE_STRING);
                    $pass1    = $_POST["pass1"];
                    $pass2    = $_POST["pass2"];
                    $spe      = $_POST["spe"];
                    $oldimage = $_POST["oldimage"];
        
                    if(empty($name))
                    {
                        $formerr[] = "username can't be <b>Empty</b>";
                    }
                    if(!empty($name))
                    {
                        if(strlen($name) < 3)
                        {
                            $formerr[] = "username must be more than <b>4 char</b>";
                        }
                        if(strlen($name) > 15)
                        {
                            $formerr[] = "username must be less than <b>15 char</b>";
                        }
                    }
                    if(empty($pass1))
                    {
                        $formerr[] = "password can't be  <b>Empty</b>";
                    }
                    if(!empty($pass1))
                    {
                        if($pass1 !== $pass2)
                        {
                            $formerr[] = "password not <b>identical</b>";
                        }
                    }
                    if(!empty($fname))
                    {
                        if(!in_array($extion,$allowextion))
                        {
                            $formerr[] = "this file is  <b>not allowed</b>";
                        }
                        if($fsize > 4202500)
                        {
                            $formerr[] = "this image can't be less more <b>4MB</b>";
                        }
                    }

                    
                if(empty($formerr))
                {
                    $stmt = $con->prepare("SELECT * FROM `admin` WHERE username = ? AND ID != ? ");
                    $stmt->execute(array($name,$idadminedit));
                    $count = $stmt->rowCount();
                    if($count > 0)
                    {
                        $formerr[] = "this name is already exist";
                    }
                    else
                    {
                        if(empty($fname))
                        {
                            $path  ="C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\adminimage\\";
                            move_uploaded_file($ftemp,$path.$oldimage);

                            $stmt = $con->prepare
                            ("UPDATE `admin` SET  username =:u , `password` =:p , `image` =:i , spiecal =:s
                            WHERE ID = :id ");
                            $stmt->execute(array(
                            'u'  =>  $name,
                            'p'  =>  $pass1,
                            'i'  =>  $oldimage,
                            's'  =>  $spe,
                            'id' =>  $idadminedit
                            ));
                            $count2 = $stmt->rowCount();
                            if($count2 > 0)
                            {
                                $themeg = "<div class='alert alert-success'>This Form Is Edited</div>";
                                redirect ($themeg , 'back' ,  3 , 'back');
                            }
                        }
                        if(!empty($fname))
                        {
                            $imageadmin = rand(0,10000)."_".$fname;
                            $path = "C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\adminimage\\";
                            move_uploaded_file($ftemp,$path.$imageadmin);

                            $stmt = $con->prepare
                            ("UPDATE `admin` SET  username = :u , `password` = :p , `image` = :i , spiecal = :s
                            WHERE ID = :id");
                            $stmt->execute(array(
                            'u'  =>  $name,
                            'p'  =>  $pass1,
                            'i'  =>  $imageadmin,
                            's'  =>  $spe,
                            'id' =>  $idadminedit
                            ));
                            $count2 = $stmt->rowCount();
                            if($count2 > 0)
                            {
                                $themeg = "<div class='alert alert-success'>This Form Is Edited</div>";
                                redirect ($themeg , 'back' ,  3 , 'back');
                            }
        
                        }
                    }

                 }
                 if(!empty($formerr))
                 {
                     foreach($formerr as $err)
                     {
                     ?>
                     <div class="alert alert-dnager err"><?php echo $err; ?></div>
                     <?php 
                     }
                 }
                }
            }
       }
       else
       {
           header("location:login.php");
       }
    }
    elseif($do == 'dele')
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]))
        {
            $idadmin = $_GET["id"];

            $stmt = $con->prepare("SELECT * FROM `admin` WHERE ID =?");
            $stmt->execute(array($idadmin));
            $count = $stmt->rowCount();
            if($count > 0)
            {
                $stmt  = $con->prepare("DELETE FROM `admin` WHERE ID = ?");
                $stmt->execute(array($idadmin));
                $count2 = $stmt->rowCount();
                if($count2 > 0)
                {
                    $themeg = "<div class='alert alert-success'>This Admin Is <b>Deleted</b></div>";
                    redirect ($themeg , 'pro' ,  3 , 'pro');
                }
            }
            else
            {
                header("location:login.php");
            }
        }
    }
    include $footer;
}
else
{
    header("location:login.php");
}