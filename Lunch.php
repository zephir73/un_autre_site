<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Lunch Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Lunch.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Lunch_500px.css" type="text/css" /> 
</head>

<body>
<?php
include 'Header.php';
include 'Slide_Lunch.php';
?>


<article>
		<p id="lu">LES <b>FORMULES LUNCH</b></p>
		<div id="ligne"></div>
		</br>
		<center><p class="titre_gen">DU LUNDI AU VENDREDI JUSQU'A 15H</p></center>
		</br>
		<ul><p class="description_titre">Rustique</p>
			<li><p>Sandwich ou wrap + Dessert ou Boisson</br>
				Sandwich ou wrap + Dessert + Boisson<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Light</p>
			<li><p>Salade ou pâtes + Dessert ou Boisson</br>
				Salade ou pâtes + Dessert + Boisson<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Américain</p>
			<li><p>Bagel ou bun + Dessert ou boisson</br>
				Bagel ou bun + Dessert + boisson<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Italien</p>
			<li><p>Panini ou focaccia + Dessert ou Boisson</br>
				Panini ou focaccia + Dessert + Boisson<p></li>
		</ul>
		</br>
		
		
		</article>

<?php
include 'Footer.php';
?>
		   
</body>
</html>