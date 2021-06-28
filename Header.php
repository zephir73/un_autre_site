<?php

$List_Commande = array();
$List_Article = array();
$ok = false;
$Client = new Client();

$List_Categorie = array();
$List_Categorie = Lecture_Categorie();

?>
<header>
	<ul id="menu-deroulant">
	<li><a class="nsa_ent" href="Index.php#nsa">Savoir-faire</br>
		<img src="image/cafejadore_logo_insigne_couleurs.png" alt="" width="30" height="39"/>
		</a>
		<ul>
			<li><a class="ec_ent" href="Index.php#ec">Expertise du Café</a></li>
			<li><a class="dt_ent" href="Index.php#dt">Découvrez nos thés</a></li>
			<li><a class="ds_ent" href="Index.php#ds">Dégustations salées</a></li>
			<li><a class="dess_ent" href="Index.php#dess">Desserts sucrés</a></li>
		</ul>
	</li>
	<li><a class="me_ent" href="#">Menu</br>
		<img src="image/menu.jpg" alt="" width="30" height="39"/>
		</a>
		<ul>
			<li><a class="br_ent" href="Breakfast.php">Breakfast</a></li>
			<li><a class="lu_ent" href="Lunch.php">Lunch</a></li>
			<li><a class="go_ent" href="Gouter.php">Goûter</a></li>
			<li><a class="bru_ent" href="Brunch.php">Brunch</a></li>
		</ul>
	</li>
	<?php
	if(isset($_SESSION['Nom_Client']))
	{
		echo('<li><a class="cont_ent" href="Index.php#cont">Contact</br>');
		echo('<img src="image/pointeur.jpg" alt="" width="30" height="39"/></br></a> <ul><li></li></ul></li>');
		echo('<li><a href="#"></br>
		<img src="image/cafejadore_logo_sans-baseline_couleurs.jpg" alt="" width="150" height="178" />
		</a>
		<ul>
		<li></li>
		</ul>
		</li>');

	}
	else
	{
		echo('<li><a href="#"></br>
		<img src="image/cafejadore_logo_sans-baseline_couleurs.jpg" alt="" width="150" height="178"/>
		</a>
		<ul>
		<li></li>
		</ul>
		</li>');
		echo('<li><a class="cont_ent" href="Index.php#cont">Contact</br>
		<img src="image/pointeur.jpg" alt="" width="30" height="39" />
		</a>
		<ul>
		<li></li>
		</ul>
		</li>');
	}
	
	if(isset($_SESSION['ID_Droit']))
	{
		if($_SESSION['ID_Droit'] == 2)
		{	
			echo('<li><a class="bout_ent" href ="Boutique.php">Boutique</br>');
			echo('<img src="image/boutique.jpg" alt="" width="30" height="39"/></a>');
			echo('<ul>');
			$arrlength = count($List_Categorie);
				for($x = 0; $x < $arrlength; $x++) 
				{
					echo ('<li><a class="Catego_ent" href="Boutique.php?cat='.$List_Categorie[$x]->ID_Categorie_get().'">'.$List_Categorie[$x]->Nom_Categorie_get().'</a></li>');
				}
			echo('</ul>');
			echo('</li>');
		}
	}	
			
		
	if(isset($_SESSION['ID_Droit']))
	{
		if($_SESSION['ID_Droit'] == 1 || $_SESSION['ID_Droit'] == 2)
		{
			echo('<li><a class="pagnier_ent" href="Panier.php">Panier</br>');
			echo('<img src="image/shoppingcart.jpg" alt="" width="30" height="39"/>
			</a>
			<ul>
			<li></li>
			</ul>
			</li>');
			
		}
	}
	
	if(isset($_SESSION['ID_Droit'])) /*2 est l'admin 1 est un client si le server trouve une variable de session il la verifie est ouvre le menu admin du site*/
	{
		if($_SESSION['ID_Droit'] == 2)
		{
			echo('<li><a class="admin" href="">Gestion Boutique</br>
			<img src="image/espace_perso.jpg" alt="" width="30" height="39"/>
			</a>
			<ul>						
			<li><a class="admin" href="Creation_Categorie_Article.php">Creation des Catégories et des Articles</a></li>
			<li><a class="admin" href="Creation_Transporteur.php">Creation Transporteur</a></li>
			<li><a class="admin" href="Gestion_Client.php">Modification des clients</a></li>
			<li><a class="admin" href="Recapitulatif_Commande.php">Mes commandes</a></li>
			</ul>
			</li>');
		}
				
		if(($_SESSION['ID_Droit'] == 1))
		{
			echo('<li><a class="client" href="">Espace personnel</br>
			<img src="image/espace_perso.jpg" alt="" width="30" height="39" /></a>');
			
			echo('<ul>');
			echo('<li><a class="client" href="Recherche_Client_resultat.php?Email_Client='.$_SESSION['Email_Client'].'">Modification de mes informations</a></li>');
			echo('<li><a class="client" href="Recapitulatif_Commande.php">Mes commandes</a></li>');
			//echo('<li><a class="client" href="">rien</a></li>');
			echo('</ul>');
			echo('</li>');
		}			
	}

	echo('</ul>');

if(isset($_POST['Deconnection']))
{
	Deconnexion_Client();
	echo ('<script language="Javascript">
			<!--
			document.location.replace("index.php");
			// -->
			</script>');
}

if(isset($_SESSION['Nom_Client']))
{
	echo'<div class="login">';
	echo'<p>Bonjour '.$_SESSION['Nom_Client'].' '.$_SESSION['Prenom_Client'].'</p>';
	echo'<form method="post">';
	echo'<button type="submit" name="Deconnection">Déconnection</button>';
	echo'</form>';
	echo'</div>';
}
else
{
?>
<!--
<div class="login">
<h1>Se loguer</h1>
<form action="Login.php"  method="post">
<button type="submit">Login</button>
</form>
</div>
-->
<?php 
}
?>
</header>