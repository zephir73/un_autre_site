<?php
class Client
{
	private $_id_Client;
	private $_nom_Client;
	private $_prenom_Client;
	private $_nb_Tel_Fix_Client;
	private $_nb_Tel_Port_Client;
	private $_adresse_Client;
	private $_ville_Client;
	private $_cp_Client;
	private $_email_Client;
	private $_mdp_Client;
	private $_id_Droit;

/*accesseur*/

	public function Id_Client_get()
	{
		return $this->_id_Client;
	}

	public function Id_Client_set($id_Client)
	{
		$this->_id_Client = $id_Client;
	}
	
	public function Nom_Client_get()
	{
		return $this->_nom_Client;
	}
	
	public function Nom_Client_set($nom_Client)
	{
		$tmp = strtoupper($nom_Client);
		$this->_nom_Client = $tmp;
	}
	
	public function Prenom_Client_get()
	{
		return $this->_prenom_Client;
	}
	
	public function Prenom_Client_set($prenom_Client)
	{
		$tmp1 = substr($prenom_Client,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($prenom_Client,1);
		$tmp = $tmp1.$tmp;
		$this->_prenom_Client = $tmp;
	}
	
	public function Nb_Tel_Fix_Client_get()
	{
		return $this->_nb_Tel_Fix_Client;
	}
	
	public function Nb_Tel_Fix_Client_set($nb_Tel_Fix_Client)
	{
		$this->_nb_Tel_Fix_Client = $nb_Tel_Fix_Client;
	}
	
	public function Nb_Tel_Port_Client_get()
	{
		return $this->_nb_Tel_Port_Client;
	}
	
	public function Nb_Tel_Port_Client_set($nb_Tel_Port_Client)
	{
		$this->_nb_Tel_Port_Client = $nb_Tel_Port_Client;
	}
	
	public function Adresse_Client_get()
	{
		return $this->_adresse_Client;
	}
	
	public function Adresse_Client_set($adresse_Client)
	{
		$tmp1 = substr($adresse_Client,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($adresse_Client,1);
		$tmp = $tmp1.$tmp;
		$this->_adresse_Client = $tmp;
	}
	
	public function Ville_Client_get()
	{
		return $this->_ville_Client;
	}
	
	public function Ville_Client_set($ville_Client)
	{
		$tmp1 = substr($ville_Client,0,1);
		$tmp1 = strtoupper($tmp1);
		$tmp = substr($ville_Client,1);
		$tmp = $tmp1.$tmp;
		$this->_ville_Client = $tmp;
	}
	
	public function Cp_Client_get()
	{
		return $this->_cp_Client;
	}
	
	public function Cp_Client_set($cp_Client)
	{
		$this->_cp_Client = $cp_Client;
	}
	
	public function Email_Client_get()
	{
		return $this->_email_Client;
	}
	
	public function Email_Client_set($email_Client)
	{
		$this->_email_Client = $email_Client;
	}
	
	public function Mdp_Client_get()
	{
		return $this->_mdp_Client;
	}
	
	public function Mdp_Client_set($mdp_Client)
	{
		$this->_mdp_Client = $mdp_Client;
	}

	public function ID_Droit_get()
	{
		return $this->_id_Droit;
	}
	
	public function ID_Droit_set($id_Droit)
	{
		$this->_id_Droit = $id_Droit;
	}





/*fin*/
}
?>