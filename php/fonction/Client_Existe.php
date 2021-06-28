<?php

function Client_Existe($client)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	try
	{
		
		$req=$bdd->prepare("SELECT Email_Client,Mdp_Client FROM Client WHERE Email_Client='".$client->Email_Client_get()."' AND Mdp_Client='".$client->Mdp_Client_get()."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			if(!empty($donnee['Email_Client']))
			{
				
				return true;/*si donnee pas vide le client existe*/
			}
			else
			{
				return false;
			}
		}
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
}




?>