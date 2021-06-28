<?php
class Transporteur
{
	private $_id_Transporteur;
	private $_nom_Transporteur;
	private $_prix_Transporteur;
	
	public function Id_Transporteur_get()
	{
		return $this->_id_Transporteur;
	}
	
	public function Id_Transporteur_set($id_Transporteur)
	{
		$this->_id_Transporteur = $id_Transporteur;
	}
	
	public function Nom_Transporteur_get()
	{
		return $this->_nom_Transporteur;
	}
	
	public function Nom_Transporteur_set($nom_Transporteur)
	{
		$tmp1 = substr($nom_Transporteur,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($nom_Transporteur,1);
		$tmp = $tmp1.$tmp;
		$this->_nom_Transporteur = $tmp;
	}
	
	public function Prix_Transporteur_get()
	{
		return $this->_prix_Transporteur;
	}
	
	public function Prix_Transporteur_set($prix_Transporteur)
	{
		$this->_prix_Transporteur = $prix_Transporteur;
	}
	
	
}
?>