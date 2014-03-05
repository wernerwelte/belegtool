<?php
class DB
{
var $conn;
var $dbIDM;

function DB( $dbIDM = null )
{
  require( "ini/db.ini.php" );
  $this->conn  = mysql_connect( $server, $user, $pass );
	if( $this->conn )
	{   
		mysql_select_db( $dbase, $this->conn );
	}
	else
	{
		echo( "<b>Verbindung zur IDM-DB konnte nicht hergestellt werden </b>" );
	}
	if( $dbIDM )
	{
		$this->dbIDM = $dbIDM;
	}
}

function getProfessor( $professorID )
{
    $sql_1 = "SELECT * FROM `mdl_haw_professoren` WHERE  `ID` =  $professorID";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$professor = $row;
		}
	}
  	return $professor;
}

function getStudiengang( $studiengangID )
{
  
  $studiengang = null;
  $sql_1 = "SELECT * FROM `mdl_haw_studiengaenge` WHERE  `ID` =   $studiengangID";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$studiengang = $row;
		}
	}
  	return $studiengang;
}

function getVeranstaltung( $veranstaltungID ) // zB Mat1
{
    $sql_1 = "SELECT * FROM `mdl_haw_veranstaltungen` WHERE `ID`= $veranstaltungID";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$veranstaltung= $row;
		}
	}
  	return $veranstaltung;
}

function getVorlesungsVerzeichnis()
{  	
	$id = 0;
	$sql_1 = "SELECT DISTINCT * FROM `mdl_haw_vl_verzeichnis` ORDER BY `veranstaltungID`";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$tmp[ 'ID' ] 					= "";
	 		$tmp[ 'professor' ] 			= "";
			$tmp[ 'studiengang' ] 			= "";
			$tmp[ 'veranstaltung' ] 		= "";
			$tmp[ 'semester' ] 		     	= "";
			$tmp[ 'anzStudenten' ]			= "";
 
			$tmp[ 'ID' ] 					= $row[ 'ID' ];
			$tmp[ 'professor' ] 			= $this->getProfessor( $row[ 'professorID' ] );
 			$tmp[ 'studiengang' ] 			= $this->getStudiengang( $row[ 'studiengangID' ] );
 			$tmp[ 'veranstaltung' ] 		= $this->getVeranstaltung( $row[ 'veranstaltungID' ] );
 			$tmp[ 'semester' ] 			    = $row[ 'semester' ];
			$tmp[ 'anzStudenten' ]			= $this->getAnzStudisInVeranstaltung( $row[ 'ID' ] );

			$vl_verzeichnis[ $row['ID'] ] 	= $tmp;
 
			unset( $tmp );
		}
	}
  	return $vl_verzeichnis;
}

function getAnzStudisInVeranstaltung( $veranstaltungID )
{
	$tmp[] = "";
	$ret = 0;
	$sql_1 = "SELECT `veranstaltungID` FROM `mdl_haw_wunschbelegliste` WHERE `veranstaltungID` = ". $veranstaltungID;
	$result_1 = mysql_query( $sql_1, $this->conn  );

	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$ret++;
            $tmp[] = "";
		}
		//$ret = sizeof($tmp);
	}
	return $ret;	
}

function getVorlesung( $ID )
{  		
	$sql_1 = "SELECT DISTINCT * FROM `mdl_haw_vl_verzeichnis` WHERE `ID` = $ID ORDER BY `veranstaltungID`";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$tmp[ 'ID' ]			= $row[ 'ID' ];
			$tmp[ 'professor' ] 	= $this->getProfessor( $row[ 'professorID' ] );
			$tmp[ 'studiengang' ] 	= $this->getStudiengang( $row[ 'studiengangID' ] );
			$tmp[ 'veranstaltung' ]	= $this->getVeranstaltung( $row[ 'veranstaltungID' ]);
			$tmp[ 'semester' ] 	    = $row[ 'semester' ];
			$vorlesung 				= $tmp;
			unset( $tmp );
		}
	}
  	return $vorlesung;
}

function getBelegliste( $matrikelNr, $vl_verzeichnis )
{  	
	$sql_1 = "SELECT  * FROM `mdl_haw_wunschbelegliste` WHERE `studId` = '$matrikelNr'   ORDER BY `ID` ASC"; 	
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			$row[ 'veranstaltung' ] = $vl_verzeichnis[ $row[ 'veranstaltungID' ] ];
			$belegliste[] 			= $row;
		}
	}
  	return $belegliste;
}


	function getPhasen()
	{
		$sql_1 = "SELECT * FROM `mdl_haw_phasen` " ;
		 
		$result_1 = mysql_query($sql_1, $this->conn);
		if ( $result_1 )
		{
			while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
			{ $p = $row[phase]; 
				$phasen[ $p ]  = $row['timestamp']; 
			}
		}
		return $phasen;
	}	

/*


function getErstsemestermatnr()
{
	$sql_1 = "SELECT `erstsemestermatnr` FROM `mdl_haw_erstsemestermatnr`";
	$result_1 = mysql_query( $sql_1, $this->conn  );
	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{	
			 $erstsemestermatnr = $row[ 'erstsemestermatnr' ];
		}
	}
  	return $erstsemestermatnr;
}

*/
function setDB( $param, $IDMuser , $belegliste, $vl_verzeichnis )
{    
	//$this->deb($param);
	
	if( $param[ 'column' ] == "delete" ) 
	{   
		$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";"; 
	}	

	else if( $param[ 'column' ] == "neuerBeleglistenEintrag" ) 
	{   
          $sql_1 = "INSERT INTO `mdl_haw_wunschbelegliste` ( `studID`,  `veranstaltungID`, `timestamp`, `status`, `checksum`) VALUES ( '".$IDMuser[ 'matrikelnr' ]."', '-1', NOW(), '', '".$IDMuser[ 'matrikelnr' ]."')";
  
	}	 
	
	
	else if( $param[ 'column' ] == "studiengangID" )                                                 	/*Alle Einträge in der Belegliste werden gelöscht wenn das Studiengang geändert wird */
	{    
	  $sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `studID` =".$IDMuser[ 'matrikelnr' ];
  }
	else if( $param[ 'column' ] == "semester" )	                                                      /*Alle Einträge in der Belegliste werden gelöscht wenn das Semester geändert wird */
	{  
	  $sql_0 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `studID` =".$IDMuser[ 'matrikelnr' ];
		mysql_query( $sql_0, $this->conn  );
	}
	else if( $param[ 'column' ] == "update2" )                                                        // Update von Checksumme und Veranstaltungs ID
	{  
	    if ( isset( $param[ 'phase' ] ) ) // Argument:Phase nur bei Existenz mit in den SQL Queue 
		{  $p = "`phase` =  ".$param[ 'phase' ]. " ,";	}
		else
		{  $p = '';	}
		
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',  $p  `veranstaltungID` = '".$param[ 'value' ]."' WHERE  `ID` = ".$param[ 'ID' ];
	 
		$result_1 = mysql_query( $sql_1, $this->conn  );
 
        if(sizeof($belegliste) > 0)
		{
			foreach ( $belegliste as $bl )
			{
				if( $bl[ 'ID' ] ==   $param[ 'ID' ]  ) 
				{
					$status =  $bl[ 'status' ];
				}
			}
        }
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = '" .$status. "' WHERE  `ID` = " .$param[ 'ID' ];
	 
 
	 	if( $param[ 'value' ] == -1 ) 
		{
			$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";"; 
		}	

		$result_1 = mysql_query( $sql_1, $this->conn  );

	}
	else if( $param[ 'column' ] == "update3" )
	{  
		
		$sql_1 = "INSERT INTO `mdl_haw_wunschbelegliste` ( `studID`,  `veranstaltungID`, `timestamp`, `status`, `checksum`) VALUES ( '".$IDMuser[ 'matrikelnr' ]."', '-1', NOW(), '', '".$IDMuser[ 'matrikelnr' ]."')";
		$result_1 = mysql_query( $sql_1, $this->conn  );
		
		// Update von Checksumme und Veranstaltungs ID
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',   `veranstaltungID` = '".$param[ 'value' ]."' WHERE  `checksum` = ".$param[ 'ID' ];
		$result_1 = mysql_query( $sql_1, $this->conn  );

		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = 'M' WHERE  `checksum` = " .$param[ 'ID' ];
		$result_1 = mysql_query( $sql_1, $this->conn  );
	}
	
	else
	{
		// Update von Checksumme und Veranstaltungs ID
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',  `phase` =  '".$param[ 'phase' ]."' ,  `".$param[ 'column' ]."` = '".$param[ 'value' ]."' WHERE  `ID` = ".$param[ 'ID' ];
		
		$result_1 = mysql_query( $sql_1, $this->conn  );
		$belegliste = $this->getBelegliste( $IDMuser[ 'matrikelnr' ], $vl_verzeichnis );	
		$belegliste = $this->isBooked( $IDMuser, $belegliste );
	  
		if( sizeof( $belegliste ) >0 )
		foreach ( $belegliste as $bl )
		{
			if( $bl[ 'ID' ] ==   $param[ 'ID' ] )
			{
				$status =  $bl[ 'status' ];
			}
		}
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = '".$status."' WHERE  `ID` = ".$param[ 'ID' ];

		if( $param[ 'value' ] == -1 ) 
		{
			$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";"; 
		}	
		
		$result_1 = mysql_query( $sql_1, $this->conn  );
	}

	if( !$result_1 )
	{	
		$result_1 = mysql_query( $sql_1, $this->conn );
	}
	return $belegliste;
}

function isBooked( $IDMuser, $belegliste )
{  
  if ( sizeof( $belegliste ) > 0 )
   
   for( $i=0; $i< sizeof( $belegliste ); $i++ )  // foreach ($belegliste as $bl)
   {   
		$blStudiengang 		  =  $belegliste[$i][ 'veranstaltung' ][ 'studiengang' ][ 'ID' ];
		$blSemester 	      =  $belegliste[$i][ 'veranstaltung' ][ 'semester' ];
	 
    $userStudiengang 	  =  $IDMuser[ 'studiengang' ];
		$userSemester       =  $IDMuser[ 'semester' ];
	
		if ( $blStudiengang == $userStudiengang && $blSemester == $userSemester   )
		{
			$belegliste[ $i ][ 'status' ] = "B";	
		}
		else
		{
			$belegliste[ $i ][ 'status' ] = "W";		
		}
	}
	return $belegliste;
}

function setWishState( $id, $state )
{   
   if ( $state == 1 ) {  $sql_1 = "UPDATE `beleg`.`mdl_haw_wunschbelegliste` SET `status` = 'W' WHERE `mdl_haw_wunschbelegliste`.`ID` = ".$id;  }
   if ( $state == 2 ) {  $sql_1 = "UPDATE `beleg`.`mdl_haw_wunschbelegliste` SET `status` = 'B' WHERE `mdl_haw_wunschbelegliste`.`ID` = ".$id;  }
	$result_1 = mysql_query( $sql_1, $this->conn  );
}


function getVLVZStudiengaenge()  
{   
	$sql_1 = "SELECT DISTINCT `studiengangID` FROM `mdl_haw_vl_verzeichnis`";	
	$result_1 = mysql_query($sql_1, $this->conn );
	if ( $result_1 )
	{
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{   
			$sql_2 = "SELECT DISTINCT * FROM `mdl_haw_studiengaenge` WHERE ID = ".$row['studiengangID'];
			$result_2 = mysql_query($sql_2, $this->conn );
			if ( $result_2 )
			{
				while ( $row2 = mysql_fetch_array( $result_2, MYSQL_ASSOC ) )
				{
					$studiengaenge[] = $row2;
				}
			}
		}
	}
	return $studiengaenge;	
}

function getVeranstaltungsListe()
{   
	$sql_1 = "SELECT DISTINCT `veranstaltungID` FROM `mdl_haw_vl_verzeichnis`";
	$result_1 = mysql_query($sql_1, $this->conn );
 
	if ( $result_1 )
	{
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{   
			$sql_2 = "SELECT DISTINCT * FROM `mdl_haw_veranstaltungen` WHERE ID = ".$row['veranstaltungID'];
			$result_2 = mysql_query($sql_2, $this->conn );
			if ( $result_2 )
			{
				while ( $row2 = mysql_fetch_array( $result_2, MYSQL_ASSOC ) )
				{
					$veranstaltungen[] = $row2;
				}
			}
		}
	}
	return $veranstaltungen;
}


	function getVorlesungsListe()
	{   
		$sql_3 = "SELECT * FROM `mdl_haw_veranstaltungen";

		$result_3 = mysql_query($sql_3, $this->conn);
		
		while ( $row = mysql_fetch_array( $result_3, MYSQL_ASSOC ) )
		{
			$vorlesung[] = $row;
		}
		return $vorlesung;
	}


function deb($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

function getGesamtBelegliste( $sort = "veranstaltung" )
{
	if( $sort =="" )
		$sort = "stud";
		
	$sql_1 = "SELECT * FROM `mdl_haw_wunschbelegliste` ORDER BY `".$sort."ID`	ASC ";

	$result_1 = mysql_query( $sql_1, $this->conn );

	if ( $result_1 )
	{	
		while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
		{
			$tmp[ 'ID' ] 		= $row[ 'ID' ];
			$tmp[ 'status' ]	= $row[ 'status' ];
			$tmp[ 'phase' ]  	= $row[ 'phase' ];

	 
			if( $row[ 'veranstaltungID' ] != '-1' )
			{	 
				$tmp2 = explode( ';',  $row['checksum'] );
				$tmp[ 'IDMuser' ] = $this->dbIDM->getIDMuser( $tmp2[ 0 ] ) ;
				$tmp[ 'IDMuser' ][ 'studiengang' ]=    $this->getStudiengang( $tmp[ 'IDMuser' ][ 'studiengang' ]);
				$tmp[ 'vorlesung' ] = $this->getVorlesung( $row[ 'veranstaltungID' ]);	
				$belegliste[] = $tmp;			
			}   
		}
	}
	return $belegliste;
}

	function getAllLists()
	{   
		$lists = "";

		$sql_1 = "SELECT * FROM `mdl_haw_professoren";
		$sql_2 = "SELECT * FROM `mdl_haw_studiengaenge";
		$sql_3 = "SELECT * FROM `mdl_haw_veranstaltungen";
		
		$result_1 = mysql_query($sql_1, $this->conn);
		$result_2 = mysql_query($sql_2, $this->conn);
		$result_3 = mysql_query($sql_3, $this->conn);

		if ( $result_1 )
		{
			while ( $row = mysql_fetch_array( $result_1, MYSQL_ASSOC ) )
			{
				$professoren[] = $row;
			}
			$lists[ 'professoren' ] = $professoren;
		}

		if ( $result_2 )
		{
			while ( $row = mysql_fetch_array( $result_2, MYSQL_ASSOC ) )
			{
				$studiengaenge[] = $row;
			}
			$lists[ 'studiengaenge' ] = $studiengaenge;
		}

		if ($result_3)
		{
			while ( $row = mysql_fetch_array( $result_3, MYSQL_ASSOC ) )
			{
				$veranstaltungen[] = $row;
			}
			$lists[ 'veranstaltungen' ] = $veranstaltungen;
		}
		return $lists;
	}




}

/*

----------------------------
 	ID 	studiengang
----------------------------
	1 	Medizintechnik
	2 	Biomedical Engineering
	3 	Hazard Control
	4 	Rescue Engineering
	5 	Biotechnologie
	6 	Bioprocess Engineering
	7 	Umwelttechnik
	8 	Enviromental Engineering
	9 	Verfahrenstechnik
	10 	Process Engineering
	11 	Oekotrophologie
	12 	Feed Sciences
	13 	Health Sciences
	14 	Public Health

----------------------------
	ID 	professor 	abk
----------------------------
	1	Heitmann  	Heit
	2 	Maas 		Maa
	3 	Sawatzki 	Swi
	4 	Siegers 	Sie
	5 	Teschke 	Teb
	6 	Kampschulte Kps
	7 	Rodenhausen Rod
	8 	Schiemann 	Smn
	9 	Foerger 	Foer
	10 	Tolg 		Tlg
	12 	Kohlhoff 	Koh
	13 	Strehlow 	Str
	14 	Dildey 		Dil
	15 	Letzig 		Let
	16 	Baumann 	Bau
	17 	Kober 		Kob
	
----------------------------
 	ID 	veranstaltung 	abk
----------------------------
	1 	Mathematik 1 	Mat1
	2 	Mathematik 2 	Mat2
	3 	Mathematik 3 	Mat3
	5 	Physik 2 		Phy2
	7 	Informatik 2 	Inf2
	4 	Physik 1 		Phy1
	6 	Informatik 1 	Inf1
	8 	Informatik 3 	Inf3
*/

 


?>
