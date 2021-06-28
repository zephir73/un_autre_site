<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';
?>

<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Brunch Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Brunch.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Brunch_500px.css" type="text/css" /> 
</head>

<body>
<?php
include 'Header.php';
include 'Slide_Brunch.php';
?>



		<article>
		<p id="bru">WEEK-ENDS <b>BRUNCH</b></p>
		<div id="ligne"></div>
		</br>
		<center><p class="titre_gen">LE SAMEDI ET LE DIMANCHE DE 11H A 14H</p></center>
		<center><p><b>Une réservation est conseillée</b></p></center>
		</br>
		</br>
		</br>
		<center><p>Chaque week-end un brunch d'une destination différente
		</br>
		</br>
		Brunch Italien,</br>
		Brunch Américain,</br>
		Brunch Canadien,</br>
		Brunch Mexicain,</br>
		...</p></center>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		
		</article>

<?php
include 'Footer.php';
?>
		   
</body>
</html>