<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Commande = array();
$List_Article = array();
$List_Facture = array();

$adresse_facture ='';
$nom_prenom = '';
$adresse = '';
$ville = '';
$adresse_livraison = '';
$nom_prenom_liv = '';
$adresse_liv = '';
$ville_liv = '';

$tmp = 0;
$prix_unitaire_ht = 0;

$prix_unitaire_ttc = 0;
$prix_total_article_ht = 0;//ht total par article
$prix_total_article = 0;// ttc total par article


$prix_article = 0;
$montant_ht = 0;//Prix hors tax
$montant_ttc = 0;//Prix ttc
$nb_article_total = 0;

$montant_tva_55 = 0;
$montant_tva_20 = 0;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Facture Reedition Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css"/>
		<link href="css/Facture_Client_Reedition.css" media="screen" rel="stylesheet" type="text/css"/>
		<link href="css/Print_Reedition.css" media="print" rel="stylesheet" type="text/css"/>
</head>
<?php
include 'Header.php';
?>
<body>
<article>
<?php

if(isset($_POST['Id_Commande']))
{
	$List_Commande = Recherche_Commande($_POST['Id_Commande'],$_SESSION['Email_Client'],1);// 1 payer 2 pas payer 3 en cour

	$List_Facture = Recherche_Facture($_POST['Id_Commande']);
	
	$List_Article = Lecture_Commande_Article($_POST['Id_Commande']);
	
}


foreach ($List_Facture as $value)
{
	echo('<p>Facture n=°: '.$value->Id_Facture_get().'</p>');
	echo('<p>Date : '.$value->Date_Facture_get().'</p>');
	foreach($List_Commande as $value2)
	{
		echo('<p>Numéro client : '.$value2->Id_Client_get().'</p></br>');
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

<?php

foreach($List_Facture as $value)
{
	$adresse_facture = $value->Adresse_Facture_get();
	$adresse_livraison = $value->Adresse_Livraison_get();
	$arraylenght = strlen($adresse_facture);
	$i=0;
	// pour avoir l'adresse de facturation dans 3 variables
	// $nom_prenom,$adresse,$ville
	for($x=0; $x<$arraylenght; $x++)
	{
		if($adresse_facture[$x] != '@' && $i<2)
		{
			$nom_prenom = $nom_prenom.$adresse_facture[$x];
		}
		else
		{
			if($adresse_facture[$x] =='@' && $i<2)
			{
				$nom_prenom = $nom_prenom.' ';
				$i++;
			}
			else
			{
				if($adresse_facture[$x] != '@' && $i<3)
				{
					$adresse = $adresse.$adresse_facture[$x];
				}
				else
				{
					if($adresse_facture[$x] =='@' && $i<3)
					{
						$i++;
					}
					else
					{
						if($adresse_facture[$x] !='@' && $i<4)
						{
							$ville = $ville.$adresse_facture[$x];
						}
						else
						{
							if($adresse_facture[$x] =='@' && $i<4)
							{
								$ville = $ville.' ';
								$i++;
							}
							else
							{
								$ville = $ville.$adresse_facture[$x];
							}
						}
					}
				}
			}
		}
	}
	
	$arraylenght = strlen($adresse_livraison);
	$i=0;
	// pour avoir l'adresse de livraison dans 3 variables
	// $nom_prenom_liv,$adresse_liv,$ville_liv
	for($x=0; $x<$arraylenght; $x++)
	{
		if($adresse_livraison[$x] != '@' && $i<2)
		{
			$nom_prenom_liv = $nom_prenom_liv.$adresse_livraison[$x];
		}
		else
		{
			if($adresse_livraison[$x] =='@' && $i<2)
			{
				$nom_prenom_liv = $nom_prenom_liv.' ';
				$i++;
			}
			else
			{
				if($adresse_livraison[$x] != '@' && $i<3)
				{
					$adresse_liv = $adresse_liv.$adresse_livraison[$x];
				}
				else
				{
					if($adresse_livraison[$x] =='@' && $i<3)
					{
						$i++;
					}
					else
					{
						if($adresse_livraison[$x] !='@' && $i<4)
						{
							$ville_liv = $ville_liv.$adresse_livraison[$x];
						}
						else
						{
							if($adresse_livraison[$x] =='@' && $i<4)
							{
								$ville_liv = $ville_liv.' ';
								$i++;
							}
							else
							{
								$ville_liv = $ville_liv.$adresse_livraison[$x];
							}
						}
					}
				}
			}
		}
	}
}



echo('<table class="adresse">');
echo('<tr>');
echo('<th><h2>Adresse de Facturation</h2></th>');
echo('<th class="Livraison"></th>');
echo('<th><h2>Adresse de Livraison</h2></th>');
echo('</tr>');
echo('<tr>');
echo('<td>'.$nom_prenom.'</br>');
echo($adresse.'</br>');
echo($ville.'</td>');

echo('<td class="Livraison"></td>');
echo('<td>'.$nom_prenom_liv.'</br>');
echo($adresse_liv.'</br>');
echo($ville_liv.'</td>');

echo('</tr>');
echo('</table>');

echo('<div class="detail">');
echo('<center><h2>Détail de la facture</h2></center>');
echo('<table class="detail">');
echo('<tr>');
echo('<th>Nom Articles</th>');
echo('<th>Quantité</th>');
echo('<th>Prix unitaire Hors Taxe</th>');
echo('<th>Prix unitaire TTC</th>');
echo('<th>Prix total Article Hors Taxe</th>');
echo('<th>Prix total Article TTC</th>');
echo('</tr>');


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
echo('<div>');
?>

</article>
<form>
<input id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" />
</form>
<script type="text/javascript">
function imprimer_page()
{
  window.print();
}
</script>
<?php
include 'Footer.php';
?>
</body>
</html>