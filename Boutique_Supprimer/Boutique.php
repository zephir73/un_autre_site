<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisée pour le site
include 'Fichier_Require.php';
$List_Categorie = array();
$List_Categorie = Lecture_Categorie();
$List_Stock = array();

$List_Article = array();
$List_Article = Lecture_Article();
$tmp = '';
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Boutique Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
        <meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Boutique.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Boutique_500px.css" type="text/css" /> 
</head>
<body>
<?php
include 'Header.php';
if(isset($_SESSION['ID_Droit']) && $_SESSION['ID_Droit'] == 2)
{
?>
<!--/*article ou corps de la page*/-->
<article>
<div class="body">
<?php
// si la valeur cat est dans l'url lecture des articles de la categories selectionner
// puis stock le resultat dans une liste
// si non lit tout les article de toute les categories
if(isset($_GET['cat']))
{
	$List_Article = Lecture_Article_Categorie($_GET['cat']);
	foreach($List_Categorie as $value)
	{
		if($value->ID_Categorie_get() == $_GET['cat'])
		{
				echo '<center><h1 class="titre_gen" style="color:#434343;">voici une sélection de nos '.$value->Nom_Categorie_get().' :</h1></center>';
		}
	}		
}
else
{
	$List_Article = Lecture_Article();
	echo '<center><h1 class="titre_gen" style="color:#434343;">Voici nos produits :</h1></center>';
}

// lecture du stock
$List_Stock = Lecture_Stock();// a la meme longueur que la liste article

// affiche les vignettes sur la page boutique dans une table
$arrlength = count($List_Article);
echo('<center><table id="Boutique" class="boutique">');
$i = 0;
$z =0;
for($x = 0; $x < $arrlength; $x++) 
{
	if($i==0)
	{
		echo('<tr>');
	}
    echo('<td>');
	echo('<h2>'.$List_Article[$x]->Nom_Article_get().'</h2>');
	// compte le nb de caractere a afficher pour la description de l'article
	// de façon que tout soit bien aligner
	if(strlen($List_Article[$x]->Description_Article_get()) > 40) 
	{
		$tmp = substr($List_Article[$x]->Description_Article_get(),0,40);
		//echo('<p id="survole">'.$tmp.'<strong> (...)</strong></p>');
	}
	else
	{
		$tmp = $List_Article[$x]->Description_Article_get();
		//echo('<p id="survole">'.$List_Article[$x]->Description_Article_get().'</p>');
	}
	
	echo('<p id="survole">'.$tmp.'</br><strong> (...)</strong></p>');// ne fonctionne que ici ???
	echo('<div class="cacher">');
	echo('<img src="'.$List_Article[$x]->Chemin_Image_get().'" alt="'.$List_Article[$x]->Nom_Article_get().'" height="200" width="300">');
	echo('<p>'.$List_Article[$x]->Description_Article_get().'</p>');
	echo('</div>');
	
	echo('<h4>Prix : '.$List_Article[$x]->Prix_Article_get().' €</h4></br>');
	echo('<img src='.$List_Article[$x]->Chemin_Image_get().' alt='.$List_Article[$x]->Nom_Article_get().' height="100" width="100"></br>');
	
	foreach($List_Stock as $value)
	{
		
		/*
		if($List_Article[$x]->ID_Article_get() == $value->ID_Article_get())
		{
			echo('il reste '.$value->Qte_Stock_get().' Articles');
		}
		*/
		
		if($value->Qte_Stock_get() >=1 )
		{
			if($value->ID_Article_get() == $List_Article[$x]->Id_Article_get())
			{
				echo('<form method="post" action="Panier.php?id_article='.$List_Article[$x]->Id_Article_get().'&nom_article='.$List_Article[$x]->Nom_Article_get().'&qte=1&prix='.$List_Article[$x]->Prix_Article_get().'&tva='.$List_Article[$x]->Tva_Article_get().'&chemin='.$List_Article[$x]->Chemin_Image_get().'">');
				echo('<button type="submit">Ajouter au panier</button>');
				echo('</form>');
			}

		}
		else
		{
			if($value->ID_Article_get() == $List_Article[$x]->Id_Article_get())
			{
			echo('<p style="color:red;">Article Non Disponible</p>');
			}
		}
	}
	
	
	//echo('Categorie_id='.$List_Article[$x]->Id_Categorie_get());
	//echo('Article_id='.$List_Article[$x]->Id_Article_get().'id');
	echo('</td>');
	
	/*affiche 4 produits puis revient à la ligne*/
	if($i>=3)
	{
		echo('<tr class="ess"><td></br><td><td></br></td><td></br></td></tr>');
		//echo('<tr class="ess"><td></br></br></td></tr>');
		echo('</tr>');
		$i=0;
	}
	else
	{
		$i++;
	}
}

//pour finir la table
if ($x % 2 == 0) 
{
     //echo ($x.' est multiple de 2');
} 
else 
{
    //echo ($x. 'n\'est pas multiple de 2');
	echo('<td><h2 class="h2">Nouvel Article</br> à venir !!</h2></td>');
}
echo('</table></center>');
echo('</div>');
echo('</article>');

}
else
{
	echo('<h1 style="color:red;"><center>La boutique n\'est pas opérationnelle</center></h1>');
}

/*footer*/
include 'Footer.php';
?>
</body>
</html>