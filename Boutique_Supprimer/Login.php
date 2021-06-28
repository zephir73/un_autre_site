<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Client = array();
$Client = new Client();

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Login Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Login.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Login_500px.css" type="text/css" /> 
</head>
<body>
<?php
include 'Header.php';
?>
<!--/*article ou corps de la page*/-->
<article>
<center><h1 style="color:red">La Boutique n'est pas opérationnelle, il est inutile de s'inscrire</h1></center>
<?php

//gestion des boutons

if(isset($_POST['Email_Client']) && !empty($_POST['Email_Client']) && isset($_POST['Se_Loguer'])) 
{
  $Client->Email_Client_set($_POST['Email_Client']);
  
  if(isset($_POST['Mdp_Client']) && !empty($_POST['Mdp_Client']))
  {
	  $Client->Mdp_Client_set($_POST['Mdp_Client']);
	  
		if(Client_Existe($Client))
		{
			$List_Client = Lecture_Client_Email_Mdp($Client->Email_Client_get(),$Client->Mdp_Client_get());
			$arrlength = count($List_Client);
			for($x = 0; $x < $arrlength; $x++) 
			{
				$_SESSION['ID_Client'] = $List_Client[$x]->ID_Client_get();
				$_SESSION['Nom_Client'] = $List_Client[$x]->Nom_Client_get();
				$_SESSION['Prenom_Client'] = $List_Client[$x]->Prenom_Client_get();
				$_SESSION['Nb_Tel_Fix_Client'] = $List_Client[$x]->Nb_Tel_Fix_Client_get();
				$_SESSION['Nb_Tel_Port_Client'] = $List_Client[$x]->Nb_Tel_Port_Client_get();
				$_SESSION['Adresse_Client'] = $List_Client[$x]->Adresse_Client_get();
				$_SESSION['Ville_Client'] = $List_Client[$x]->Ville_Client_get();
				$_SESSION['Cp_Client'] = $List_Client[$x]->Cp_Client_get();
				$_SESSION['Email_Client'] = $List_Client[$x]->Email_Client_get();
				$_SESSION['Mdp_Client'] = $List_Client[$x]->Mdp_Client_get();
				$_SESSION['ID_Droit'] = $List_Client[$x]->ID_Droit_get();
				
				// lire sur la bdd s'il y a une commande qui est en cours
				// si oui la mettre dans le panier et l'afficher.
				$List_Commande =  Recherche_Commande(0,$_SESSION['Email_Client'],3); // 3 = en cours
				
				
				if(count($List_Commande) >=1)
				{
					
					$ok = true;
					if(!isset($_SESSION['panier']) || $_SESSION['panier']['id_article'][0] == NULL)
					{
						
						creation_panier();
						$x=0;
						foreach($List_Commande as $value)
						{
							$List_Article = Lecture_Commande_Article($List_Commande[0]->Id_Commande_get());
							$_SESSION['id_commande'] = $List_Commande[0]->Id_Commande_get();
							
							foreach($List_Article as $value2)
							{
								$_SESSION['panier']['id_article'][$x] = $value2->ID_Article_get();
								$_SESSION['panier']['nom_article'][$x] = $value2->Nom_Article_get();
								$_SESSION['panier']['qte'][$x] = $value2->Nb_Article_get();
								$_SESSION['panier']['prix'][$x] = $value2->Prix_Article_get();
								
								$_SESSION['panier']['chemin_image'][$x] = $value2->Chemin_Image_get();
								$_SESSION['panier']['prix_transporteur'] = 0;
								$x++;
								
							}
							
						}
						
						
					}
					else
					{
						Suppression_Commande($List_Commande[0]->Id_Commande_get());
					}
					
					
				}
				
					
			}
				
		if($ok == false)
		{
			echo ('<script language="Javascript">
			<!--
			document.location.replace("Boutique.php");
			// -->
			</script>');
			//header('Location:Boutique.php');
		}
		else
		{
			if($ok == true)
			{
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Panier.php");
				// -->
				</script>');
			}
			//header('Location:Panier.php');
		}
		
					
	
	}
	else
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Creation_Client.php");
			// -->
			</script>');
		//header('Location:Creation_Client.php');
		
	}
  
	  
  }
 
}

if(isset($_POST['Mdp_Oublier']))
{
	$List_Client = Lecture_Client_Email($_POST['Email_Client']);// 1 client est dans la list
	
	if(count($List_Client) > 0)
	{
		foreach($List_Client as $value)
		{
			$client = new Client();
			$client->ID_Client_set($value->ID_Client_get());
			$client->Nom_Client_set($value->Nom_Client_get());
			$client->Prenom_Client_set($value->Prenom_Client_get());
			$client->Nb_Tel_Fix_Client_set($value->Nb_Tel_Fix_Client_get());
			$client->Nb_Tel_Port_Client_set($value->Nb_Tel_Port_Client_get());
			$client->Adresse_Client_set($value->Adresse_Client_get());
			$client->Ville_Client_set($value->Ville_Client_get());
			$client->Cp_Client_set($value->Cp_Client_get());
			$client->Email_Client_set($value->Email_Client_get());
			$client->Mdp_Client_set($value->Mdp_Client_get());
			$client->ID_Droit_set($value->ID_Droit_get());
		}
		
		Mdp_Oublier($client);
		
	}
	else
	{
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Client.php");
		// -->
		</script>');
	}
	
}


?>


 <form action="Login.php" method="post">
 <center><h1 class="titre">Login</h1></center>
  <table class="client_login">
  <tr>
    <td>Email:</td>
    <td><input id="email" type="email" name="Email_Client" required></td>
  </tr>
  <tr>
	<td>Mot de passe:</td>
	<td><input id="mdp" type="password" name="Mdp_Client"required></td>
  </tr>
  <tr>
	<td><input type="submit" name="Se_Loguer" value="Se loguer"/></td>
	<td><button type="submit" name="Inscription" formaction="Creation_Client.php" formnovalidate>Inscription</button></td>
  </tr>
  <tr>
	<td colspan="2"><input type="submit" name="Mdp_Oublier" value="Mot de passe oublier !?" formnovalidate></td>
</table>
</form>
</article>
<!--/*footer*/-->
<?php
include 'Footer.php';
?>
</body>
</html>