	<?php
	$liveserver = "lernserver.ls.haw-hamburg.de"; # Adresse des Liveservers ohne "www",
	# "www.meine.server.de = meine.server.de"
   
	if ( $_SERVER[ 'SERVER_NAME' ] == $liveserver )
	{   
		# Werte auf Produktivserver einstellen!
		$user 	= "IDM"; 			# Username f�r die MySQL-DB
		$pass 	= "IDMbd"; 		    # Kennwort f�r die MySQL-DB
		$server = "localhost";      # Adresse/IP/Name des MySQL-Server
		$dbase 	= "IDM"; 			# Name der standardm��ig verwendeten Datenbank
	}

	else 
	{
		# Werte auf Entwicklungsserver einstellen!
		$user 	= "IDM"; 			# Username f�r die MySQL-DB
		$pass 	= "IDMbd"; 		    # Kennwort f�r die MySQL-DB
		$server = "localhost";      # Adresse/IP/Name des MySQL-Server
		$dbase 	= "IDM"; 			# Name der standardm��ig verwendeten Datenbank
	}
	
	?>
