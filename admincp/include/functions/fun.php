<?php 

/***
 * get title
 */
function gettilte()
{
    global $titlepage;

    if (isset($titlepage))
    {
        echo $titlepage ;
    }
    else
    {
      echo "defalut";
    }
}

function redirect ($themeg , $url=null , $sec = 3 , $name = null)
{
    if($url === null)
    {
        $url = "login.php";
    }
    elseif($url === 'pro' )
    {
        $url = "profile.php";
    }
    else  
    {
        if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "") {
            $url = $_SERVER["HTTP_REFERER"];
        }
    }


    if($name === null)
    {
        $name = "login page";
    }
    elseif ($name == 'back')
    {
        $name = "backpage";
    }
    elseif($name == "pro")
    { 
         $name = "profile page";
    }

    echo $themeg ;
    echo "<div class='alert alert-info'>you will redirect in $name after $sec sec</div>";
    header("refresh:$sec;$url:$url");
    exit();
}