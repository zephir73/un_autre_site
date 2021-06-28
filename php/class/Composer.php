<?php
class Composer
{
	private $_nb_Article;
	private $_prix_Article;
	private $_id_Article;
	private $_tva_article;
	private $_id_Commande;
	
	public function Nb_Article_get()
	{
		return $this->_nb_Article;
	}
	
	public function Nb_Article_set($Nb_Article)
	{
		$this->_nb_Article = $Nb_Article;
	}
	
	public function Prix_Article_get()
	{
		return $this->_prix_Article;
	}
	
	public function Prix_Article_set($Prix_Article)
	{
		$this->_prix_Article = $Prix_Article;
	}
	
	public function Tva_Article_get()
	{
		return $this->_tva_article;
	}
	
	public function Tva_Article_set($Tva_Article)
	{
		$this->_tva_article = $Tva_Article;
	}
	
	public function Id_Article_get()
	{
		return $this->_id_Article;
	}
	
	public function Id_Article_set($Id_Article)
	{
		$this->_id_Article = $Id_Article;
	}
	
	public function Id_Commande_get()
	{
		return $this->_id_Commande;
	}

	public function Id_Commande_set($id_Commande)
	{
		$this->_id_Commande = $id_Commande;
	}
}
// fin
?>