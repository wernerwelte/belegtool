<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="lib/lib.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="lib/style.css" />
<title>Vorlesungs VZ</title>
</head>
<body>
<h1>BELEGUNG</h1>

<?php
require_once("../inc/vz.db.class.php");
require_once("../inc/vz.data.class.php");
require_once("../inc/vz.render.class.php");

$data 	= new Data;
$render = new Render;
$DB 	= new DB;
 

$belegung = $DB->getBelegung();

/*
$html .= "<br>";
$html .= $data->exportBelegung($belegung);
$html .= "<br>";
$html .= "<br>";*/
$html .= $render->printBelegung($belegung);

echo $html;
?>
</body>
</html> 