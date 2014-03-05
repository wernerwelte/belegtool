<?php session_start();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Unbenanntes Dokument</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body><?php 

if (isset($_SESSION["r"])) 
{

require_once("../../inc/ini/phpMyEdit.ini.php");

$opts['tb'] = 'mdl_haw_studiengaenge';

$opts['fdd']['ID'] = array(
  'name'     => 'ID',
  'select'   => 'T',
  'options'  => 'AVCPDR', // auto increment
  'maxlen'   => 50,
  'default'  => '0',
  'sort'     => true
);

$opts['fdd']['studiengang'] = array(
  'name'     => 'Studiengang',
  'select'   => 'T',
  'maxlen'   => 50,
  'sort'     => true
);

$opts['fdd']['abk'] = array(
  'name'     => 'Abk',
  'select'   => 'T',
  'maxlen'   => 10,
  'sort'     => true
);

$opts['fdd']['abk2'] = array(
  'name'     => 'Abk2',
  'select'   => 'T',
  'maxlen'   => 10,
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
