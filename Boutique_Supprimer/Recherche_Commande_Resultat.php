<?php
session_start(); // On démarre la session AVANT toute chose
// charge touts les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Etat_Commande = array();
$List_Etat_Commande = Lecture_Etat_Commande();
$List_Transporteur = array();
$List_Transporteur = Lecture_Transporteur();
$List_Commande = array();
$List_Article = array();
$List_Commande_Article = array();
$id_commande = 0;
$email_client='';
$etat_commande = 0;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Recherche Commande Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Gestion_Commande_Client.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
<?php
if(isset($_POST['ID_Commande']))
{
	$id_commande = $_POST['ID_Commande'];
}	

if(isset($_POST['Email_Client']))// a tracer
{
	$email_client = $_POST['Email_Client'];
}

if(isset($_POST['Etat_Commande']))
{
	$etat_commande = $_POST['Etat_Commande'];			
}

$List_Commande = Recherche_Commande($id_commande,$email_client,$etat_commande);


echo('<center><h1>Voici le résultat de la recherche</h1></center>');
$arrlength = count($List_Commande);
for($x = 0; $x < $arrlength; $x++) 
	{
		$Total_Commande = 0;
		echo('<table class="Gestion_Commande_Client">
			<tr>
				<th>rien</th>
				<th>numero de commande</th>
				<th>date commande</th>
				<th>total commande</th>
				<th>Nom Client</th>
				<th>Email Client</th>
				<th>Statuts</th>
				<th>transporteur</th>
				<th>nb article</th>
			</tr>
			<tr><form action="" method="post">
				<td><button type="submit" formaction="fonction/Suppression_Commande.php">suppression</button></td>
				<td><input type="text" name="ID_Commande" value="'.$List_Commande[$x]->Id_Commande_get().'" readonly></td>
				<td><input type="text" name="Date_Commande" value="'.$List_Commande[$x]->Date_Commande_get().'"readonly></td>');
				$List_Article = Lecture_Commande_Article($List_Commande[$x]->Id_Commande_get());
				foreach($List_Article as $value)
				{
					$Total_Commande += $value->Prix_Article_get() * $value->Nb_Article_get();
				}
				echo('<td><input type="text" name="Total_Commande" value="'.$Total_Commande.' €" readonly></td>
				<input type="hidden" name="ID_Client" value="'.$List_Commande[$x]->Id_Client_get().'">');
				$List_Client = Lecture_Client_Id($List_Commande[$x]->Id_Client_get());
				foreach($List_Client as $value)
				{
					if($List_Commande[$x]->Id_Client_get() == $value->Id_Client_get())
					{
						echo('<td><input type="text" name="Nom_Client" value="'.$value->Nom_Client_get().'"readonly></td>');
						echo('<td><input type="text" name="Email_Client" value="'.$value->Email_Client_get().'" readonly></td>');
					}
				}
				echo('<input type="hidden" name="Id_Etat_Commande" value="'.$List_Commande[$x]->Id_Etat_Commande_get().'">
				<td><select name="Etat_Commande">');
				foreach ($List_Etat_Commande as $value)
				{
					if($List_Commande[$x]->Id_Etat_Commande_get() == $value->Id_Etat_Commande_get())
					{
						echo('<option value="'.$List_Commande[$x]->Id_Etat_Commande_get().'" selected>'.$value->Etat_Commande_get().'</option>');
					}
					else
					{
						echo('<option value="'.$value->Id_Etat_Commande_get().'">'.$value->Etat_Commande_get().'</option>');
					}
				}
				echo('</select></td>
				<td><select name="Transporteur">');
				foreach ($List_Transporteur as $value)
				{
					if($value->Id_Transporteur_get() == $List_Commande[$x]->Id_Transporteur_get())
					{
						echo('<option value="'.$List_Commande[$x]->Id_Transporteur_get().'" selected>'.$value->Nom_Transporteur_get().'</option>');
					}
					else
					{
						echo('<option value="'.$value->Id_Transporteur_get().'">'.$value->Nom_Transporteur_get().'</option>');
					}
				}
				echo('</select></td>');
				$List_Commande_Article = Lecture_Commande_Article($List_Commande[$x]->Id_Commande_get());
				$nb_article = 0;
				foreach ($List_Commande_Article as $value)
				{
					$nb_article += $value->Nb_Article_get();
				}
				echo('<td><input type="text" name="Nb_Article"value="'.$nb_article.'" readonly></td>
				<td><button type="submit"formaction="fonction/Modification_Commande.php">modification</button></td>
			</tr>
			<tr>
				<td>rien</td>
				<td>rien</td>
				<td>rien</td>');
				if($Total_Commande != $List_Commande[$x]->Total_Commande_get())
				{
					echo('<td style="color:red">Total_Commande : '.$List_Commande[$x]->Total_Commande_get().' €</td>');
				}
				else
				{
					echo('<td>Total_Commande : '.$List_Commande[$x]->Total_Commande_get().' €</td>');
				}
				echo('<td>rien</td>
				<td>rien</td>
				<td>rien</td>
				<td>rien</td>
				<td><button type="submit" formaction="Detail_Commande_Resultat.php">detail</button></td>
				<td>rien</td>
			</tr>
		</form>
		</table>');
	}
?>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>