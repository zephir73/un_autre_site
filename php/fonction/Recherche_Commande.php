<?php

function Recherche_Commande($id_commande,$email_client,$etat_commande)
{
	$ID_Commande = false;
	$Email_Client = false;
	$Etat_Commande = false;
	$List_Commande = array();
	$id_client = "";
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	
	if($id_commande > 0)
	{
		$ID_Commande = true;
	}
	
	if(strlen($email_client))
	{
		$Email_Client = true;
	}
	
	if($etat_commande >0)
	{
		$Etat_Commande = true;
	}
	
	

	try
	{
		/*ID_Commande	Date_Commande	Total_Commande	ID_Client	ID_Etat_Commande	ID_Transporteur*/
		if($ID_Commande == true && $Email_Client == false)
		{
			$req = $bdd->prepare('SELECT ID_Commande, Date_Commande, Total_Commande, ID_Client, ID_Etat_Commande, ID_Transporteur FROM Commande 
			WHERE ID_Commande='.$id_commande.';');
			//echo ('recherche id');
			
		}
		else
		{
			
			if($ID_Commande == false && $Email_Client == true) 
			{
				$req = $bdd->prepare('SELECT ID_Client, Email_Client FROM Client WHERE Email_Client='.'\''.$email_client.'\';');
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$id_client = $donnee['ID_Client'];
				}
				
				
				$req = $bdd->prepare('SELECT ID_Commande, Date_Commande, Total_Commande, ID_Client, ID_Etat_Commande, ID_Transporteur FROM Commande 
				WHERE ID_Client='.$id_client.' AND ID_Etat_Commande='.$etat_commande.';');
				
				//echo('rechetrche email_client');
				
			}
			else
			{
					if($ID_Commande == true && $Email_Client == true && $Etat_Commande == true)
					{
						$req = $bdd->prepare('SELECT ID_Client, Email_Client FROM Client WHERE Email_Client='.'\''.$email_client.'\';');
						$req->execute();
				
						while($donnee=$req->fetch())
						{
							$id_client = $donnee['ID_Client'];
						}
						
						$req = $bdd->prepare('SELECT ID_Commande, Date_Commande, Total_Commande, ID_Client, ID_Etat_Commande, ID_Transporteur FROM Commande 
						WHERE ID_Etat_Commande='.$etat_commande.' AND ID_Client='.$id_client.' AND ID_Commande='.$id_commande.';');
						
						
						//echo('recherche id,email,etat');
						
					}
				
				
				else
				{
					if($Etat_Commande == true)
					{
						$req = $bdd->prepare('SELECT ID_Commande, Date_Commande, Total_Commande, ID_Client, ID_Etat_Commande, ID_Transporteur FROM Commande 
						WHERE ID_Etat_Commande='.$etat_commande.';');
						//echo ('recherche etat');
					}
				}
			}
		}
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$commande = new Commande();
			$commande->Id_Commande_set($donnee['ID_Commande']);
			$commande->Date_Commande_set($donnee['Date_Commande']);
			$commande->Total_Commande_set($donnee['Total_Commande']);
			$commande->Id_Client_set($donnee['ID_Client']);
			$commande->Id_Etat_Commande_set($donnee['ID_Etat_Commande']);
			$commande->Id_Transporteur_set($donnee['ID_Transporteur']);
			
			array_push($List_Commande, $commande);
		}
	
	
		return $List_Commande;
		
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}

?>