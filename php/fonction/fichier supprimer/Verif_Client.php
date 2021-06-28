<?php

function Verif_Client()
{
	if(!empty($_POST['Nom_Client'])) 
	{  
	  if(!empty($_POST['Prenom_Client']))
	  {	  
		  if(!empty($_POST['Nb_Tel_Fix_Client']))
		  {		  
			  if(!empty($_POST['Nb_Tel_Port_Client']))
			  {			  
				  if(!empty($_POST['Adresse_Client']))
				  {	  
					  if(!empty($_POST['Ville_Client']))
					  {	  
						  if(!empty($_POST['Cp_Client']))
						  {						  
							  if(!empty($_POST['Email_Client']))
							  {
								  if(!empty($_POST['Email_Client2']))
								  {
									  if ($_POST['Email_Client'] == $_POST['Email_Client2'])
									  {			  
										  if(!empty($_POST['Mdp_Client']))
										  {										  
											  if(!empty($_POST['Mdp_Client2']))
											  {
												  if($_POST['Mdp_Client'] == $_POST['Mdp_Client2'])
												  {
													  return true;	
												  }
												  else
												  {
													  echo('les 2 mots de passe ne sont pas les même');
													  return false;
												  }
											  }
											  else
											  {
												  echo('la confirmation du mot de passe n\'est pas remplis');
												  return false;
											  }
										  }
										  else
										  {
											  echo('le mot de passe n\'est pas remplis');
											  return false;
										  }
									  }
									  else
									  {
										  echo('les 2 mails ne sont pas pareil');
										  return false;
									  }
								  }
								  else
								  {
									  echo('mail de confirmation pas remplis');
									  return false;
								  }
							  }
							  else
							  {
								  echo('mail pas remplis');
								  return false;
							  }
						  }
						  else
						  {
							  echo('code postal pas remplis');
							  return false;
						  }
					  }
					  else
					  {
						  echo('ville pas remplis');
						  return false;
					  }
				  }
				  else
				  {
					  echo('addresse pas remplis');
					  return false;
				  }
			  }
			  else
			  {
				  echo('numero de tel portable pas remplis');
				  return false;
			  }
		  }
		  else
		  {
			  echo ('numero de tel fix pas remplis');
			  return false;
		  }
	  }
	  else
	  {
		  echo ('prenom pas remplis');
		  return false;
	  }
	}
	else
	{
		echo('nom pas remplis');
		return false;
	}
}

function Verif_Client_Modif()
{	
	if(!empty($_POST['Nom_Client'])) 
	{  
	  if(!empty($_POST['Prenom_Client']))
	  {	  
		  if(!empty($_POST['Nb_Tel_Fix_Client']))
		  {		  
			  if(!empty($_POST['Nb_Tel_Port_Client']))
			  {			  
				  if(!empty($_POST['Adresse_Client']))
				  {	  
					  if(!empty($_POST['Ville_Client']))
					  {	  
						  if(!empty($_POST['Cp_Client']))
						  {						  
							  if(!empty($_POST['Email_Client']))
							  {   
								  if(!empty($_POST['Mdp_Client']))
								  {								  
											  return true;	
								  }
								  else
								  {
									  echo('le mot de passe n\'est pas remplis');
									  return false;
								  }
							  }
							  else
							  {
								  echo('mail pas remplis');
								  return false;
							  }
						  }
						  else
						  {
							  echo('code postal pas remplis');
							  return false;
						  }
					  }
					  else
					  {
						  echo('ville pas remplis');
						  return false;
					  }
				  }
				  else
				  {
					  echo('addresse pas remplis');
					  return false;
				  }
			  }
			  else
			  {
				  echo('numero de tel portable pas remplis');
				  return false;
			  }
		  }
		  else
		  {
			  echo ('numero de tel fix pas remplis');
			  return false;
		  }
	  }
	  else
	  {
		  echo ('prenom pas remplis');
		  return false;
	  }
	}
	else
	{
		echo('nom pas remplis');
		return false;
	}

}

/*fin*/
?>