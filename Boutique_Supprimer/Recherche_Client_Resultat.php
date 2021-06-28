<?php
session_start(); // On démarre la session AVANT toute chose
// charge touts les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Client = array();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Recherche Client Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Recherche_Client_Resultat.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>

<?php
if(isset($_POST['Modification']))
{
	$client = new Client();
	$client->ID_Client_set($_POST['ID_Client']);
	$client->Nom_Client_set($_POST['Nom_Client']);
	$client->Prenom_Client_set($_POST['Prenom_Client']);
	$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client']);
	$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client']);
	$client->Adresse_Client_set($_POST['Adresse_Client']);
	$client->Ville_Client_set($_POST['Ville_Client']);
	$client->Cp_Client_set($_POST['Cp_Client']);
	$client->Email_Client_set($_POST['Email_Client_Re']);
	$client->Mdp_Client_set($_POST['Mdp_Client_Re']);
	$client->ID_Droit_set($_POST['ID_Droit']);
	
	if(Modification_Client($client) == true)
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Recherche_Client_Resultat.php?Email_Client='.$client->Email_Client_get().'&Ok=true&Admin=true");
			// -->
			</script>');
		
	}
	else
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Recherche_Client_Resultat.php?Email_Client='.$client->Email_Client_get().'&Ok=false&Admin=true");
			// -->
			</script>');
	}
}


if(isset($_POST['Modification_Client']))//bouton modification du client
{
	$client = new Client();
	$client->ID_Client_set($_POST['ID_Client']);
	$client->ID_Droit_set($_POST['ID_Droit']);
	$client->Nom_Client_set($_POST['Nom_Client']);
	$client->Prenom_Client_set($_POST['Prenom_Client']);
	$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client']);
	$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client']);
	$client->Adresse_Client_set($_POST['Adresse_Client']);
	$client->Ville_Client_set($_POST['Ville_Client']);
	$client->Cp_Client_set($_POST['Cp_Client']);
	$client->Email_Client_set($_POST['Email_Client_Re']);
	$client->Mdp_Client_set($_POST['Mdp_Client_Re']);
	
	if(Modification_Client($client) == true)
	{
		
		$_SESSION['ID_Client'] = $client->ID_Client_get();
		$_SESSION['Nom_Client'] = $client->Nom_Client_get();
		$_SESSION['Prenom_Client'] = $client->Prenom_Client_get();
		$_SESSION['Nb_Tel_Fix_Client'] = $client->Nb_Tel_Fix_Client_get();
		$_SESSION['Nb_Tel_Port_Client'] = $client->Nb_Tel_Port_Client_get();
		$_SESSION['Adresse_Client'] = $client->Adresse_Client_get();
		$_SESSION['Ville_Client'] = $client->Ville_Client_get();
		$_SESSION['Cp_Client'] = $client->Cp_Client_get();
		$_SESSION['Email_Client'] = $client->Email_Client_get();
		$_SESSION['Mdp_Client'] = $client->Mdp_Client_get();
		$_SESSION['ID_Droit'] = $client->ID_Droit_get();
		
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Recherche_Client_Resultat.php?Email_Client='.$client->Email_Client_get().'&Ok=true");
			// -->
			</script>');			
		
	}
	else
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Recherche_Client_Resultat.php?Email_Client='.$client->Email_Client_get().'&Ok=false");
			// -->
			</script>');
	}
}
?>

<!--/*article ou corps de la page*/-->
<article>
<?php

/* message pour divers informations */
if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
{
	echo('<p style="color:red;">La modification n\' à pas été effectuer !</p>');
}
else
{
	if(isset($_GET['Ok']) && $_GET['Ok'] == 'true')
	{
		echo('<p style="color:red;">La modification à été effectuer !</p>');
	}
}

$ok_admin = false;
$ok_client = false;

if(isset($_POST['Nom_Client_Ch']) && strlen($_POST['Nom_Client_Ch']) >=1)
{
	echo ('<center><h1>Résultat de la recherche</br>par nom de Client</h1></center>');
	$tmp = "";
	$tmp = ucfirst(strtoupper($_POST['Nom_Client_Ch']));// met la 1er lettre en majuscule
	$List_Client = Lecture_Client_Nom($tmp);
	$ok_admin = true;
}
else
{
	if(isset($_POST['Email_Client_Ch']) && strlen($_POST['Email_Client_Ch']) >=1)
	{
		echo ('<center><h1>Résultat de la recherche</br>par email de Client</h1></center>');
		$List_Client = Lecture_Client_Email($_POST['Email_Client_Ch']);
		$ok_admin = true;
	}
	else
	{
		if(isset($_GET['Email_Client']))
		{
			$List_Client = Lecture_Client_Email($_GET['Email_Client']);
			$ok_client=true;
		}
	}
}

if(isset($_GET['Admin']) && ($_GET['Admin'] == true))
{
	echo ('<center><h1>Résultat de la recherche</br>par email de Client</h1></center>');
	$List_Client = Lecture_Client_Email($_POST['Email_Client_Ch']);
	$ok_admin = true;
}

if($ok_admin == true)
{
	foreach($List_Client as $value)
	{
		echo ('<table class="gestion_client">');
		echo ('<tr>');
		echo ('<th></th>');
		echo ('<th>ID Client</th>');
		echo ('<th>Nom Client</th>');
		echo ('<th>Prenom Client</th>');
		echo ('<th>Tel Fix Client</th>');
		echo ('<th>Tel Port Client</th>');
		echo ('<th>Adresse Client</th>');
		echo ('<th>Ville Client</th>');
		echo ('<th>Cp Client</th>');
		echo ('<th>Email Client</th>');
		echo ('<th>Mdp Client</th>');
		echo ('<th>ID Droit</th>');
		echo ('<th></th>');
		echo ('</tr>');
		echo ('<tr>');
		echo ('<td><form action="Recherche_Client_Resultat.php" method="post">
			 <button type="submit" formaction="Suppression_Client.php">Suppression</button>');
		echo ('<td><input type="text" name="ID_Client" value="'.$value->ID_Client_get().'" readonly></td>');
		echo ('<td><input type="text" name="Nom_Client" value="'.$value->Nom_Client_get().'"></td>');
		echo ('<td><input type="text" name="Prenom_Client" value="'.$value->Prenom_Client_get().'"></td>');
		echo ('<td><input type="text" name="Nb_Tel_Fix_Client" value="'.$value->Nb_Tel_Fix_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');
		echo ('<td><input type="text" name="Nb_Tel_Port_Client" value="'.$value->Nb_Tel_Port_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>');
		echo ('<td><input type="text" name="Adresse_Client" value="'.$value->Adresse_Client_get().'"></td>');
		echo ('<td><input type="text" name="Ville_Client" value="'.$value->Ville_Client_get().'"></td>');
		echo ('<td><input type="text" name="Cp_Client" value="'.$value->Cp_Client_get().'" pattern="[0-9]{5}" ></td>');
		echo ('<td><input type="email" name="Email_Client_Re" value="'.$value->Email_Client_get().'"></td>');
		echo ('<td><input type="text" name="Mdp_Client_Re" value="'.$value->Mdp_Client_get().'"></td>');
		echo ('<td><input type="text" name="ID_Droit" value="'.$value->ID_Droit_get().'" title="1 pour client 2 pour admin"></td>');
		echo ('<td><input type="submit" value="Modification" name="Modification"/></form></td>');
		echo ('</tr>');
		echo ('</table>');
	
	}
}
else
{
	if($ok_client == true)
	{
		foreach($List_Client as $value)
		{
			// modification des variables de session du client car il peut y avoir modification
			// apres la modification on retourne sur cette page et ce coup la c'est bon 
			// les variables de session sont éguales aux infos de la bdd
			echo('<form class="modification_client" action="Recherche_Client_Resultat.php" method="post">');
			echo('<input type="hidden" name="ID_Client" value="'.$value->ID_client_get().'">');
			echo('<input type="hidden" name="ID_Droit" value="'.$value->ID_Droit_get().'">');
			echo ('<center><h1>Information du client '.$_SESSION['Nom_Client'].' '.$_SESSION['Prenom_Client'].'</h1></center>');
			echo('<table class="Modif_info">
			  <tr>
				<td>Nom:</td>
				<td><input type="text" name="Nom_Client" value="'.$value->Nom_Client_get().'" required readonly></td>
			  </tr>
			  <tr>
				<td>Prénom:</td>
				<td><input type="text" name="Prenom_Client" value="'.$value->Prenom_Client_get().'" required readonly></td>
			  </tr>
			  <tr>
				<td>Numero de telephone fixe:</td>
				<td><input type="text" name="Nb_Tel_Fix_Client" value="'.$value->Nb_Tel_Fix_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numero de telephone : +33XXXXXXXXXX 12 caractères"></td>
			  </tr>
			  <tr>
				<td>Numero de telephone portable:</td>
				<td><input type="text" name="Nb_Tel_Port_Client" value="'.$value->Nb_Tel_Port_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}" title="Exemple de numero de telephone : +33XXXXXXXXXX 12 caractères"></td>
			  </tr>
			   <tr>
				<td>Adresse:</td>
				<td><input type="text" name="Adresse_Client" value="'.$value->Adresse_Client_get().'" required></td>
			  </tr>
			   <tr>
				<td>Ville:</td>
				<td><input type="text" name="Ville_Client" value="'.$value->Ville_Client_get().'" required></td>
			  </tr>
			   <tr>
				<td>Code postale:</td>
				<td><input type="text" name="Cp_Client" value="'.$value->Cp_Client_get().'" required></td>
			  </tr>
			  <tr>
				<td>Adresse e-mail:</td>
				<td><input type="email" name="Email_Client_Re" value="'.$value->Email_Client_get().'" required></td>
			  </tr>
			  <tr>
				<td>Confirmation adresse e-mail:</td>
				<td><input type="email" name="Email_Client2" required></td>
			  </tr>
			  <tr>
				<td>Mot de passe:</td>
				<td><input type="password" name="Mdp_Client_Re" required></td>
			  </tr>
			  <tr>
				<td>Confirmation Mot de passe:</td>
				<td><input type="password" name="Mdp_Client2" required></td>
			  </tr>
			  <tr>
				<td><input type="submit" name="Modification_Client" value="Modification"/></td>
				<td><button formaction="Boutique.php" formnovalidate >Retour à la boutique</button></td>
			  </tr>
			</table>'); 
			echo('</form>');
		}
	}
}
?>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>