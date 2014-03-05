<?php 

$LOCAL = false;

if(!$LOCAL)
{   $host1 = explode('/', $_SERVER['HTTP_REFERER']);
    if 
    (
        $host1[2] == "www.emil-archiv.haw-hamburg.de" 
    ||  $host1[2] =="www.elearning.haw-hamburg.de"
    ||  $host1[2] =="lernserver.el.haw-hamburg.de"
    ||  $host1[2] =="localhost"
    )
    {
        //print_r($_GET);
        if (!isset($_SESSION["r"]))  {  if ( isset($_GET['r']))  $_SESSION["r"] =  $_GET['r'];}
        if (!isset($_SESSION["s"]))  {  if ( isset($_GET['s']))  $_SESSION["s"] =  $_GET['s'];}
        if (!isset($_SESSION["t"]))  {  if ( isset($_GET['t']))  $_SESSION["t"] =  $_GET['t'];}
    }
    else 
    {
        //die($host1[2]);
        die('<h1>ACCESS DENIED</h1>');
    }
}
else
{
    $_SESSION["r"] = 5 ;
}

?>