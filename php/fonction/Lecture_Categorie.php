<?php

function Lecture_Categorie()
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Categorie = array();
	try
	{	
		$req=$bdd->prepare("SELECT ID_Categorie, Nom_Categorie FROM Categorie ;");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Categorie = new Categorie();
			$Categorie->ID_Categorie_set($donnee['ID_Categorie']);
			$Categorie->Nom_Categorie_set($donnee['Nom_Categorie']);			
			
			array_push($List_Categorie, $Categorie);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	
	
	
	
	return $List_Categorie;
}



?>