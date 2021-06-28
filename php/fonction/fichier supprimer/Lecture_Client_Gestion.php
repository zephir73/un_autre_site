<?php
require'/class/Client.php';

function Lecture_Client()
{
	
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	
	$List_Client = array();
	try
	{	
	/*ID_Client 	Nom_Client 	Prenom_Client 	Nb_Tel_Fix_Client 	Nb_Tel_Port_Client 	Adresse_Client 	Ville_Client 	Cp_Client 	Email_Client 	Mdp_Client 	ID_Droit */
		$req=$bdd->prepare("SELECT ID_Client, Nom_Client, Prenom_Client, Nb_Tel_Fix_Client, Nb_Tel_Port_Client, Adresse_Client, Ville_Client, Cp_Client, Email_Client, Mdp_Client, ID_Droit FROM Client");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Client = new Client();
			$Client->ID_Client_set($donnee['ID_Client']);
			$Client->Nom_Client_set($donnee['Nom_Client']);
			$Client->Prenom_Client_set($donnee['Prenom_Client']);
			$Client->Nb_Tel_Fix_Client_set($donnee['Nb_Tel_Fix_Client']);
			$Client->Nb_Tel_Port_Client_set($donnee['Nb_Tel_Port_Client']);
			$Client->Adresse_Client_set($donnee['Adresse_Client']);
			$Client->Ville_Client_set($donnee['Ville_Client']);
			$Client->Cp_Client_set($donnee['Cp_Client']);
			$Client->Email_Client_set($donnee['Email_Client']);
			$Client->Mdp_Client_set($donnee['Mdp_Client']);
			$Client->ID_Droit_set($donnee['ID_Droit']);
			
			array_push($List_Client, $Client);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
		
	return $List_Client;
}

function Lecture_Client_Nom($nom_client)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();

	$List_Client = array();
	try
	{	
	/*ID_Client 	Nom_Client 	Prenom_Client 	Nb_Tel_Fix_Client 	Nb_Tel_Port_Client 	Adresse_Client 	Ville_Client 	Cp_Client 	Email_Client 	Mdp_Client 	ID_Droit */
		$req=$bdd->prepare("SELECT ID_Client, Nom_Client, Prenom_Client, Nb_Tel_Fix_Client, Nb_Tel_Port_Client, Adresse_Client, Ville_Client, Cp_Client, Email_Client, Mdp_Client, ID_Droit FROM Client WHERE Nom_Client='".$nom_client."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Client = new Client();
			$Client->ID_Client_set($donnee['ID_Client']);
			$Client->Nom_Client_set($donnee['Nom_Client']);
			$Client->Prenom_Client_set($donnee['Prenom_Client']);
			$Client->Nb_Tel_Fix_Client_set($donnee['Nb_Tel_Fix_Client']);
			$Client->Nb_Tel_Port_Client_set($donnee['Nb_Tel_Port_Client']);
			$Client->Adresse_Client_set($donnee['Adresse_Client']);
			$Client->Ville_Client_set($donnee['Ville_Client']);
			$Client->Cp_Client_set($donnee['Cp_Client']);
			$Client->Email_Client_set($donnee['Email_Client']);
			$Client->Mdp_Client_set($donnee['Mdp_Client']);
			$Client->ID_Droit_set($donnee['ID_Droit']);
			
			array_push($List_Client, $Client);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
		
	return $List_Client;
}

function Lecture_Client_Email($email_client)
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();

	$List_Client = array();
	try
	{	
	/*ID_Client 	Nom_Client 	Prenom_Client 	Nb_Tel_Fix_Client 	Nb_Tel_Port_Client 	Adresse_Client 	Ville_Client 	Cp_Client 	Email_Client 	Mdp_Client 	ID_Droit */
		$req=$bdd->prepare("SELECT ID_Client, Nom_Client, Prenom_Client, Nb_Tel_Fix_Client, Nb_Tel_Port_Client, Adresse_Client, Ville_Client, Cp_Client, Email_Client, Mdp_Client, ID_Droit FROM Client WHERE Email_Client='".$email_client."';");
		
		
		$req->execute();
		while($donnee=$req->fetch())
		{
			$Client = new Client();
			$Client->ID_Client_set($donnee['ID_Client']);
			$Client->Nom_Client_set($donnee['Nom_Client']);
			$Client->Prenom_Client_set($donnee['Prenom_Client']);
			$Client->Nb_Tel_Fix_Client_set($donnee['Nb_Tel_Fix_Client']);
			$Client->Nb_Tel_Port_Client_set($donnee['Nb_Tel_Port_Client']);
			$Client->Adresse_Client_set($donnee['Adresse_Client']);
			$Client->Ville_Client_set($donnee['Ville_Client']);
			$Client->Cp_Client_set($donnee['Cp_Client']);
			$Client->Email_Client_set($donnee['Email_Client']);
			$Client->Mdp_Client_set($donnee['Mdp_Client']);
			$Client->ID_Droit_set($donnee['ID_Droit']);
			
			array_push($List_Client, $Client);
		}
		
		
		
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
		
	return $List_Client;
}

?>