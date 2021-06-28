<?php

function Suppression_Commande($id_commande)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	try
	{
		/*Nb_Article ID_Article	ID_Commande*/
		
		$req = $bdd->prepare('DELETE FROM Composer WHERE ID_Commande='.$id_commande.';');

		$req->execute();
		
		$req = $bdd->prepare('DELETE FROM Commande WHERE ID_Commande='.$id_commande.';');

		$req->execute();
		
		return true;

    
	}

	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}

?>