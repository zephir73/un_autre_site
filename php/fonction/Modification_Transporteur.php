<?php

function Modification_Transporteur($transporteur)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	try
	{
		$req = $bdd->prepare('UPDATE Transporteur
		SET Nom_Transporteur = :Nom_Transporteur,
		Prix_Transporteur = :Prix_Transporteur
		WHERE Id_Transporteur = :Id_Transporteur;');
		
		$req->execute(array(
		'Nom_Transporteur' => $transporteur->Nom_Transporteur_get(),
		'Prix_Transporteur' => $transporteur->Prix_Transporteur_get(),
		'Id_Transporteur' => $transporteur->Id_Transporteur_get()
		));
		
		return true;
		
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
}
?>