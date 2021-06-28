<?php

function Article_Existe($article)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{	
		
		$req=$bdd->prepare("SELECT Nom_Article, Description_Article, Prix_Article, Chemin_Image, ID_Categorie FROM Article WHERE Nom_Article='".$article->Nom_Article_get()."' AND Description_Article='".
		$article->Description_Article_get()."' AND Prix_Article='".$article->Prix_Article_get()."' AND Chemin_Image='".$article->Chemin_Image_get()."' AND ID_Categorie='".$article->Id_Categorie_get()."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			if(empty($donnee['Nom_Article']))
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