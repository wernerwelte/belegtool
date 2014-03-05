<?php 
//error_reporting(0);
session_start();
include ("checkreferer.php");

if (isset($_SESSION["r"])) 
{
    $role = $_SESSION["r"];

    require_once( "../inc/belegliste.class.php" );
    require_once( "../inc/db.class.php" );
    require_once( "../inc/db.IDM.class.php" );
    require_once( "../inc/vz.data.class.php" );
    require_once( "../inc/vz.render.class.php" );

    $html = "";
    include ("htmlheader.php");
 

    $dbIDM                  = new DBIDM();
    $db                     = new DB( $dbIDM );
    $bl                     = new Belegliste( $db, $dbIDM );
    $data                   = new Data;
    $render                 = new Render;


    $changeable             = $bl->isChangeable();
    $veranstaltungsFilterID = $bl->getFilterID();
    $filterListe            = $bl->getFilterListe();   
    $param                  = $bl->getParams();    
    $gesamtBelegliste       = $db->getGesamtBelegliste();
    $vl_verzeichnis         = $db->getVorlesungsVerzeichnis();

    if( isset ( $param[ 'action' ] ) )
    {  
        $data->logIt( $param[ 'checksum' ].",".$param[ 'filterID' ]);
        $db->setDB( $param, 0 , $gesamtBelegliste, $vl_verzeichnis );
        $vl_verzeichnis     = $db->getVorlesungsVerzeichnis();
        
        $gesamtBelegliste   = $db->getGesamtBelegliste();
    }

    $vl_verzeichnisSort     = $data->sortVorlesungsVerzeichnis($vl_verzeichnis);
    
                                           $html .= $render->printVeranstaltungsMatrix( $vl_verzeichnisSort, $role )."<br />";

    
                                           
    if( $veranstaltungsFilterID != -2)   { $html .= $data->exportBelegliste( $gesamtBelegliste, $vl_verzeichnis,  $veranstaltungsFilterID ); }
    if( $veranstaltungsFilterID == -2)   { $html .= $data->exportHELIOSliste( $gesamtBelegliste , $vl_verzeichnis  ); }
    if( $filterListe )                   { $html .= $data->exportHELIOSliste2( $gesamtBelegliste , $vl_verzeichnis , $filterListe  );    }
    
                                           $html .= $render->printGesamtBelegliste( $gesamtBelegliste , $vl_verzeichnis , $veranstaltungsFilterID, $changeable  ); 
                                           $html .= $render->printSemesterListe( $gesamtBelegliste , $veranstaltungsFilterID  );
                                           $html .= $render->printForm();
                                           $html .= '</body></html>';
    echo $html;
}


else 
{    die("SESSION CLOESED");
}




?>