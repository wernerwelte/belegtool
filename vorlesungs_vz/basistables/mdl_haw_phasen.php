<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Phasen</title>

<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php

if (isset($_SESSION["r"])) 
{

require_once("../../inc/ini/phpMyEdit.ini.php");

$opts['tb'] = 'mdl_haw_phasen';


$opts['fdd']['ID'] = array(
  'name'     => 'ID',
  'select'   => 'T',
  'options'  => 'AVCPDR', // auto increment
  'maxlen'   => 3,
  'default'  => '0',
  'sort'     => true
);

$opts['fdd']['phase'] = array(
  'name'     => 'phase',
  'select'   => 'T',
  'maxlen'   => 3,
  'sort'     => true
  );

$opts['fdd']['timestamp'] = array(
  'name'     => 'timestamp',
  'select'   => 'T',
  'maxlen'   => 11,
  'sort'     => true
);

$opts['fdd']['desc'] = array(
  'name'     => 'desc',
  'select'   => 'T',
  'maxlen'   => 150,
  'sort'     => true
  );


// Now important call to phpMyEdit
require_once 'phpMyEdit.class.php';
new phpMyEdit($opts);
}

else
{
	die("ERROR");
}


?>

</body>
</html>
