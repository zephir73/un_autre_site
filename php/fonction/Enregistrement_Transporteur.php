<?php


function Enregistrement_Transporteur($transporteur)
{
	
	$bool_exist = false;		
		$bdd_connection = new Connection();
		$bdd=$bdd_connection->Bdd_get();
		
		try
		{
			
			$req=$bdd->prepare("SELECT Nom_Transporteur FROM Transporteur WHERE Nom_Transporteur='".$transporteur->Nom_Transporteur_get()."';");
		
			$req->execute();
			while($donnee=$req->fetch())
			{
				if(empty($donnee['Nom_Transporteur']))
				{
					$bool_exist = false; // si pas trouver
				}
				else
				{
					$bool_exist = true; // si trouver
				}
			}
			
			
			if($bool_exist == false) // si le transporteur existe pas on enregistre
			{
			
				$req = $bdd->prepare('INSERT INTO Transporteur(Nom_Transporteur, Prix_Transporteur)
				VALUES(:Nom_Categorie, :Prix_Transporteur)'); 
				$req->execute(array(
				'Nom_Categorie' => $transporteur->Nom_transporteur_get(),
				'Prix_Transporteur' => $transporteur->Prix_Transporteur_get()
				));
				
				return true;
			}
			else
			{
				return false;
			}
			
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		
	
}

?>