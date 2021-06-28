<?php
function Verif_Categorie()
{
	if(!empty($_POST['Nom_Categorie']))
	{
		return true;
	}
	else
	{
		echo ('Le champ Categorie est pas remplis');
		return false;
	}
}
?>