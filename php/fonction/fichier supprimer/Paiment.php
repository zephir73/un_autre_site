<?php
//session_start();// On démarre la session AVANT toute chose
require_once 'Enregistrement_Commande.php';
require_once '../class/Commande.php';
require_once 'Modification_Etat_Commande.php';
require_once '../class/Composer.php';
require_once '../class/Facture.php';
require_once 'Enregistrement_Facture.php';


// on verifie que le client est loger si oui 
// on enregistre la commande du client (pagnier sous forme de pas payer)
// on effectue le contacte chez paypal on attend le retour de payment 
// on enregistre une seconde fois la commande mais avec le payment effectuer
// si pas de payment on efface la commande;
$List_Composer=array();

if(isset($_SESSION['ID_Client']))
{
	$commande = new Commande();
	date_default_timezone_set("Europe/Paris");
	
	$commande->Date_Commande_set(date("d/m/Y").' '.date("h:i:sa"));
	$commande->Total_Commande_set($_SESSION['MontantGlobal']);
	$commande->Id_Client_set($_SESSION['ID_Client']);
	$commande->Id_Etat_Commande_set(3);//en cours "1 er enregistrement"
	$commande->Id_Transporteur_set($_SESSION['id_transporteur']);
	
	$x=0;
	foreach ($_SESSION['panier']['id_article'] as $value)// fait une liste composer pour la table composer
	{
		$composer = new Composer();
		$composer->Prix_Article_set($_SESSION['panier']['prix'][$x]);
		$composer->Nb_Article_set($_SESSION['panier']['qte'][$x]);
		$composer->Id_Article_set($_SESSION['panier']['id_article'][$x]);
		array_push($List_Composer, $composer);
		$x++;
	}
	
	
	
	//contacte paypal A FAIRE !!!! pour savoir si la commande est payer 
	$payer = 1; // normalement c'est paypal qui reponds
	if($payer == 1)
	{
		$id_commande = Enregistrement_Commande($commande,$List_Composer);
		
		$facture = new Facture();
		date_default_timezone_set("Europe/Paris");
		$facture->Date_Facture_set(date("d/m/Y").' '.date("h:i:sa"));
		$facture->Total_Facture_set($_SESSION['MontantGlobal']);
		$facture->Id_Commande_set($id_commande);
	
		Enregistrement_Facture($facture);
		$id_etat_commande = Modification_Etat_Commande($id_commande);// passe la commande en payer
		
		
	
		unset($_SESSION['panier']);
		
		// VOIR POUR PEUX ETRE UTILISER DES VARIABLE DE SESSION	
		echo('facture');
		//header("location:../Facture_Client.php?ID_Commande=".$id_commande."&ID_Etat_Commande=".$id_etat_commande);
	}
	else
	{
		//suppression des article de la commande dans table compose
		// puis suppression de la commande
	}
}
else
{
	//le client n'est pas loger on le renvoie sur la page login
	header('location:../Login.php');
}

?>