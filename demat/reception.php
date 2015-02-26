<?php

	$dico = array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
		'0','1','2','3','4','5','6','7','8','9');

	$chaine_original="";

	$chaine_test="";
	$ca_original=0;
	$ca_test=0;
	$ca_correcte=0;
	$ca_non_correcte=0;
	// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur

	if ((isset($_FILES['original']) AND $_FILES['original']['error'] == 0) && (isset($_FILES['test']) AND $_FILES['test']['error'] == 0))
	{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['monfichier']['size'] <= 1000000)
        {
 			$_fichier = fopen($_FILES['original']['tmp_name'],"rb");
 			while(!feof($_fichier))
		 	{
		 		$ca_original++;
   				$chaine_original.=fgetc($_fichier);
 			}
 			fclose($_fichier);
 			$_fichier2 = fopen($_FILES['test']['tmp_name'],"rb");
			while(!feof($_fichier2))
		 	{
		 		$ca_test++;
   				$chaine_test.= fgetc($_fichier2);
 			}
 			fclose($_fichier2);
        }
        $chaine_original=trim($chaine_original, " \t\n\r\0\x0B");
		$chaine_test=trim($chaine_test, " \t\n\r\0\x0B");

		$error=0;
        for($i=0; $i<=61;$i++){
        	$find_cara=0;
        	for($j=0; $j<=strlen($chaine_test);$j++){
        		if($dico[$i]==$chaine_test[$j]){
        		//	echo $dico[$i]. " : ";
        			$find_cara++;	
        			
        		}
        		else{
        	//		echo $chaine_original[$i]. " : " .$chaine_test[$i] ."<br>";  			
        		}
        	//	echo $chaine_test[$j]. "<br>";
        	}
        	//echo " r&eacute;sultat : ".$find_cara ."<br>";

        	$error=$error+abs((28-$find_cara));
        }        
	}
	echo "Nombre de caract&egrave;res originaux : ". $ca_original ."<br>";
	echo "Nombre de caract&egrave;res du test OCR :". $ca_test ."<br>";
	if($ca_test>=$ca_original){
		$error=$error+($ca_test-$ca_original);
	}
	elseif($ca_original>$ca_test){
		$error=$error+($ca_original-$ca_test);
	}
	echo "Nombre d erreurs : ". $error ."<br>";


