<?php
class Categorie
{
	private $_id_Categorie;
	private $_nom_Categorie;
	
	public function ID_Categorie_get()
	{
		return $this->_id_Categorie;
	}
	
	public function ID_Categorie_set($id_Categorie)
	{
		$this->_id_Categorie = $id_Categorie;
	}
	
	public function Nom_Categorie_get()
	{
		return $this->_nom_Categorie;
	}
	
	public function Nom_Categorie_set($nom_Categorie)
	{
		$tmp1 = substr($nom_Categorie,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($nom_Categorie,1);
		$tmp = $tmp1.$tmp;
		$this->_nom_Categorie = $tmp;
	}
}


?>