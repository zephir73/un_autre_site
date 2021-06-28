<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

$List_Commande = array();
$List_Commande_Brut = array();
$List_Commande_Brut = Lecture_Commande(false);
$List_Transporteur = array();

$List_Etat_Commande = array();
$List_Etat_Commande = Lecture_Etat_Commande();
$List_Article = array();
$List_Commande_Article = array();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Boutique Café J\'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Gestion_Commande_Client.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<?php
var_dump($_POST);
$List_Commande = Lecture_Commande(true);
$List_Transporteur = Lecture_Transporteur();
$List_Etat_Commande = Lecture_Etat_Commande();
var_dump($List_Commande);
/*gestion des boutons*/
if(isset($_POST['Rech']))
{
	$List_Commande = Recherche_Commande($_POST['ID_Commande_Client'],$_POST['Email_Client_Gestion'],$_POST['Etat_Commande']);
	var_dump($List_Commande);
}


?>
<article> en tete de la zone-->

<table class="Recherche_Commande">
<form action="Gestion_Commande_Client.php" method="post"> 
	<tr>
		<th>numéro de commande</th>
		<th>email client</th>
		<th>statut de la commande</th>
	</tr>
	<tr>
		<td><input type="text" name="ID_Commande_Client"></td>
		<td><input type="text" name="Email_Client_Gestion"></td>
		<?php
		echo('<td><select name="Etat_Commande">');
		foreach ($List_Etat_Commande as $value)
		{
			echo('<option value="'.$value->Id_Etat_Commande_get().'">'.$value->Etat_Commande_get().'</option>');
		}
		echo('</select></td>');
		?>
	</tr>
	<tr>
		<td><input type="submit" name="Rech" value="Recherche"/></td>
		<td>Recherche par numéro de commande </br> email de client et</br> par statut uniquement</td>
	</tr>
</table>
</form>
<!--affiche toutes les commandes -->
<?php

$arrlength1 = count($List_Commande);
$arrlength2 = count($List_Commande_Brut);
if($arrlength1 == $arrlength2)
{
	for($x = 0; $x < $arrlength1; $x++) 
	{
		$Total_Commande = 0;
		echo('<table class="Gestion_Commande_Client">
		<form action="Gestion_Commande_Client.php" method="post">
			<tr>
				<th>rien</th>
				<th>numéro de commande</th>
				<th>date commande</th>
				<th>total commande</th>
				<th>Nom Client</th>
				<th>Statut</th>
				<th>transporteur</th>
				<th>nb article</th>
			</tr>
			<tr>
				<td><button type="submit" >suppression</button></td>
				<td><input type="text" name="ID_Commande" value="'.$List_Commande[$x]->Id_Commande_get().'" readonly></td>
				<td><input type="text" name="Date_Commande" value="'.$List_Commande[$x]->Date_Commande_get().'"readonly></td>');
				$List_Article = Lecture_Commande_Article($List_Commande[$x]->Id_Commande_get());
				foreach($List_Article as $value)
				{
					$Total_Commande += $value->Prix_Article_get() * $value->Nb_Article_get();
				}
				echo('<td><input type="text" name="Total_Commande" value="'.$Total_Commande.' €" readonly></td>
				<input type="hidden" name="ID_Client" value="'.$List_Commande_Brut[$x]->Id_Client_get().'">
				<td><input type="text" name="Nom_Client" value="'.$List_Commande[$x]->Id_Client_get().'"readonly></td>
				<input type="hidden" name="Id_Etat_Commande" value="'.$List_Commande_Brut[$x]->Id_Etat_Commande_get().'">
				<td><select name="Etat_Commande">
				<option value="'.$List_Commande_Brut[$x]->Id_Etat_Commande_get().'" selected>'.$List_Commande[$x]->Id_Etat_Commande_get().'</option>');
				foreach ($List_Etat_Commande as $value)
				{
					if($List_Commande_Brut[$x]->Id_Etat_Commande_get() != $value->Id_Etat_Commande_get())
					{
						echo('<option value="'.$value->Id_Etat_Commande_get().'">'.$value->Etat_Commande_get().'</option>');
					}
				}
				echo('</select></td>
				<td><select name="Transporteur">
				<option value="'.$List_Commande_Brut[$x]->Id_Transporteur_get().'" selected>'.$List_Commande[$x]->Id_Transporteur_get().'</option>');
				foreach ($List_Transporteur as $value)
				{
					if($value->Id_Transporteur_get() != $List_Commande_Brut[$x]->Id_Transporteur_get())
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
				<td><button type="submit" >modification</button></td>
			</tr>
			<tr>
				<td>rien</td>
				<td>rien</td>
				<td>rien</td>');
				if($Total_Commande != $List_Commande[$x]->Total_Commande_get())
				{
					echo('<td style="color:red">Total Commande : '.$List_Commande[$x]->Total_Commande_get().' €</td>');
				}
				else
				{
					echo('<td>Total Commande : '.$List_Commande[$x]->Total_Commande_get().' €</td>');
				}
				echo('<td>rien</td>
				<td>rien</td>
				<td>rien</td>
				<td><button type="submit" >détail</button></td>
				<td>rien</td>
			</tr>
		</form>
		</table>');
	}
}
?>
</article>
<!--/*footer*/-->
<?php
include 'Footer.php';
?>
</body>
</html>