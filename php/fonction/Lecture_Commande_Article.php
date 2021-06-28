<?php

function Lecture_Commande_Article($id_commande)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Article = array();
	$List_Composer = array();
	
	try
	{	
		$req=$bdd->prepare("SELECT Nb_Article, Prix_Article, Tva_Article, ID_Article FROM Composer WHERE ID_Commande=".$id_commande.";");
		$req->execute();
		
		while($donnee=$req->fetch())
		{
			$composer = new Composer();
			$composer->Nb_Article_set($donnee['Nb_Article']);
			$composer->Prix_Article_set($donnee['Prix_Article']);
			$composer->Tva_Article_set($donnee['Tva_Article']);
			$composer->Id_Article_set($donnee['ID_Article']);
			$composer->Id_Commande_set($id_commande);
			array_push($List_Composer,$composer);
		}
	
		foreach ($List_Composer as $value)
		{
			$req=$bdd->prepare("SELECT ID_Article, Nom_Article, Description_Article, Prix_Article, Tva_Article, Chemin_Image, ID_Categorie FROM Article WHERE ID_Article=".$value->Id_Article_get()." ;");
			
			
			$req->execute();
			while($donnee=$req->fetch())
			{
				$Article = new Article();
				$Article->Id_Article_set($donnee['ID_Article']);
				$Article->Nom_Article_set($donnee['Nom_Article']);
				$Article->Description_Article_set($donnee['Description_Article']);
				$Article->Prix_Article_set($value->Prix_Article_get());// prend le pris de l'article sur la table composer
				$Article->Tva_Article_set($value->Tva_Article_get());// prend la tva sur la table composer
				$Article->Chemin_Image_set($donnee['Chemin_Image']);
				$Article->ID_Categorie_set($donnee['ID_Categorie']);
				$Article->Nb_Article_set($value->Nb_Article_get());
				
				
				array_push($List_Article, $Article);
			}
		}
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	
	
	
	
	return $List_Article;
}

?>