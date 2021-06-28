<?php

function Enregistrement_Facture($facture)
{
	try
	{
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
			
		$req = $bdd->prepare('INSERT INTO Facture(Date_Facture,Total_Facture,Adresse_Facture,Adresse_Livraison,ID_Commande)
			VALUES(:Date_Facture, :Total_Facture, :Adresse_Facture, :Adresse_Livraison, :ID_Commande)'); 
			$req->execute(array(
			'Date_Facture' => $facture->Date_Facture_get(),
			'Total_Facture' => $facture->Total_Facture_get(),
			'Adresse_Facture' => $facture->Adresse_Facture_get(),
			'Adresse_Livraison' => $facture->Adresse_Livraison_get(), 
			'ID_Commande' => $facture->Id_Commande_get()
			));
			
			return true;
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
		return false;
	}
}
?>