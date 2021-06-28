<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';



$id_client=0;
$List_Commande = array();
$List_Facture = array();
$List_Article = array();
$id_commande = 0;

$tmp = 0;
$prix_unitaire_ht = 0;
$prix_unitaire_ttc = 0;
$prix_total_article_ht = 0;
$prix_total_article = 0;
$montant_tva_55 = 0;
$montant_tva_20 = 0;


$prix_article = 0;
$montant_ht = 0;
$montant_ttc = 0;
$nb_article_total = 0;



?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Facture Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css"/>
		<link href="css/Facture_Client.css" media="screen" rel="stylesheet" type="text/css"/>
		<link href="css/Print.css" media="print" rel="stylesheet" type="text/css"/>
</head>
<?php
include 'Header.php';
?>
<?php

if(isset($_SESSION['id_commande']) && !isset($_POST['ID_Commande_Client']))
{
	$id_commande = $_SESSION['id_commande'];
	$etat_commande = $_SESSION['id_etat_commande'];
	$List_Commande = Recherche_Commande($id_commande,$_SESSION['Email_Client'],$etat_commande);// 1 commande doit etre lu
	$List_Facture = Recherche_Facture($id_commande);

}
else
{
	if(isset($_POST['ID_Commande_Client']))
	{
		$id_commande = $_POST['ID_Commande_Client'];
		$etat_commande = 1;// payer
		$List_Commande = Recherche_Commande($id_commande,$_SESSION['Email_Client'],$etat_commande);// 1 commande doit etre lu
		$List_Facture = Recherche_Facture($id_commande);
	}
	else
	{
		// si la page se fait recharger ou autre
		echo ('<script language="Javascript">
			<!--
			document.location.replace("index.php");
			// -->
			</script>');			
	}
}


?>
<body>
<article>
<?php

foreach ($List_Facture as $value)
{
	echo('<p>Facture n=°: '.$value->Id_Facture_get().'</p>');
	echo('<p>Date : '.$value->Date_Facture_get().'</p>');
	foreach($List_Commande as $value2)
	{
		echo('<p>Numéro client : '.$value2->Id_Client_get().'</p>');
		echo('<p>Commande n=° : '.$value2->Id_Commande_get().'</p></br>');
		$id_client = $value2->Id_Client_get();
	}
}
?>
<div class="addresse_companie">
<p>Café j'adore</br>
46 Montée de la Grande Côte</br>
69001 Lyon</p>
</div>
<center><img src="image/cafejadore_logo_insigne_couleurs.png" alt="logo_cafe" height="200" width="200"></center>
<div class="addresse_client">
<table class="client_addresse">
<?php
$List_Client = Lecture_Client_Id($id_client);
foreach($List_Client as $value)
{
	echo('<tr>');
	echo('<td><h2>Adresse de Facturation</h2>');
	echo($value->Nom_Client_get().' '.$value->Prenom_Client_get().'</br>');
	echo($value->Adresse_Client_get().'</br>');
	echo($value->Cp_Client_get().' '.$value->Ville_Client_get().'</td>');
	
	if(isset($_SESSION['Nom_Client_Liv']))
	{
		echo('<td><h2>Adresse de Livraison</h2>');
		echo($_SESSION['Nom_Client_Liv'].' '.$_SESSION['Prenom_Client_Liv'].'</br>');
		echo($_SESSION['Adresse_Client_Liv'].'</br>');
		echo($_SESSION['Cp_Client_Liv'].' '.$_SESSION['Ville_Client_Liv'].'</td>');
	}
	else
	{
		echo('<td class="Livraison"><h2>Adresse de Livraison</h2>');
		echo($value->Nom_Client_get().' '.$value->Prenom_Client_get().'</br>');
		echo($value->Adresse_Client_get().'</br>');
		echo($value->Cp_Client_get().' '.$value->Ville_Client_get().'</td>');
	}
	echo('</tr>');
}
?>
</table>
</div>
<?php
echo('<center><h2>Détail de la facture</h2></center>');
echo('<div class="detail_facture">');
echo('<table class="facture_detail">');
echo('<tr>');
echo('<th>Nom Articles</th>');
echo('<th>Quantité</th>');
echo('<th>Prix unitaire Hors Taxe</th>');
echo('<th>Prix unitaire TTC</th>');
echo('<th>Prix total Article Hors Taxe</th>');
echo('<th>Prix total Article TTC</th>');
echo('</tr>');

$List_Article = Lecture_Commande_Article($id_commande);

foreach($List_Article as $value)
{
	
	$tmp = $value->Prix_Article_get()*($value->Tva_Article_get()/100);
	$prix_unitaire_ht = $value->Prix_Article_get() - $tmp;
	
	$prix_unitaire_ttc = $value->Prix_Article_get();
	$prix_total_article_ht = $prix_unitaire_ht * $value->Nb_Article_get();//ht total par article
	$prix_total_article = $value->Prix_Article_get() * $value->Nb_Article_get();// ttc total par article
	
	
	$prix_article += $value->Nb_Article_get() * $value->Prix_Article_get();
	$montant_ht += $prix_unitaire_ht * $value->Nb_Article_get();//Prix hors tax
	$montant_ttc += $prix_unitaire_ttc * $value->Nb_Article_get();//Prix ttc
	$nb_article_total += $value->Nb_Article_get();
	
	if($value->Tva_Article_get() == 5.5)
	{
		$montant_tva_55 += $tmp * $value->Nb_Article_get();
	}
	else
	{
		if($value->Tva_Article_get() > 5.5)
		{
			$montant_tva_20 += $tmp * $value->Nb_Article_get();
		}
	}
	
	echo('<tr>');
	echo('<td>'.$value->Nom_Article_get().'</td>');
	echo('<td>'.$value->Nb_Article_get().'</td>');
	echo('<td>'.$prix_unitaire_ht.'€</td>');
	echo('<td>'.$prix_unitaire_ttc.'</td>');
	echo('<td>'.$prix_total_article_ht.'</td>');
	echo('<td>'.$prix_total_article.'</td>');
	echo('</tr>');
	$x++;
}
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>Prix des Article HT :</strong></td>');
	echo('<td>'.$montant_ht.'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>TVA 5.5%</strong></td>');
	echo('<td>'.$montant_tva_55.'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>TVA 20%</strong></td>');
	echo('<td>'.$montant_tva_20.'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>Prix Total TTC :</strong></td>');
	echo('<td>'.$montant_ttc.'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');

	$fdp = $List_Commande[0]->Total_Commande_get() - $montant_ttc;
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>Frais de Port :</strong></td>');
	echo('<td>'.$fdp.'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	
	echo('<tr>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td id="vide_commande"></td>');
	echo('<td><strong>Prix Total net à payer :</strong></td>');
	echo('<td>'.$List_Commande[0]->Total_Commande_get().'</td>');
	echo('<td id="vide_commande"></td>');
	echo('</tr>');
	
	
	echo('</table>');
	
	unset($_SESSION['panier']);
	unset($_SESSION['id_commande']);
	unset($_SESSION['MontantGlobal']);
	unset($_SESSION['id_etat_commande']);
	unset($_SESSION['prix_transporteur']);
	
	Envoie_Facture($_SESSION['Email_Client'],$id_commande);
?>
</div>
<form>
  <input id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" />
</form>
<script type="text/javascript">
function imprimer_page()
{
  window.print();
}
</script>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>