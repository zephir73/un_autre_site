
<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Creation Client Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Creation_Client.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Creation_Client_500px.css" type="text/css" /> 
</head>
<body>
<?php
include 'Header.php';
?>
<center><h1 style="color:red">La Boutique n'est pas opérationnelle, il est inutile de s'inscrire</h1></center>
<?php
/* gestion des boutons */
if(isset($_POST['Inscription']))
{
	$client = new Client();
	if(isset($_POST['Nom_Client']) && !empty($_POST['Nom_Client']))
	{
		$client->Nom_Client_set($_POST['Nom_Client']);
		$_SESSION['Nom_Client_ins'] = $_POST['Nom_Client'];
		if(isset($_POST['Prenom_Client']) && !empty($_POST['Prenom_Client']))
		{
			$client->Prenom_Client_set($_POST['Prenom_Client']);
			$_SESSION['Prenom_Client_ins'] = $_POST['Prenom_Client'];
			if(isset($_POST['Nb_Tel_Fix_Client']))// pas de verif empty car pas obligatoire
			{
				$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client']);
				$_SESSION['Nb_Tel_Fix_Client_ins'] = $_POST['Nb_Tel_Fix_Client'];
				if(isset($_POST['Nb_Tel_Port_Client']))// pas de verif empty car pas obligatoire
				{
					$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client']);
					$_SESSION['Nb_Tel_Port_Client_ins'] = $_POST['Nb_Tel_Port_Client'];
					if(isset($_POST['Adresse_Client']) && !empty($_POST['Adresse_Client']))
					{
						$client->Adresse_Client_set($_POST['Adresse_Client']);
						$_SESSION['Adresse_Client_ins'] = $_POST['Adresse_Client'];
						if(isset($_POST['Ville_Client']) && !empty($_POST['Ville_Client']))
						{
							$client->Ville_Client_set($_POST['Ville_Client']);
							$_SESSION['Ville_Client_ins'] = $_POST['Ville_Client'];
							if(isset($_POST['Ville_Client']) && !empty($_POST['Ville_Client']))
							{
								$client->Cp_Client_set($_POST['Cp_Client']);
								$_SESSION['Cp_Client_ins'] = $_POST['Cp_Client'];
								if(isset($_POST['Email_Client_Ins']) && !empty($_POST['Email_Client_Ins']))
								{
									if($_POST['Email_Client_Ins'] == $_POST['Email_Client2'])
									{
										$client->Email_Client_set($_POST['Email_Client_Ins']);
										$_SESSION['Email_Client_Ins'] = $_POST['Email_Client_Ins'];								
										if(isset($_POST['Mdp_Client_Ins']) && !empty($_POST['Mdp_Client_Ins']))
										{
											if($_POST['Mdp_Client_Ins'] == $_POST['Mdp_Client2'])
											{
												$client->Mdp_Client_set($_POST['Mdp_Client_Ins']);
												$client->ID_Droit_set(1);// 1 pour le client 2 pour admin
												
												if(Enregistrement_Client($client) == true)
												{
													// destruction des variable de session devenue inutile
													// apres l'enregistrement du client
													unset($_SESSION['Nom_Client_ins']);
													unset($_SESSION['Prenom_Client_ins']);
													unset($_SESSION['Nb_Tel_Fix_Client_ins']);
													unset($_SESSION['Nb_Tel_Port_Client_ins']);
													unset($_SESSION['Adresse_Client_ins']);
													unset($_SESSION['Ville_Client_ins']);
													unset($_SESSION['Cp_Client_ins']);
													unset($_SESSION['Email_Client_Ins']);
													//envoie d'un mail de confirmation d'inscription
													Mail_Inscription($_POST['Email_Client_Ins'],$_POST['Mdp_Client_Ins']);
													//redirection de la page vers le login
													echo ('<script language="Javascript">
													<!--
													document.location.replace("Login.php");
													// -->
													</script>');			
													//header('location:Boutique.php');
												}
												else
												{
													//echo('probléme d\'enregistrement du client');
													echo ('<script language="Javascript">
													<!--
													document.location.replace("Creation_Client.php?Ok=false#Creation_Client");
													// -->
													</script>');			
													//header('Location:Creation_Client.php?Ok=false#Creation_Client');
												}
											}
											else
											{
												//probleme de mdp
												echo ('<script language="Javascript">
												<!--
												document.location.replace("Creation_Client.php?Mdp=false#Creation_Client");
												// -->
												</script>');			
											}
										}
									}
									else
									{
										//probleme de mail
										echo ('<script language="Javascript">
										<!--
										document.location.replace("Creation_Client.php?Mail=false#Creation_Client");
										// -->
										</script>');			
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
?>




<article>
<?php

if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
{
	echo('<p id="Creation_Client" style="color:red;">La creation du client n\' à pas été effectuer !<br>Car un client a les <strong>Meme coordonée</strong>.</p>');
}
if(isset($_GET['Mail']) && $_GET['Mail'] == 'false')
{
		echo('<p id="Creation_Client" style="color:red;">La creation du client n\' à pas été effectuer !<br>Car les <strong>Adresses Mail son differante</strong>.</p>');
}
if(isset($_GET['Mdp']) && $_GET['Mdp'] == 'false')
{
	echo('<p id="Creation_Client" style="color:red;">La creation du client n\' à pas été effectuer !<br>Car les <strong>Mots de passe sont differant</strong>.</p>');
}


if(!isset($_SESSION['Nom_Client_ins']))
{
echo('<form id="Creation_Client" class="creation_client" action="Creation_Client.php" method="post">
 <center><h1>Inscription Client</h1></center>
  <table class="">
  <tr>
    <td>Nom:</td>
    <td><input type="text" name="Nom_Client" required></td>
  </tr>
  <tr>
    <td>Prénom:</td>
    <td><input type="text" name="Prenom_Client" required></td>
  </tr>
  <tr>
	<td>Téléphone fixe:</td>
	<td><input type="text" name="Nb_Tel_Fix_Client" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numéro de téléphone : +33XXXXXXXXXX 12 caractères"></td>
  </tr>
  <tr>
	<td>Téléphone portable:</td>
	<td><input type="text" name="Nb_Tel_Port_Client" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numéro de téléphone : +33XXXXXXXXXX 12 caractères"></td>
  </tr>
   <tr>
	<td>Adresse:</td>
	<td><input type="text" name="Adresse_Client" required></td>
  </tr>
   <tr>
	<td>Ville:</td>
	<td><input type="text" name="Ville_Client" required></td>
  </tr>
   <tr>
	<td>Code postale:</td>
	<td><input type="text" name="Cp_Client" required pattern="[0-9]{5}" title="Exemple de code postale : 69000"></td>
  </tr>
  <tr>
	<td>Adresse e-mail:</td>
	<td><input type="email" name="Email_Client_Ins" required></td>
  </tr>
  <tr>
	<td>Confirmation adresse e-mail:</td>
	<td><input type="email" name="Email_Client2" required></td>
  </tr>
  <tr>
	<td>Mot de passe:</td>
	<td><input type="password" name="Mdp_Client_Ins" required></td>
  </tr>
  <tr>
	<td>Confirmation Mot de passe:</td>
	<td><input type="password" name="Mdp_Client2" required></td>
  </tr>
  <tr>
	<td><input type="submit" value="S\'inscrire" name="Inscription"/></td>
  </tr>
</table> 
</form>');
}
else
{
echo('<form id="Creation_Client" class="creation_client" action="Creation_Client.php" method="post">
 <center><h1>Inscription Client</h1></center>
  <table class="">
  <tr>
    <td>Nom:</td>
    <td><input type="text" name="Nom_Client" value="'.$_SESSION['Nom_Client_ins'].'" required></td>
  </tr>
  <tr>
    <td>Prénom:</td>
    <td><input type="text" name="Prenom_Client" value="'.$_SESSION['Prenom_Client_ins'].'" required></td>
  </tr>
  <tr>
	<td>Téléphone fixe:</td>
	<td><input type="text" name="Nb_Tel_Fix_Client" value="'.$_SESSION['Nb_Tel_Fix_Client_ins'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numéro de téléphone : +33XXXXXXXXXX 12 caractères"></td>
  </tr>
  <tr>
	<td>Téléphone portable:</td>
	<td><input type="text" name="Nb_Tel_Port_Client" value="'.$_SESSION['Nb_Tel_Port_Client_ins'].'" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numéro de téléphone : +33XXXXXXXXXX 12 caractères"></td>
  </tr>
   <tr>
	<td>Adresse:</td>
	<td><input type="text" name="Adresse_Client" value="'.$_SESSION['Adresse_Client_ins'].'" required></td>
  </tr>
   <tr>
	<td>Ville:</td>
	<td><input type="text" name="Ville_Client" value="'.$_SESSION['Ville_Client_ins'].'" required></td>
  </tr>
   <tr>
	<td>Code postale:</td>
	<td><input type="text" name="Cp_Client" value="'.$_SESSION['Cp_Client_ins'].'" required pattern="[0-9]{5}" title="Exemple de code postale : 69000"></td>
  </tr>
  <tr>
	<td>Adresse e-mail:</td>
	<td><input type="email" name="Email_Client_Ins" value="'.$_SESSION['Email_Client_ins'].'" required></td>
  </tr>
  <tr>
	<td>Confirmation adresse e-mail:</td>
	<td><input type="email" name="Email_Client2" required></td>
  </tr>
  <tr>
	<td>Mot de passe:</td>
	<td><input type="password" name="Mdp_Client_Ins" required></td>
  </tr>
  <tr>
	<td>Confirmation Mot de passe:</td>
	<td><input type="password" name="Mdp_Client2" required></td>
  </tr>
  <tr>
	<td><input type="submit" value="S\'inscrire" name="Inscription"/></td>
  </tr>
</table> 
</form>');
}
?>
</article>
<!--/*footer*/-->
<?php
include 'Footer.php';
?>
</body>
</html>