<?php
session_start();
// charge tous les fichiers utilises pour le site
include 'Fichier_Require.php';

$List_Article = array();
$List_Article = Lecture_Article();
$List_Categorie = array();
$List_Categorie = Lecture_Categorie();
$List_Stock = array();
$List_Stock = Lecture_Stock();
$id_categorie = 0;
$valid_modif = false;
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Creation categorie et article Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Creation_Categorie_Article.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';

if(isset($_SESSION['ID_Droit']) && $_SESSION['ID_Droit'] == 2)
{

?>

<?php
// Gestion des boutons
if(isset($_POST['Enregistrement_Cat']) && !empty($_POST['Nom_Categorie']))
{
	$categorie = new Categorie();
	$categorie->Nom_Categorie_set($_POST['Nom_Categorie']);
	if(Enregistre_Categorie($categorie) == true)
	{
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Ok=true#Categorie");
		// -->
		</script>');
	}
	else
	{
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Ok=false");
		// -->
		</script>');
	}
}

if(isset($_POST['Supprime_Cat']) && $_POST['categorie_suppresion'] > 0)
{
	$categorie = new Categorie();
	$categorie->ID_Categorie_set($_POST['categorie_suppresion']);
	if(Supprime_Categorie($categorie) == true)
	{
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Ok=true#Categorie");
		// -->
		</script>');
	}
	else
	{
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Ok=false");
		// -->
		</script>');
	}
}

if(isset($_POST['submit']))// bouton enregistrement article
{

	// check if the form was submitted
	if (!empty($_POST['submit'])) 
	{
	  $valid = true;
	
	  // check if there are values in $_POST
	  if (isset($_GET['submit'])) 
	  {
		// the form was submitted but post is empty - the max size was exceeded
		echo 'The file was too large.';
		$valid = false;
	  }
	  else 
	  {
		  
		// see http://php.net/manual/en/features.file-upload.errors.php
		if ($_FILES["fileToUpload"]['error'] != UPLOAD_ERR_OK) 
		{
		  switch ($_FILES["fileToUpload"]['error']) 
		  {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:  echo 'The uploaded file was too large.'; $valid = false; break;
			case UPLOAD_ERR_PARTIAL:    echo 'The uploaded file was only partially received.'; $valid = false; break;
			case UPLOAD_ERR_NO_FILE:    echo 'No file was selected.'; $valid = false; break;
			case UPLOAD_ERR_NO_TMP_DIR: echo 'Missing temporary folder.'; $valid = false; break;
			case UPLOAD_ERR_CANT_WRITE: echo 'Failed to write file to disk.'; $valid = false; break;
			case UPLOAD_ERR_EXTENSION:  echo 'The server stopped the upload.'; $valid = false; break;
		  }
		}

		if ($valid) 
		{
		  $target_dir = "images_boutique/";
		  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		  $target_file = strtolower($target_file);
		  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		  // Check if image file is a actual image or fake image
		  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		  if($check !== false) 
		  {
			  //controle si le fichier est une image ou pas
			//echo "File is an image - " . $check["mime"] . ".";
		  } 
		  else 
		  {
			echo "File is not an image.";
			$valid = false;
		  }
		  // Check if file already exists
		  if (file_exists($target_file)) 
		  {
			
			$Article = new Article();
			$Article->Nom_Article_set($_POST['Nom_Article']);
			$Article->Description_Article_set($_POST['Description_Article']);		
			$Article->Prix_Article_set($_POST['Prix_Article']);
			$Article->Tva_Article_set($_POST['Tva_Article']);
			$Article->Chemin_Image_set($target_file);
			$Article->Id_Categorie_set($_POST['Categorie']);
			$Article->Nb_Article_set($_POST['Qte']);
			
			
			if(Enregistrement_Article($Article) == true)
			{
				//echo "Le fichier image existe déjà mais l'article s'est enregistré.";
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=true#Creation");
				// -->
				</script>');

			}
			else
			{
				//echo('<p>probléme d\'enregistrement de l\'article</br>L\'article existe déjà</p>');
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=false");
				// -->
				</script>');
			}
			$valid = false;
		  }
		  // Check file size
		  if ($_FILES["fileToUpload"]["size"] > 50000000) /*taille max 50mb */
		  {
			echo "Sorry, your file is too large.";
			$valid = false;
		  }
		  // Allow certain file formats
		  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		  && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$valid = false;
		  }
		  // Check if $valid is set to false by an error
		  if ($valid == false) 
		  {
			//echo "Sorry, your file was not uploaded.";
		  // if everything is ok, try to upload file
		  } 
		  else 
		  {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
				/* faire l'enregistrement de l'article apres que la photo est ete uploader*/
				//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";				
				
				$Article = new Article();
				$Article->Nom_Article_set($_POST['Nom_Article']);
				$Article->Description_Article_set($_POST['Description_Article']);
				$Article->Prix_Article_set($_POST['Prix_Article']);
				$Article->Tva_Article_set($_POST['Tva_Article']);
				$Article->Chemin_Image_set($target_file);
				$Article->Id_Categorie_set($_POST['Categorie']);
				$Article->Nb_Article_set($_POST['Qte']);
				
				if(Enregistrement_Article($Article) == true)
				{
					echo ('<script language="Javascript">
					<!--
					document.location.replace("Creation_Categorie_Article.php?Ok=true#Creation");
					// -->
					</script>');
					
				}
				else
				{
					//echo('<p>probléme d\'enregistrement article l\'article existe déjà</p>');
					echo ('<script language="Javascript">
					<!--
					document.location.replace("Creation_Categorie_Article.php?Ok=false");
					// -->
					</script>');
				}
				
			} 
			else 
			{
				echo "Sorry, there was an error uploading your file.";
			}
		  }
		}
	  }
	}
}

//Bouton modification article
if(isset($_POST['Modif']))
{
	// check if the form was submitted
	if (!empty($_POST['Modif'])) 
	{
	  $valid = true;
	
	  // check if there are values in $_POST
	  if (isset($_GET['Modif'])) 
	  {
		// the form was submitted but post is empty - the max size was exceeded
		echo 'The file was too large.';
		$valid = false;
	  }
	  else 
	  {
		  
		// see http://php.net/manual/en/features.file-upload.errors.php
		if ($_FILES["fileToUpload"]['error'] != UPLOAD_ERR_OK) 
		{
		  switch ($_FILES["fileToUpload"]['error']) 
		  {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:  echo 'The uploaded file was too large.'; $valid = false; break;
			case UPLOAD_ERR_PARTIAL:    echo 'The uploaded file was only partially received.'; $valid = false; break;
			case UPLOAD_ERR_NO_FILE:    echo 'No file was selected.'; $valid = false; $valid_modif = true; break;
			case UPLOAD_ERR_NO_TMP_DIR: echo 'Missing temporary folder.'; $valid = false; break;
			case UPLOAD_ERR_CANT_WRITE: echo 'Failed to write file to disk.'; $valid = false; break;
			case UPLOAD_ERR_EXTENSION:  echo 'The server stopped the upload.'; $valid = false; break;
		  }
		}

		if($valid_modif == true)// pas de modification du fichier image car pas sectionner
		{
			$Article = new Article();
			$Article->Id_Article_set($_POST['Id_Article']);
			$Article->Nom_Article_set($_POST['Nom_Article']);
			$Article->Description_Article_set($_POST['Description_Article']);
			$Article->Prix_Article_set($_POST['Prix_Article']);
			$Article->Tva_Article_set($_POST['Tva_Article']);
			$Article->Chemin_Image_set($_POST['Chemin_Image']);
			$Article->Id_Categorie_set($_POST['Categorie']);
			$Article->Nb_Article_set($_POST['Qte']);
			
			if(Modification_Article($Article) == true)
			{
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=true#Creation");
				// -->
				</script>');
			}
			else
			{
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=false");
				// -->
				</script>');
			}				
		}
		
		if ($valid == true) 
		{
		  $target_dir = "images_boutique/";
		  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		  $target_file = strtolower($target_file);
		  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		  // Check if image file is a actual image or fake image
		  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		  if($check !== false) 
		  {
			//echo "File is an image - " . $check["mime"] . ".";
		  } 
		  else 
		  {
			echo "File is not an image.";
			$valid = false;
		  }
		  // Check if file already exists
		  if (file_exists($target_file)) 
		  {
			
			$Article = new Article();
			$Article->Id_Article_set($_POST['Id_Article']);
			$Article->Nom_Article_set($_POST['Nom_Article']);
			$Article->Description_Article_set($_POST['Description_Article']);
			$Article->Prix_Article_set($_POST['Prix_Article']);
			$Article->Tva_Article_set($_POST['Tva_Article']);
			$Article->Chemin_Image_set($target_file);
			$Article->Id_Categorie_set($_POST['Categorie']);
			$Article->Nb_Article_set($_POST['Qte']);
			
			
			if(Modification_Article($Article) == true)
			{
				//echo "Le fichier image existe déjà mais l'article s'est enregistré.";
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=true#Creation");
				// -->
				</script>');
			}
			else
			{
				//echo('<p>Probléme la modification de l\'article n\'à pas été éffectuée</p>');
				echo ('<script language="Javascript">
				<!--
				document.location.replace("Creation_Categorie_Article.php?Ok=false");
				// -->
				</script>');
			}
			
			$valid = false;
		  }
		  // Check file size
		  if ($_FILES["fileToUpload"]["size"] > 50000000) /*taille max 50mb */
		  {
			echo "Sorry, your file is too large.";
			$valid = false;
		  }
		  // Allow certain file formats
		  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		  && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$valid = false;
		  }
		  // Check if $valid is set to false by an error
		  if ($valid == false) 
		  {
			echo "Sorry, your file was not uploaded.";
		  // if everything is ok, try to upload file
		  } 
		  else 
		  {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
				/* faire l'enregistrement de l'article apres que la photo est ete uploader*/
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";				
				
				$Article = new Article();
				$Article->Id_Article_set($_POST['Id_Article']);
				$Article->Nom_Article_set($_POST['Nom_Article']);
				$Article->Description_Article_set($_POST['Description_Article']);
				$Article->Prix_Article_set($_POST['Prix_Article']);
				$Article->Tva_Article_set($_POST['Tva_Article']);
				$Article->Chemin_Image_set($target_file);
				$Article->Id_Categorie_set($_POST['Categorie']);
				$Article->Nb_Article_set($_POST['Qte']);
				
				if(Modification_Article($Article) == true)
				{
					echo ('<script language="Javascript">
					<!--
					document.location.replace("Creation_Categorie_Article.php?Ok=true#Creation");
					// -->
					</script>');
				}
				else
				{
					echo ('<script language="Javascript">
					<!--
					document.location.replace("Creation_Categorie_Article.php?Ok=false");
					// -->
					</script>');
				}
				
			} 
			else 
			{
				echo "Sorry, there was an error uploading your file.";
			}
		  }
		}
	  }
	}
}

if(isset($_POST['Suppression_Article']))
{
	$article = new Article();
	$article->Id_Article_set($_POST['Supprime_Article']);
	
	if(Supprime_Article($article) == true)
	{
		//echo('article supprimmer');
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Sup=true");
		// -->
		</script>');
	}
	else
	{
		//echo('probleme de suppression de l\'article');
		echo ('<script language="Javascript">
		<!--
		document.location.replace("Creation_Categorie_Article.php?Sup=false");
		// -->
		</script>');
	}
}


/*fin bouton*/
?>

<!--/*article ou corps de la page*/-->
<article>
<?php
/* message pour divers informations */
if(isset($_GET['Ok']) && $_GET['Ok'] == 'false')
{
	echo('<p style="color:red;">L\'enregistrement ou la modification n\' à pas été effectuer !</p>');
}
else
{
	if(isset($_GET['Ok']) && $_GET['Ok'] == 'true')
	{
		echo('<p style="color:red;">L\'enregistrement ou la modification à été effectuer !</p>');
	}
}

if(isset($_GET['Sup']) && $_GET['Sup'] == 'false')
{
	echo('<p style="color:red;">La suppression n\' à pas été effectuer !</p>');
}
else
{
	if(isset($_GET['Sup']) && $_GET['Sup'] == 'true')
	{
		echo('<p style="color:red;">La suppression à été effectuer !</p>');
	}
}

/* fin */
?>

<form action="Creation_Categorie_Article.php" method="post">
	<table id="Categorie" class="Creation_Categorie">
		<tr>
			<th><h1>Création d'une nouvelle catégorie :</h1></th>
			<th><h1>Supprimer une catégorie:</h1></th>
		</tr>
		<tr>
			<td>Catégorie existante : </br>
<?php
/*<!-- php à faire pour lire les catégories de façon auto -->*/
echo('<select name="categorie_creation">');
echo('<option value="0" selected></option>');
$arrlength = count($List_Categorie);
for($x = 0; $x < $arrlength; $x++) 
{
	echo('<option value="'.$List_Categorie[$x]->ID_Categorie_get().'">'.$List_Categorie[$x]->Nom_Categorie_get().'</option>');
}
echo('</select>');
?>
			Nom de la catégorie : <input type="text" name="Nom_Categorie"/></td>
			<td>Nom de la catégorie a supprimer :
<?php
/*<!-- php à faire pour lire les categories de façon auto -->*/
echo('<select name="categorie_suppresion">');
echo('<option value="0" selected></option>');
$arrlength = count($List_Categorie);
for($x = 0; $x < $arrlength; $x++) 
{
	echo('<option value="'.$List_Categorie[$x]->ID_Categorie_get().'">'.$List_Categorie[$x]->Nom_Categorie_get().'</option>');
}
echo('</select>');
echo('(La supression d\'une catégorie</br>supprime les articles</br>qui sont liés à cette catégorie)');
?>
			</td>
			
		</tr>
		<tr>
			<td><button type="submit" value="Enregistrement_Categorie" name="Enregistrement_Cat">Enregistrement</button></td>
			<td><button type="submit" value="Supprime_Cat" name="Supprime_Cat">Supprime Catategorie</button></td>
		</tr>
	</table>
</form>


<table class="Article">
<tr>
<th colspan="2"><h1 id="Creation" >Creation ou Modification d'un article</h1></th>
</tr>
<tr>
<td>
<form action="Creation_Categorie_Article.php" method="post" enctype="multipart/form-data">
	<table class="gestion_boutique">
		<tr>
			<th><h3>Catégorie de l'article :</h3></th>
			<th><h3>Création d'un Article :</h3></th>
		</tr>
		<tr>
			<td>Choix de la Categorie : </br><?php
/*<!-- php pour lire les catégories de façon auto -->*/
echo('<select name="Categorie">');
echo('<option value="0" selected></option>');
$arrlength = count($List_Categorie);
for($x = 0; $x < $arrlength; $x++) 
{
	echo('<option value="'.$List_Categorie[$x]->Id_Categorie_get().'">'.$List_Categorie[$x]->Nom_Categorie_get().'</option>');
}
echo('</select>');
?>
			</td>
			<td>Nom de l'Article : <input type="text" name="Nom_Article"/></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Description de l'Article : (500 caractéres max)</br><textarea rows="4" cols="50" maxlength="500" name="Description_Article"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td>Prix de l'Article : <input type="text" name="Prix_Article"/></td>
		</tr>
		<tr>
			<td></td>
			<td>TVA de l'Article : <input type="text" name="Tva_Article"/></td>
		</tr>
		<tr>
			<td></td>
			<td>Sélectionner une image pour l'article : <input type="file" name="fileToUpload" id="fileToUpload"/></td>
		</tr>
		<tr>
			<td></td>
			<td>Quantité d'articles : <input type="text" name="Qte"/></td>
		</tr>
		<tr>
			<td><input type="submit" value="Enregistrement de l'article" name="submit"/></td>
		</tr>
	</table>
</form>
</td>
<td>
<form action="Creation_Categorie_Article.php" method="post" enctype="multipart/form-data">
<table class="Modification_Article">
		<tr>
			<th><h3>Catégorie de l'article :</h3></th>
			<th><h3>Modification d'un Article :</h3></th>
		</tr>
<?php
echo('<tr>');
echo('<td>');
$List_Article = Lecture_Article();// ne pas toucher car il perd les infos entre temps ????

/*<!-- php pour lire les catégories de façon auto -->*/
echo('<select name="Categorie">');
if(isset($_POST['Id_Article']))
{
	foreach($List_Categorie as $value)
	{
		foreach($List_Article as $value2)
		{
			if($value2->Id_Article_get() == $_POST['Id_Article'])
			{
				if($value->Id_Categorie_get() == $value2->Id_Categorie_get())
				{
					echo('<option value="'.$value->Id_Categorie_get().'" selected>'.$value->Nom_Categorie_get().'</option>');
					$id_categorie = $value->Id_Categorie_get();
				}
			}
		}
		if($value->Id_Categorie_get() != $id_categorie)
		{
			echo('<option value="'.$value->Id_Categorie_get().'">'.$value->Nom_Categorie_get().'</option>');
		}
	}
}
else
{
	echo('<option value="0" selected></option>');
	foreach($List_Categorie as $value)
	{
		echo('<option value="'.$value->Id_Categorie_get().'">'.$value->Nom_Categorie_get().'</option>');
	}		
}
echo('</select>');
/*<!-- fin lecture categorie -->*/
echo('</td>');
echo('<td>');
echo('Nom de l\' Article :');

$x="";
if(isset($_POST['Id_Article']))
{
	echo('<select name="Id_Article">');
	foreach($List_Article as $value)
	{
		if($value->Id_Article_get() == $_POST['Id_Article'])
		{
			echo('<option value="'.$_POST['Id_Article'].'" selected>'.$value->Nom_Article_get().'</option>');
			//echo('<input type="hidden" name="Nom_Article" >');
			$x = $value->Nom_Article_get();
		}
		
		if($value->Id_Article_get() != $_POST['Id_Article'])
		{
			echo('<option value="'.$value->Id_Article_get().'">'.$value->Nom_Article_get().'</option>');
		}
	}
	echo('</select>');
	echo('<input type="hidden" name="Nom_Article" value="'.$x.'">');
}
else
{
	echo('<select name="Id_Article">');
	echo('<option value="0" selected></option>');
	
	foreach($List_Article as $value)
	{
		echo('<option value="'.$value->Id_Article_get().'">'.$value->Nom_Article_get().'</option>');
		
	}
	echo('</select>');
}
echo('<button type="submit" value="Rafraichire" formaction="Creation_Categorie_Article.php#Creation" name="Rafraichire">Rafraîchir</button>');
echo('</td>');
echo('</tr>');
if(isset($_POST['Id_Article']))
{
	foreach($List_Article as $value)
	{
		if($_POST['Id_Article'] == $value->Id_Article_get())
		{
			echo('<tr>');
			echo('<td></td>');
			echo('<td>Description de l\'Article : (500 caractéres maxi)</br><textarea rows="4" cols="50" maxlength="500" name="Description_Article">'.$value->Description_Article_get().'</textarea></td>');
			echo('</tr>');
			echo('<tr>');
			echo('<td></td>');
			echo('<td>Prix de l\'Article : <input type="text" name="Prix_Article" value="'.$value->Prix_Article_get().'"/></td>');
			echo('</tr>');
			echo('<tr>');
			echo('<td></td>');
			echo('<td>TVA de l\'Article : <input type="text" name="Tva_Article" value="'.$value->Tva_Article_get().'"/></td>');
			echo('</tr>');
			echo('<tr>');
			echo('<td></td>');
			echo('<td>Sélectionner une image pour l\'article : <input type="file" name="fileToUpload" id="fileToUpload" /></td>');
			echo('<input type="hidden" name="Chemin_Image" value="'.$value->Chemin_Image_get().'"/>');
			echo('</tr>');
			echo('<tr>');
			echo('<td></td>');
			foreach($List_Stock as $value)
			{
				if($value->Id_Article_get() == $_POST['Id_Article'])
				{
					echo('<td>Quantité d\'articles : <input type="text" name="Qte" value="'.$value->Qte_Stock_get().'"/></td>');
					echo('</tr>');
				}
			}
			echo('<td><input type="submit" value="Modification de l\'article" name="Modif"/></td>');
			echo('</tr>');
			break;
		}
	}
}

?>
	</table>
</form>
</td>
</tr>
</table>
<form action="Creation_Categorie_Article.php" method="post">
	<table class="Supprime_Article">
		<tr>
			<th><h1>Suppression Article :</h1></th>
		</tr>
		<tr>
			<td>
<?php
/*<!-- php pour lire les catégories de façon auto -->*/
echo'<select name="Supprime_Article">';
echo'<option value="0" selected></option>';
$arrlength = count($List_Article);
for($x = 0; $x < $arrlength; $x++) 
{
	echo('<option value="'.$List_Article[$x]->Id_Article_get().'">'.$List_Article[$x]->Nom_Article_get().'</option>');
}
echo('</select>');

echo('</td>');
echo('<tr>');
echo('<td><input type="submit" value="Supprimer l\'article" name="Suppression_Article"/></td>');
echo('</tr>');
?>
</table>
</form>
</article>

<?php
}
else
{
	echo('<h1 style="color:red;"><center>Vous n\'avez rien à faire sur cette page !!</center></h1>');
}
/*footer*/
include 'Footer.php';
?>
</body>
</html>