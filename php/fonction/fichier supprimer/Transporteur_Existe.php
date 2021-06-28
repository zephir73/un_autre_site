<?php

function Transporteur_Existe($transporteur)
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{
		
		$req=$bdd->prepare("SELECT Nom_Transporteur FROM transporteur WHERE Nom_Transporteur='".$transporteur->Nom_Transporteur_get()."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			if(empty($donnee['Nom_Transporteur']))
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
}
?>