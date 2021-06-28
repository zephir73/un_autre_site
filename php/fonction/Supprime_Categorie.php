<?php

function Supprime_Categorie($categorie)
{
	if(Categorie_Existe($categorie) == true)
	{
		return false;
	}
	else
	{
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		
		try
		{
			// on efface les articles de la table stock qui on la meme categorie
			$List_Article = Lecture_Article();
			
			foreach($List_Article as $value)
			{
				if($value->ID_Categorie_get() == $categorie->ID_Categorie_get())
				{
					$req=$bdd->prepare("DELETE FROM Stock WHERE ID_Article=".$value->ID_Article_get().";");
					$req->execute();
				}
					
			}
			
			// on efface les article de la table article qui on la meme categorie
			// puis on efface la categorie de la table categorie
			$req=$bdd->prepare("DELETE FROM Article WHERE ID_Categorie=".$categorie->ID_Categorie_get().";");
			$req->execute();
			
			$req=$bdd->prepare("DELETE FROM Categorie WHERE ID_Categorie=".$categorie->ID_Categorie_get().";"); 
			$req->execute();
	
			return true;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}
	
	/*fin fonction Supprime_Categorie*/
}




?>