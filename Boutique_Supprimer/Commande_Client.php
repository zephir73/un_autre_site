<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';


$List_Composer = array();
$List_Transporteur = array();

$prix_article = 0;
$montant_ht = 0;
$nb_article_total = 0;
$montant_tva_55 = 0;
$montant_tva_20 = 0;
$montant_ttc = 0;
//Set useful variables for paypal form
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypalID = 'didier.cyprien0243-facilitator@orange.fr'; //Business Email 
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Commande Client Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Commande_Client.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<?php
// gestion des boutons
// bouton Payer paypal retour de payments avec success
if(isset($_GET['PayPal']) && $_GET['PayPal'] == 'success' )
{
	// met l'adresse du client dans une variable et @ est pour les espaces
	$Adresse_Client_Fac = $_SESSION['Nom_Client'];
	$Adresse_Client_Fac = $Adresse_Client_Fac .'@'. $_SESSION['Prenom_Client'];
	$Adresse_Client_Fac = $Adresse_Client_Fac .'@'. $_SESSION['Adresse_Client'];
	$Adresse_Client_Fac = $Adresse_Client_Fac .'@'. $_SESSION['Cp_Client'];
	$Adresse_Client_Fac = $Adresse_Client_Fac .'@'. $_SESSION['Ville_Client'];
	
	if(isset($_SESSION['Nom_Client_Liv']))
	{
		$Adresse_Client_Liv = $_SESSION['Nom_Client_Liv'];
		$Adresse_Client_Liv = $Adresse_Client_Liv .'@'. $_SESSION['Prenom_Client_Liv'];
		$Adresse_Client_Liv = $Adresse_Client_Liv .'@'. $_SESSION['Adresse_Client_Liv'];
		$Adresse_Client_Liv = $Adresse_Client_Liv .'@'. $_SESSION['Cp_Client_Liv'];
		$Adresse_Client_Liv = $Adresse_Client_Liv .'@'. $_SESSION['Ville_Client_Liv'];
	}
	else
	{
		$Adresse_Client_Liv = $Adresse_Client_Fac;
	}
	
	//contacte paypal A FAIRE !!!! pour savoir si la commande est payer 
	
	//$payer = 1; // normalement c'est paypal qui reponds
	
	if($_GET['PayPal'] == 'success')
	{
		date_default_timezone_set("Europe/Paris");
		$commande = new Commande();
		$commande->Date_Commande_set(date("d/m/Y").' '.date("h:i:sa"));
		$commande->Total_Commande_set($_SESSION['MontantGlobal']);
		$commande->Id_Client_set($_SESSION['ID_Client']);
		$commande->Id_Etat_Commande_set(1);// passe la commande en payer
		$_SESSION['id_etat_commande'] = $commande->Id_Etat_Commande_get();
		$commande->Id_Transporteur_set(1);
		$x=0;
		foreach ($_SESSION['panier']['id_article'] as $value)// fait une liste composer pour la table composer
		{
			$composer = new Composer();
			$composer->Prix_Article_set($_SESSION['panier']['prix'][$x]);
			$composer->Nb_Article_set($_SESSION['panier']['qte'][$x]);
			$composer->Tva_Article_set($_SESSION['panier']['tva'][$x]);
			$composer->Id_Article_set($_SESSION['panier']['id_article'][$x]);
			array_push($List_Composer, $composer);
			$x++;
		}
		if(isset($_SESSION['id_commande']))
		{
			$commande->Id_Commande_set($_SESSION['id_commande']);
			$List_Composer = array();// efface la liste precedente et la re cree avec l'id commande
			$x=0;
			foreach ($_SESSION['panier']['id_article'] as $value)// fait une liste composer pour la table composer
			{
				$composer = new Composer();
				$composer->Prix_Article_set($_SESSION['panier']['prix'][$x]);
				$composer->Nb_Article_set($_SESSION['panier']['qte'][$x]);
				$composer->Tva_Article_set($_SESSION['panier']['tva'][$x]);
				$composer->Id_Article_set($_SESSION['panier']['id_article'][$x]);
				$composer->Id_Commande_set($commande->Id_Commande_get());
				array_push($List_Composer, $composer);
				$x++;
			}
			$id_commande = Enregistrement_Commande($commande,$List_Composer,$_SESSION['id_commande']);// enregistre la commande avec l'emplacement connue
		}
		else
		{
			$id_commande = Enregistrement_Commande($commande,$List_Composer,0);// enregistre la commande;
		}
		
		$facture = new Facture();
		date_default_timezone_set("Europe/Paris");
		$facture->Date_Facture_set(date("d/m/Y").' '.date("h:i:sa"));
		$facture->Total_Facture_set($_SESSION['MontantGlobal']);
		$facture->Adresse_Facture_set($Adresse_Client_Fac);
		$facture->Adresse_Livraison_set($Adresse_Client_Liv);
		$facture->Id_Commande_set($id_commande);
		Enregistrement_Facture($facture);
		$id_etat_commande = Modification_Etat_Commande($id_commande);// passe la commande en payer

		if($id_etat_commande == 1)
		{
			$_SESSION['id_commande'] = $id_commande;
			$_SESSION['id_etat_commande'] = $id_etat_commande;	
			echo ('<script language="Javascript">
			<!--
			document.location.replace("Facture_Client.php");
			// -->
			</script>');			
			//header('location:Facture_Client.php');//un jour ça fonctionne l'autre pas
		}
	
	}
}

// bouton Modif addresse de facturation
if(isset($_POST['Modif_Adresse_Fac']))
{
	$client = new Client();
	$client->ID_Client_set($_SESSION['ID_Client']);
	$client->Nom_Client_set($_POST['Nom_Client_Fac']);
	$client->Prenom_Client_set($_POST['Prenom_Client_Fac']);
	$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client_Fac']);
	$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client_Fac']);
	$client->Adresse_Client_set($_POST['Adresse_Client_Fac']);
	$client->Ville_Client_set($_POST['Ville_Client_Fac']);
	$client->Cp_Client_set($_POST['Cp_Client_Fac']);
	$client->Email_Client_set($_POST['Email_Client_Fac']);
	$client->Mdp_Client_set($_SESSION['Mdp_Client']);
	$client->ID_Droit_set($_SESSION['ID_Droit']);
	
	if(Modification_Client($client) == true)
	{
		//echo('La modification de votre adresse de facturation a été effectuée avec succès');
		$_SESSION['Nom_Client'] = $client->Nom_Client_get();
		$_SESSION['Prenom_Client'] = $client->Prenom_Client_get();
		$_SESSION['Nb_Tel_Fix_Client'] = $client->Nb_Tel_Fix_Client_get(); 
		$_SESSION['Nb_Tel_Port_Client'] = $client->Nb_Tel_Port_Client_get();
		$_SESSION['Adresse_Client'] = $client->Adresse_Client_get();
		$_SESSION['Ville_Client'] = $client->Ville_Client_get();
		$_SESSION['Cp_Client'] = $client->Cp_Client_get();
		$_SESSION['Email_Client'] = $client->Email_Client_get();
		
		
		
		header('Location:Commande_Client.php?Ok=true#Adresse');
	}
	else
	{
		//echo('Probléme modification adresse de facturation');
		header('Location:Commande_Client.php?Ok=false#Adresse');
	}
}

if(isset($_POST['Modif_Adresse_Liv']))
{
	$_SESSION['Nom_Client_Liv'] = strtoupper($_POST['Nom_Client_Liv']);
	//met une majuscule au debut du mot
	$tmp1 = substr($_POST['Prenom_Client_Liv'],0,1);
	$tmp1 = strtoupper($tmp1);
	$tmp = substr($_POST['Prenom_Client_Liv'],1);
	$tmp = $tmp1.$tmp;
	$_SESSION['Prenom_Client_Liv'] = $tmp;
	$_SESSION['Nb_Tel_Fix_Client_Liv'] = $_POST['Nb_Tel_Fix_Client_Liv'];
	$_SESSION['Nb_Tel_Port_Client_Liv'] = $_POST['Nb_Tel_Port_Client_Liv'];
	//met une majuscule au debut du mot
	$tmp1 = substr($_POST['Adresse_Client_Liv'],0,1);
	$tmp1 = strtoupper($tmp1);
	$tmp = substr($_POST['Adresse_Client_Liv'],1);
	$tmp = $tmp1.$tmp;
	$_SESSION['Adresse_Client_Liv'] = $tmp;
	//met une majuscule au debut du mot
	$tmp1 = substr($_POST['Ville_Client_Liv'],0,1);
	$tmp1 = strtoupper($tmp1);
	$tmp = substr($_POST['Ville_Client_Liv'],1);
	$tmp = $tmp1.$tmp;
	$_SESSION['Ville_Client_Liv'] = $tmp;
	$_SESSION['Cp_Client_Liv'] = $_POST['Cp_Client_Liv'];
	$_SESSION['Email_Client_Liv'] = $_POST['Email_Client_Liv'];
	$_SESSION['Email_Client_Liv2'] = $_POST['Email_Client_Liv2'];
	
	header('Location:Commande_Client.php?Ok=true#Adresse');
	
}
/*fin bouton*/
?>

<article>
<?php

if(isset($_SESSION['panier']))
{

	/* message pour divers informations */
	if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
	{
		echo('<p id="Modif" style="color:red;">La modification de l\' adresse n\' à pas été effectuer !</p>');
	}
	else
	{
		if(isset($_GET['Ok']) && $_GET['Ok'] == 'true')
		{
			echo('<p id="Modif" style="color:red;">La modification à été effectuer !</p>');
		}
	}
	
	if(isset($_GET['PayPal']) && $_GET['PayPal'] == 'cancel')// pour le payment paypal si pas effectuée
	{
		echo('<h1 style="color:red;">Le payment à été annuler</h1>');
	}
	/* fin */

	echo('<form action="Commande_Client.php" method="post">');
	echo('<table id="Adresse" class="Adresse">');

	echo('<tr>');
	echo('<th id="vide_adresse"></th>');
	echo('<th><h1>Adresse de facturation</h1></th>');//facturation
	echo('<th id="vide_adresse"></th>');
	echo('<th id="vide_adresse"></th>');
	echo('<th><h1>Adresse de livraison</h1></th>');//livraison
	echo('<th id="vide_adresse"></th>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Nom :</td>');//facturation
	echo('<td><input type="text" name="Nom_Client_Fac" value="'.$_SESSION['Nom_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Nom :</td>');//livraison
	if(isset($_SESSION['Nom_Client_Liv']))
	{
		echo('<td><input type="text" name="Nom_Client_Liv" value="'.$_SESSION['Nom_Client_Liv'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Nom_Client_Liv" value="'.$_SESSION['Nom_Client'].'" required ></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Prénom :</td>');//facturation
	echo('<td><input type="text" name="Prenom_Client_Fac" value="'.$_SESSION['Prenom_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Prénom :</td>');//livraison
	if(isset($_SESSION['Prenom_Client_Liv']))
	{
		echo('<td><input type="text" name="Prenom_Client_Liv" value="'.$_SESSION['Prenom_Client_Liv'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Prenom_Client_Liv" value="'.$_SESSION['Prenom_Client'].'" required ></td>');
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Téléphone fixe :</td>');//facturation
	echo('<td><input type="text" name="Nb_Tel_Fix_Client_Fac" value="'.$_SESSION['Nb_Tel_Fix_Client'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Téléphone fixe :</td>');//livraison
	if(isset($_SESSION['Nb_Tel_Fix_Client_Liv']))
	{
		echo('<td><input type="text" name="Nb_Tel_Fix_Client_Liv" value="'.$_SESSION['Nb_Tel_Fix_Client_Liv'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Nb_Tel_Fix_Client_Liv" value="'.$_SESSION['Nb_Tel_Fix_Client'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//livraison
	}

	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Téléphone portable :</td>');//facturation
	echo('<td><input type="text" name="Nb_Tel_Port_Client_Fac" value="'.$_SESSION['Nb_Tel_Port_Client'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Télephone portable :</td>');//livraison
	if(isset($_SESSION['Nb_Tel_Port_Client_Liv']))
	{
		echo('<td><input type="text" name="Nb_Tel_Port_Client_Liv" value="'.$_SESSION['Nb_Tel_Port_Client_Liv'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Nb_Tel_Port_Client_Liv" value="'.$_SESSION['Nb_Tel_Port_Client'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Adresse :</td>');//facturation
	echo('<td><input type="text" name="Adresse_Client_Fac" value="'.$_SESSION['Adresse_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Adresse :</td>');//livraison
	if(isset($_SESSION['Adresse_Client_Liv']))
	{
		echo('<td><input type="text" name="Adresse_Client_Liv" value="'.$_SESSION['Adresse_Client_Liv'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Adresse_Client_Liv" value="'.$_SESSION['Adresse_Client'].'" required ></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Ville :</td>');//facturation
	echo('<td><input type="text" name="Ville_Client_Fac" value="'.$_SESSION['Ville_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Ville :</td>');//livraison
	if(isset($_SESSION['Ville_Client_Liv']))
	{
		echo('<td><input type="text" name="Ville_Client_Liv" value="'.$_SESSION['Ville_Client_Liv'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Ville_Client_Liv" value="'.$_SESSION['Ville_Client'].'" required></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Code postal :</td>');//facturation
	echo('<td><input type="text" name="Cp_Client_Fac" value="'.$_SESSION['Cp_Client'].'" pattern="[0-9]{5}" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Code postal :</td>');//livraison
	if(isset($_SESSION['Cp_Client_Liv']))
	{
		echo('<td><input type="text" name="Cp_Client_Liv" value="'.$_SESSION['Cp_Client_Liv'].'" pattern="[0-9]{5}" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="text" name="Cp_Client_Liv" value="'.$_SESSION['Cp_Client'].'" pattern="[0-9]{5}" required ></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Adresse mail :</td>');//facturation
	echo('<td><input type="email" name="Email_Client_Fac" value="'.$_SESSION['Email_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Adresse mail :</td>');//livraison
	if(isset($_SESSION['Email_Client_Liv']))
	{
		echo('<td><input type="email" name="Email_Client_Liv" value="'.$_SESSION['Email_Client_Liv'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="email" name="Email_Client_Liv" value="'.$_SESSION['Email_Client'].'" required ></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td>Adresse mail :</td>');//facturation
	echo('<td><input type="email" name="Email_Client_Fac2" value="'.$_SESSION['Email_Client'].'" required ></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td>Adresse mail :</td>');//livraison
	if(isset($_SESSION['Email_Client_Liv2']))
	{
		echo('<td><input type="email" name="Email_Client_Liv2" value="'.$_SESSION['Email_Client_Liv2'].'" required ></td>');//livraison
	}
	else
	{
		echo('<td><input type="email" name="Email_Client_Liv2" value="'.$_SESSION['Email_Client'].'" required></td>');//livraison
	}
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');

	echo('<tr>');
	echo('<td id="vide_adresse"></td>');//facturation
	echo('<td><input type="submit" name="Modif_Adresse_Fac" value="Modification de l\' adresse de facturation"></td>');//facturation
	echo('<td id="vide_adresse"></td>');
	echo('<td id="vide_adresse"></td>');//livraison
	echo('<td><input type="submit" name="Modif_Adresse_Liv" value="Modification de l\' adresse de livraison"></td>');//livraison
	echo('<td id="vide_adresse"></td>');
	echo('</tr>');
	echo('</table>');
	echo('</form>');

	$List_Transporteur = Lecture_Transporteur();// que 1 seul transporteur dans la bdd
	$_SESSION['prix_transporteur'] = $List_Transporteur[0]->Prix_Transporteur_get();


    echo('<table id="Commande" class="commande_client">');
    echo('<h1>Récapitulatif de la commande de Mr '.$_SESSION['Nom_Client'].' </h1>');
    echo('<tr>');
    echo('<th>Nom Articles</th>');
    echo('<th>Image du Produit</th>');
    echo('<th>Quantité</th>');
    echo('<th>Prix unitaire Hors Taxe</th>');
    echo('<th>Prix unitaire TTC</th>');
    echo('<th>Prix total Article Hors Taxe</th>');
    echo('<th>Prix total Article TTC</th>');
    echo('</tr>');
    $x = 0;

    foreach($_SESSION['panier']['id_article'] as $value) {

        $tmp = $_SESSION['panier']['prix'][$x] * ($_SESSION['panier']['tva'][$x] / 100);
        $prix_unitaire_ht = $_SESSION['panier']['prix'][$x] - $tmp;
        $prix_unitaire_ttc = $_SESSION['panier']['prix'][$x];
        $prix_total_article_ht = $prix_unitaire_ht * $_SESSION['panier']['qte'][$x];//ht total par article
        $prix_total_article = $_SESSION['panier']['qte'][$x] * $_SESSION['panier']['prix'][$x];// ttc total par article


        $prix_article += $_SESSION['panier']['qte'][$x] * $_SESSION['panier']['prix'][$x];
        $montant_ht += $prix_unitaire_ht * $_SESSION['panier']['qte'][$x];//Prix hors tax
        $montant_ttc += $prix_unitaire_ttc * $_SESSION['panier']['qte'][$x];//Prix ttc
        $nb_article_total += $_SESSION['panier']['qte'][$x];

        if ($_SESSION['panier']['tva'][$x] == 5.5) {
            $montant_tva_55 += $tmp * $_SESSION['panier']['qte'][$x];
        } else {
            if ($_SESSION['panier']['tva'][$x] == 20) {
                $montant_tva_20 += $tmp * $_SESSION['panier']['qte'][$x];
            }
        }


        echo('<tr>');
        echo('<td class="commande_client">' . $_SESSION['panier']['nom_article'][$x] . '</td>');
        echo('<td><img src="' . $_SESSION['panier']['chemin_image'][$x] . '" alt="' . $_SESSION['panier']['nom_article'][$x] . '" height="42" width="42"></td>');
        echo('<td>' . $_SESSION['panier']['qte'][$x] . '</td>');
        echo('<td>' . $prix_unitaire_ht . '€</td>');
        echo('<td>' . $_SESSION['panier']['prix'][$x] . '</td>');
        echo('<td>' . $prix_total_article_ht . '</td>');
        echo('<td>' . $prix_total_article . '</td>');
        echo('</tr>');
        $x++;
    }
    //echo($y);

    echo('<tr>');
    echo('<td id="vide_commande"></td>');
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
    echo('<td id="vide_commande"></td>');
    echo('<td><strong>Prix des Article HT :</strong></td>');
    echo('<td>'.$montant_ht.'</td>');
    echo('<td id="vide_commande"></td>');
    echo('</tr>');

    echo('<tr>');
    echo('<td id="vide_commande"></td>');
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
    echo('<td id="vide_commande"></td>');
    echo('<td><strong>TVA 20%</strong></td>');
    echo('<td>'.$montant_tva_20.'</td>');
    echo('<td id="vide_commande"></td>');
    echo('</tr>');

    echo('<tr>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td><strong>Prix Total TTC :</strong></td>');
    echo('<td>'.$montant_ttc.'</td>');
    echo('</tr>');

    echo('<tr>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td><strong>Frais de Port :</strong></td>');
    echo('<td>'.$_SESSION['prix_transporteur'].'</td>');

    echo('</tr>');


    echo('<tr>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td><strong>Prix Total net à payer :</strong></td>');
    $total = $prix_article + $_SESSION['prix_transporteur'];
    echo('<td>'.$total.'</td>');
    $_SESSION['MontantGlobal'] = $total;
    echo('</tr>');

    echo('<tr>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td id="vide_commande"></td>');
    echo('<td>');


    $x=0;
    $y=$x+1;

    echo('<form action="'.$paypalURL.'" method="post">');
    echo('<input type="hidden" name="cmd" value="_cart">');
    echo('<input type="hidden" name="upload" value="1">');
    echo('<input type="hidden" name="no_shipping" value="2">');

    foreach($_SESSION['panier']['id_article'] as $value)
    {
        echo('<input type="hidden" name="business" value="'.$paypalID.'">');
        echo('<input type="hidden" name="item_name_'.$y.'" value="'.$_SESSION['panier']['nom_article'][$x].'">');
        echo('<input type="hidden" name="amount_'.$y.'" value="'.$_SESSION['panier']['prix'][$x].'">');
        echo('<input type="hidden" name="quantity_'.$y.'" value="'.$_SESSION['panier']['qte'][$x].'">');
        echo('<input type="hidden" name="item_number_'.$y.'" value="'.$y.'">');
        $x++;
        $y++;
    }

	echo('<input type="hidden" name="business" value="'.$paypalID.'">');
	echo('<input type="hidden" name="item_name_'.$y.'" value="Frais de port">');
	echo('<input type="hidden" name="amount_'.$y.'" value="'.$_SESSION['prix_transporteur'].'">');
	echo('<input type="hidden" name="quantity_'.$y.'" value="1">');
    echo('<input type="hidden" name="item_number_'.$y.'" value="'.$y.'">');
    
	echo('<input type="hidden" name="currency_code" value="EUR">');
    echo('<input type="hidden" name="cancel_return" value="https://www.cafejadore.fr/cancel.php">');
    echo('<input type="hidden" name="return" value="https://www.cafejadore.fr/success.php">');
	echo('<input type="hidden" name="notify_url" value="https://www.cafejadore.fr/ipn.php">');

    if(isset($_SESSION['Adresse_Client_Liv']))
    {
        echo('<input type="hidden" name="address1" value="'.$_SESSION['Adresse_Client_Liv'].'">');
    }
    else
    {
        echo('<input type="hidden" name="address1" value="'.$_SESSION['Adresse_Client'].'">');
    }

    if(isset($_SESSION['Ville_Client_Liv']))
    {
        echo('<input type="hidden" name="city" value="'.$_SESSION['Ville_Client_Liv'].'">');
    }
    else
    {
        echo('<input type="hidden" name="city" value="'.$_SESSION['Ville_Client'].'">');
    }

    if(isset($_SESSION['Cp_Client_Liv']))
    {
        echo('<input type="hidden" name="zip" value="'.$_SESSION['Cp_Client_Liv'].'">');
    }
    else
    {
        echo('<input type="hidden" name="zip" value="'.$_SESSION['Cp_Client'].'">');
    }

    echo('<input type="submit" value="Payer"></form></td>');
    echo('</tr>');
    echo('</table>');

}
else
{
	header('Location:Boutique.php');
}
?>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>