<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';



?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Boutique Café J\'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Gestion_Bdd.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<?php

if(isset($_POST['Mise_A_Zero_Bdd']))
{
	if(Mise_A_Zero_Bdd() == true)
	{
		unset($SESSION);
		session_destroy();
		header('location:Login.php?Email=didier.cyprien@gmail.com&Mdp=mdp');
		
	}
	else
	{
		echo('ne doit pas passer');
	}
}

?>
<article> Entête de la zone considérée -->
<?php

if(isset($_SESSION['ID_Droit']))
{
	if($_SESSION['ID_Droit'] == 2)
	{
		echo('<form method="post" formaction="Gestion_Bdd.php" >
		<table class="Mise_A_Zero_Bdd">
			<tr>
				<th>Mise à zéro de la bdd detruit tout sauf :</br>
				-Le compte administrateur</br>
				-La table droit</br>
				-La table état commande</th>
			</tr>
			<tr>
				<td><button type="submit" name="Mise_A_Zero_Bdd" value="Ok">Supprimer</br>les tables</button><td>
			</tr>
		</table>
		</form>');
	}
}
?>
</article>
<!--/*footer*/-->
<?php
include 'Footer.php';
?>
</body>
</html>