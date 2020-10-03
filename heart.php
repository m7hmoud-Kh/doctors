<?php 

$titlepage = "Heart";
include "init.php";

$stmt = $con->prepare("SELECT * FROM doctors WHERE categor = ? ORDER BY rating DESC ");
$stmt->execute(array("heart"));
$info = $stmt->fetchAll();
?>
<div class="hearts">
    <div class="container">
      <h1 class="text-center">Heart Problem</h1>
      <div class="row">
       <?php
       foreach($info as $doc)
       {
        $path = '..//doctors//admincp//upload//';
           ?>
           <div class="doccard">
               <div class="docimg">
                   <img src="<?php echo $path.$doc["image"]; ?>" alt="">
               </div>
               <div class="doccaption">
                   <h4>Name: <span> <?php echo $doc["name"]; ?> </span></h4>
                   <h5>graduated from: <span> <?php echo $doc["university"];?> </span></h5>
                   <h5>Age: <span> <?php echo $doc["age"];?></span></h5>
                   <h5>qualifications: <span> <?php if($doc["qualifications"] == 1){ echo "M.A." ;} elseif($doc["qualifications"] == 2){echo " M.A. AND PhD  ";}?> </span></h5>
                   <h5>Rating: <span><?php if($doc["rating"] == 1){echo '<i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 2){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 3){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;} elseif($doc["rating"] == 4){echo '<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>' ;}  ?></span></h5>
                   <a class="alert alert-info book" href="patient.php?docid=<?php echo $doc["ID"]; ?>">Book now</a>
               </div>
           </div>
           <?php
       }
       ?>
       </div>
    </div>
</div>

<?php
include $footer ;