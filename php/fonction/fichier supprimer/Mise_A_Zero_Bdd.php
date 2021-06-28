<?php

function Mise_A_Zero_Bdd()
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
		
		try
		{
			$req=$bdd->prepare('DELETE FROM facture');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM composer');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM commande');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM transporteur');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM stock');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM article');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM categorie');
			$req->execute();
			
			$req=$bdd->prepare('DELETE FROM client');
			$req->execute();
			
			$req = $bdd->prepare('INSERT INTO client(Nom_Client, Prenom_Client, Nb_Tel_Fix_Client, Nb_Tel_Port_Client, Adresse_Client, Ville_Client, Cp_Client, Email_Client, Mdp_Client,ID_Droit)
			VALUES(:Nom_Client, :Prenom_Client, :Nb_Tel_Fix_Client, :Nb_Tel_Port_Client, :Adresse_Client, :Ville_Client, :Cp_Client, :Email_Client, :Mdp_Client, :ID_Droit)'); 
			$req->execute(array(
			'Nom_Client' => 'Cyprien',
			'Prenom_Client' => 'Didier',
			'Nb_Tel_Fix_Client' => '+330479364826',
			'Nb_Tel_Port_Client' => '+330479364826',
			'Adresse_Client' => 'Le chef lieu',
			'Ville_Client' => 'Betton-bettonnet',
			'Cp_Client' => '73390',
			'Email_Client' => 'didier.cyprien@gmail.com',
			'Mdp_Client' => 'mdp',
			'ID_Droit' => '2'
			));

			return true;
			
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
}

?>