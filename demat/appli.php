<?php

	define('__ROOT__', dirname(dirname(__FILE__))); 
	require_once './vendor/TesseractOCR/TesseractOCR.php';
	require_once './config.php';
	

	$fact="";
	$nom="";
	$date="";
	$montant="";
	$nomEntre="";

	#Liste le dossier ou il y a les fichiers à traiter
	$dir=__ROOT__."/demat/src/Scan/";
	echo $dir;

	$archive = '/var/www/html/Projet/demat/demat/Archive.csv';

	if (file_exists($archive)) {
		echo "Le fichier Archive.csv existe.";
	} else {
		createCSV();
	}
	
	if (is_dir($dir)) {
		//var_dump($dir);
	   // si il contient quelque chose
	   if ($dh = opendir($dir)) {

	       // boucler tant que quelque chose est trouve
	       while (($file = readdir($dh)) !== false) {

	           // affiche le nom et le type si ce n'est pas un element du systeme
	           if( $file != '.' && $file != '..' ){
	           		// si son type est un file
	           		if(filetype($dir . $file)=="file" )
	           		{
	           			
	           			$name=$file;
	           			$fichier=__ROOT__."/demat/src/Scan/".$file;
	           			// echo "fichier : $file : type : " . filetype($dir . $file) . "<br />\n"; // Donne le nom et le type de fichier traité
	           			$tesseract = new TesseractOCR($fichier);
						$tesseract->setTempDir('/var/www/html/Projet/demat/demat/src/temp/');
						$tesseract->setLanguage('fra'); //same 3-letters code as tesseract training data packages
						$tesseract->setWhitelist(range('A','Z'), range(0,9),'/_-@.',range('a','z'));  
						$text=$tesseract->recognize();
						   

						$temp="/var/www/html/Projet/demat/demat/src/temp/".$file.".txt";
						$_fichier = fopen($temp,"rb");


						//echo $_fichier;
						$chaine="";
             			while(!feof($_fichier))
            		 	{
               				$chaine.=fgetc($_fichier);
             			}
             			fclose($_fichier);
            
			            $_facture="FACTURE";
			            $_facture2="TVA";
			            $_dpd="PRIME";
			            $_dpd2="DEMANDE";
			            $_dal="AIDE";
			            $_dal2="LOGEMENT";
			            $_dal3="DAL";

			            $_morey1="MOREY";
			            $_morey2="tourettes";
			            $_uni1="madelaine";
			            $_uni2="batteries";
						$_ali1="allibert";
						$_ali1="aristides";

			            if (preg_match("/\b{$_facture}\b/i", $chaine) && preg_match("/\b{$_facture2}\b/i", $chaine)){
			              	echo "Trouver Facture ! <br>";
			              	
			              	//image source
			                $src= imagecreatefrompng($fichier);

			                 if (preg_match("/\b{$_morey1}\b/i", $chaine) || preg_match("/\b{$_morey2}\b/i", $chaine)){
			              		echo "Trouver Morey ! <br>";	
			              		//Découpage image pour un numéro de facture Morey
						        $destNumFact=imagecreatetruecolor(300, 60);  						
						        //Découpage image par le nom de facture Morey
						        $destNomFact= imagecreatetruecolor(600, 100);
						        //Découpage image par la date de facture Morey	
						        $destDateFact= imagecreatetruecolor(255, 60); 
						        //Découpage image pour le montant de la facture Morey	
						        $destMontantFact= imagecreatetruecolor(250, 70); 

							 	imagecopy($destNumFact, $src, 0, 0, 80, 1120, 300, 60); // Numero Facture MOREY
							 	$fact=recupFact($file,$destNumFact);
						 		imagecopy($destNomFact, $src, 0, 0, 1280, 530, 600, 100); // Nom MOREY
						 		$nom=recupFact($file,$destNomFact);
								imagecopy($destDateFact, $src, 0, 0, 445, 1120, 255, 60); // DATE MOREY
								$date=recupFact($file,$destDateFact);
								imagecopy($destMontantFact, $src, 0, 0, 2090, 2870, 250, 70); // Montant MOREY
								$montant=recupFact($file,$destMontantFact);
								$nomEntre="MOREY";
								
			                }
			                else if (preg_match("/\b{$_uni1}\b/i", $chaine) || preg_match("/\b{$_uni2}\b/i", $chaine)){
			              		echo "Trouver Uniross ! <br>";	
			              		
			              		//Découpage image pour un numéro de facture UniRoss
						        $destNumFact=imagecreatetruecolor(200, 60);  						
						        //Découpage image par le nom de facture UniRoss
						        $destNomFact= imagecreatetruecolor(600, 48);
						        //Découpage image par la date de facture UniRoss
						        $destDateFact= imagecreatetruecolor(240, 60); 
						        //Découpage image pour le montant de la facture UniRoss	
						        $destMontantFact= imagecreatetruecolor(240, 50); 

							 	imagecopy($destNumFact, $src, 0, 0, 1250, 330, 200, 60); // Numero Facture UniRoss
							 	$fact=recupFact($file,$destNumFact);
						 		imagecopy($destNomFact, $src, 0, 0, 1280, 682, 600, 48); // Nom UniRoss
						 		$nom=recupFact($file,$destNomFact);
								imagecopy($destDateFact, $src, 0, 0, 2000, 330, 240, 60); // DATE UniRoss
								$date=recupFact($file,$destDateFact);
								imagecopy($destMontantFact, $src, 0, 0, 2010, 3210, 240, 50); // Montant UniRoss
								$montant=recupFact($file,$destMontantFact);
								$nomEntre="UNIROSS";
								

			                }
			                else if (preg_match("/\b{$_ali1}\b/i", $chaine) || preg_match("/\b{$_ali2}\b/i", $chaine)){
			              		echo "Trouver Allibert ! <br>";	
 
			              		//Découpage image pour un numéro de facture Allibert
						        $destNumFact=imagecreatetruecolor(330, 100);  						
						        //Découpage image par le nom de facture Allibert
						        $destNomFact= imagecreatetruecolor(750, 260);
						        //Découpage image par la date de facture Allibert
						        $destDateFact= imagecreatetruecolor(270, 50); 
						        //Découpage image pour le montant de la facture Allibert	
						        $destMontantFact= imagecreatetruecolor(300, 90); 

							 	imagecopy($destNumFact, $src, 0, 0, 1570, 50, 330, 100); // Numero Facture Allibert
							 	$fact=recupFact($file,$destNumFact);
						 		imagecopy($destNomFact, $src, 0, 0, 1320, 430, 750, 260); // Nom Allibert
						 		$nom=recupFact($file,$destNomFact);
								imagecopy($destDateFact, $src, 0, 0, 1800, 285, 270, 50); // DATE Allibert
								$date=recupFact($file,$destDateFact);
								imagecopy($destMontantFact, $src, 0, 0, 2040, 3030, 300, 90); // Montant Allibert
								$montant=recupFact($file,$destMontantFact);
								$nomEntre="ALLIBERT";		
										
			                }
							

							
							unlink($file);
           					 unlink($temp);

							update($file,$fact,$date,$nom,$montant,$nomEntre);
              		 		//Place La facture dans le dossier Facture
             				rename($fichier, $dir.'../F/'.$name);


             				echo 'Nom Fichier:'.$file.'    Numero Fact : '.$fact.'   Nom    :'.$nom.'    date:'.$date.'    montant:'.$montant;

			            }
			            elseif(preg_match("/\b{$_dpd}\b/i", $chaine) && preg_match("/\b{$_dpd2}\b/i", $chaine)){
			            	echo "Trouver DPD ! <br>";
			               	rename($fichier, $dir.'../DPD/'.$name);
			               	unlink($temp);
			            }
            			elseif ((preg_match("/\b{$_dal}\b/i", $chaine) && preg_match("/\b{$_dal2}\b/i", $chaine)) || preg_match("/\b{$_dal3}\b/i", $chaine) ) {
              				echo "Trouver DAL ! <br>";
               				rename($fichier, $dir.'../DAL/'.$name);
               				unlink($temp);
            			}
            
          
                	}
               
              	}
            }
       	// on ferme la connection
       	closedir($dh);
       	}
    }
    

    function recupFact($file,$dest){
    	$miniature = $file;

							
		imagepng($dest,$file);
		$tess = new TesseractOCR($file);


		$tess->setTempDir('/var/www/html/Projet/demat/');
		$tess->setLanguage('fra'); //same 3-letters code as tesseract training data packages
		$tess->setWhitelist(range('A','Z'), range(0,9), '_/-@.',range('a','z'));

		$text=$tess->recognize();

    	$temp="/var/www/html/Projet/demat/".$file.".txt";
		$_fichier = fopen($temp,"rb");
		$chaine="";

		while(!feof($_fichier))
 		{
			$chaine.=fgetc($_fichier);
		}

		fclose($_fichier);
		$chaine=trim($chaine);
		unlink($temp);
		return $chaine;
    }

    function createCSV(){

    	$lignes[] = array('Nom Image', 'N° facture', 'Date', 'Nom','Montant','Nom Entreprise');
    	$chemin = '/var/www/html/Projet/demat/Archive.csv';
		$delimiteur = ',';

    	
    	// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'w+');

		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));

		// Boucle foreach sur chaque ligne du tableau
		foreach($lignes as $ligne){
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}

		// fermeture du fichier csv
		fclose($fichier_csv);

    }

    function update($nomImage,$numFact,$date,$nomEntreprise,$montant,$nomEntre){

		$lignes[] = array($nomImage,$numFact,$date,$nomEntreprise,$montant,$nomEntre);

    	$chemin = '/var/www/html/Projet/demat/Archive.csv';
		$delimiteur = ',';

    	
    	// Création du fichier csv (le fichier est vide pour le moment)
		// w+ : consulter http://php.net/manual/fr/function.fopen.php
		$fichier_csv = fopen($chemin, 'a+');

		// Si votre fichier a vocation a être importé dans Excel,
		// vous devez impérativement utiliser la ligne ci-dessous pour corriger
		// les problèmes d'affichage des caractères internationaux (les accents par exemple)
		fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));

		// Boucle foreach sur chaque ligne du tableau
		foreach($lignes as $ligne){
			// chaque ligne en cours de lecture est insérée dans le fichier
			// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
			fputcsv($fichier_csv, $ligne, $delimiteur);
		}

		// fermeture du fichier csv
		fclose($fichier_csv);
    }
