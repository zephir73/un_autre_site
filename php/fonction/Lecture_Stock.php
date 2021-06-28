<?php

function Lecture_Stock()
{
	$bdd_connection = new Connection();
	$bdd=$bdd_connection->Bdd_get();
	$List_Stock=array();
	
	try
	{
		$req=$bdd->prepare("SELECT ID_Stock, Qte_Stock, ID_Article FROM Stock ;");
		$req->execute();
			
		while($donnee=$req->fetch())
		{
			$stock = new Stock();
			$stock->ID_Stock_set($donnee['ID_Stock']);
			$stock->Qte_Stock_set($donnee['Qte_Stock']);
			$stock->ID_Article_set($donnee['ID_Article']);
			
			
			array_push($List_Stock,$stock);
		}
		
		//var_dump($List_Stock);
		
		
		return $List_Stock;
	}
	catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	
}

?>