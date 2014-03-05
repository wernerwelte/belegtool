<?php
class DBIDM
{

var $conn;
 
function DBIDM()
{
  require("ini/db.IDM.ini.php");
	$this->conn  = @mysql_connect( $server, $user, $pass );
	 
	if( $this->conn )
	{   
		if (!mysql_select_db( $dbase, $this->conn )            ) 		echo "<br>ERROR: DB Select<br>";
		if (!mysql_query( "set names 'utf8'" , $this->conn   ) ) 		echo "<br>ERROR: DB UTF8<br>";
	}
	else
	{
																		echo("<b>ERROR:  IDM-DB no connection </b>");
	}
}

function getIDMuser($value, $select = "A")
{   if          ( $select == "M" ) $selector = "matrikelnr";
	else if  	( $select == "A" ) $selector = "akennung";
	
	$IDMuser ="";

	$sql_1 = "SELECT * FROM `mdl_haw_idm` WHERE `$selector` = '$value'";
	
	$result_1 = mysql_query( $sql_1, $this->conn  );
 
	if ( $result_1 )
	{	 
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$IDMuser = $row;
		}
	}
   	return $IDMuser;
}

function existMatNr( $akennung )
{
	$exist = false; 

	$sql_1 = "SELECT `akennung` FROM `mdl_haw_idm`";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			if ( $akennung == $row['akennung'] )
				$exist = true;
		}
	}
  	return $exist;
}

function setIDMuser( $IDMuser )
{
 

	if ($this->existMatNr( $IDMuser['akennung'] ))
	{ 
        if ( isset ( $IDMuser[ 'vorname'    ] )) { $tmp .=  '`vorname`		= \'' .$IDMuser[ 'vorname'    ]. '\','; }
		if ( isset ( $IDMuser[ 'nachname'   ] )) { $tmp .=  '`nachname`	    = \'' .$IDMuser[ 'nachname'   ]. '\','; }
		if ( isset ( $IDMuser[ 'studiengang'] )) { $tmp .=  '`studiengang`	= \'' .$IDMuser[ 'studiengang']. '\','; }
		if ( isset ( $IDMuser[ 'semester'   ] )) { $tmp .=  '`semester` 	= \'' .$IDMuser[ 'semester'   ]. '\','; }
		if ( isset ( $IDMuser[ 'department' ] )) { $tmp .=  '`department`	= \'' .$IDMuser[ 'department' ]. '\','; }
		if ( isset ( $IDMuser[ 'mail'       ] )) { $tmp .=  '`mail` 		= \'' .$IDMuser[ 'mail'       ]. '\','; }
		if ( isset ( $IDMuser[ 'matrikelnr' ] )) { $tmp .=  '`matrikelnr` 	= \'' .$IDMuser[ 'matrikelnr' ]. '\' '; }
 

         $sql_1 = "UPDATE `mdl_haw_idm` SET ".$tmp." WHERE `akennung`	= '".$IDMuser['akennung'] ."'";
	}
	else
	{
		$sql_1	=
			"INSERT INTO `mdl_haw_idm` (
			`akennung`, 
			`matrikelnr`, 
			`vorname`, 
			`nachname`, 
			`studiengang`, 
			`department`,
			`semester`, 
			`mail` ) 	
			
			VALUES ( 
			\"".$IDMuser['akennung']."\",
			\"".$IDMuser['matrikelnr']."\",
			\"".$IDMuser['vorname']."\", 
			\"".$IDMuser['nachname']."\", 
			\"".$IDMuser['studiengang']."\", 
			\"".$IDMuser['studiengang']."\", 
			\"".$IDMuser['semester']."\" , 
			\"".$IDMuser['mail']."\" )";
	} 
	$result_1	= mysql_query( $sql_1, $this->conn  );
}

function setDB( $param, $IDMuser )
{  
	if($param['column'] == "studiengangID")
	{   
		$sql_1 = "UPDATE `mdl_haw_idm` SET `studiengang` = '".$param['value']."' WHERE `akennung` ='".$IDMuser['akennung'] ."' ";
		//$_SESSION[ 'IDMuser'  ]['studiengang'] = $param['value'];
	}
	else if($param['column'] == "semester")
	{
		$sql_1 = "UPDATE `mdl_haw_idm` SET `semester` = '".$param['value']."' WHERE `akennung` ='".$IDMuser['akennung'] ."' ";
        //$_SESSION[ 'IDMuser'  ]['semester'] = $param['value'];
	}
	$result_1 = mysql_query( $sql_1, $this->conn  );
}

function deb($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

}

?>
