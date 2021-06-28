<?php

function Enregistrement_Commande($commande,$List_Composer,$id_Commande)
{	
	try
	{
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		
		if($id_Commande == 0)// enregistre la commande
		{			
			    $req = $bdd->prepare('INSERT INTO Commande(Date_Commande,Total_Commande,ID_Client,ID_Etat_Commande,ID_Transporteur)
				VALUES(:Date_Commande, :Total_Commande, :ID_Client, :ID_Etat_Commande, :ID_Transporteur)'); 
				$req->execute(array(
				'Date_Commande' => $commande->Date_Commande_get(),
				'Total_Commande' => $commande->Total_Commande_get(),
				'ID_Client' => $commande->Id_Client_get(),
				'ID_Etat_Commande' => $commande->Id_Etat_Commande_get(),
				'ID_Transporteur' => $commande->Id_Transporteur_get()
				));
			
				$req = $bdd->prepare('SELECT ID_Commande,ID_Client FROM Commande WHERE ID_Etat_Commande='.$commande->Id_Etat_Commande_get().' AND ID_Client='.$commande->Id_Client_get().';');
				$req->execute();
				
				while($donnee=$req->fetch())
				{
					$commande->Id_Commande_set($donnee['ID_Commande']);
				}
				
				foreach ($List_Composer as $value)
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
					
					
					// change le stock des articles commander si l'id_Commande est 1 (payer)
					// si non la commande est juste enregistrée
					if($commande->ID_Etat_Commande_get() == 1)
					{
						Modification_Stock($value->Id_Article_get(),$value->Nb_Article_get());
					}
					
				}	
				
		}
		else // modifie la commande car c'est un ancien panier
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
					
				// change le stock des articles commander si l'id_Commande est 1 (payer)
				// si non la commande est juste enregistrée
				if($commande->ID_Etat_Commande_get() == 1)
				{
					Modification_Stock($value->Id_Article_get(),$value->Nb_Article_get());
				}
				
					
			}
			
			
		}
							
			return $commande->ID_Commande_get();
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
		return false;
	}
	
}

?>