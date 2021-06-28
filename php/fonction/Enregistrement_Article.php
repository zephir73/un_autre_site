<?php
function Enregistrement_Article($article)
{	
$bool_existe = false;
$id_article = 0;
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		try
		{
			// regarde si un nom d'article existe deja sur la bdd
			$req = $bdd->prepare('SELECT ID_Article, Nom_Article FROM Article WHERE Nom_Article="'.$article->Nom_Article_get().'";');
			$req->execute();
			while($donnee=$req->fetch())
			{
				$bool_existe = true ;// passe a	true si il y a un article avec le meme nom			
			}
			if($bool_existe == false)
			{
				// enregistre un article
				$req = $bdd->prepare('INSERT INTO Article(Nom_Article, Description_Article, Prix_Article, Tva_Article, Chemin_Image, ID_Categorie)
				VALUES(:Nom_Article, :Description_Article, :Prix_Article, :Tva_Article, :Chemin_Image, :ID_Categorie)'); 
				$req->execute(array(
				'Nom_Article' => $article->Nom_Article_get(),
				'Description_Article' => $article->Description_Article_get(),
				'Prix_Article' => $article->Prix_Article_get(),
				'Tva_Article' => $article->Tva_Article_get(),
				'Chemin_Image' => $article->Chemin_Image_get(),
				'ID_Categorie' => $article->Id_Categorie_get()
				));
				// recherche de l'article enregistréé pour avoir son id_article
				// pour pouvoir créé un stock pour cette article
				$req = $bdd->prepare('SELECT ID_Article, Nom_Article FROM Article WHERE Nom_Article="'.$article->Nom_Article_get().'";');
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$id_article = $donnee['ID_Article'];
				}
				
				// creation du stock de l'article
				$req = $bdd->prepare('INSERT INTO Stock(Qte_Stock, ID_Article) VALUES(:Qte_Stock, :ID_Article)');
				$req->execute(array(
				'Qte_Stock' => $article->Nb_Article_get(),
				'ID_Article' =>$id_article
				));
				return true;
			}
			else
			{
				return false;// aucun enregistrement effectuer
			}
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
}
?>