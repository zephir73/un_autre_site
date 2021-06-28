<?php
class Etat_Commande
{
	private $_id_etat_commande;
	private $_etat_commande;
	
	function Id_Etat_Commande_get()
	{
		return $this->_id_etat_commande;
	}
	
	function Id_Etat_Commande_set($id_etat_commande)
	{
		$this->_id_etat_commande = $id_etat_commande;
	}
	
	function Etat_Commande_get()
	{
		return $this->_etat_commande;
	}
	
	function Etat_Commande_set($etat_commande)
	{
		$this->_etat_commande = $etat_commande;
	}
	
}
?>