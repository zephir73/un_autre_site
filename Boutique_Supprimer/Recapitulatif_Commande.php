<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';
$List_Client = array();
$List_Commande_Client = array();
$List_Commande = array();
$List_Article = array();
$tmp = 0;
$Prix_Article_Total = 0;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Recapitulatif Commande Café J\'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Recapitulatif_Commande.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
<?php

if(isset($_SESSION['ID_Droit']) && ($_SESSION['ID_Droit'] == 2))
{
	$List_Client = Lecture_Client();
	
	foreach($List_Client as $client)
	{
		$List_Commande_Client = Recherche_Commande(0,$client->Email_Client_get(),1);
		
		foreach($List_Commande_Client as $value)
		{
			$commande = new Commande();
			$commande->Id_Commande_set($value->Id_Commande_get());
			$commande->Date_Commande_set($value->Date_Commande_get());
			$commande->Total_Commande_set($value->Total_Commande_get());
			$commande->Id_Client_set($value->Id_Client_get());
			$commande->Id_Etat_Commande_set($value->Id_Etat_Commande_get());
			$commande->Id_Transporteur_set($value->Id_Transporteur_get());
			
			array_push($List_Commande,$commande);
		}
		
		
		
	}
}
else
{
	$List_Commande = Recherche_Commande(0,$_SESSION['Email_Client'],1); // 1 payer, 2 pas payer, 3 en cours
	rsort($List_Commande);// trie la liste par id_commande dans le sens decroissant 
}




if(count($List_Commande) <=0)
{
	echo('Pas de commande a afficher '.$_SESSION['Nom_Client'].' '.$_SESSION['Prenom_Client']);
}
else
{
	//echo('<h1>Commande de '.$_SESSION['Nom_Client'].' '.$_SESSION['Prenom_Client'].' :</h1>');
	

	foreach($List_Commande as $value)
	{
		$List_Client = Lecture_Client_Id($value->Id_Client_get());
		
		foreach($List_Client as $client)
		{
			echo('<h1>Commande de '.$client->Nom_Client_get().' '.$client->Prenom_Client_get().' :</h1>');
		}
		
		$tmp = 0;
		$Prix_Article_Total = 0;
		echo('<table class="Recap_Commande">');
		echo('<tr>');
		echo('<th>Commande n=° :</th>');
		echo('<th>Date de la commande :</th>');
		echo('<th>Articles :</th>');
		echo('<th>Image Articles :</th>');
		echo('<th>Quantitée :</th>');
		echo('<th>Prix Unitaire</th>');
		echo('<th>Prix total par article</th>');
		echo('</tr>');
		echo('<tr>');
		echo('<td>'.$value->Id_Commande_get().'</td>');
		echo('<td>'.$value->Date_Commande_get().'</td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('</tr>');
		
		$List_Article = Lecture_Commande_Article($value->Id_Commande_get());
		foreach($List_Article as $value2)
		{
			echo('<tr>');
			echo('<td></td>');
			echo('<td></td>');
			echo('<td>'.$value2->Nom_Article_get().'</td>');
			echo('<td><img src="'.$value2->Chemin_Image_get().'" alt="'.$value2->Nom_Article_get().'" height="42" width="42"></td>');
			echo('<td>'.$value2->Nb_Article_get().'</td>');
			echo('<td>'.$value2->Prix_Article_get().' €</th>');
			$tmp = $value2->Nb_Article_get() * $value2->Prix_Article_get();
			echo('<td>'.$tmp.' €</td>');
			echo('</tr>');	
			$Prix_Article_Total += $tmp;
		}
		
		echo('<tr>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td>Total article :</td>');
		echo('<td>'.$Prix_Article_Total.' €</td>');
		echo('</tr>');
		
		echo('<tr>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td>Total frait de port :</td>');
		$tmp = $value->Total_Commande_get() - $Prix_Article_Total;
		echo('<td>'.$tmp.' €</td>');
		echo('</tr>');
		
		echo('<tr>');
		echo('<td>Réediter la facture :</td>');
		echo('<form action="Facture_Client_Reedition.php" method="post">');
		echo('<input type="hidden" name="Id_Commande" value="'.$value->Id_Commande_get().'">');
		echo('<td><input type="submit" value="Facture" name="Facture"></td>');
		echo('</form>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td></td>');
		echo('<td>Total :</td>');
		echo('<td>'.$value->Total_Commande_get().' €</td>');
		echo('</tr>');
		
		echo('</table>');
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