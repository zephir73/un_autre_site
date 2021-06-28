<?php


function Modification_Stock($id_article,$qte_acheter)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	try
	{
		
		$req = $bdd->prepare('SELECT Qte_Stock FROM Stock WHERE ID_Article='.$id_article.';');
		$req->execute();
		
		while($donnee=$req->fetch())
		{
			$qte_stock = $donnee['Qte_Stock'];
		}
		
		$reste = $qte_stock - $qte_acheter ;
		
		$req = $bdd->prepare('UPDATE Stock SET Qte_Stock='.$reste.' WHERE ID_Article='.$id_article.';');
		$req->execute();
		
		return true;
		
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
?>