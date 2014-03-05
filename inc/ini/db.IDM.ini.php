	<?php
	$liveserver = "lernserver.ls.haw-hamburg.de"; # Adresse des Liveservers ohne "www",
	# "www.meine.server.de = meine.server.de"
   
	if ( $_SERVER[ 'SERVER_NAME' ] == $liveserver )
	{   
		# Werte auf Produktivserver einstellen!
		$user 	= "IDM"; 			# Username für die MySQL-DB
		$pass 	= "IDMbd"; 		    # Kennwort für die MySQL-DB
		$server = "localhost";      # Adresse/IP/Name des MySQL-Server
		$dbase 	= "IDM"; 			# Name der standardmäßig verwendeten Datenbank
	}

	else 
	{
		# Werte auf Entwicklungsserver einstellen!
		$user 	= "IDM"; 			# Username für die MySQL-DB
		$pass 	= "IDMbd"; 		    # Kennwort für die MySQL-DB
		$server = "localhost";      # Adresse/IP/Name des MySQL-Server
		$dbase 	= "IDM"; 			# Name der standardmäßig verwendeten Datenbank
	}
	
	?>
