<?php

function Modification_Commande($commande,$List_Composer)
{
	$bdd_connection = new Connection();
	$bdd = $bdd_connection->Bdd_get();
	
	try
	{
		/*ID_Commande	Date_Commande	Total_Commande	ID_Client	ID_Etat_Commande	ID_Transporteur*/
		$req = $bdd->prepare('UPDATE Commande SET Date_Commande = :Date_Commande, Total_Commande = :Total_Commande, ID_Client = :ID_Client, ID_Etat_Commande = :ID_Etat_Commande, ID_Transporteur = :ID_Transporteur WHERE ID_Commande = :ID_Commande');
	
		
		$req->execute(array(
		'Date_Commande' => $commande->Date_Commande_get(),
		'Total_Commande' => $commande->Total_Commande_get(),
		'ID_Client' => $commande->Id_Client_get(),
		'ID_Etat_Commande' => $commande->Id_Etat_Commande_get(),
		'ID_Transporteur' => $commande->Id_Transporteur_get(),
		'ID_Commande' => $commande->Id_Commande_get()
		
		));
		
		
		// on efface toute les referance de la commande dans la table composer
		// puis on reecrit tout avec les nouvelles valeurs
		
		$req = $bdd->prepare('DELETE FROM Composer WHERE ID_Commande = '.$commande->ID_Commande_get().';');
		$req->execute();
		
		foreach($List_Composer as $value)
		{
			$req = $bdd->prepare('INSERT INTO Composer(Nb_Article,Prix_Article,Tva_Article,ID_Article,ID_Commande)
				VALUES(:Nb_Article, :Prix_Article, :Tva_Article, :ID_Article, :ID_Commande)'); 
				$req->execute(array(				
				'Nb_Article'=>$value->Nb_Article_get(),
				'Prix_Article'=>$value->Prix_Article_get(),
				'Tva_Article'=>$value->Tva_Article_get(),
				'ID_Article' => $value->Id_Article_get(),
				'ID_Commande' => $commande->Id_Commande_get()
				));
				
		}
					
		return true;
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
}

?>