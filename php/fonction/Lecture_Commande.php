<?php

function Lecture_Commande($bool)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Commande = array();
	try
	{	
		$req=$bdd->prepare("SELECT * FROM Commande ;");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Commande = new Commande();
			$Commande->Id_Commande_set($donnee['ID_Commande']);
			$Commande->Date_Commande_set($donnee['Date_Commande']);
			$Commande->Total_Commande_set($donnee['Total_Commande']);
			$Commande->Id_Client_set($donnee['ID_Client']);
			$Commande->Id_Etat_Commande_set($donnee['ID_Etat_Commande']);
			$Commande->Id_Transporteur_set($donnee['ID_Transporteur']);
			
			
			array_push($List_Commande, $Commande);
		}
		if($bool == true)
		{
			//retrouve le nom du client l'etat de la commande et le nom du transporteur
			//modifie la liste les ID devienent des nom 
			$x=0;
			foreach($List_Commande as $value)
			{
				$req=$bdd->prepare("SELECT Nom_Client FROM Client WHERE ID_Client=".$value->Id_Client_get().";");
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$List_Commande[$x]->Id_Client_set($donnee['Nom_Client']);

				}
				
				$req=$bdd->prepare("SELECT Etat_Commande FROM Etat_commande WHERE ID_Etat_Commande=".$value->Id_Etat_Commande_get().";");
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$List_Commande[$x]->Id_Etat_Commande_set($donnee['Etat_Commande']);
				}
				
				$req=$bdd->prepare("SELECT Nom_Transporteur FROM Transporteur WHERE ID_Transporteur=".$value->Id_Transporteur_get().";");
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$List_Commande[$x]->Id_Transporteur_set($donnee['Nom_Transporteur']);
				}
				
				$x++;
			}
		
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	return $List_Commande;
	
}	


?>