<?php
session_start(); // On démarre la session AVANT toute chose
require_once '../class/Client.php';
require_once 'Client_Existe.php';
require_once 'Lecture_Client.php';
require_once 'Recherche_Commande.php';
require_once 'fonctions-panier.php';
require_once 'Lecture_Commande_Article.php';
require_once 'Suppression_Commande.php';

$List_Commande = array();
$List_Article = array();
$ok = false;
$Client = new Client();
/*
if(!empty($_POST['Email_Client'])) 
{
  $Client->Email_Client_set($_POST['Email_Client']);
  
  if(!empty($_POST['Mdp_Client']))
  {
	  $Client->Mdp_Client_set($_POST['Mdp_Client']);
	  
		if(Client_Existe($Client))
		{
			$List_Client = Lecture_Client_Email_Mdp($Client->Email_Client_get(),$Client->Mdp_Client_get());
			$arrlength = count($List_Client);
			for($x = 0; $x < $arrlength; $x++) 
			{
				$_SESSION['ID_Client'] = $List_Client[$x]->ID_Client_get();
				$_SESSION['Nom_Client'] = $List_Client[$x]->Nom_Client_get();
				$_SESSION['Prenom_Client'] = $List_Client[$x]->Prenom_Client_get();
				$_SESSION['Nb_Tel_Fix_Client'] = $List_Client[$x]->Nb_Tel_Fix_Client_get();
				$_SESSION['Nb_Tel_Port_Client'] = $List_Client[$x]->Nb_Tel_Port_Client_get();
				$_SESSION['Adresse_Client'] = $List_Client[$x]->Adresse_Client_get();
				$_SESSION['Ville_Client'] = $List_Client[$x]->Ville_Client_get();
				$_SESSION['Cp_Client'] = $List_Client[$x]->Cp_Client_get();
				$_SESSION['Email_Client'] = $List_Client[$x]->Email_Client_get();
				$_SESSION['Mdp_Client'] = $List_Client[$x]->Mdp_Client_get();
				$_SESSION['ID_Droit'] = $List_Client[$x]->ID_Droit_get();
				
				// lire sur la bdd si il y a une commande qui est en cours
				// si oui la mettre dans le panier et l'afficher.
				$List_Commande =  Recherche_Commande(0,$_SESSION['Email_Client'],3);
				
				
				if(count($List_Commande) >0)
				{
					$ok = true;
					if(!isset($_SESSION['panier']))
					{
						creation_panier();
						$x=0;
						foreach($List_Commande as $value)
						{
							$List_Article = Lecture_Commande_Article($List_Commande[0]->Id_Commande_get());
							$_SESSION['id_commande'] = $List_Commande[0]->Id_Commande_get();
							foreach($List_Article as $value2)
							{
								$_SESSION['panier']['id_article'][$x] = $value2->ID_Article_get();
								$_SESSION['panier']['nom_article'][$x] = $value2->Nom_Article_get();
								$_SESSION['panier']['qte'][$x] = $value2->Nb_Article_get();
								$_SESSION['panier']['prix'][$x] = $value2->Prix_Article_get();
								/*correction du chemin de l'image origine /../../images_boutique/nom_image.jpg en ../images_boutique/nom_image.jpg
								$tmp = $value2->Chemin_Image_get();
								$tmp = substr($tmp,3);
								$_SESSION['panier']['chemin_image'][$x] = $tmp;
								$x++;
								
							}
							
						}
					}
					else
					{
						Suppression_Commande($List_Commande[0]->Id_Commande_get());
					}
					
					
				}
				
					
			}
				
		if($ok == false)
		{
			header('Location:../Boutique.php');
		}
		else
		{
			header('Location:../Panier.php');
		}
		
					
	
	}
	else
	{
		header('Location:../Login.php');
		
	}
  
	  
  }
  else
  {
	  echo('le champ mot de passe n\'est pas remplis!!');
	  header('Location:../Login.php');
	  
  }
}
else
{
	header('Location:../Login.php');
}
*/
?>