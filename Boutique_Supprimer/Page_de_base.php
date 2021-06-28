<?php
session_start(); // On démarre la session AVANT toute chose
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
        <title>Page de base Café J\'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />	
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="../css/...css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php
include 'Header.php';
?>
<article>
/*article ou corps de la page*/
</article>
<?php
include 'Footer.php';
?>
</body>
</html>