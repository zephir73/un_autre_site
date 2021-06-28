<?php

function Lecture_Etat_Commande()
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Etat_Commande = array();
	
	try
	{
		$req=$bdd->prepare("SELECT * FROM Etat_Commande ;");
		$req->execute();
		
		while($donnee=$req->fetch())
		{
			$Etat_Commande = new Etat_Commande();
			$Etat_Commande->Id_Etat_Commande_set($donnee['ID_Etat_Commande']);
			$Etat_Commande->Etat_Commande_set($donnee['Etat_Commande']);
			
			array_push($List_Etat_Commande, $Etat_Commande);
			
		}
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	return $List_Etat_Commande;
}

?>