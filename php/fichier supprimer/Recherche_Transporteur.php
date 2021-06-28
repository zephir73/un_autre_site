<?php
function Recherche_Transporteur($id_transporteur)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{	
		$req=$bdd->prepare("SELECT ID_Transporteur, Nom_Transporteur, Prix_Transporteur FROM transporteur WHERE ID_Transporteur=".$id_transporteur."");
		$req->execute();
		while($donnee=$req->fetch())
		{
			$transporteur = new Transporteur();
			$transporteur->Id_Transporteur_set($donnee['ID_Transporteur']);
			$transporteur->Nom_Transporteur_set($donnee['Nom_Transporteur']);
			$transporteur->Prix_Transporteur_set($donnee['Prix_Transporteur']);
		}
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	return $transporteur;
}
?>