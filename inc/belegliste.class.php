<?php
class Belegliste 
{
var $db2;

function Belegliste($db, $dbIDM)
{   
    $this->db2 = $db;  
}

function transSG( $sg )
{
    if( $sg == 913 || $sg == 923 || $sg == 924 || $sg == 967 ) $ret = 'UT'; 
    if( $sg == 925 || $sg == 926 || $sg == 968               ) $ret = 'VT'; 
    if( $sg == 917 || $sg == 917 || $sg == 920               ) $ret = 'BT';     
    if( $sg == 112 || $sg == 971                             ) $ret = 'RE';     
    if( $sg == 904 || $sg == 970                             ) $ret = 'HC'; 
    if( $sg == 921 || $sg == 922                             ) $ret = 'MT'; 
    return $ret;
}

function getStudiengaengeAuswahl( $studiengaenge, $select )                                         //-- Liefert HTML-Auswahlliste mit allen Studiengänen, aktueller Studiengang ist selektiert
{
  $linie = "---------------";
  $list .= "\n\r<select name='studiengang$id' size='1'   onchange='update(\"studiengangID\",this.form.studiengang.options[this.form.studiengang.selectedIndex].value )'>";
  $list .= "\n\r<option value=\"0\">". $linie ."</option>";

  for( $i = 0; $i < sizeof( $studiengaenge )  ; $i++ )
  {
    $studiengang =  $studiengaenge[ $i ];

    if( $studiengang[ 'ID' ] == $select )  $sel = 'selected="selected"';
    else        $sel = '';

    $list .="\n\r<option value=\"". $studiengang[ 'ID' ]."\" $sel>".$studiengang[ 'abk' ]."</option>";
  }

  $list .= "\n\r</select>";
  return $list;
}

function getSemesterAuswahl( $IDMuser )
{
  $IDMuser[ 'semester' ];

  $sel  = '';
  $txt .= "\n\r<select name=\"semester\" size=\"1\" onchange=\"update('semester', this.form.semester.options[this.form.semester.selectedIndex].value, false)\">";
  $txt .= "\n\r<option  value=\"0\">--</option>";

  for( $i = 1; $i < 16; $i++ )
  {
    if( $i == $IDMuser[ 'semester' ] )
    {
      $sel = 'selected="selected"';
    }
    else
    {
      $sel = '';
    }      
  $txt  .="\n\r<option $sel  value=\"$i\">$i</option>";
  }

  if( 16 == $IDMuser[ 'semester' ] )
  {  
    $sel = 'selected="selected"';
  }
  $txt  .=  "\n\r<option $sel  value=\"16\">15+</option>";
  $txt  .=  "</select>";  

  return $txt;
}

function getFachsemesterAuswahl( $IDMuser )
{  
  $IDMuser[ 'semester' ];
  $sel    =  '';
  $txt  .=  "\n\r<select name=\"semester\" size=\"1\" onchange=\"update('semester', this.form.semester.options[this.form.semester.selectedIndex].value, false)\">";
  $txt  .=  "\n\r<option  value=\"0\">--</option>";

  for( $i = 1; $i < 16; $i++ )
  {  if( $i == $IDMuser[ 'semester' ] )
    {  $sel = 'selected="selected"';
    }
    else
    {  $sel = '';
    }      
  $txt  .="\n\r<option $sel  value=\"$i\">$i</option>";
  }

  if( 16 == $IDMuser['semester'] )
  {  $sel = 'selected="selected"';
  }
  $txt  .=  "\n\r<option $sel  value=\"16\">15+</option>";
  $txt  .=  "</select>";  

  return $txt;
}


function getVeranstaltungenAuswahl($belegliste, $veranstaltungen, $select , $id , $IDMuser, $phase = '' )
{   
  $spacer = " -- ";
  $linie = "---------------";
  $list  = "";
  $sel2  = 'selected="selected"';
  $list .= "\n\r<select name='veranstaltung$id' size='1' onchange='update(\"veranstaltungID\",this.form.veranstaltung$id.options[this.form.veranstaltung$id.selectedIndex].value, $id)'>";
  
  if( $select == "-1" )                                                                             // Liste mit ALLEN Veranstaltungen wird erzeugt
  {
    if( sizeof( $veranstaltungen ) > 0 )
    foreach( $veranstaltungen as $va )
    {
      $kursSchonGewaehlt = false;
      
      if( sizeof( $belegliste ) > 0 )
      foreach ( $belegliste as $bl )                                                                // Ermittelt ob die Veranstaltungsgruppe schon gewählt wurde // Dann wird diese Elemente  nicht mehr in die Liste aufgenommen  //
      { 
        if( $va[ 'veranstaltung' ][ 'ID' ]  == $bl[ 'veranstaltung' ][ 'veranstaltung' ][ 'ID' ]  )   
        {  
          $kursSchonGewaehlt = true;
        }
      }
      
      if( !$kursSchonGewaehlt  )
      { if( $IDMuser[ 'semester' ] == 1 )                                                           // Wenn Erstsemester
        {                                                                                           // dann nur Veranstaltungen aus dem 1. Semseter und dem Studiengang des Studenten  
          if($va[ 'semester' ] == 1 && $va['studiengang']['ID'] == $IDMuser['studiengang']  ) 
          {   
            $sel = '';
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\" $sel>".$va[ 'veranstaltung' ]['abk'] ." -> ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " </option>";
          }
        }
        else if( $phase == 2  )                                                                     // Wenn Phase 2
        {                                                                                           // dann nur Veranstaltungen aus dem 1. Semseter 
          if($va[ 'semester' ] == 1 ) 
          {   
            $sel = '';
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\" $sel>".$va[ 'veranstaltung' ]['abk'] ." -> ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " </option>";
          }
        }
        
          
        
        else
        {  
          $sel = '';
          $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\" $sel>".$va[ 'veranstaltung' ]['abk'] ." -> ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " </option>";
        }
      }
    }
  }
    
  else                                                                                              // Liste mit  Veranstaltungen der gleichen Vorlesungstruppe (zB Mat1)  wird erzeugt
  {
    if ( $phase > 1) { $dis = 'disabled="disabled"'; }
    
    if( sizeof($veranstaltungen ) > 0 )
    foreach( $veranstaltungen as $va )
    {
      if( $va[ 'ID' ] == $select  )
      {
        $sel  = 'selected="selected"';
        $sel2 = '';
      }
      else
      {
        $sel = '';
      }
      
      if ( $va['veranstaltung' ][ 'ID' ] == $veranstaltungen[$select]['veranstaltung']['ID'] )
      {      
        if( $IDMuser[ 'semester' ] == 1  )                                                          // Wenn Erstsemester
        {                                                                                           // dann nur Veranstaltungen aus dem 1. Semseter und dem Studiengang des Studenten  
          if( $va[ 'studiengang' ][ 'ID' ] == $IDMuser[ 'studiengang' ] ) 
          {
            $sel = '';
            $sel  = 'selected="selected"';
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\"  $dis  $sel>".$va[ 'veranstaltung' ]['abk'] ." ->  ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " </option>";
          }
        }
        else
        {  
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\"  $dis  $sel>".$va[ 'veranstaltung' ]['abk'] ." ->  ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. "</option>";
        }        
      }
    }
  }

  $list .= "\n\r<option value=\"-1\" $dis $sel2>".$linie ."</option>";
  $list .= $list_tmp;
  $list .= "\n\r</select>";
  
  return $list;
}


function getVeranstaltungen($belegliste, $veranstaltungen, $select , $id , $IDMuser)
{   
  $spacer = " -- ";
    $linie = "---------------";
    $list  = "";
  if( $select =="-1" )                                                                              // Liste mit ALLEN Veranstaltungen wird erzeugt
  {
    if( sizeof( $veranstaltungen ) >0 )
    foreach( $veranstaltungen as $va )
    {
      $kursSchonGewaehlt = false;
      if( sizeof( $belegliste ) >0 )
      foreach ( $belegliste as $bl )                                                                // Ermittelt ob die Veranstaltungsgruppe schon gewählt wurde // Dann wird diese Elemente  nicht mehr in die Liste aufgenommen  //
      { 
        if( $va[ 'veranstaltung' ][ 'ID' ]  == $bl[ 'veranstaltung' ][ 'veranstaltung' ][ 'ID' ]  )   
        {  
          $kursSchonGewaehlt = true;
        }
      }
      
      if( !$kursSchonGewaehlt  )
      {   

  
        if( $IDMuser[ 'semester' ] == 1)                                                            // Wenn Erstsemester
        {                                                                                           // dann nur Veranstaltungen aus dem 1. Semseter und dem Studiengang des Studenten  
          if($va[ 'semester' ] == 1 && $va['studiengang']['ID'] == $IDMuser['studiengang']  ) 
          {
            $sel = '';
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\" $sel>".$va[ 'veranstaltung' ]['abk'] ." -> ( ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " )</option>";
          }
        }
        else
        {
          $sel = '';
            $list_tmp .="\n\r<option value=\"". $va[ 'ID' ]."\" $sel>".$va[ 'veranstaltung' ]['abk'] ." -> ( ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk']. " )</option>";
        }
      }
    }
  }
    
  else                                                                                              // Liste mit  Veranstaltungen der gleichen Vorlesungstruppe (zB Mat1)  wird erzeugt
  {
    if(sizeof($veranstaltungen)>0)
    foreach($veranstaltungen as $va)
    {
      if( $va[ 'ID' ] == $select  )
      {
        $sel  = 'selected="selected"';
        $sel2 = '';
      }
      else
      {
        $sel = '';
      }
      
      if ( $va[ 'ID' ] == $select  && $va['veranstaltung' ][ 'ID' ] == $veranstaltungen[$select]['veranstaltung']['ID'] )
      {      
            $list_tmp2 .="\n\r". $va[ 'veranstaltung' ]['abk'] ." -> ( ". $va[ 'studiengang' ]['abk']  ." / ". $va[ 'professor' ]['abk'].")<br>" ;
      }
    }
  }

  $list .= "\n\r<span >";
  $list .= $list_tmp2;
  $list .= "\n\r</span >";
  
  return $list;
}

function removeElement( $veranstaltung, $select )                                                   // Entfernt ausgwähltes Element aus dem Array
{
    for ( $i = 0; $i < sizeof( $veranstaltung );  $i++ )
  {   
    if ( $veranstaltung[ $i ][ 'ID' ] == $select )
    {  
      unset( $veranstaltung[ $i ] );
    }
  }
   return   $veranstaltung;
}

function  getBeleglistenAuswahl( $belegliste, $vl_verzeichnis, $IDMuser, $phase = 0 )
{
    
    $contentA = "[".$phase."] ";
    if ( $phase == 2 )                                                                                 // Belegungszeitraum 2 ( nur noch Veranstaltungen des 1. Semester ) hat begonnen 
    {
        $contentA .= "<div style='width:100%; color:#FFFFFF; background-color:#880000; padding:0px; text-align:center;'>Belegung nur noch für Veranstaltungen des <br/>1. Semesters möglich.</div>";
    }
    
    if ( $phase > 0 )                                                                                // Normaler Belegungszeitraum  ( alle Veranstaltungen wählbar )  
    {    
        $contentA .= "<strong>Ihre Wunschbelegung</strong><br /><hr />";
        
        if( sizeof( $belegliste ) > 0 )
        foreach( $belegliste as $bl )
        {  
          
            if ( $phase > 3 && $bl[ 'status' ] != "B"  )  
            {}
            else
            {   
              $bid       = $bl[ 'ID' ];
              $select    = $bl[ 'veranstaltungID' ];

              if ( $bl[ 'status' ] == "B" ) { $style = "beleggeBucht"; }    
              else                          { $style = "belegWunsch";  }    

              $contentA .= "<div class=\"".$style."\">";
              $contentA .= $this->getVeranstaltungenAuswahl( $belegliste, $vl_verzeichnis, $select, $bid,  $IDMuser, $phase );
              if ( ( $IDMuser[ 'semester' ] > 1 &&  $phase ==  2  || $phase >  2  ) && $bl[ 'status' ] == "B") 
              { $contentA .= ""; }
              else
              { $contentA .= "<input class=\"delItem\" src=\"pix/m.png\"  id=\"delItem\"  onclick=\"update('delete',false,$bid); return false;\"  alt=\"DELETE\" title=\"DELETE\"  type=\"image\">\n\r";
              }
              $contentA .= " ".$bl[ 'status' ]."</div>";
              $contentA .= "\n\r<hr />";
              $veranstaltungen = $this->removeElement( $veranstaltungen, $select );
            }
        }
        $contentA .= "</div>";
    }
    else
    {
      $contentA .= "<div style='width:100%; color:#FFFFFF; background-color:#880000; padding:0px; text-align:center;'>z.Zt keine Belegung möglich</div>";
    }
    
  return $contentA;
}

function  getBelegliste( $belegliste, $vl_verzeichnis, $IDMuser )
{
  $contentA .= "<strong>Ihre Belegung</strong><br /><hr />";
  if( sizeof($belegliste) > 0 )
  foreach( $belegliste as $bl )
  { 
    $bid     = $bl[ 'ID' ];
    $select  = $bl[ 'veranstaltungID' ];

    if( $bl[ 'status' ] == "B" )
    {
      $style = "beleggeBucht";
    }    
    else
    {
      $style = "beleggeBucht";
    }    

    $contentA .= "<div class=\"".$style."\">";
       $contentA .= $this->getVeranstaltungen( $belegliste, $vl_verzeichnis, $select, $bid,  $IDMuser );
    $contentA .= "</div>";
    $contentA .= "\n\r<hr />";
  }
  $contentA .= "</div>";
  return $contentA;
}



function  getVorlesungsAuswahl( $belegliste, $vl_verzeichnis, $IDMuser )
{
  if( sizeof( $belegliste ) > 0 )
  foreach( $belegliste as $bl )
  { 
    $bid   = $bl[ 'ID' ];
    $select = $bl[ 'veranstaltungID' ];

    if( $bl['status'] == "B")
    {
      $style = "beleggeBucht";
    }    
    else
    {
      $style = "belegWunsch";
    }    

    $contentA .= "<div class=\"".$style."\">";
    $contentA .= $this->getVeranstaltungenAuswahl( $belegliste, $vl_verzeichnis, $select, $bid,  $IDMuser );

    $contentA .= "<input class=\"delItem\" src=\"pix/m.png\"  id=\"delItem\"  onclick=\"update('delete',false,$bid); return false;\"  alt=\"DELETE\" title=\"DELETE\"  type=\"image\">\n\r";
    $contentA .= "</div>";
    $contentA .= "\n\r<hr />";
      $veranstaltungen = $this->removeElement( $veranstaltungen, $select );
  }
  $contentA .= "</div>";
  return $contentA;
}


function getParamForm( $IDMuser )
{
  $form .= "";
  $form .=  "<form  method=\"post\"      name=\"param\" action=\"".$_SERVER[ 'PHP_SELF' ]."\" >\n";
  $form .=  "<input name=\"a\"           type=\"hidden\" value=\"update\" />\n";
  $form .=  "<input name=\"col\"         type=\"hidden\" />\n";
  $form .=  "<input name=\"val\"         type=\"hidden\" />\n";
  $form .=  "<input name=\"id\"          type=\"hidden\" />\n";
  $form .=  "<input name=\"checksum\"    type=\"hidden\" />\n";
  $form .=  "<input name=\"semester\"    type=\"hidden\" value=\"".$IDMuser[ 'semester' ]."\"/>\n";
  $form .=  "<input name=\"studiengang\" type=\"hidden\" value=\"".$IDMuser[ 'studiengang' ] ."\"/>\n";
  $form .=  "<input name=\"matrikelnr\"  type=\"hidden\" value=\"".$IDMuser[ 'matrikelnr' ]  ."\"/>\n";
  $form .=  "<input name=\"akennung\"    type=\"hidden\" value=\"".$IDMuser[ 'akennung' ]  ."\"/>\n";
  $form .=  "</form>\n";
  return $form;
}

function getJavaScript()
{
return "<script type=\"text/javascript\">
function update(col  ,value, id)
{   
  checksum    =\"\";
  akennung    = document.param.akennung.value    =  document.belegliste.akennung.value;
  matrikelnr  = document.param.matrikelnr.value  =  document.belegliste.matrikelnr.value;

  if(id)
  {
    veranstaltungID = eval(\"document.belegliste.veranstaltung\"+ id +\".value\");
    checksum = akennung + \";\"+veranstaltungID + \";\"+ matrikelnr;
  }

  document.param.col.value      = col;
  document.param.val.value      = value;
  document.param.id.value       = id;
  document.param.checksum.value = checksum; 
  document.param.submit();
}
</script>
";

}


function getstudiverwaltunghtmlhead()
{
 return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- script src="lib/lib.js" type="text/javascript"></script -->
<link rel="stylesheet" type="text/css" href="lib/style.css" />
<title>Belegliste</title></head>
<body style="margin:0; padding:0;" ><div style="width:220px">';
}


function getAddNewEntryButton( $phase = 1 )
{
  if ( $phase >= 1 && $phase <= 3  )
  {
    return "\n\r<a  href=\"#\" class=\"addItem\" id=\"addItem\"  onclick=\"update('neuerBeleglistenEintrag',false,false); return false;\"  alt=\"ADD\" title=\"ADD\"  type=\"image\">Neuer Eintrag <img  border=\"0\" src=\"pix/p.png\"></a>\n\r";
  }
}

function getFilterID()
{
    if    ( isset( $_POST[ 'filterID' ] ) )                    { $veranstaltungsFilterID = $_POST[ 'filterID' ]; } 
    elseif( isset( $_GET[ 'F'         ] ) )                    { $veranstaltungsFilterID = $_GET[ 'F' ];         } 
    elseif( isset( $_POST[ 'filterID' ] )  || (isset ( $_POST[ 'F' ]) ) ) {} 
	else { $veranstaltungsFilterID =  -1;                  } 
    return $veranstaltungsFilterID ;
}

function getFilterListe()
{
    $filterListe = null;

   // print_r($_POST);
    
    if ( isset ($_POST[ 'SUB' ] ))                                              /* Ermittelt die angeklickten Felder für den HELIOS Export und erstellt die entsprechende Filterliste */  
    {    foreach ( $_POST as $P )
        {    if( $P != "-SELECTED-" )
            {    $filterListe[] =  $P ;
            }
        } 
    }

    
    return $filterListe;
  
}


function isChangeable()
{
    if( $_SESSION["r"] >= 4 ) { $changeable    = true; }
    else                      { $changeable    = false; }
    return $changeable;
}


function getParams()
{
   $param = '';
   
   if ( isset( $_POST[ 'a'        ] ) ) $param[ 'action'   ] = $_POST[ 'a'        ];
   if ( isset( $_POST[ 'col'      ] ) ) $param[ 'column'   ] = $_POST[ 'col'      ];
   if ( isset( $_POST[ 'val'      ] ) ) $param[ 'value'    ] = $_POST[ 'val'      ];
   if ( isset( $_POST[ 'id'       ] ) ) $param[ 'ID'       ] = $_POST[ 'id'       ];
   if ( isset( $_POST[ 'checksum' ] ) ) $param[ 'checksum' ] = $_POST[ 'checksum' ];
   if ( isset( $_POST[ 'filterID' ] ) ) $param[ 'filterID' ] = $_POST[ 'filterID' ];
   
   return $param;
}

function deb($var)
{   echo "<pre>";
    print_r($var);
    echo "</pre>";
}
/*
---- DATENSTRUKTUREN  -----
-----------------------------------------
$_POST
-----------------------------------------
Array
(
    [a] => update
    [col] => studiengangID
    [val] => 5
    [id] => undefined
    [checksum] => 
    [semester] => 2
    [studiengang] => 5
    [akennung] => 1234567
    [mail] => 
    [vorname] => 
    [nachname] => 
)

-----------------------------------------
$PARAM
-----------------------------------------
Array
(
    [action] => update
    [column] => studiengangID
    [value] => 5
    [ID] => undefined
    [sum] => 
)

-----------------------------------------
$IDMuser
-----------------------------------------
Array
(
    [ID] => 1
    [akennung] => 1234567
    [vorname] => Studi
    [nachname] => Student
    [studiengang] => 1
    [semester] => 2
    [mail] => studi.student@haw-hamburg.de
)

*/
}
?>
