<?php
$titlepage = "Doctors";
session_start();
include "init.php";
include $men ;
if (isset($_SESSION["admin"])) {
    $do = "";
    if (isset($_GET["do"])) {
        $do = $_GET["do"];
    } else {
        $do = "mange";
    }
   
    if ($do == "mange") {
        $stmt = $con->prepare("SELECT * FROM doctors ORDER BY categor DESC");
        $stmt->execute();
        $alldoc = $stmt->fetchAll();

      
        $path="..//admincp//upload//";
        ?>
        <div class="container">
            <h1 class="text-center headoc"><i class="fas fa-user-md"></i> Doctors</h1>
           <table class="main-table table table-bordered">
             <tr>
               <td>ID</td>
               <td>Image</td>
               <td>Name</td>
               <td>Categor</td>
               <td>Rating</td>
               <td>All Information</td>
               <td>Controls</td>
             </tr>
             <?php
             foreach($alldoc as $doc)
             {
                 ?>
                  <tr>
                      <td><?php echo $doc["ID"]; ?></td>
                      <td>
                          <?php
                           if ($doc["image"]==0)
                          {
                             echo "No image";
                          }
                          else
                          {
                          ?>
                          <div class="timagedoc">
                            <?php
                            if($doc["rating"] == 4)
                            {
                                ?>
                                <img src="<?php echo $path.$doc['image']; ?>" alt="">
                                <span>the best</span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                 <img src="<?php echo $path.$doc['image']; ?>" alt="">
                                <?php
                            }
                           ?>
                          </div>
                          <?php
                          }
                          ?>
                      </td>
                      <td><?php echo $doc["name"]; ?></td>
                      <td><?php echo $doc["categor"]; ?></td>
                      <td><?php if($doc["rating"] == 1){echo '<i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 2){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 3){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 4){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;}  ?></td>
                      <td><a class="infoeyes" href="docto.php?do=allinfo&id=<?php echo $doc["ID"]; ?>"> <i class="fa fa-eye"></i> All Information </a></td>
                      <td>
                          <a class="btn btn-success" href="docto.php?do=edit&id=<?php echo $doc["ID"]; ?>"> <i class="fa fa-edit"></i> Edit </a>
                          <a class="btn btn-danger con" href="docto.php?do=dele&id=<?php echo $doc["ID"]; ?>"> <i class="fas fa-times"></i> Delete </a>
                      </td>
                  </tr>
                 <?php
             }
             ?>
           </table>
           <a href="docto.php?do=add" class="btn btn-primary added">Add Doctor</a>
        </div>
        <?php
    } 
    elseif($do == "add")
    {
        if(($_SERVER["REQUEST_METHOD"] == 'POST'))
        {
            $formerr = array();

            $fname = $_FILES["image"]["name"];
            $ftype = $_FILES["image"]["type"];
            $ftemp = $_FILES["image"]["tmp_name"];
            $fsize = $_FILES["image"]["size"];
            
            $allowextion = array("png","jpg","jepg","gif");
            $extion      = explode(".",$fname);
            $extion      = end($extion);
            $extion      = strtolower($extion);

            $name     = filter_var($_POST["doc"],FILTER_SANITIZE_STRING);
            $uni      = filter_var($_POST["uni"],FILTER_SANITIZE_STRING);
            $namehost = filter_var($_POST["namehost"],FILTER_SANITIZE_STRING);
            $qul      = $_POST["qualifications"];
            $age      = $_POST["age"];
            $categor  = $_POST["categor"];
            $rat      = $_POST["rating"];

            if(empty($name))
            {
                $formerr[] = "name can't be <b>Empty</b>";
            }
            if(!empty($name))
            {
                if(strlen($name) < 4)
                {
                    $formerr[] = "name must be more than <b>4 char</b>";
                }
                if(strlen($name) > 20)
                {
                    $formerr[] = "name must be less than <b>20 char</b>";
                }
            }
            if(empty($uni))
            {
                $formerr[] = "university can't be <b>Empty</b>";
            }
            if($qul == 0)
            {
                $formerr[] = "qualifications can't be <b>Empty</b>";
            }
            if($age == 0)
            {
                $formerr[] = "Age can't be <b>Empty</b>";
            }
            if($categor == "nothing")
            {
                $formerr[] = "categor can't be <b>Empty</b>";
            }
            if($rat == 0)
            {
                $formerr[] = "Rating can't be <b>Empty</b>";
            }
            if(empty($fname))
            {
                $formerr[] = "Image can't be <b>Empty</b>";
            }
            if(!empty($fname))
            {
                if(!in_array($extion,$allowextion))
                {
                    $formerr[] = "this file <b>not allowed<b>";
                }
                if($fsize == 4202500)
                {
                    $formerr[] = "Image must be less than <b>4MB<b>";
                }
            }

            if(empty($formerr))
            {
                $stmt = $con->prepare("SELECT `name` FROM doctors WHERE `name` = ?");
                $stmt->execute(array($name));
                $count = $stmt->rowCount();
                if($count > 0)
                {
                    $formerr[] = "This name is Exist";
                }
                else
                {
                    $imageavatr = rand(0,10000)."_".$fname;
                    $path  ="C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\upload\\";
                    move_uploaded_file($ftemp,$path.$imageavatr);
                    
                    $stmt2 = $con->prepare("INSERT INTO 
                    doctors (`name`,university,qualifications,age,categor,nameofhost,`image`,rating)
                    VALUES (:n,:u,:q,:a,:c,:h,:i,:r)");

                    $stmt2->execute(array(
                        'n' => $name,
                        'u' => $uni,
                        'q' => $qul,
                        'a' => $age,
                        'c' => $categor,
                        'h' => $namehost,
                        'i' => $imageavatr,
                        'r' => $rat
                    ));
                    if($stmt2)
                    {
                        $meg = "<div class='alert alert-success'>DR/ $name is Added</div>";
                    }
                }
            }
        }
        ?>
            <div class="container">
                <h1 class="text-center headoc"><i class="fas fa-user-md"></i> add Doctors</h1>
                <div class="formdoc">
                    <form action="docto.php?do=add" method="POST" enctype="multipart/form-data">
                    <div>
                        <input class="form-control" type="text" name="doc" placeholder="type doctor name">
                    </div>
                    <div>
                        <input class="form-control" type="text" name="uni" placeholder="type university">
                    </div>
                    <div>
                        <input class="form-control" type="text" name="namehost" placeholder="type name of hospital">
                    </div>
                    <div>
                        <select name="qualifications" class="form-control">
                            <option value="0">select qualifications</option>
                            <option value="1">M.A.</option>
                            <option value="2">M.A.&PhD</option>
                        </select>
                    </div>
                    <div>
                        <select name="age" class="form-control">
                            <option value="0">select Age</option>
                            <?php
                            for($i=25;$i<=80;$i++)
                            {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> Years</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select name="categor" class="form-control">
                            <option value="nothing">select categor</option>
                            <option value="heart">heart</option>
                            <option value="brain">brain</option>
                            <option value="lung">lung</option>
                            <option value="knee">knee</option>
                        </select>
                    </div>
                    <div>
                        <select name="rating" class="form-control">
                            <option value="0">select rating</option>
                            <option value="1">one</option>
                            <option value="2">two</option>
                            <option value="3">three</option>
                            <option value="4">four</option>
                        </select>
                    </div>
                    <div class="fileimage">
                        <input type="file" class="form-control docimage" name="image">
                        <span> <i class="fa fa-upload"></i> upload image</span>
                    </div>
                    <div>
                        <input type="submit" value="Add" class="btn btn-success log">
                    </div>
                    <?php
                    if(!empty($formerr))
                    {
                        foreach($formerr as $err)
                        {
                            ?>
                                <div class="alert alert-danger err"><?php echo $err; ?></div>
                            <?php
                        }
                    } 
                    if(isset($meg))
                    {
                        echo $meg;
                    }
                    ?>
                    </form>
                </div>
            </div>
        <?php
    }
    elseif($do == "allinfo")
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]))
        {
            $docid = $_GET["id"];

            $stmt = $con->prepare("SELECT * FROM doctors WHERE ID = ?");
            $stmt->execute(array($docid));
            $infodoc = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {
                $path = "..//admincp//upload//";
                ?>
                <div class="container">
                    <h1 class="text-center headinfodoc"> <i class="fa fa-user-md"></i> Dr\ <?php echo ucwords($infodoc["name"]); ?></h1>
                    <table class="main-table table table-bordered">
                        <tr>
                            <td>ID</td>
                            <td>Image</td>
                            <td>university</td>
                            <td>qualifications</td>
                            <td>name of hospital</td>
                            <td>age</td>
                        </tr>
                        <tr>
                            <td><?php echo $infodoc["ID"] ;?></td>
                            <td>
                          <?php
                          if ($infodoc["image"]==0)
                          {
                              echo "No image";
                          }
                          else
                          {
                          ?>
                          <div class="timagedoc">
                            <?php
                            if($infodoc["rating"] == 4)
                            {
                                ?>
                                <img src="<?php echo $path.$infodoc['image']; ?>" alt="">
                                <span>the best</span>
                                <?php
                            } 
                            else
                            {
                                ?>
                                 <img src="<?php echo $path.$infodoc['image']; ?>" alt="">
                                <?php
                            }
                           ?>
                          </div>
                          <?php
                          }
                          ?>
                      </td>
                      <td><?php echo $infodoc["university"]; ?></td>
                      <td>
                          <?php
                          if($infodoc["qualifications"] == 1){echo "M.A.";}else{ echo "M.A. & PhD";} 
                          ?>
                      </td>
                      <td><?php echo $infodoc["nameofhost"] ?></td>
                      <td><?php echo $infodoc["age"]; ?></td>
                        </tr>
                    </table>
                </div>
                <?php 
            }
            else 
            {
                $themeg =  "<div class='alert alert-danger'>this is no such ID</div>";
                redirect($themeg);
            }
        }
        else 
        {
            $themeg =  "<div class='alert alert-danger'>this is no such ID</div>";
            redirect($themeg);
        }
        
        
    }
    elseif($do == "edit")
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]))
        {
            $docid = $_GET["id"];
            $stmt = $con->prepare("SELECT * FROM doctors WHERE ID = ?");
            $stmt->execute(array($docid));
            $docinfo = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {
               
                    ?>
             <div class="container">
                <h1 class="text-center headinfodoc"><i class="fas fa-user-md"></i> Edit Dr\ <?php echo $docinfo["name"]; ?></h1>
                <div class="formdoc">
                    <form action="docto.php?do=insert&id=<?php echo $docinfo["ID"];?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $docinfo["ID"] ?>" name="iddoc">
                    <input type="hidden" value="<?php echo $docinfo["image"];?>" name="oldimage"> 
                    <div>
                        <input class="form-control" type="text" name="doc" placeholder="type doctor name" value="<?php echo $docinfo["name"]; ?>">
                    </div>
                    <div>
                        <input class="form-control" type="text" name="uni" placeholder="type university" value="<?php echo $docinfo["university"] ?>">
                    </div>
                    <div>
                        <input class="form-control" type="text" name="namehost" placeholder="type name of hospital" value="<?php echo $docinfo["nameofhost"] ?>">
                    </div>
                    <div>
                        <select name="qualifications" class="form-control" >
                            <option value="0">select qualifications</option>
                            <option value="1" <?php if($docinfo["qualifications"] == 1) {echo "selected" ;} ?>>M.A.</option>
                            <option value="2" <?php if($docinfo["qualifications"] == 2) {echo "selected" ;} ?> >M.A.&PhD</option>
                        </select>
                    </div>
                    <div>
                        <select name="age" class="form-control">
                            <option value="0">select Age</option>
                            <?php
                            for($i=25;$i<=80;$i++)
                            {
                                ?>
                                <option value="<?php echo $i; ?>" <?php if($docinfo["age"] == $i){echo "selected";} ?>><?php echo $i; ?> Years</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select name="categor" class="form-control">
                            <option value="nothing">select categor</option>
                            <option value="heart" <?php if($docinfo["categor"] == "heart"){echo "selected" ;} ?>>heart</option>
                            <option value="brain" <?php if($docinfo["categor"] == "brain"){echo "selected" ;} ?>>brain</option>
                            <option value="lung" <?php if($docinfo["categor"] == "lung"){echo "selected" ;} ?>>lung</option>
                            <option value="knee" <?php if($docinfo["categor"] == "knee"){echo "selected" ;} ?>>knee</option>
                        </select>
                    </div>
                    <div>
                        <select name="rating" class="form-control">
                            <option value="0">select rating</option>
                            <option value="1"  <?php if($docinfo["rating"] == 1) {echo "selected" ;} ?>>one</option>
                            <option value="2"  <?php if($docinfo["rating"] == 2) {echo "selected" ;} ?>>two</option>
                            <option value="3"  <?php if($docinfo["rating"] == 3) {echo "selected" ;} ?>>three</option>
                            <option value="4"  <?php if($docinfo["rating"] == 4) {echo "selected" ;} ?>>four</option>
                        </select>
                    </div>
                    <div class="fileimage">
                        <input type="file" class="form-control docimage" name="image">
                        <span> <i class="fa fa-upload"></i> upload image</span>
                    </div>
                    <div>
                        <input type="submit" value="save" class="btn btn-success log">
                    </div>
                    <?php 
            }
            else 
            {
                $themeg =  "<div class='alert alert-danger'>this is no such ID</div>";
                redirect($themeg,null , 3 ,null);
            }
        }
        else
        {
            header("location:login.php");
        }
    }
    elseif($do == "insert")
    {
        if($_SERVER["REQUEST_METHOD"] == 'POST'){

            if(isset($_GET["id"]) && is_numeric($_GET["id"]))
            {
                $docid    = $_POST["iddoc"];
                $oldimage = $_POST["oldimage"];

                $stmt =$con->prepare("SELECT * FROM doctors WHERE ID =?");
                $stmt->execute(array($docid));
                $allinfo = $stmt->rowCount();
                if($allinfo > 0)
                {
                        
                    $formerr = array();

                    $fname = $_FILES["image"]["name"];
                    $ftype = $_FILES["image"]["type"];
                    $ftemp = $_FILES["image"]["tmp_name"];
                    $fsize = $_FILES["image"]["size"];
                    
                    $allowextion = array("png","jpg","jepg","gif");
                    $extion      = explode(".",$fname);
                    $extion      = end($extion);
                    $extion      = strtolower($extion);
        
                    $name     = filter_var($_POST["doc"],FILTER_SANITIZE_STRING);
                    $uni      = filter_var($_POST["uni"],FILTER_SANITIZE_STRING);
                    $namehost = filter_var($_POST["namehost"],FILTER_SANITIZE_STRING);
                    $qul      = $_POST["qualifications"];
                    $age      = $_POST["age"];
                    $categor  = $_POST["categor"];
                    $rat      = $_POST["rating"];
        
                    if(empty($name))
                    {
                        $formerr[] = "name can't be <b>Empty</b>";
                    }
                    if(!empty($name))
                    {
                        if(strlen($name) < 4)
                        {
                            $formerr[] = "name must be more than <b>4 char</b>";
                        }
                        if(strlen($name) > 20)
                        {
                            $formerr[] = "name must be less than <b>20 char</b>";
                        }
                    }
                    if(empty($uni))
                    {
                        $formerr[] = "university can't be <b>Empty</b>";
                    }
                    if($qul == 0)
                    {
                        $formerr[] = "qualifications can't be <b>Empty</b>";
                    }
                    if($age == 0)
                    {
                        $formerr[] = "Age can't be <b>Empty</b>";
                    }
                    if($categor == "nothing")
                    {
                        $formerr[] = "categor can't be <b>Empty</b>";
                    }
                    if($rat == 0)
                    {
                        $formerr[] = "Rating can't be <b>Empty</b>";
                    }
                    if(!empty($fname))
                    {
                        if(!in_array($extion,$allowextion))
                        {
                            $formerr[] = "this file <b>not allowed<b>";
                        }
                        if($fsize == 4202500)
                        {
                            $formerr[] = "Image must be less than <b>4MB<b>";
                        }
                    }
        
                    if(empty($formerr))
                    {
                        $stmt = $con->prepare("SELECT `name` FROM doctors WHERE `name` = ? AND ID != ?");
                        $stmt->execute(array($name , $docid));
                        $count = $stmt->rowCount();
                        if($count > 0)
                        {
                            $formerr[] = "This name is Exist";
                        }
                        else
                        {
                            if(!empty($fname)){
                            $imageavatr = rand(0,10000)."_".$fname;
                            $path  ="C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\upload\\";
                            move_uploaded_file($ftemp,$path.$imageavatr);
                            }
                            if(empty($fname))
                            {
                                $path  ="C:\\xampp\\htdocs\\php_mah\\doctors\\admincp\\upload\\";
                                move_uploaded_file($ftemp,$path.$oldimage);
                            }
                            if(!empty($fname)){
                            $stmt2 = $con->prepare("UPDATE doctors SET `name` = :n , university = :u , qualifications = :q , age = :a , categor = :c  , nameofhost = :h , `image` = :i , rating= :r  WHERE ID = :id ");
                            $stmt2->execute(array(
                                'n' => $name,
                                'u' => $uni,
                                'q' => $qul,
                                'a' => $age,
                                'c' => $categor,
                                'h' => $namehost,
                                'i' => $imageavatr,
                                'r' => $rat,
                                'id'=> $docid
                            )); 
                            if($stmt2)
                            {
                                echo "<div class='container'>";
                                $meg = "<div class='alert alert-success'>This Form is Edited</div>";
                                redirect($meg,'back' , 2 ,'back');
                                echo "</div>";
                            }
                          }
                          if(empty($fname)){
                            $stmt2 = $con->prepare("UPDATE doctors SET `name` = :n , university = :u , qualifications = :q , age = :a , categor = :c  , nameofhost = :h , `image` = :i , rating= :r  WHERE ID = :id ");
                            $stmt2->execute(array(
                                'n' => $name,
                                'u' => $uni,
                                'q' => $qul,
                                'a' => $age,
                                'c' => $categor,
                                'h' => $namehost,
                                'i' => $oldimage,
                                'r' => $rat,
                                'id'=> $docid
                            )); 
                            if($stmt2)
                            {
                                echo "<div class='container'>";
                                $meg = "<div class='alert alert-success'>This Form is Edited</div>";
                                redirect($meg,'back' , 2 ,'back');
                                echo "</div>";
                            }
                          }
                        }
                    }
                
                }
                else
                {
                    $themeg =  "<div class='alert alert-danger'>this is no such ID</div>";
                    redirect($themeg,null , 3 ,null);
                }
            }
            else
            {
                header("location:login.php");
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
            $iddoc = $_GET["id"];
            $stmt =$con->prepare("SELECT * FROM doctors WHERE ID = ?");
            $stmt->execute(array($iddoc));
            $count = $stmt->rowCount();
            if($count > 0)
            {
                $stmt = $con->prepare("DELETE FROM doctors WHERE ID = ?");
                $stmt->execute(array($iddoc));
                $count2 = $stmt->rowCount();
                if($count2 > 0)
                {
                    echo "<div class='container'>";
                    $meg = "<div class='alert alert-success'>This doctors IS Deleted</div>";
                    redirect($meg,'doc', 3 ,'doc');
                    echo "</div>";
                }
            }
            else
            {
                $themeg =  "<div class='alert alert-danger'>this is no such ID</div>";
                redirect($themeg,null , 3 ,null);
            }
        }
        else
        {
            header("location:login.php");
        }
    }


    include $footer;
} else {
    header("location:login.php");
}
