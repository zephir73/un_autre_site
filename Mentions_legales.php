<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Mentions legales Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Mentions_legales.css" media="screen" rel="stylesheet" type="text/css"/>
</head>

<body>
<?php
include 'Header.php';
?>
		<article>
		<h1><b style="font-family:'Ailerons';">MENTIONS LEGALES</b></h1>
		<div id="ligne"></div>
		</br>
		<!--<center><p class="description_titre">MENTIONS LEGALES</p></center>-->
		<h2>Propriété du site</h2>
		<p>Le présent site est la propriété de :
		</br>
		CAFE J’ADORE</br>
		46 Montée de la grande côte</br>
		69001 LYON</br>
		</br>
		Capital social : 5 000,00€</br>
		</br>
		Téléphone</br>
		09.81.73.29.04</br>
		06.69.99.10.20</br>
		</br>
		Mail</br>
		<a href="info@cafejadore.fr">info@cafejadore.fr</a></br>
		Commerce de détail de boissons en magasin spécialisé (4725Z)</br>
		RCS : Lyon B 514 721 026</br>
		Répertoire des métiers sous le n°5610CQ</br>
		<h2>Responsabilité éditoriale</h2>
		CYPRIEN Didier (Stagiaire)</br>
		<h2>Hébergeur du site :</h2>
		L'hébergement du présent site est assuré par : </br>
		<a href="https://www.1and1.fr/">https://www.1and1.fr/</a></br>
		1&1 Internet SARL</br>
		7, place de la gare</br>
		BP 70109</br>
		57201 Sarreguemines Cedex</br>
		Contact</br>
		Vous pouvez joindre le service clientéle par téléphone 24h/24,7j/7 au 09 70 80 89 11</br>
		Appel non surtaxé ou via le formulaire de contact : <a href="http://assistance.1and1.fr/contact">http://assistance.1and1.fr/contact</a></p>
		</br>
		</br>
		
		</article>
		
<?php
include 'Footer.php';
?>

</body>
</html>