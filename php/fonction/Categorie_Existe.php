<?php


function Categorie_Existe($categorie)
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{
		
		$req=$bdd->prepare("SELECT Nom_Categorie FROM Categorie WHERE Nom_Categorie='".$categorie->Nom_Categorie_get()."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			if(empty($donnee['Nom_Categorie']))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
}
?>