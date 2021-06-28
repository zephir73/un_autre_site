<?php

function Enregistre_Categorie($categorie)
{
	if(Categorie_Existe($categorie) == true)
	{
		//echo 'La categorie existe';
		return false;
	}
	else
	{
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		
		try
		{
			
			$req = $bdd->prepare('INSERT INTO Categorie(Nom_Categorie)
			VALUES(:Nom_Categorie)'); 
			$req->execute(array(
			'Nom_Categorie' => $categorie->Nom_Categorie_get()));
			
			return true;
			
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}
	
		/*fin fonction enregistre categorie*/
}

?>