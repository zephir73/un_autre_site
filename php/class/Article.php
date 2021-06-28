<?php
class Article
{
	private $_id_Article;
	private $_nom_Article;
	private $_description_Article;
	private $_prix_Article;
	private $_tva_article;
	private $_chemin_Image;
	private $_id_Categorie;
	
	private $_nb_Article;
	
	public function Nb_Article_get()
	{
		return $this->_nb_Article;
	}
	
	public function Nb_Article_set($nb_Article)
	{
		$this->_nb_Article = $nb_Article;
	}
	
	/*accesseur*/
	public function Id_Article_get()
	{
		return $this->_id_Article;
	}

	public function Id_Article_set($id_Article)
	{
		$this->_id_Article = $id_Article;
	}
	
	public function Nom_Article_get()
	{
		return $this->_nom_Article;
	}
	
	public function Nom_Article_set($nom_Article)
	{
		$tmp1 = substr($nom_Article,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($nom_Article,1);
		$tmp = $tmp1.$tmp;
		$this->_nom_Article = $tmp;
	}
	
	public function Description_Article_get()
	{
		return $this->_description_Article;
	}
	
	public function Description_Article_set($description_Article)
	{
		$tmp1 = substr($description_Article,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($description_Article,1);
		$tmp = $tmp1.$tmp;
		$this->_description_Article = $tmp;
	}
	
	public function Prix_Article_get()
	{
		return $this->_prix_Article;
	}
	
	public function Prix_Article_set($prix_Article)
	{
		$this->_prix_Article = $prix_Article;
	}
	
	public function Tva_Article_get()
	{
		return $this->_tva_article;
	}
	
	public function Tva_Article_set($Tva_Article)
	{
		$this->_tva_article = $Tva_Article;
	}
	
	public function Chemin_Image_get()
	{
		return $this->_chemin_Image;
	}
	
	public function Chemin_Image_set($chemin_Image)
	{
		$this->_chemin_Image = $chemin_Image;
	}
	
	public function Id_Categorie_get()
	{
		return $this->_id_Categorie;
	}
	
	public function Id_Categorie_set($id_Categorie)
	{
		$this->_id_Categorie = $id_Categorie;
	}
}



?>