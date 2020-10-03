<?php 
session_start();
$titlepage = "sick people";
include "init.php";
include $men ;
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

    if($do == "mange")
    {
        $stmt = $con->prepare("SELECT COUNT(ID) FROM sick WHERE categor = ?");
        $stmt->execute(array("heart"));
        $countheart = $stmt->fetchcolumn();

        $stmt = $con->prepare("SELECT COUNT(ID) FROM sick WHERE categor = ?");
        $stmt->execute(array("brain"));
        $countbrain = $stmt->fetchcolumn();

        $stmt = $con->prepare("SELECT COUNT(ID) FROM sick WHERE categor = ?");
        $stmt->execute(array("knee"));
        $countknee = $stmt->fetchcolumn();

        $stmt = $con->prepare("SELECT COUNT(ID) FROM sick WHERE categor = ?");
        $stmt->execute(array("lung"));
        $countlung = $stmt->fetchcolumn();
        
      ?>
        <div class="container">
            <h1 class="text-center headoc"> <i class="fas fa-user-injured"></i> sick pepole</h1>
            <div class="row">
            <div class="cat">
                <div class="ser1image">
                    <img src="../include/template/layout/img/service1.png" alt="">
                </div>
               <a href="sick.php?do=heart"> <p>heart</p> </a>
               <a href="sick.php?do=heart"> <span><?php echo $countheart; ?></span> </a>
            </div>
            <div class="cat">
                <div class="ser2image">
                    <img src="../include/template/layout/img/service2.png" alt="">
                </div>
               <a href="sick.php?do=brain"> <p>brain</p> </a>
                <a href="sick.php?do=brain"> <span><?php echo $countbrain; ?></span></a> 
            </div>
            <div class="cat">
                <div class="ser3image">
                    <img src="../include/template/layout/img/service3.png" alt="">
                </div>
               <a href="sick.php?do=knee"> <p>knee</p> </a>
              <a href="sick.php?do=knee">  <span><?php echo $countknee; ?></span> </a>
            </div>
            <div class="cat">
                <div class="ser4image">
                    <img src="../include/template/layout/img/service4.png" alt="">
                </div>
                <a href="sick.php?do=lung"><p>The lung</p></a>
                <a href="sick.php?do=lung"><span><?php echo $countlung; ?></span></a>
            </div>
            </div>
        </div>
      <?php
    }
    elseif($do == "heart")
    {
        $stmt = $con->prepare("SELECT sick.* , doctors.name
                            FROM sick 
                            INNER JOIN doctors ON doctors.ID = sick.doc_id 
                            WHERE sick.categor = ? ");
        $stmt->execute(array("heart"));
        $allsick = $stmt->fetchAll();
        ?>
        <div class="container">
        <h1 class="text-center headoc"> heart</h1>
            <div class="row">
                <table class="main-table table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>name</td>
                    <td>gender</td>
                    <td>message</td>
                    <td>date</td>
                    <td>doctor</td>
                    <td>controls</td>
                </tr>
                 <?php
                 foreach($allsick as $sick)
                 {
                     ?>
                     <tr>
                    <td><?php echo $sick["ID"]; ?></td>
                    <td><?php echo $sick["namesick"]; ?></td>
                    <td>
                        <?php if($sick["gender"] == 1){echo "male";} ?>
                        <?php if($sick["gender"] == 2){echo "female";} ?>
                    </td>
                    <td> <?php echo $sick["message"]; ?></td>
                    <td><?php echo $sick["date"]; ?></td>
                    <td><?php echo $sick["name"]; ?></td>
                    <td>
                        <a href="sick.php?do=allinfo&id=<?php echo $sick["ID"]; ?>" 
                        class="btn btn-success"><i class="fas fa-eye"> All </i></a>
                        <a href="sick.php?do=dele&id=<?php echo $sick["ID"]; ?>" 
                        class="btn btn-danger sick"><i class="fas fa-times"> Delete </i></a>
                    </td>
                    </tr>
                     <?php
                 }
                 ?>
                </table>
            </div>
        </div>
        <?php
    }
    elseif($do == "allinfo")
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]))
        {
            $sickid  = $_GET["id"];
            $stmt = $con->prepare("SELECT * FROM sick WHERE ID = ?");
            $stmt->execute(array($sickid));
            $allsick = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0)
            {
                ?>
                <div class="container">
                <h1 class="text-center headoc"><?php echo $allsick["namesick"]; ?></h1>
                    <div class="row">
                        <table class="main-table table table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>email</td>
                                <td>phone</td>
                                <td>age</td>
                                <?php 
                                if($allsick["categor"] == 'heart')
                                {
                                ?>
                                <td>disease</td>
                                <td>Heartbeat</td>
                                <?php
                                }
                                if($allsick["categor"] == "brain")
                                {
                                    ?>
                                    <td>problemsleep</td>
                                    <?php 
                                }
                                if($allsick["categor"] == 'knee')
                                {
                                    ?>
                                    <td>break</td>
                                    <?php 
                                }
                                if($allsick["categor"] == 'lung')
                                {
                                    ?>
                                    <td>smoking</td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td><?php echo $allsick["ID"]; ?></td>
                                <td><?php echo $allsick["email"]; ?></td>
                                <td><?php echo $allsick["phone"]; ?></td>
                                <td><?php echo $allsick["age"]; ?></td>
                                <?php 
                                if($allsick["categor"] == 'heart'){
                                    ?>
                                <td>
                                    <?php if($allsick["disease"] == 1){echo "Yes";} ?>
                                    <?php if($allsick["disease"] == 2){echo "No";} ?>
                                </td>
                                <td>
                                    <?php if($allsick["Heartbeat"] == 1){echo "Fast";} ?>
                                    <?php if($allsick["Heartbeat"] == 2){echo "Slow";} ?>
                                </td>
                                <?php
                                }
                                if($allsick["categor"] == 'brain')
                                {
                                    ?>
                                    <td>
                                    <?php if($allsick["problemsleep"] == 1){echo "Yes";} ?>
                                    <?php if($allsick["problemsleep"] == 2){echo "No";} ?>
                                    </td>
                                    <?php
                                }
                                if($allsick["categor"] == 'knee')
                                {
                                    ?>
                                    <td>
                                    <?php if($allsick["break"] == 1){echo "Yes";} ?>
                                    <?php if($allsick["break"] == 2){echo "No";} ?>
                                    </td>
                                    <?php
                                }
                                if($allsick["categor"] == 'lung')
                                {
                                    ?>
                                    <td>
                                    <?php if($allsick["smoking"] == 1){echo "Yes";} ?>
                                    <?php if($allsick["smoking"] == 2){echo "No";} ?>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php 
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
    elseif($do == "dele")
    {
        if(isset($_GET["id"]) && is_numeric($_GET["id"]))
        {
            $sickid  = $_GET["id"];
            $stmt = $con->prepare("SELECT * FROM sick WHERE ID = ?");
            $stmt->execute(array($sickid));
            $count = $stmt->rowCount();
            if($count > 0)
            {
                $stmt = $con->prepare("DELETE FROM sick WHERE ID = ?");
                $stmt->execute(array($sickid));
                $dele = $stmt->rowCount();
                if($dele > 0)
                {
                    echo "<div class='container'>";
                    $meg = '<div class="alert alert-success">this sick is deleted</div>';
                    redirect($meg,'back',3,'back');
                    echo "</div>";
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
    elseif($do == "brain")
    {
                $stmt = $con->prepare("SELECT sick.* , doctors.name
                FROM sick 
                INNER JOIN doctors ON doctors.ID = sick.doc_id 
                WHERE sick.categor = ? ");
        $stmt->execute(array("brain"));
        $allsick = $stmt->fetchAll();
        ?>
        <div class="container">
        <h1 class="text-center headoc"> brain</h1>
        <div class="row">
        <table class="main-table table table-bordered">
        <tr>
        <td>ID</td>
        <td>name</td>
        <td>gender</td>
        <td>message</td>
        <td>date</td>
        <td>doctor</td>
        <td>controls</td>
        </tr>
        <?php
        foreach($allsick as $sick)
        {
            ?>
            <tr>
            <td><?php echo $sick["ID"]; ?></td>
            <td><?php echo $sick["namesick"]; ?></td>
            <td>
                <?php if($sick["gender"] == 1){echo "male";} ?>
                <?php if($sick["gender"] == 2){echo "female";} ?>
            </td>
            <td> <?php echo $sick["message"]; ?></td>
            <td><?php echo $sick["date"]; ?></td>
            <td><?php echo $sick["name"]; ?></td>
            <td>
                <a href="sick.php?do=allinfo&id=<?php echo $sick["ID"]; ?>" 
                class="btn btn-success"><i class="fas fa-eye"> All </i></a>
                <a href="sick.php?do=dele&id=<?php echo $sick["ID"]; ?>" 
                class="btn btn-danger sick"><i class="fas fa-times"> Delete </i></a>
            </td>
            </tr>
            <?php
         }
      ?>
    </table>
    </div>
    </div>
    <?php
    }
    elseif($do == 'knee')
    {
                $stmt = $con->prepare("SELECT sick.* , doctors.name
                FROM sick 
                INNER JOIN doctors ON doctors.ID = sick.doc_id 
                WHERE sick.categor = ? ");
        $stmt->execute(array("knee"));
        $allsick = $stmt->fetchAll();
        ?>
        <div class="container">
        <h1 class="text-center headoc"> knee</h1>
        <div class="row">
        <table class="main-table table table-bordered">
        <tr>
        <td>ID</td>
        <td>name</td>
        <td>gender</td>
        <td>message</td>
        <td>date</td>
        <td>doctor</td>
        <td>controls</td>
        </tr>
        <?php
        foreach($allsick as $sick)
        {
            ?>
            <tr>
            <td><?php echo $sick["ID"]; ?></td>
            <td><?php echo $sick["namesick"]; ?></td>
            <td>
                <?php if($sick["gender"] == 1){echo "male";} ?>
                <?php if($sick["gender"] == 2){echo "female";} ?>
            </td>
            <td> <?php echo $sick["message"]; ?></td>
            <td><?php echo $sick["date"]; ?></td>
            <td><?php echo $sick["name"]; ?></td>
            <td>
                <a href="sick.php?do=allinfo&id=<?php echo $sick["ID"]; ?>" 
                class="btn btn-success"><i class="fas fa-eye"> All </i></a>
                <a href="sick.php?do=dele&id=<?php echo $sick["ID"]; ?>" 
                class="btn btn-danger sick"><i class="fas fa-times"> Delete </i></a>
            </td>
            </tr>
            <?php
        }
        ?>
        </table>
        </div>
        </div>
        <?php
    }
    elseif($do == "lung")
    {
                    $stmt = $con->prepare("SELECT sick.* , doctors.name
                    FROM sick 
                    INNER JOIN doctors ON doctors.ID = sick.doc_id 
                    WHERE sick.categor = ? ");
            $stmt->execute(array("lung"));
            $allsick = $stmt->fetchAll();
            ?>
            <div class="container">
            <h1 class="text-center headoc"> lung</h1>
            <div class="row">
            <table class="main-table table table-bordered">
            <tr>
            <td>ID</td>
            <td>name</td>
            <td>gender</td>
            <td>message</td>
            <td>date</td>
            <td>doctor</td>
            <td>controls</td>
            </tr>
            <?php
            foreach($allsick as $sick)
            {
                ?>
                <tr>
                <td><?php echo $sick["ID"]; ?></td>
                <td><?php echo $sick["namesick"]; ?></td>
                <td>
                    <?php if($sick["gender"] == 1){echo "male";} ?>
                    <?php if($sick["gender"] == 2){echo "female";} ?>
                </td>
                <td> <?php echo $sick["message"]; ?></td>
                <td><?php echo $sick["date"]; ?></td>
                <td><?php echo $sick["name"]; ?></td>
                <td>
                    <a href="sick.php?do=allinfo&id=<?php echo $sick["ID"]; ?>" 
                    class="btn btn-success"><i class="fas fa-eye"> All </i></a>
                    <a href="sick.php?do=dele&id=<?php echo $sick["ID"]; ?>" 
                    class="btn btn-danger sick"><i class="fas fa-times"> Delete </i></a>
                </td>
                </tr>
                <?php
            }
            ?>
            </table>
            </div>
            </div>
            <?php
    }

include $footer;
}
else
{
    header("location:login.php");
}