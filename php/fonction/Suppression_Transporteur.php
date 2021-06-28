<?php

function Suppression_Transporteur($id_transporteur)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	try
	{
		
		$req = $bdd->prepare('DELETE FROM Transporteur WHERE ID_Transporteur='.$id_transporteur.';');
		$req->execute();
		
		return true;
		
		
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
	
	
	
	
}

?>