<?php
class Commande
{
	private $_id_Commande;
	private $_date_Commande;
	private $_total_Commande;
	private $_id_Client;
	private $_id_Etat_Commande;
	private $_id_Transporteur;
	
	

/*accesseur*/

	public function Id_Commande_get()
	{
		return $this->_id_Commande;
	}

	public function Id_Commande_set($id_Commande)
	{
		$this->_id_Commande = $id_Commande;
	}
	
	public function Date_Commande_get()
	{
		return $this->_date_Commande;
	}

	public function Date_Commande_set($date_Commande)
	{
		$this->_date_Commande = $date_Commande;
	}
	
	public function Total_Commande_get()
	{
		return $this->_total_Commande;
	}

	public function Total_Commande_set($total_Commande)
	{
		$this->_total_Commande = $total_Commande;
	}

	public function Id_Client_get()
	{
		return $this->_id_Client;
	}

	public function Id_Client_set($id_Client)
	{
		$this->_id_Client = $id_Client;
	}
	
	public function Id_Etat_Commande_get()
	{
		return $this->_id_Etat_Commande;
	}

	public function Id_Etat_Commande_set($id_Etat_Commande)
	{
		$this->_id_Etat_Commande = $id_Etat_Commande;
	}
	
	public function Id_Transporteur_get()
	{
		return $this->_id_Transporteur;
	}

	public function Id_Transporteur_set($id_Transporteur)
	{
		$this->_id_Transporteur = $id_Transporteur;
	}

/*fin*/
}
?>