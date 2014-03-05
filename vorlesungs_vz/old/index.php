<?php
if (!isset($_SESSION["role"])) $_SESSION["role"] =  $_GET['r'];
echo " ".base64_encode( $_[ 'r'  ]);
echo " ".base64_decode( $_GET[ 'r'  ]);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Belegliste -- Admin Tool</title>
</head>

<frameset rows="40,*" frameborder="no" border="0" framespacing="0">
  <frame src="navi.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frame src="belegliste.php" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>
