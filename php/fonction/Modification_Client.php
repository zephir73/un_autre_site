<?php

function Modification_Client($client)
{
	
	$bdd_connection = new Connection();
	$bdd = $bdd_connection->Bdd_get();
	
	/*/ avant de modifier le client je regarde si il existe
	if(Client_Existe($client) == true)
	{
		return false;
	}
	*/

		try
		{

				/*ID_Client	Nom_Client	Prenom_Client	Nb_Tel_Fix_Client	Nb_Tel_Port_Client	Adresse_Client	Ville_Client	Cp_Client	Email_Client	Mdp_Client	ID_Droit*/

			$req = $bdd->prepare('UPDATE Client
			SET Nom_Client = :Nom_Client,
			Prenom_Client = :Prenom_Client,
			Nb_Tel_Fix_Client = :Nb_Tel_Fix_Client,
			Nb_Tel_Port_Client = :Nb_Tel_Port_Client,
			Adresse_Client = :Adresse_Client,
			Ville_Client = :Ville_Client,
			Cp_Client = :Cp_Client,
			Email_Client = :Email_Client,
			Mdp_Client = :Mdp_Client,
			ID_Droit = :ID_Droit
			WHERE ID_Client= :ID_Client ;');
		
			
			$req->execute(array(
			'ID_Client' => $client->ID_Client_get(),
			'Nom_Client' => $client->Nom_Client_get(),
			'Prenom_Client' => $client->Prenom_Client_get(),
			'Nb_Tel_Fix_Client' => $client->Nb_Tel_Fix_Client_get(),
			'Nb_Tel_Port_Client' => $client->Nb_Tel_Port_Client_get(),
			'Adresse_Client' => $client->Adresse_Client_get(),
			'Ville_Client' => $client->Ville_Client_get(),
			'Cp_Client' => $client->Cp_Client_get(),
			'Email_Client' => $client->Email_Client_get(),
			'Mdp_Client' => $client->Mdp_Client_get(),
			'ID_Droit' => $client->ID_Droit_get()
			));
			
			
			return true;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
	
	


}

?>