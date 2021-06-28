<?php
session_start();
// charge tout les fichiers utiliser pour le site
include 'Fichier_Require.php';
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Breakfast Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Breakfast.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Breakfast_500px.css" type="text/css" />
</head>

<body>
<?php
include 'Header.php';
include 'Slide_Breakfast.php';
?>

		
        <article>
		<p id="br">LES <b>FORMULES BREAKFAST</b></p>
		<div id="ligne"></div>
		</br>
		<center><p class="titre_gen">TOUS LES MATINS</p></center>
		</br>
		<ul><p class="description_titre">Breakfast Paris</p>
			<li><p>Jus d'oranges pressées + Americano + Pain au Chocolat ou Croissant<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast Boston</p>
			<li><p>Jus d'oranges pressées + Caffè Latte + Pancakes(x3)<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast Lyon</p>
			<li><p>Jus d'oranges pressées + Thé Vert ou Noir Nature + Pain au Chocolat ou Croissant<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast Miami</p>
			<li><p>Pancakes(x3) + Cappuccino + Jus Artisanal Alain Milliat (25cl)<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast New York</p>
			<li><p>Muffin + Cappuccino<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast San Francisco</p>
			<li><p>Bagel Beurre Confiture + Expresso<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast Montréal</p>
			<li><p>Pancakes(x3) + Latte Nero<p></li>
		</ul>
		</br>
		<ul><p class="description_titre">Breakfast Londres</p>
			<li><p>Cookie + Jus Artisanal Alain Milliat(25cl)<p></li>
		</ul>
		</br>
		</br>
		
		</article>
        
<?php
include 'Footer.php';
?>        
   
</body>
</html>