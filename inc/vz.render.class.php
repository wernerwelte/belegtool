<?php
class Render
{
  //-- Liefert HTML-Auswahlliste mit allen Professoren, aktueller Professor ist selektiert
  function getProfessorenAuswahl( $professoren, $select , $id )
  {
    $linie = "---------------";
    $list  = "";
    $list .= "\n\r<select name='professor$id' size='1'   onchange='update(\"professorID\",this.form.professor$id.options[this.form.professor$id.selectedIndex].value, $id)'>";
    $list .= "\n\r<option value=\"X\">". $linie ."</option>";

    for( $i = 0; $i < sizeof( $professoren ) ; $i++ )
    {
      $professor = $professoren[ $i ];

      if( $professor[ 'ID' ] == $select )  $sel = 'selected="selected"';
      else  $sel = '';
      $list .= "\n\r<option value=\"". $professor[ 'ID' ]."\" $sel >".$professor[ 'professor' ]." / ".$professor[ 'abk' ]."</option>";
    }
    $list .=  "\n\r</select>";
    return $list;
  }

  //-- Liefert HTML-Auswahlliste mit allen Studiengänen, aktueller Studiengang ist selektiert
  function getStudiengaengeAuswahl( $studiengaenge, $select , $id )
  {
    $linie = "---------------";

    $list  = "";
    $list .= "\n\r<select name='studiengang$id' size='1'   onchange='update(\"studiengangID\",this.form.studiengang$id.options[this.form.studiengang$id.selectedIndex].value, $id, $select)'>";
    $list .= "\n\r<option value=\"X\">". $linie ."</option>";

    for( $i = 0; $i < sizeof( $studiengaenge )  ; $i++ )
    {
      $studiengang =  $studiengaenge[ $i ];

      if( $studiengang[ 'ID' ] == $select )  $sel = 'selected="selected"';
      else        $sel = '';

      $list .="\n\r<option value=\"". $studiengang[ 'ID' ]."\" $sel>".$studiengang[ 'studiengang' ]."</option>";
    }
    $list .= "\n\r</select>";
    return $list;
  }

  //-- Liefert HTML-Auswahlliste mit allen Semestern, aktuelles FS ist selektiert
  function getFachsemseterAuswahl( $select , $id )
  {
    $linie = "---------------";
    $list  = "";
    $list .= "\n\r<select name='semester$id' size='1' onchange='update(\"semester\",this.form.semester$id.options[this.form.semester$id.selectedIndex].value, $id)'>";
    //    $list .= "\n\r<option value=\"X\">".$linie ."</option>";

    for( $i = 0; $i < 10  ; $i++)
    {
      if( $i == $select )  $sel = 'selected="selected"';
      else        $sel = '';
      $list .="\n\r<option value=\"". $i."\" $sel>".$i."</option>";
    }
    $list .= "\n\r</select>";
    return $list;
  }

  //-- Liefert HTML-Auswahlliste mit allen Veranstaltungen, aktuelle Veranstaltung ist selektiert
  function getVeranstaltungenAuswahl( $veranstaltungen, $select , $id )
  {
    $linie = "---------------";
    $list  = "";
    $list .= "\n\r<select name='veranstaltung$id' size='1' onchange='update(\"veranstaltungID\",this.form.veranstaltung$id.options[this.form.veranstaltung$id.selectedIndex].value, $id)'>";
    $list .= "\n\r<option value=\"X\">".$linie ."</option>";

    for( $i = 0; $i < sizeof( $veranstaltungen ) ; $i++)
    {
      $veranstaltung =  $veranstaltungen[ $i ];
      if($veranstaltung[ 'ID' ] == $select)
      $sel = 'selected="selected"';
      else
      $sel = '';
      $list .="\n\r<option value=\"". $veranstaltung[ 'ID' ]."\" $sel>".$veranstaltung[ 'veranstaltung' ]." / ".$veranstaltung[ 'abk' ]."</option>";
    }
    $list .= "\n\r</select>";
    return $list;
  }



  function printGesamtBelegliste(  $gesamtBelegliste, $vl_verzeichnis ,$veranstaltungsFilterID, $changeable = false )
  {   
  $tab   = null;
  $tabX  = null;
  $tabXX = null;
  $tmp1  = $tmp2 = '';
  
  $i = 0;
  $headline = " ALLE STUDIERENDE  ";
  
  if( $veranstaltungsFilterID > 0 )
  {  
    $headline .= "   " .$vl_verzeichnis[$veranstaltungsFilterID]['professor']['professor']      ; 
    $headline .= " - " .$vl_verzeichnis[$veranstaltungsFilterID]['studiengang']['studiengang']    ;
    $headline .= " - " .$vl_verzeichnis[$veranstaltungsFilterID]['veranstaltung']['veranstaltung']  ; 
    $headline .= " -- Anz.Studenten:" .$vl_verzeichnis[$veranstaltungsFilterID]['anzStudenten']; 
  }

  /*
  $veranstaltungsFilterID = VeranstaltungsID
  $veranstaltungsFilterID = -1     --> ALLE
  $veranstaltungsFilterID = -2    --> KEINE
  */
    
    $tab  = '<script type="text/javascript" src="jquery.min.js"></script>';
    $tab .= "<h2>".$headline."</h2>";
    $tab .= "\n\r<form  method='post'  name='beleglisteGesamt' action='".$_SERVER['PHP_SELF']."' >";
    $tab .= "<input name=\"F\" type=\"hidden\" value=\"".$veranstaltungsFilterID."\"  />";
    $tab .= "<table  style=\"float:left\" id=\"belegTabelle\">\r\n";
    //$tab .= "<col class=m01><col class=m02><col class=m03><col class=m04><col class=m05><col class=m06>";
    $tab .= "<thead><tr> ";
    $tab .= "<th style=\"width:80px;\">MatNr</th>\r\n ";
    $tab .= "<th style=\"width:125px;\">Vorname</th> \r\n";
    $tab .= "<th style=\"width:125px;\">Name</th> \r\n";
   // $tab .= "<th style=\"width:250px;\">Email</th> \r\n";
    $tab .= "<th style=\"width:20px;\">SE</th>\r\n";
    if($changeable) { $tab .= "<th style=\"width:70px;\">Belegen</th>\r\n "; }
    $tab .= "<th style=\"width:20px;\">S</th>\r\n ";
    $tab .= "<th style=\"width:20px;\">P</th>\r\n ";
        if($changeable) { $tab .= "<th style=\"width:125px;\">Vorlesung</th>\r\n ";}
    
    $tab .= "</tr></thead> \r\n \r\n";

    if($gesamtBelegliste)
    {
      
    $tab .= "<tbody>\r\n";

    foreach($gesamtBelegliste as $gbl )
    {
    
      if($changeable) // Nur Rolle Koordinator und Admin dürfen Änderungen vornehmen
      {
        $list_tmp = "\n\r<select name='veranstaltung".$gbl['ID']."' size='1' onchange='update2(\"update2\",this.form.veranstaltung".$gbl['ID'].".options[this.form.veranstaltung".$gbl['ID'].".selectedIndex].value, ".$gbl['ID'].", \"". $gbl['IDMuser']['matrikelnr'] ."\" , \"". $gbl['IDMuser']['akennung'] ."\"  , \"" .$gbl['status']."\", ".$veranstaltungsFilterID."  )'>";
        $i=1;
        foreach($vl_verzeichnis as $vlvz )
        {  if( $vlvz['veranstaltung']['ID']  ==   $gbl['vorlesung']['veranstaltung']['ID'])
          {  $txt =   $vlvz['semester'] . "" . $vlvz['studiengang']['abk2']  . " / " . $vlvz['professor']['abk'] . " (" .  $vlvz['veranstaltung']['abk'] . ") ";
            
            if   ( $gbl[ 'vorlesung' ][ 'ID' ] == $vlvz[ 'ID' ])   { $sel = 'selected="selected"'; }
            else                                                { $sel = ''; }

            $list_tmp .="\n\r<option class=\"a".$i++."\" value=\"". $vlvz['ID']."\" $sel> ". $txt  ." </option>";
          }
        }
        $list_tmp .= "</select>";
      }   

      // Daten in Array speichern, damit diese sortiert werden können  
      if( $gbl['vorlesung']['ID'] == $veranstaltungsFilterID ||  $veranstaltungsFilterID == -2 )
      {        
        $tabX['matrikelnr'] = $gbl['IDMuser']['matrikelnr'];
        $tabX['vorname'] = $gbl['IDMuser']['vorname'];
        $tabX['nachname'] = $gbl['IDMuser']['nachname'];
       // $tabX['mail'] = $gbl['IDMuser']['mail'];
        $tabX['semSG'] = $gbl['IDMuser']['semester']."".$gbl['IDMuser']['studiengang']['abk2'];
                
        if($changeable) $tabX['liste'] = $list_tmp;
        $tabX['status'] = $gbl['status'];
        $tabX['phase'] = $gbl['phase'];
        $tabX['id'] = $gbl['ID'];
        $tabXX[] = $tabX; 
             unset($tabX);
      }
    }

     // $this->deb($tabXX);
    
    if($tabXX)
    {
      usort($tabXX, 'vergleichAufSemSG');
      $i=0;
            
      foreach( $tabXX as $tabX )
      { $i++; 
        $tab .= "<tr>";
        $tab .= "<td>" .$tabX['matrikelnr']. "</td>\r\n";
        $tab .= "<td>" .$tabX['vorname']. "</td>\r\n";
        $tab .= "<td>" .$tabX['nachname']. "</td>\r\n";
       // $tab .= "<td>" .$tabX['mail']. "</td>\r\n";
        $tab .= "<td>" .$tabX['semSG']. "</td>\r\n";
        
          if      ($tabX['status'] == 'W')  $tabX['status'] =  '<a href="#" class="W" onclick="return false;">W</a>';
          else if ($tabX['status'] == 'B')  $tabX['status'] =  '<a href="#" class="B" onclick="return false;">B</a>';
        
        if($changeable)  
        $tab .= '<td><a href="#" class="W" onclick="return false;" id="alink'.$i.'a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> <a href="#" class="B" onclick="return false;" id="alink'.$i.'b">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>'.''."</td>\r\n";
        $tab .= '<td><span id="axcontent'.$i.'">'.$tabX['status'].'</span>'."</td>\r\n";
        $tab .= "<td>" .$tabX['phase']. "</td>\r\n";
        if($changeable)
        $tab .= "<td>" .$tabX['liste']. "</td>\r\n";
        
        $tab .= "</tr>\r\n";
        
        $tmp1 .= '$("#alink'.$i.'a").click(function(){ $("#axcontent'.$i.'").load("ajax.php?id='.$tabX['id'].'&p=1"); }); $("#alink'.$i.'b").click(function(){ $("#axcontent'.$i.'").load("ajax.php?id='.$tabX['id'].'&p=2"); });'."\r\n";
      }
    }
    
    $tab .= "</tbody>\r\n";
    }
 
    
    $tab .="</table>\r\n";
    $tab .="</form>\r\n";
    
    $tmp2 = '<script type="text/javascript"> $(document).ready(function(){'."\r\n";
    $tmp2 .= $tmp1;
    $tmp2 .= "\r\n".'});</script>';
    
	$tab .= $tmp2;
        
    return $tab;
  }

  function printSemesterListe(  $gesamtBelegliste, $veranstaltungsFilterID  )
  {   
    $semList = null;
	$semester = null;
	
    if($gesamtBelegliste)
    {
      foreach($gesamtBelegliste as $gbl )
      {
        if( $gbl['vorlesung']['ID'] == $veranstaltungsFilterID ||  $veranstaltungsFilterID == -2 ) // Initialisierung $semList[$semester]['value']
        {  
          $semester = $gbl['IDMuser']['semester'] ."". $gbl['IDMuser']['studiengang']['abk2'];
          $semList[$semester]['value'] = 0;
        }
      }


	foreach($gesamtBelegliste as $gbl )
    {
        if( $gbl['vorlesung']['ID'] == $veranstaltungsFilterID ||  $veranstaltungsFilterID == -2 )
        {  
          $semester = $gbl['IDMuser']['semester'] ."". $gbl['IDMuser']['studiengang']['abk2'];
          ++$semList[$semester]['value'];
          $semList[$semester]['name'] = $semester;
        }
    }

    
      $tab  = "<table style=\"border-left:25px; float:left\" id=\"SemListTabelle\">\r\n";
      $tab .= "<thead><tr><td>Sem</td><td>Anz</td></tr></thead>";

            
      if( isset ( $semList ))
      {
        usort( $semList, 'vergleichAufName' );
        $tab .= "<tbody>";
        foreach ( $semList as $sem )
        {
          $tab .= "<tr><td>";
          $tab .= $sem['name'];
          $tab .= "</td><td>";
          $tab .= $sem['value'];
          $tab .= "</td></tr>";
        }
        $tab .= "</tbody>";
      }    
      $tab .= "</table>";
    }  
    return $tab;
  }
  
  function getAnzStudisInFach( $vl_verzeichnis, $fach)
  {
    $anzStudis = 0;
    foreach( $vl_verzeichnis as $vl )
    {  
      foreach( $vl as $vlvz )
      {  
        if( $vlvz['veranstaltung']['abk'] == $fach || "ALLE" == $fach)
        {
          $anzStudis += $vlvz['anzStudenten'];
        }
      }
    }
    return   $anzStudis;
  }
  
  
  function printVeranstaltungsMatrix( $vl_verzeichnis, $role )
  {    
    $i=1;
    
    $ret  ="<div class=\"veranstaltungsmatrix\">";

    $ret .= "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"#\">";
    
    // -- X-Achse Überschriften 
    for( $i = 0; $i < sizeof($vl_verzeichnis) ; ++$i  )
    {   
      
      $sg_abk ="";      

      for( $j = 0; $j < sizeof($vl_verzeichnis[$i]) ; ++$j  )
      {
        if ( $vl_verzeichnis[$i][$j]['studiengang']['abk2'] )
        {
          $sg_abk = $vl_verzeichnis[$i][$j]['studiengang']['abk2']; 
        }        
      }

      if ($sg_abk)
        $ret .=" <div class=\"a".$i." bx \">". $sg_abk ."  </div><br /><br />\n" ;
    }  
        
    // -- Y-Achse Überschriften 
  

 
    foreach( $vl_verzeichnis as $vlvz   )
    {  for( $i = 0; $i < sizeof($vlvz ) ; $i++  )
		{
		  for( $j = 0; $j < sizeof($vl_verzeichnis[1]) ; $j++  )
		  {   
			if( isset ( $vl_verzeichnis[$i][$j]['veranstaltung']['abk'] ) )
			{
			  $ret .=" <div class=\"ax b".$j. "\" >".$vl_verzeichnis[$i][$j]['veranstaltung']['abk'] ."  </div>" ; 
			}
		  }
    }
	}
    // -- Matrix mit den Werten
    for( $i = 0; $i < sizeof($vl_verzeichnis) ; ++$i  )
    {   
      for( $j = 0; $j < sizeof($vl_verzeichnis[$i]) ; ++$j  )
      {   
        $txt =  $vl_verzeichnis[$i][$j]['semester']."".$vl_verzeichnis[$i][$j]['studiengang']['abk2'] . "-" . $vl_verzeichnis[$i][$j]['professor']['abk'] .".#". $vl_verzeichnis[$i][$j]['anzStudenten'];
        
        if($vl_verzeichnis[$i][$j]['ID'])
        {
          $ret .="\r\r<a class=\"a".$i. " b".$j. "\"   href=\"".$_SERVER['PHP_SELF']."?F=".$vl_verzeichnis[$i][$j]['ID']."\">$txt</a> ";
          if ($role == 5) 
            $ret .="\r\r<input  class=\"a1_".$i. " b1_".$j. "\"  type=\"checkbox\" name=\"v".$vl_verzeichnis[$i][$j]['ID']."\" value=\"".$vl_verzeichnis[$i][$j]['ID']."\" />";
      
        }
      }
    }
    
      $ret .= "\n\r<br /><br /><a  class=\"a0 b".($j). "\"  href=\"".$_SERVER['PHP_SELF']."?F=-2\">ALLE # ".$this->getAnzStudisInFach( $vl_verzeichnis, 'ALLE' )." </a>";
      if ($role == 5)
      $ret .= "\n\r<input  class=\"a1 b".($j+2). " x \"  name=\"SUB\" type=\"submit\" value=\"-SELECTED-\" />";

    
    $ret .=" </form></div>";
  
  return $ret;

  }
  //-- Liefert HTML-Auswahlliste mit allen Belegunsmöglichkeiten
  function getBelegungsAuswahl( $vl_verzeichnis, $beleg , $id )
  {
    $linie = "---------------";
    $list  = "";
    $list .= "\n\r<select name='belegung$id' size='1' onchange='update2(\"belegungID\",this.form.belegung$id.options[this.form.belegung$id.selectedIndex].value, ".$vl_verzeichnis['belegungsID'].")'>";
    $list .= "\n\r<option value=\"X\">".$linie ."</option>";

    for( $i = 0; $i < sizeof( $vl_verzeichnis )  ; $i++)
    {
      $belegung =  $vl_verzeichnis[ $i ];
      //echo "<br />".$belegung[ 'ID' ] ." -- ". $beleg['veranstaltungID'];
      if($belegung[ 'ID' ] == $beleg['veranstaltungID'])
      {
        $sel = 'selected="selected"';
      }
      else
      {
        $sel = '';
      }

      $txt = $belegung['veranstaltung']['abk']." - ".$belegung['professor']['abk']." - ".$belegung['studiengang']['studiengang'];
      $list .="\n\r<option value=\"". $belegung[ 'ID' ]."\" $sel>".$txt ."</option>";
    }
    $list .= "\n\r</select>";
    return $list;
  }

  function printBeleglisteEdit($belegliste, $vl_verzeichnis)
  {
    //$this->deb($vl_verzeichnis);
    $tab = "<table>\r\n";
    $tab .= "<tr><td>STATUS</td><td>STUDENT</td><td>VERANSTALTUNG</td><td>WUNSCH</td></tr>";

    for ($i=0; $i < sizeof($belegliste);$i++)
    {
      $tab .= "<tr>
    <td>".$belegliste[$i]['status']."</td>                       
    <td>".$belegliste[$i]['user']['matrikelnr']." - ".$belegliste[$i]['user']['vorname']." ".$belegliste[$i]['user']['nachname']." - ".$belegliste[$i]['user']['studiengang']." ".$belegliste[$i]['user']['semester']."  
    <td>".$this->getBelegungsAuswahl( $vl_verzeichnis,  $belegliste[$i] , $i )."</td>
    <td>".$belegliste[$i]['veranstaltung']['veranstaltung_abk']." - ".$belegliste[$i]['veranstaltung']['professor_abk']." - ".$belegliste[$i]['veranstaltung']['vorlesung_bei']."</td>      
    </tr>\r\n" ;
    }
    $tab .="</table>";
    return $tab;
  }

  function printBelegung($belegung)
  {
    $tab = "<table>\r\n";
    $tab .= "<tr>
  <td>PROFESSOR</td>
  <td>VERANSTALTUNG</td>
  <td>STUDIENGANG</td>
  <td>ANZ STUDENTEN</td></tr>";

    for ($i=0; $i < sizeof($belegung);$i++)
    {
      $tab .= "<tr>
    <td>".$belegung[$i]['professor']['professor']."</td>                   
    <td>".$belegung[$i]['veranstaltung']['veranstaltung']."</td>                   
    <td>".$belegung[$i]['studigengang']['studiengang']."</td>                   
    <td>".$belegung[$i]['anzahlstudenten']."</td>                   
    </tr>\r\n" ;  
    }
    $tab .="<tr><td colspan=\"3\"></ td><td >".$belegung['anzahlGesamtStudenten']."</td> </tr>";
    $tab .="</table>";
    return $tab;
  }

  function printVorlesungsverzeichnisAuswahl($vl_verzeichnis, $lists, $role )
  {
    $filename = "download/vorlesungsverzeichnis_".date("Y-m-d-His",time()).".csv";

    $tab .= "\n\r<form name='vlvz' action='#'>";
    $tab .= "<table>";
    $tab .=  "<tr><td>";
    $tab .=  "<a   href='".$_SERVER['PHP_SELF']."?s=veranstaltung'\" >VERANSTALTUNG</a>";
    $tab .=  "</td><td>";
    $tab .=  "<a   href='".$_SERVER['PHP_SELF']."?s=professor'\" >PROFESSOR</a>";
    $tab .=  "</td><td>";
    $tab .=  "<a   href='".$_SERVER['PHP_SELF']."?s=studiengang'\" >STUDIENGANG</a>";
    $tab .=  "</td><td>";
    $tab .=  "<a>SEM</a>";
    $tab .=  "</td><td>";

    $tab .=  "<a style=\"float:right\"  target='_self' href='".$_SERVER['PHP_SELF']."?a=new' title=\"ADD\"  ><img  width=\"18\" height=\"18\" alt=\"ADD\" border=\"0\" src=\"img/p.gif\" /></a>";
    $tab .=  "</td><tr>";

    for( $id = 0;  $id < sizeof($vl_verzeichnis); $id++ )
    {
      $bgc ="";
      if(($id%2) == 0)
      $bgc ="bgcolor=\"#DDDDDD\"";

      $vorlesung = $vl_verzeichnis[$id]  ;
      $nid = $vorlesung['ID'];
      $tab .=  "<tr $bgc><td>";
      $tab .=   $this->getVeranstaltungenAuswahl(  $lists['veranstaltungen'],  $vorlesung['veranstaltungID'],   $nid );
      $tab .=  "</td><td>";
      $tab .=   $this->getProfessorenAuswahl(    $lists['professoren'],     $vorlesung['professorID'],     $nid );
      $tab .=  "</td><td>";
      $tab .=   $this->getStudiengaengeAuswahl(  $lists['studiengaenge'],   $vorlesung['studiengangID'],   $nid );
      $tab .=  "</td><td>";
      $tab .=   $this->getFachsemseterAuswahl(  $vorlesung['semester'],   $nid );
      $tab .=  "</td><td>";

      $tab .=   "\n\r<a target='_self' href='".$_SERVER['PHP_SELF']."?a=delete&amp;id=$nid' ><img  width=\"18\" height=\"18\"  border=\"0\" src=\"img/m.gif\" alt=\"DELETE\" title=\"DELETE\"/></a>\n ";
      $tab .=  "</td><tr>";

      $veranst  = $this->getName( $lists['veranstaltungen'], $vorlesung['veranstaltungID']);
      $prof    = $this->getName( $lists['professoren']  , $vorlesung['professorID']);
      $studieng  = $this->getName( $lists['studiengaenge']  , $vorlesung['studiengangID']);

      $bl .=  " ".$veranst['veranstaltung'];
      $bl .=  ";".$veranst['abk'];
      $bl .=  ";".$prof['professor'];
      $bl .=  ";".$prof['abk'];
      $bl .=  ";".$studieng['studiengang'];
      $csv .= $bl."\r\n";
      $bl = "";
    }
    $tab .=   "<tr><td  colspan='4' >";
    $tab .=   "</form>";
    $tab .=   "<a  href=\"$filename\" target=\"blank\">Download Vorlesungsverzeichnis</a></td></tr><table>";
    
    $head = "VERANSTALTUNG;VER_ABK;PROFESSOR;PROF_ABK;STUDIENGANG\r\n";
    $csv = $head.$csv;

    $fh = fopen($path.$filename,"w");
    fwrite($fh,utf8_decode( $csv ) );
    fclose($fh);
    return $tab;
  }

  /* ermittelt den Namen aus der Liste über die ID */
  function getName( $list, $ID )
  {
    for($i=0; $i < sizeof($list); $i++ )
    {
      if($list[$i]['ID'] == $ID)
      return $list[$i];
    }
  }

  function deb($var)
  {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }
  
  function printForm()
  {
    $form  =  "<form  method=\"post\" name=\"param\" action=\"".$_SERVER[ 'PHP_SELF' ]."\" >\n";
    $form .=  "<input name=\"a\"           type=\"hidden\" value=\"update\" />\n";
    $form .=  "<input name=\"col\"         type=\"hidden\" />\n";
    $form .=  "<input name=\"val\"         type=\"hidden\" />\n";
    $form .=  "<input name=\"id\"          type=\"hidden\" />\n";
    $form .=  "<input name=\"checksum\"    type=\"hidden\" />\n";
    $form .=  "<input name=\"status\"      type=\"hidden\" />\n";
    $form .=  "<input name=\"filterID\"    type=\"hidden\" />\n";
    $form .=  "</form>\n";
    return $form;
  }
  
  function printVorlesungsverzeichnisHeader()
  {
  
    $html .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
  <html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"de\" lang=\"de\" dir=\"ltr\">
  <head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
  <script src=\"lib/lib.js\" type=\"text/javascript\"></script>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"lib/style.css\" />
  <title>Vorlesungs VZ</title>
  </head>
  <body>
  <h1>Vorlesungs VZ</h1>";
  
  return $html;
  }

}
 function vergleichAufSemSG( $wert_a, $wert_b  ) 
  {
    $pos  = 'semSG';
    $a = $wert_a[$pos];
    $b = $wert_b[$pos];
 
    if ($a == $b)    { $ret = 0;    }
    else             { $ret = ($a < $b) ? -1 : +1; }
  
    return $ret;
  }

  function vergleichAufName( $wert_a, $wert_b ) 
  {
    $pos  = 'name';
    $a = $wert_a[$pos];
    $b = $wert_b[$pos];

    if ($a == $b)    { $ret = 0;    }
    else             { $ret = ($a < $b) ? -1 : +1; }
  
    return $ret;
  }
  
