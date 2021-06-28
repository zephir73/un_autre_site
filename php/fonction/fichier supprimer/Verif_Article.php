<?php

function verif_article()
{
	if(isset($_POST['Categorie']) > 0)
	{
		if(!empty($_POST['Nom_Article']))
		{
			if(!empty($_POST['Description_Article']))
			{
				if(!empty($_POST['Prix_Article']))
				{
					return true;
				}
				else
				{
					echo('Le champ prix de l\'article n\'est pas remplis');
					return false;
				}
			}
			else
			{
				echo('Le champ description de l\'article n\'est pas remplis');
				return false;
			}
		}
		else
		{
			echo('Le champ Nom de l\'article est pas remplis');
			return false;
		}
	}
	else
	{
		echo('La Categorie n\'est pas selectionnée');
		return false;
	}
}




?>