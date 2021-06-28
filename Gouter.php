<?php
session_start();
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Goûter Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Gouter.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Gouter_500px.css" type="text/css" /> 
</head>

<body>
<?php
include 'Header.php';
include 'Slide_Gouter.php';
?>

<article>
		<p id="go">LES <b>FORMULES GOUTER</b></p>
		<div id="ligne"></div>
		</br>
		<center><p class="titre_gen">TOUS LES JOURS</p></center>
		</br>
		</br>
		<p id="description" class="description_titre">Cheesecake + Thé Vert ou Noir Nature</br></br></br>
									Cheesecake + Latte Nero</br></br></br>
									Muffin + Chocolat Viennois</br></br></br>
									Pancakes(x3) + Latte Viennois</br></br></br>
									Smoothie + Cookie</br></br></br>
									Brownie + Cappuccino</p></br></br></br></br>
		
		</article>

<?php
include 'Footer.php';
?>
		   
</body>
</html>