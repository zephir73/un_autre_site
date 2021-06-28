<?php
class Facture
{
	private $_id_facture;
	private $_date_facture;
	private $_total_facture;
	private $_adresse_facture;
	private $_adresse_livraison;
	private $_id_commande;
	
	
	function Id_Facture_get()
	{
		return $this->_id_facture;
	}
	
	function Id_Facture_set($id_facture)
	{
		$this->_id_facture = $id_facture;
	}
	
	function Date_Facture_get()
	{
		return $this->_date_facture;
	}
	
	function Date_Facture_set($date_facture)
	{
		$this->_date_facture = $date_facture;
	}
	
	function Total_Facture_get()
	{
		return $this->_total_facture;
	}
	
	function Total_Facture_set($total_facture)
	{
		$this->_total_facture = $total_facture;
	}
	
	function Adresse_Facture_get()
	{
		return $this->_adresse_facture;
	}
	
	function Adresse_Facture_set($adresse_facture)
	{
		$this->_adresse_facture = $adresse_facture;
	}
	
	function Adresse_Livraison_get()
	{
		return $this->_adresse_livraison;
	}
	
	function Adresse_Livraison_set($adresse_livraison)
	{
		$this->_adresse_livraison = $adresse_livraison;
	}
	
	function Id_Commande_get()
	{
		return $this->_id_commande;
	}
	
	function Id_Commande_set($id_commande)
	{
		$this->_id_commande = $id_commande;
	}
	
}
?>