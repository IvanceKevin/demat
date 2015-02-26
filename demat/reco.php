<?php

	define('__ROOT__', dirname(dirname(__FILE__))); 

	echo '
			Fichier Original : 
			
			<form method="post" action="reception.php" enctype="multipart/form-data">
			     <label for="mon_fichier">Fichier (TXT | max. 1 Mo) :</label><br />
			     <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
			     Fichier Original : <input type="file" name="original" id="original" /><br />
			     Fichier &agrave; tester :<input type="file" name="test" id="test" /><br />
			     <input type="submit" name="submit" value="Envoyer" />
				</form>';
