<?php
class Stock
{
	private $_id_stock;
	private $_qte_stock;
	private $_id_article;
	
	
	function ID_Stock_get()
	{
		return $this->_id_article;
	}
	
	function ID_Stock_set($id_stock)
	{
		$this->_id_stock = $id_stock;
	}
	
	function Qte_Stock_get()
	{
		return $this->_qte_stock;
	}
	
	function Qte_Stock_set($qte_stock)
	{
		$this->_qte_stock = $qte_stock;
		
	}
	
	function ID_Article_get()
	{
		return $this->_id_article;
	}
	
	function ID_Article_set($id_article)
	{
		$this->_id_article = $id_article;
	}
	
}
?>