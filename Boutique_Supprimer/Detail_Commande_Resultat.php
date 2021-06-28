<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Article = array();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Detail Commande Resultat Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Detail_Commande_Resultat.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
<?php
if(isset($_POST['ID_Commande']))
{
	$List_Article = Lecture_Commande_Article($_POST['ID_Commande']);
	echo('<h1><center>Voici le détail du panier de la commande n=°'.$_POST['ID_Commande'].' de Mr '.$_POST['Nom_Client'].'</center></h1>');
}
else
{
	if(isset($_GET['ID_Commande']))
	{
		$List_Article = Lecture_Commande_Article($_GET['ID_Commande']);
		echo('<h1><center>Voici le detail du panier de la commande n=°'.$_GET['ID_Commande'].' de Mr '.$_GET['Nom_Client'].'</center></h1>');
	}
}
foreach ($List_Article as $value)
{
	echo('<table class="Detail_Commande_Resultat">');
	echo('<tr>');
	echo('<th>Nom Article</th>');
	echo('<th>Description Article</th>');
	echo('<th>Prix Article</th>');
	echo('<th>Image Article</th>');
	echo('<th>Nombre Article</th>');
	echo('</tr>');
	echo('<tr>');
	echo('<td>'.$value->Nom_Article_get().'</td>');
	echo('<td>'.$value->Description_Article_get().'</td>');
	echo('<td>'.$value->Prix_Article_get().'</td>');
	echo('<td><img src='.$value->Chemin_Image_get().' alt='.$value->Nom_Article_get().' height="100" width="100"></td>');
	echo('<form method="post">');
	if(isset($_POST['ID_Commande']))
	{
		echo('<input type="hidden" name="ID_Commande" value="'.$_POST['ID_Commande'].'">');
		echo('<input type="hidden" name="Nom_Client" value="'.$_POST['Nom_Client'].'">');
	}
	else
	{
		if(isset($_GET['ID_Commande']))
		{
			echo('<input type="hidden" name="ID_Commande" value="'.$_GET['ID_Commande'].'">');
			echo('<input type="hidden" name="Nom_Client" value="'.$_GET['Nom_Client'].'">');
		}
	}
	echo('<input type="hidden" name="ID_Article" value="'.$value->ID_Article_get().'">');
	echo('<td><input type="number" name="qte" value="'.$value->Nb_Article_get().'" min="1"></td>');
	echo('</tr>');
	echo('<tr>');
	echo('<td>rien</td>');
	echo('<td>rien</td>');
	echo('<td>rien</td>');
	echo('<td>rien</td>');
	echo('<td><button type="submit" formaction="fonction/Modification_Nb_Article_Commande.php" name="btn_raf">rafraîchir</button></td>');
	echo('</form>');
	echo('</tr>');
	echo('</table>');
}
echo('<form>');
echo('<button type="submit" formaction="Gestion_Commande_Client.php">Retour Modification Suppression commande client</button>');
echo('</form>');
?>
</article>
<!--/*footer*/-->
<?php
include 'Footer.php';
?>
</body>
</html>