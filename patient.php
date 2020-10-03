<?php 

$titlepage = "Book Now";
include "init.php";
if(isset($_GET["docid"]) && is_numeric($_GET["docid"]))
{
    $docid = $_GET["docid"];
    $stmt = $con->prepare("SELECT * FROM doctors WHERE ID = ? ");
    $stmt->execute(array($docid));
    $docinfo = $stmt->fetch();
    $count = $stmt->rowCount();
   /** COUNT number of sick people in doctors in all categor */
    $stmt2 = $con->prepare("SELECT COUNT(sick.ID) FROM sick WHERE SICK.doc_id = ?  AND sick.categor = ?");
    $stmt2->execute(array($docinfo["ID"],$docinfo["categor"]));
    $numsick = $stmt2->fetchcolumn();
    if($count > 0)
    {
        if($_SERVER["REQUEST_METHOD"] == 'POST')
        {
            $formerr = array(); 

            $name   = filter_var($_POST["sick"],FILTER_SANITIZE_STRING);
            $email  = filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
            $phone  = filter_var($_POST["phone"],FILTER_SANITIZE_NUMBER_INT);
            $gen    = $_POST["gender"];
            $meg    = $_POST["meg"];
            $age    = $_POST["age"];
            if($docinfo["categor"] == "heart"){
            $dis    = $_POST["disea"];
            $heart  = $_POST["heartbeat"];
            }
            if($docinfo["categor"] == "brain"){
             $sleep  = $_POST["sleep"];
            }
            if($docinfo["categor"] == "lung")
            {
                $smok = $_POST["smoking"];
            }
            if($docinfo["categor"] == "knee")
            {
                $kser = $_POST["break"];
            }

            if(empty($name))
            {
                $formerr[]= "username can't be <b>empty<b>"; 
            }
            if(!empty($name))
            {
                if(strlen($name) < 3)
                {
                    $formerr[]= "username must be more than <b>3 char<b>"; 
                }
                if(strlen($name) > 20)
                {
                    $formerr[]= "username must be more than <b>20 char<b>"; 
                }
            }
            if(empty($email))
            {
                $formerr[]= "Email can't be <b>empty<b>"; 
            }
            if(empty($phone))
            {
                $formerr[]= "phone can't be <b>empty<b>"; 
            }
            if(!empty($phone))
            {
                if(strlen($phone) !== 11) 
                {
                    $formerr[] = "your phone in not  <b>completed</b>";
                }
            }
            if($gen == 0)
            {
                $formerr[]= "gender can't be <b>empty<b>"; 
            }
            if($age == 0)
            {
                $formerr[]= "Age can't be <b>empty<b>"; 
            }
            if($docinfo["categor"] == "heart")
            {
                if($dis == 0)
                {
                    $formerr[]= "gender can't be <b>empty<b>"; 
                }
                if($heart == 0)
                {
                    $formerr[]= "heart can't be <b>empty<b>"; 
                }
            }
            if($docinfo["categor"] == "brain")
            {
                if($sleep == 0)
                {
                    $formerr[]= "peoblem sleeping can't be <b>empty<b>"; 
                }
            }
            if($docinfo["categor"] == "lung")
            {
                if($smok == 0)
                {
                    $formerr[]= "Smoking can't be <b>empty<b>";
                }
            }
            if($docinfo["categor"] == "knee")
            {
               if($kser == 0)
               {
                $formerr[]= "fracture can't be <b>empty<b>";
               }
            }
            if(empty($meg))
            {
                $formerr[]= "message can't be <b>empty<b>"; 
            }
            if(!empty($meg))
            {
                if(strlen($meg) < 10)
                {
                    $formerr[]= "message must be more than <b>10 char<b>"; 
                }
            }
            if(empty($formerr))
            {
                $stmt = $con->prepare("SELECT namesick FROM sick WHERE namesick = ?");
                $stmt->execute(array($name));
                $count = $stmt->rowCount();
                if($count > 0)
                {
                    $formerr[]= "username is exist try anthor name sir"; 
                }
                else
                {
                 if($docinfo["categor"] == "heart"){
                    $stmt = $con->prepare("INSERT INTO sick (namesick,email,phone,`message`,gender,age,disease,Heartbeat,`date`,doc_id,categor ) VALUES (:n , :e , :p , :m , :g, :a , :d , :h ,now() , :do , :c ) ");
                    $stmt->execute(array(
                        'n' => $name,
                        'e' => $email,
                        'p' => $phone,
                        'm' => $meg,
                        'g' => $gen,
                        'a' => $age,
                        'd' => $dis,
                        'h' => $heart, 
                        'do'=> $docinfo["ID"] ,
                        'c' => $docinfo["categor"]      
                    ));
                 }
                 if($docinfo["categor"] == "brain"){
                    $stmt = $con->prepare("INSERT INTO sick (namesick,email,phone,`message`,gender,age, problemsleep ,`date`,doc_id,categor ) VALUES (:n , :e , :p , :m , :g ,:a, :s ,now() , :do , :c ) ");
                    $stmt->execute(array(
                        'n' => $name,
                        'e' => $email,
                        'p' => $phone,
                        'm' => $meg,
                        'g' => $gen,
                        'a' => $age,
                        's' => $sleep,
                        'do'=> $docinfo["ID"],
                        'c' => $docinfo["categor"]     
                    ));
                 }
                 if($docinfo["categor"] == "knee"){
                    $stmt = $con->prepare("INSERT INTO sick (namesick,email,phone,`message`,gender, age ,`break` ,`date`,doc_id,categor ) VALUES (:n , :e , :p , :m , :g , :a ,:b ,now() , :do , :c ) ");
                    $stmt->execute(array(
                        'n' => $name,
                        'e' => $email,
                        'p' => $phone,
                        'm' => $meg,
                        'g' => $gen,
                        'a' => $age,
                        'b' => $kser,
                        'do'=> $docinfo["ID"],
                        'c' => $docinfo["categor"]     
                    ));
                 }
                 if($docinfo["categor"] == "lung"){
                    $stmt = $con->prepare("INSERT INTO sick (namesick,email,phone,`message`,gender, age ,smoking ,`date`,doc_id,categor ) VALUES (:n , :e , :p , :m , :g , :a ,:s ,now() , :do , :c ) ");
                    $stmt->execute(array(
                        'n' => $name,
                        'e' => $email,
                        'p' => $phone,
                        'm' => $meg,
                        'g' => $gen,
                        'a' => $age,
                        's' => $smok,
                        'do'=> $docinfo["ID"],
                        'c' => $docinfo["categor"]     
                    ));
                 }
                    $themeg = "<div class='alert alert-success text-center'>you are login Mr/s $name <br> we are waiting</div>";
                }
            }
        }
        $path = '..//doctors//admincp//upload//';
           ?>
              <div class="container">
                  <div class="row">
                      <div class="heartdoc">
                         <div class="row">
                            <div class="heartimg">
                                <img src="<?php echo $path.$docinfo["image"]; ?>" alt="">
                            </div>
                            <div class="heartinfo">
                                <div class="name">
                                <i class="fas fa-user-md"></i> Name: <span> <?php echo $docinfo["name"]; ?> </span>
                                </div>
                                <div class="univer">
                                <i class="fas fa-university"></i> graduated from: <span> <?php echo $docinfo["university"];?> </span>
                                </div>
                                <div class="cert">
                                <i class="fas fa-notes-medical"></i> qualifications: <span> <?php if($docinfo["qualifications"] == 1){ echo "M.A." ;} elseif($docinfo["qualifications"] == 2){echo " M.A. AND PhD  ";}?> </span> 
                                </div>
                                <div class="hos">
                                <i class="fas fa-hospital-alt"></i> Hospital: <span><?php echo $docinfo["nameofhost"] ?></span>
                                </div>
                                <div class="rat">
                                Rating: <span><?php if($docinfo["rating"] == 1){echo '<i class="fas fa-star"></i>' ;} elseif($docinfo["rating"] == 2){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($docinfo["rating"] == 3){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($docinfo["rating"] == 4){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;}  ?></span>
                                </div>
                                <div>
                                 <SPan>The number of patients: </SPan>  <?php echo $numsick; ?> <i class="true fas fa-check"></i>   
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="formsick">
                         <span class="h2">Book in Doctor <b> <?php echo $docinfo["name"]; ?> </b> </span>
                         <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
                           <div>
                           <i class="fas fa-user-injured form"></i>   
                           <input class="form-control" type="text" name="sick" placeholder="type your name">
                           </div>
                           <div>
                           <i class="fas fa-envelope-open form"></i>
                           <input class="form-control" type="email" name="email" placeholder="type  email">
                           </div>
                           <div>
                           <i class="fas fa-mobile form"></i>
                           <input class="form-control" type="numder" name="phone" placeholder="type your phone">
                           </div>
                           <div>
                           <i class="fas fa-venus-mars form"></i>
                           <select name="gender" class="form-control select">
                               <option value="0">---</option>
                               <option value="1">male</option>
                               <option value="2">female</option>
                           </select>
                           </div>
                           <div>
                           <label for="" style="margin-top: 2%;"><b> Age ?</b></label>
                           <select name="age" class="form-control select">
                               <option value="0">---</option>
                                <?php 
                                   for($i=1;$i<=70;$i++)
                                   {   ?>
                                       <option value="<?php echo $i ;?>"><?php echo $i ;?> Years</option>
                                       <?php
                                   }
                                ?>
                           </select>
                           </div>
                           <?php
                           if($docinfo["categor"] === "heart"){
                           ?> 
                           <div>
                           <label for="" style="margin-top: 2%;"><b> Do you have concurrent diseases? </b></label>
                           <select name="disea" class="form-control select">
                               <option value="0">---</option>
                               <option value="1">YES</option>
                               <option value="2">NO</option>
                           </select>
                           </div>
                           <div>
                           <label for="" style="margin-top: 2%;"><b>Heartbeat ? </b></label>
                           <select name="heartbeat" class="form-control select">
                               <option value="0">---</option>
                               <option value="1">Fast</option>
                               <option value="2">Slow</option>
                           </select>
                           </div>
                           <?php
                           }
                           elseif($docinfo["categor"] === "brain")
                           {
                               ?>
                                <div>
                                <label for="" style="margin-top: 2%;"><b> Do you have problem in sleeing? </b></label>
                                <select name="sleep" class="form-control select">
                                    <option value="0">---</option>
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                </select>
                                </div>
                               <?php 
                           }
                           elseif($docinfo["categor"]=="lung")
                           {
                             ?>
                                <div>
                                <label for="" style="margin-top: 2%;"><b>You Are Smoking ? </b></label>
                                <select name="smoking" class="form-control select">
                                    <option value="0">---</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                                </div>
                               <?php 
                           }
                           elseif($docinfo["categor"] == "knee")
                           {
                               ?>
                                <div>
                                <label for="" style="margin-top: 2%;"><b>Do you have a fracture in your body ? </b></label>
                                <select name="break" class="form-control select">
                                    <option value="0">---</option>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                                </div>
                               <?php
                           }
                           ?>
                           <div>
                            <textarea class="form-control" name="meg" placeholder="What It's Wrong"></textarea>
                           </div>
                           <input type="submit" value="submit" class="form-control login">
                        </form>
                        <?php
                        if(!empty($formerr))
                        {
                            foreach($formerr as $err)
                            {
                               ?>
                                  <div class="laert alert-danger err"><?php echo $err; ?></div>
                               <?php
                            }
                        }
                        if(isset($themeg))
                        {
                            echo $themeg;
                        }
                        ?>
                      </div>
                  </div>
              </div>
           <?php
         
       
    }
    else
    {
        header("location:index.php");
    }
}
include $footer ;
