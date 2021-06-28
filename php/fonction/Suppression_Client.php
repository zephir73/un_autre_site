<?php

function Suppression_Client($client)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_ID_Commande = array();
	$List_ID_Facture = array();
	
	try
	{
		
		$req = $bdd->prepare('SELECT ID_Commande FROM Commande WHERE ID_Client ='.$client->Id_Client_get().';');
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Commande = new Commande();
			$Commande->Id_Commande_set($donnee['ID_Commande']);
			array_push($List_ID_Commande,$Commande);
		}
		
		foreach($List_ID_Commande as $Commande)
		{
			$req = $bdd->prepare('SELECT ID_Facture FROM Facture WHERE ID_Commande = '.$Commande->Id_Commande_get().';');
			$req->execute();
			while($donnee=$req->fetch())
			{
				$Facture = new Facture();
				$Facture->Id_Facture_set($donnee['ID_Facture']);
				array_push($List_ID_Facture,$Facture);
			}
			
		}
		
		foreach($List_ID_Facture as $Facture)
		{
			$req = $bdd->prepare('DELETE from Facture WHERE ID_Facture = '.$Facture->Id_Facture_get().';');
			$req->execute();
			
		}
		
		foreach($List_ID_Commande as $Commande)
		{
			$req = $bdd->prepare('DELETE from Composer WHERE ID_Commande = '.$Commande->Id_Commande_get().';');
			$req->execute();
		}
		
		$req = $bdd->prepare('DELETE from Commande WHERE ID_Client = '.$client->Id_Client_get().';');
		$req->execute();
		
		
		$req = $bdd->prepare('DELETE from Client WHERE ID_Client = '.$client->Id_Client_get().';');
		$req->execute();
		
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
}
