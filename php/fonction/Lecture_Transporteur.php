<?php

function Lecture_Transporteur()
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	$List_Transporteur = array();
	try
	{	
		$req=$bdd->prepare("SELECT ID_Transporteur, Nom_Transporteur, Prix_Transporteur FROM Transporteur");
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$transporteur = new Transporteur();
			$transporteur->Id_Transporteur_set($donnee['ID_Transporteur']);
			$transporteur->Nom_Transporteur_set($donnee['Nom_Transporteur']);
			$transporteur->Prix_Transporteur_set($donnee['Prix_Transporteur']);
			
			array_push($List_Transporteur, $transporteur);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
		
	return $List_Transporteur;
}

?>