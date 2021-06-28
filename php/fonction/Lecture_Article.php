<?php

function Lecture_Article()
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Article = array();
	try
	{	
		$req=$bdd->prepare("SELECT ID_Article, Nom_Article, Description_Article, Prix_Article, Tva_Article, Chemin_Image, ID_Categorie FROM Article ;");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Article = new Article();
			$Article->Id_Article_set($donnee['ID_Article']);
			$Article->Nom_Article_set($donnee['Nom_Article']);
			$Article->Description_Article_set($donnee['Description_Article']);
			$Article->Prix_Article_set($donnee['Prix_Article']);
			$Article->Tva_Article_set($donnee['Tva_Article']);
			$Article->Chemin_Image_set($donnee['Chemin_Image']);
			$Article->ID_Categorie_set($donnee['ID_Categorie']);
			
			
			array_push($List_Article, $Article);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	return $List_Article;
}


function Lecture_Article_Categorie($categorie)
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Article = array();
	try
	{	
		$req=$bdd->prepare("SELECT ID_Article, Nom_Article, Description_Article, Prix_Article, Tva_Article, Chemin_Image, ID_Categorie FROM Article WHERE ID_Categorie=".$categorie." ;");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Article = new Article();
			$Article->Id_Article_set($donnee['ID_Article']);
			$Article->Nom_Article_set($donnee['Nom_Article']);
			$Article->Description_Article_set($donnee['Description_Article']);
			$Article->Prix_Article_set($donnee['Prix_Article']);
			$Article->Tva_Article_set($donnee['Tva_Article']);
			$Article->Chemin_Image_set($donnee['Chemin_Image']);
			$Article->ID_Categorie_set($donnee['ID_Categorie']);
			
			
			array_push($List_Article, $Article);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	
	
	
	
	
	return $List_Article;
}



?>