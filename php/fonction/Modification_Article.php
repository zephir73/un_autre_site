<?php

function Modification_Article($article)
{

		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
	
		try
		{
			$req = $bdd->prepare('UPDATE Article SET Nom_Article = :Nom_Article, Description_Article = :Description_Article,
			Prix_Article = :Prix_Article,Tva_Article = :Tva_Article, Chemin_Image = :Chemin_Image, ID_Categorie = :ID_Categorie WHERE ID_Article = :ID_Article');
			$req->execute(array(
			'Nom_Article' => $article->Nom_Article_get(),
			'Description_Article' => $article->Description_Article_get(),
			'Prix_Article' => $article->Prix_Article_get(),
			'Tva_Article' => $article->Tva_Article_get(),
			'Chemin_Image' => $article->Chemin_Image_get(),
			'ID_Categorie' => $article->Id_Categorie_get(),
			'ID_Article' => $article->ID_Article_get()
			));
			
			
			// Modification du stock de l'article
			
			$req = $bdd->prepare('UPDATE Stock SET Qte_Stock = :Qte_Stock WHERE ID_Article = :ID_Article');
			$req->execute(array(
			'Qte_Stock' => $article->Nb_Article_get(),
			'ID_Article' =>$article->Id_Article_get()
			));
			
			
			//echo 'L\'article a bien été Modifier !';
			//var_dump($article);
			//var_dump($req);
			
			
			return true;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
	
	
}


?>