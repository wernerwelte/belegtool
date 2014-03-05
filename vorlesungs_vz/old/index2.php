<?php
session_start();
$host1 = explode('/', $_SERVER[HTTP_REFERER]);
if ($host1[2] == "www.elearning.ls.haw-hamburg.de" ||  $host1[2] =="lernserver.ls.haw-hamburg.de")
{

	if (!isset($_SESSION["r"]))  $_SESSION["r"] =  $_GET['r'];
	if (!isset($_SESSION["s"]))  $_SESSION["s"] =  $_GET['s'];
	if (!isset($_SESSION["t"]))  $_SESSION["t"] =  $_GET['t'];
	 $_SESSION["r"] =  $_GET['r'];
}
else 
{
	die("WRONG REF ".$host1[2]);
}
/*

if ($_GET['ds'])
{
echo "DS ".$_GET['ds']
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) 
	{
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
}
*/
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Belegliste -- Admin Tool</title>
</head>

<?php 
if ($_SESSION["r"] >=3 ) 

echo "<frameset rows=\"40,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">
  <frame src=\"navi.php?' . SID . '\" name=\"topFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"topFrame\" title=\"topFrame\" />
  <frame src=\"belegliste.php?' . SID . '\" name=\"mainFrame\" id=\"mainFrame\" title=\"mainFrame\" />
</frameset>
<noframes  ><body>
</body>
</noframes></html>";
?>
