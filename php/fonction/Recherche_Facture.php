<?php


function Recherche_Facture($id_commande)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Facture = array();
	
	try
	{	
	/*ID_Facture	Date_Facture	Total_Facture	Adresse_Facture		Adresse_Livraison	ID_Commande*/
		$req=$bdd->prepare("SELECT ID_Facture, Date_Facture, Total_Facture, Adresse_Facture, Adresse_Livraison, ID_Commande FROM Facture WHERE ID_Commande=".$id_commande."");
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Facture = new Facture();
			$Facture->ID_Facture_set($donnee['ID_Facture']);
			$Facture->Date_Facture_set($donnee['Date_Facture']);
			$Facture->Total_Facture_set($donnee['Total_Facture']);
			$Facture->Adresse_Facture_set($donnee['Adresse_Facture']);
			$Facture->Adresse_Livraison_set($donnee['Adresse_Livraison']);
			$Facture->ID_Commande_set($donnee['ID_Commande']);
			
			array_push($List_Facture, $Facture);
			
		}
		
		return $List_Facture;
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
		
	
	
}
?>