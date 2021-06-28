<?php
session_start();
require_once 'fonctions-panier.php';
require_once '../class/Commande.php';//changer
require_once '../class/Composer.php';//changer
require_once 'Modification_Commande.php';
require_once 'Enregistrement_Commande.php';

if(isset($_POST['btn_raf']))
{
	//session_start();//?????
	echo modif_qte($_POST['ID_Article'], $_POST['qte']);
	header('location:../Panier.php');
}

if(isset($_POST['btn_sup']))
{
	//session_start();//?????
	echo supprim_article($_POST['ID_Article']);
	header('location:../Panier.php');
}

if(isset($_POST['btn_payer']))
{
	//session_start();//???
	if($_POST['Montant_Panier'] > 0 && isset($_SESSION['ID_Client'])) // si panier supperieur a zero
	{
		
		require_once 'Lecture_Transporteur.php';
		
		$List_Transporteur = Lecture_Transporteur();
		$List_Composer = array();
		$commande = new Commande();
		
		date_default_timezone_set("Europe/Paris");
	
		$commande->Date_Commande_set(date("d/m/Y").' '.date("h:i:sa"));
		$commande->Total_Commande_set($_POST['Montant_Panier']);
		$commande->Id_Client_set($_SESSION['ID_Client']);
		$commande->Id_Etat_Commande_set(3);//en cours "1 er enregistrement"
		$commande->Id_Transporteur_set($List_Transporteur[0]->Id_Transporteur_get());
		
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
		
		if(isset($_SESSION['id_commande']))
		{
			//modification commande
			
			Modification_Commande($commande);
		}
		else
		{
			$id_commande = Enregistrement_Commande($commande,$List_Composer);
		}
		
		header('location:../Commande_Client.php');
		
	}
	else
	{
		if(isset($_POST['btn_payer']))
		{
			header('location:../Login.php');
		}
	}
	
}



?>