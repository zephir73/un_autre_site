<?php

function Modification_Nb_Article_Commande($id_commande,$id_article,$qte)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{
		$req = $bdd->prepare('UPDATE composer SET Nb_Article = :Nb_Article WHERE ID_Commande = :ID_Commande AND ID_Article = :ID_Article');

	$req->execute(array(

    'Nb_Article' => $qte,

    'ID_Commande' => $id_commande,
	
	'ID_Article' => $id_article

    ));
	
	
	return true;
	
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
		return false;
	}
}

?>