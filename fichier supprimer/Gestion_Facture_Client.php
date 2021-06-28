<?php
session_start();
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Etat_Commande = array();
$List_Etat_Commande = Lecture_Etat_Commande();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Boutique Café J\'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/...css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
<form method="post">
<table class="Recherche_Commande">
	<tr>
		<th>numéro de facture</th>
		<th>nom client</th>
		<th>statut de la commande</th>
	</tr>
	<tr>
		<td><input type="text" name="ID_Commande"></td>
		<td><input type="text" name="Nom_Client"></td>
		<?php
		echo('<td><select name="Etat_Commande">');
		foreach ($List_Etat_Commande as $value)
		{
			echo('<option value="'.$value->Id_Etat_Commande_get().'">'.$value->Etat_Commande_get().'</option>');
		}
		echo('</select></td>');
		?>
	</tr>
	<tr>
		<td><button type="submit"formaction="Recherche_Commande_Resultat.php">Recherche</button></td>
		<td>Recherche par numéro de commande </br> nom de client et</br> par statut uniquement</td>
	</tr>
</table>
</form>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>