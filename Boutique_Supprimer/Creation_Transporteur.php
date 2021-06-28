<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';

$List_Transporteur = array();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Creation Transporteur Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Creation_Transporteur.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<?php
$List_Transporteur = Lecture_Transporteur();
?>
<?php
/* gestion des boutons*/
if(isset($_POST['Enregistrement'])&& !empty($_POST['Nom_Transporteur']))// enregistrement du transporteur
{
	$transporteur = new Transporteur();
	$transporteur->Nom_Transporteur_set($_POST['Nom_Transporteur']);
	$transporteur->Prix_Transporteur_set($_POST['Prix_Transporteur']);
	
	if(Enregistrement_Transporteur($transporteur) == true)
	{
		//echo('enregistrement du transporteur effectuer');
		header('location:Creation_Transporteur.php?Ok=true#Transporteur');
	}
	else
	{
		//echo('probléme d\'enregistrement du transporteur');
		header('location:Creation_Transporteur.php?Ok=false#Transporteur');
	}
}

if(isset($_POST['Modification']) && !empty($_POST['Nom_Transporteur']))
{
	$transporteur = new Transporteur();
	$transporteur->Id_Transporteur_set($_POST['Id_Transporteur']);
	$transporteur->Nom_Transporteur_set($_POST['Nom_Transporteur']);
	$transporteur->Prix_Transporteur_set($_POST['Prix_Transporteur']);
	
	if(Modification_Transporteur($transporteur) == true)
	{
		//echo('modification du transporteur effectuée');
		header('location:Creation_Transporteur.php?Ok=true#Transporteur');
	}
	else
	{
		//echo('probléme de modification du transporteur');
		header('location:Creation_Transporteur.php?Ok=false#Transporteur');
	}
	
}

if(isset($_POST['Supprimer']))
{
	if(Suppression_Transporteur($_POST['Trans']) == true)
	{
		//echo('suppression du transporteur effectuée');
		header('location:Creation_Transporteur.php?Ok=true#Transporteur');
	}
	else
	{
		//echo('probléme de suppression du transporteur');
		header('location:Creation_Transporteur.php?Ok=false#Transporteur');
	}
}


/* fin */
?>
<article>
<?php
/* message pour divers informations */
if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
{
	echo('<p style="color:red;">La modification n\'à pas été effectuer !</p>');
}
else
{
	if(isset($_GET['Ok']) && $_GET['Ok'] == 'true')
	{
		echo('<p style="color:red;">La modification à été effectuer !</p>');
	}
}
/* fin */

if(isset($_SESSION['ID_Droit']) && $_SESSION['ID_Droit'] == 2)
{
?>
<table id="Transporteur" class="transporteur">
<tr>
<th><center><h1>Creation Nouveaux Transporteurs</h1></center></th>
<th><center><h1>Modification d'un transporteur</h1></center></th>
<th><center><h1>Supprimer un transporteur</h1></center></th>
</tr>
<tr>
<td>
<div class="Creation_Transporteur">
<form action="Creation_Transporteur.php" method="post">
<label>Transporteur existant :</label>
<select>
<?php
foreach($List_Transporteur as $value)
{
	echo('<option value="'.$value->Id_Transporteur_get().'">'.$value->Nom_Transporteur_get().'</option>');
}
?>
</select>
<label>Nom Transporteur :</label>
<input type="text" name="Nom_Transporteur" required>
<label>prix d'envoi :</label>
<input type="text" name="Prix_Transporteur" required>
<input type="submit" value="Enregistrement" name="Enregistrement">
</form>
</div>
</td>
<td>
<div class="Creation_Transporteur">
<form action="Creation_Transporteur.php#Transporteur" method="post">
<label>Nom Transporteur :</label>
<select name="Trans">
<?php
foreach($List_Transporteur as $value)
{
	if(isset($_POST['Trans']))
	{
		if($_POST['Trans'] == $value->Id_Transporteur_get())
		{
			echo('<option value="'.$value->Id_Transporteur_get().'" selected>'.$value->Nom_Transporteur_get().'</option>');
		}
		else
		{
			echo('<option value="'.$value->Id_Transporteur_get().'">'.$value->Nom_Transporteur_get().'</option>');
		}
	}
	else
	{
		echo('<option value="'.$value->Id_Transporteur_get().'">'.$value->Nom_Transporteur_get().'</option>');
	}
}
?>
</select>
<input type="submit" method="post" value="Raffraichire" name="Raf">
<?php
if(isset($_POST['Trans']))
{
	foreach($List_Transporteur as $value)
	{
		if($value->Id_Transporteur_get() == $_POST['Trans'])
		{
			echo('<input type="hidden" value="'.$value->Id_Transporteur_get().'" name="Id_Transporteur">');
			echo('<label>Nom Transporteur :</label>');
			echo('<input type="text" value="'.$value->Nom_Transporteur_get().'" name="Nom_Transporteur" required>');
			echo('<label>prix d\'envoi :</label>');
			echo('<input type="text" value="'.$value->Prix_Transporteur_get().'" name="Prix_Transporteur" required>');
			break;
		}
	}
	echo('<input type="submit" value="Modification" name="Modification">');
}
?>
</form>
</div>
</td>
<td>
<div class="Creation_Transporteur">
<form action="Creation_Transporteur.php" method="post">
<label>Transporteur à supprimer :</label>
<select name="Trans">
<?php
foreach($List_Transporteur as $value)
{
	echo('<option value="'.$value->Id_Transporteur_get().'">'.$value->Nom_Transporteur_get().'</option>');
}
?>
</select>
<input type="submit" value="Supprimer" name="Supprimer">
</form>
</div>
</td>
</tr>
</table>
</article>
<!--/*footer*/-->
<?php
}
else
{
	echo('<h1 style="color:red;"><center>Vouz n\'avez rien à faire sur cette page !!!</center></h1>');
}
include 'Footer.php';
?>
</body>
</html>