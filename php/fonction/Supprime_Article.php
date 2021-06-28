<?php

function Supprime_Article($article)
{
		$List_Article = array();
		$List_Article = Lecture_Article();
		$chemin_image = "";
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		
		try
		{
			foreach($List_Article as $value)
			{
				if($value->ID_Article_get() == $article->ID_Article_get())
				{
					$chemin_image = $value->Chemin_Image_get();
				}
			}
			
			unlink ($chemin_image);
			
			$bdd->exec("DELETE FROM Stock WHERE ID_Article=".$article->ID_Article_get().";");
			$bdd->exec("DELETE FROM Article WHERE ID_Article=".$article->ID_Article_get().";"); 
			
			return true;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	
}
?>