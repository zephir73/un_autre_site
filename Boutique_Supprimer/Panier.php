<?php
session_start(); // On démarre la session AVANT toute chose
// charge touts les fichiers utilisée pour le site
include 'Fichier_Require.php';
$List_Stock = array();
$List_Stock = Lecture_Stock();
$id_commande = 0;
$select = array();
$List_Transporteur = array();
$List_Transporteur = Lecture_Transporteur();
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Panier Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/panier.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
<?php
//si pas de panier on en crée un 
//on rajoute l'objet s'il y en a un
if(!isset($_SESSION['panier']) || empty($_SESSION['panier']))
{
	creation_panier();
	//on verifie qu'il y un article à ajouter et on l'ajoute
	if(isset($_GET['id_article']))
	{
		$select['id_article'] = $_GET['id_article'];
		$select['nom_article'] = $_GET['nom_article'];
		$select['qte'] = $_GET['qte'];
		$select['prix'] = $_GET['prix'];
		$select['tva'] = $_GET['tva'];
		$select['chemin_image'] = $_GET['chemin'];
		ajout($select);
	}
}
else
{
// le panier existe déjà on ajoute l'objet s'il y en à un
// s'il est déjà présent on change la quantité
	if(isset($_GET['id_article']))
	{
		$select['id_article'] = $_GET['id_article'];
		$select['nom_article'] = $_GET['nom_article'];
		$select['qte'] = $_GET['qte'];
		$x=0;		
		foreach ($_SESSION['panier']['id_article'] as $value)
		{
			if(($_SESSION['panier']['id_article'][$x]) == ($_GET['id_article']))
			{
				$tmp = $_SESSION['panier']['qte'][$x]++;
				$select['qte'] = $_SESSION['panier']['qte'][$x]++;
				break;
			}
			else
			{
				$select['qte'] = $_GET['qte'];
			}
			$x++;
		}
		$select['prix'] = $_GET['prix'];
		$select['tva'] = $_GET['tva'];
		$select['chemin_image'] = $_GET['chemin'];
		ajout($select);
	}
}
//Gestion des boutons
if(isset($_POST['btn_raf']))
{
	modif_qte($_POST['ID_Article'], $_POST['qte']);
}
if(isset($_POST['btn_sup']))
{
	if(supprim_article($_POST['ID_Article']) == true)
	{
		
	}
}
if(isset($_POST['btn_bout']))
{
	echo ('<script language="Javascript">
    <!--
    document.location.replace("Boutique.php?#Boutique");
    // -->
     </script>');
	//header('Location:Boutique.php?#Boutique'); // un jour ça fonctionne l'autre pas
}
if(isset($_POST['btn_payer']))
{
	if($_POST['Montant_Panier'] > 0 && isset($_SESSION['ID_Client'])) // si panier supérieur à zéro et que le client est loguer
	{
		$List_Composer = array();
		$commande = new Commande();
		date_default_timezone_set("Europe/Paris");
		$commande->Date_Commande_set(date("d/m/Y").' '.date("h:i:sa"));
		$commande->Total_Commande_set($_POST['Montant_Panier']);
		$commande->Id_Client_set($_SESSION['ID_Client']);
		$commande->Id_Etat_Commande_set(3);//en cours "1er enregistrement"
		$commande->Id_Transporteur_set($List_Transporteur[0]->Id_Transporteur_get());// 1 et 1 seul transporteur pour le moment
		$x=0;
		foreach ($_SESSION['panier']['id_article'] as $value)// fait une liste composer pour la table composer
		{
			$composer = new Composer();
			$composer->Prix_Article_set($_SESSION['panier']['prix'][$x]);
			$composer->Nb_Article_set($_SESSION['panier']['qte'][$x]);
			$composer->Tva_Article_set($_SESSION['panier']['tva'][$x]);
			$composer->Id_Article_set($_SESSION['panier']['id_article'][$x]);
			array_push($List_Composer, $composer);
			$x++;
		}
		if(isset($_SESSION['id_commande']))
		{
			//modification commande
			$commande->Id_Commande_set($_SESSION['id_commande']);
			if(Modification_Commande($commande,$List_Composer,$_SESSION['id_commande']) == true)
			{
				echo ('<script language="Javascript">
				<!--
                 document.location.replace("Commande_Client.php");
				// -->
				</script>');
				//header('Location:Commande_Client.php');*/
								
			}
		}
		else
		{
			$id_commande = Enregistrement_Commande($commande,$List_Composer,0);
			$_SESSION['id_commande'] = $id_commande;
			
			echo ('<script language="Javascript">
            <!--
            document.location.replace("Commande_Client.php");
            // -->
			</script>');
			//header('Location:Commande_Client.php');*/
					
		}
	}
	else
	{
		if(!isset($_SESSION['ID_Client'])) // client pas loguer et panier supérieur a 0
		{
			echo ('<script language="Javascript">
			<!--
			document.location.replace("Login.php");
			// -->
			</script>');
		}
		
		//header('Location:Boutique.php');
	}
}
// on affiche le panier s'il existe
// sinon on affiche il n'y a pas d'article dans le panier
if(isset($_SESSION['panier']) && !empty($_SESSION['panier']['id_article'][0]))
{
	echo('<div class="panier">');
	$x=0;
	echo('<table class="panier">');
	echo('<tr>');
	echo('<th>Nom Articles</th>');
	echo('<th>Image du Produit</th>');
	echo('<th>Quantité</th>');
	echo('<th>Prix unitaire</th>');
	echo('<th></th>');
	echo('</tr>');
	foreach ($_SESSION['panier']['id_article'] as $value)
	{
		echo('<tr>');
		echo('<form method="post">');
		echo('<td>'.$_SESSION['panier']['nom_article'][$x].'</td>');
		echo('<td><img src="'.$_SESSION['panier']['chemin_image'][$x].'" alt="'.$_SESSION['panier']['nom_article'][$x].'" height="42" width="42"></th>');
		foreach($List_Stock as $value)
		{
			if($value->ID_Article_get() == $_SESSION['panier']['id_article'][$x])
			{
				if($value->Qte_Stock_get() > $_SESSION['panier']['qte'][$x])
				{
					echo('<td><input type="number" value="'.$_SESSION['panier']['qte'][$x].'" name="qte" min="1" max="'.$value->Qte_Stock_get().'">');
				}
				else
				{
					echo('<td><input type="number" value="'.$value->Qte_Stock_get().'" name="qte" min="1" max="'.$value->Qte_Stock_get().'">');
					$qte = $_SESSION['panier']['qte'][$x] - $value->Qte_Stock_get();
					if($qte == 0)
					{
						//echo('<p style="color:red">dernier article !!</p>');
					}
					else
					{
						if($qte > 0)
						{
							//echo('<p style="color:red">Le nombre a été reduit de : '.$qte.' articles</br> depuis votre dernier commande !!</p>');
							$_SESSION['panier']['qte'][$x] = $value->Qte_Stock_get();
						}
					}
				}
			}
		}
		echo('<input type="hidden" name="ID_Article" value="'.$_SESSION['panier']['id_article'][$x].'">');
		echo('<button type="submit" name="btn_raf" value="btn_raf">Actualiser l\'article</button></td>');
		echo('<td id="prix">'.$_SESSION['panier']['prix'][$x].'</td>');
		echo('</form>');
		echo('<form method="post">');
		echo('<input type="hidden" name="ID_Article" value="'.$_SESSION['panier']['id_article'][$x].'">');
		echo('<td><button type="submit" name="btn_sup" value="btn_sup">Supprimer</button></td>');
		echo('</form>');
		echo('</tr>');	
		$x++;
	}
	echo('<tr>');
	echo('<form action="Panier.php" method="post">');
	echo('<td><button type="submit" name="btn_bout" value="btn_bout">Retour a la boutique</button></td>');
	echo('<td></td>');
	echo('<td></td>');
	echo('<td>Total du Panier : '.montant_panier().' €</td>');
	echo('<input type="hidden" name="Montant_Panier" value="'.montant_panier().'">');
	echo('<td><button type="submit" name="btn_payer" value="btn_payer">payer</button></td>');
	echo('</form>');
	echo('</tr>');
	echo('</table>');
	echo('</div>');
}
else
{
	echo ('<center><strong><p style="font-size:300%;color:red;">Il n\'y a pas d\'article dans le panier !!</p></strong></center>');// le style du text est sur la meme ligne
}
?>
</article>
<?php
include 'Footer.php';
?>
</body>
</html>