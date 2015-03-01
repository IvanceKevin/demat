<b><h1>Introduction :</h1></font></b>

Cette étude porte sur la mise en œuvre d’un processus dématérialisation de documents dans le contexte
d’un donneur d’ordre. Ces donneurs d’ordre sont dans notre cas une administration qui souhaite
dématérialiser son courrier entrant, le numériser, le transmettre aux services concernés pour traitement et
alimentation du système d’information de la dite administration.
Actuellement, cette administration reçoit chaque jours entre 100 et 500 lettres de types très différents :
- Des “ Factures correspondant à 3 fournisseurs “ 
- Des “ Demande d’Aide au Logement ” 
- Des “ Demande Prime de déménagement ” 

Afin de simplifier l’étude, les corpus exemples sont proposés en annexe. Les factures sont déjà numérisées.
Les formulaires sont quant à eux disponibles pour numérisation

Nous allons donc développer un programme PHP permettant : 
- Calculer le taux d'erreurs des différents OCRs.
- De répartir ces documents dans leurs dossier.
- Pour les factures : récupérer certaines informations pour les insérer dans un fichier csv qui fera office de base de données.

<b><h1>Choix et test des OCRs :</h1></font></b>

Pour le choix de notre logiciel de reconnaissance optique de caractères (OCR), un fichier VT de type docx nous a été fournit pour tester la cohérence des caractères de sorties de chaque OCR.

- 6 images au format tiff de qualités différentes nous ont été fournit pour tester les résultats de l’OCR.
        -> Dans le dossier images

Nous avons tester les images sur de 2 OCRs différents :
- FreeOCR
- TesseractOCR

Vous pouvez voir les résultats des différents OCRs dans le dossier /demat/reconnaissance/

Pour mesurer le taux de performances et erreurs on doit catégoriser les erreurs. Dans notre cas nous avons utilisé :
- Rejet : un caractère non reconnu mais détecté
- Substitution : un caractère pris pour un autre
- Omission : un caractère est perdu
- Ajout : un caractère détecté par erreur

Puis utiliser les formules suivantes : 
    Err : Rejet+Substitution+Omission+Ajout
    N = Nombre de caractères

- Taux d’erreur = Err/N
- Taux de reconnaissance N = ( N - Err ) / N

*Le fichier VT contient 1821 caractères de “A-Z”, “a-z”, “0,1-9”.

Vous pouvez utilisé notre application qui compte le nombre de caractères présents, et le nombre d’erreurs dans un fichier txt.

url : http://127.0.0.1/Projet/demat/demat/reco.php

TABLEAU A FAIRE 


On peut en déduire que TesseracteOCR est meilleur que FreeOCR avec un meilleur taux de reconnaissance et un faible taux d’erreurs.

Nous avons donc utilisé comme OCR “TesseractOCR” pour pouvoir catégoriser les documents.

Pour installer TesseractOCR sur n’importe quels système d’exploitation veuillez utiliser l’adresse suivant :

https://code.google.com/p/tesseract-ocr/








