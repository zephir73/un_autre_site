<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Client = array();
$List_Client = Lecture_Client();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Gestion Client Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Gestion_Client.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';

// Gestion des bouton
if(isset($_POST['Modif']))
{
	$client = new $Client();
	$client->ID_Client_set($_POST['ID_Client']);
	$client->Nom_Client_set($_POST['Nom_Client']);
	$client->Prenom_Client_set($_POST['Prenom_Client']);
	$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client']);
	$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client']);
	$client->Adresse_Client_set($_POST['Adresse_Client']);
	$client->Ville_Client_set($_POST['Ville_Client']);
	$client->Cp_Client_set($_POST['Cp_Client']);
	$client->Email_Client_set($_POST['Email_Client_Gestion']);
	$client->Mdp_Client_set($_POST['Mdp_Client_Gestion']);
	$client->ID_Droit_set($_POST['ID_Droit']);
	
	if(Modification_Client($client) == true)
	{
		//echo('<h1>Modification du client '.$_POST['Email_Client_Gestion'].'</h1>');
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Gestion_Client.php?Ok=true");
			// -->
			</script>');			
		//header('Location:Gestion_Client.php?Ok=true');
	}
	else
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Gestion_Client.php?Ok=false");
			// -->
			</script>');			
		//header('Location:Gestion_Client.php?Ok=false');
	}
}

if(isset($_POST['Supp']))// bouton suppression
{
	$client = new $Client();
	$client->ID_Client_set($_POST['ID_Client']);
	$client->Nom_Client_set($_POST['Nom_Client']);
	$client->Prenom_Client_set($_POST['Prenom_Client']);
	$client->Nb_Tel_Fix_Client_set($_POST['Nb_Tel_Fix_Client']);
	$client->Nb_Tel_Port_Client_set($_POST['Nb_Tel_Port_Client']);
	$client->Adresse_Client_set($_POST['Adresse_Client']);
	$client->Ville_Client_set($_POST['Ville_Client']);
	$client->Cp_Client_set($_POST['Cp_Client']);
	$client->Email_Client_set($_POST['Email_Client_Gestion']);
	$client->Mdp_Client_set($_POST['Mdp_Client_Gestion']);
	$client->ID_Droit_set($_POST['ID_Droit']);
	
	Suppression_Client($client);
	
	if(Client_Existe($client) == false)
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Gestion_Client.php?Ok=true");
			// -->
			</script>');			
	}
	else
	{
		echo ('<script language="Javascript">
			<!--
			document.location.replace("Gestion_Client.php?Ok=false");
			// -->
			</script>');			
	}
	
}


// affiche ok ou pas 
if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
{
	echo('<p style="color:red;">La modification n\' à pas été effectuée</p>');
}
else
{
	if(isset($_GET['Ok']) && $_GET['Ok'] == 'true')
	{
		echo('<p style="color:red;">La modification à été effectuée</p>');
	}
}
?>
<article>
<?php
if(isset($_SESSION['ID_Droit']) && $_SESSION['ID_Droit'] == 2)
{
	echo('<center><h1>Modification ou Suppression</br>du Client</h1></center>
	<table class="gestion_client_recherche">
		<tr>
			<th>Nom Client</th>
			<th>Email Client</th>
		</tr>
		<tr>
			<td><form action="Recherche_Client_Resultat.php" method="post">
			<input type="text" name="Nom_Client_Ch"></td>
			<td><input type="text" name="Email_Client_Ch"></td>
		</tr>
		<tr>
			<td><input type="submit" value="Rechercher"></form></td>
			<td>Recherche par nom ou adresse mail</td>
		</tr>
	</table>');	


	$arrlength = count($List_Client);
	for($x = 0; $x < $arrlength; $x++) 
	{
		echo '<table class="gestion_client">
			<tr>
				<th></th>
				<th>Numéro Client</th>
				<th>Nom</th>
				<th>Prenom</th>
				<th>Tel Fix</th>
				<th>Tel Port</th>
				<th>Adresse</th>
				<th>Ville</th>
				<th>Code postal</th>
				<th>Email</th>
				<th>Mot de passe</th>
				<th>Droit</th>
				<th></th>
			</tr>';
		echo '<tr>';
		echo '<td><form action="Gestion_Client.php" method="post">
			 <button type="submit" name="Supp" value="Supp">Suppression</button></td>';
		echo '<td><input type="text" name="ID_Client" value="'.$List_Client[$x]->ID_Client_get().'" readonly></td>';
		echo '<td><input type="text" name="Nom_Client" value="'.$List_Client[$x]->Nom_Client_get().'"></td>';
		echo '<td><input type="text" name="Prenom_Client" value="'.$List_Client[$x]->Prenom_Client_get().'"></td>';
		echo '<td><input type="text" name="Nb_Tel_Fix_Client" value="'.$List_Client[$x]->Nb_Tel_Fix_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}" ></td>';
		echo '<td><input type="text" name="Nb_Tel_Port_Client" value="'.$List_Client[$x]->Nb_Tel_Port_Client_get().'" pattern="[+]{1}[0-9]{2}[0-9]{10}"></td>';
		echo '<td><input type="text" name="Adresse_Client" value="'.$List_Client[$x]->Adresse_Client_get().'"></td>';
		echo '<td><input type="text" name="Ville_Client" value="'.$List_Client[$x]->Ville_Client_get().'"></td>';
		echo '<td><input type="text" name="Cp_Client" value="'.$List_Client[$x]->Cp_Client_get().'" pattern="[0-9]{5}" ></td>'; 
		echo '<td><input type="email" name="Email_Client_Gestion" value="'.$List_Client[$x]->Email_Client_get().'"></td>';//(Email_Client_Gestion) pour pas que le header prenne le relais
		echo ('<input type="hidden" name="Email_Client2" value="'.$List_Client[$x]->Email_Client_get().'">');
		echo '<td><input type="text" name="Mdp_Client_Gestion" value="'.$List_Client[$x]->Mdp_Client_get().'"></td>';// (Mdp_Client_Gestion) pour pas que le header prenne le relais
		echo ('<input type="hidden" name="Mdp_Client2" value="'.$List_Client[$x]->Mdp_Client_get().'">');
		echo '<td><input type="text" name="ID_Droit" value="'.$List_Client[$x]->ID_Droit_get().'" title="1 pour client 2 pour admin"></td>';
		echo '<td><button type="submit" name="Modif" value="Modif"/>Modification</button></form></td>';
		echo '</tr>';
		echo '</table>';
	}
}
else
{
	echo('<h1 style="color:red;"><center>Vous n\'avez rien à faire sur cette page !!</center></h1>');
}
?>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>