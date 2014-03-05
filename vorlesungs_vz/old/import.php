<?php

// Systemeinstellungen
$id = "ID";
$pw = "PW";
$host = "localhost";
$database = "php3-forum";
$table = "news_user";
$datei = "news_user.csv";
// Einstellungen Ende

echo "<html><body>";
if(!$table || !$datei) die("Die Quelle oder das Ziel sind unbekannt");
// Verbindung mit dem Server und einer Datenbank
$conn_id = mysql_pconnect($host,$id,$pw) or die("Verbindung konnte nicht hergestellt werden");
mysql_select_db($database) or die("Die Datenbank konnte nicht gefunden werden");

// ermitteln Namen und Menge der Spalten
$result = mysql_list_fields($database,$table);
for($i=0;$i<mysql_num_fields($result);$i++) {
$spalten .= mysql_field_name($result,$i).",";
}
$anzahl = mysql_num_fields($result);
$spalten = trim(substr($spalten,0,-1));

// leert die Tabelle
mysql_query("DELETE FROM $table") or die(mysql_error());

// liest die Datei ab und überträgt sie zeilenweise in die Tabelle
$fp = fopen($datei,"r"); unset($i);
while(!feof($fp)) {
$zeile = fgets($fp,1024);
if(!$start) { if(count(explode(",",$zeile))!=$anzahl)
die ("Menge der Daten entspricht nicht der Anzahl der Spaltenanzahl"); }
echo $i++."<br>";
$zeile = "'".str_replace(",","','",strstr($zeile,","))."'";
mysql_query("INSERT INTO $table ($spalten) VALUES ($zeile)");
$start=true;
}
fclose($fp);

echo "Import erfolgreich abgeschlossen.<p></p>";
echo "</body></html>";

?>
