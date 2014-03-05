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
<h1>Vorlesungs VZ</h1>
<?php
$action 			= $_GET[ 'a' ]; /* ----------  Datenbank update ---------- */

require_once( "../inc/vz.db.class.php" );
require_once( "../inc/vz.data.class.php" );
require_once( "../inc/vz.render.class.php" );

$data 				= new Data;
$render 			= new Render;
$DB 				= new DB;

if ( $action )
{
	$DB->setDB( $action );
}

$lists 				= $DB->getAllLists(); 						// -- Assoc Array mit allen Professoren, Studiengänen, Veranstaltungen
$vl_verzeichnis 	= $DB->getVorlesungsVerzeichnis( $action ); // -- Struktur und Werte der DB ausgeben ----------*/

$html .= "\n\r<form name='vlvz' action='#'>";
 
$html .= $render->printVorlesungsverzeichnisAuswahl($vl_verzeichnis, $lists );

echo $html; // -- Auswahlmatrix mit dem gesamten Vorlesungsverzeichnis ausgeben
?>

<form  name="param" action="#">
<input name="a" 	type="hidden" value="update" >
<input name="col" 	type="hidden" >
<input name="val" 	type="hidden" >
<input name="id" 	type="hidden" >
<input name="sum" 	type="hidden" >
</form>
</body>
</html>
 