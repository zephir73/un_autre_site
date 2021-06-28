<?php


function Modification_Etat_Commande($id_commande)
{
	// 1 => payer 2 => pas payer 3=> en cours
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{
		$req = $bdd->prepare('UPDATE Commande SET ID_Etat_Commande = :ID_Etat_Commande WHERE ID_Commande = :ID_Commande');

	$req->execute(array(

    'ID_Commande' => $id_commande,

    'ID_Etat_Commande' => '1' // payer

    ));
	
	return 1;
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
		return false;
	}

	
//fin fonction	
}





?>