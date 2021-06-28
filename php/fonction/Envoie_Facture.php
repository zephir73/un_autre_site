<?php
 
 function Envoie_Facture($email,$id_commande)
 {
	$List_Commande = array();
	$List_Article = array();
	$List_Facture = array();

	$adresse_facture ='';
	$nom_prenom = '';
	$adresse = '';
	$ville = '';
	$adresse_livraison = '';
	$nom_prenom_liv = '';
	$adresse_liv = '';
	$ville_liv = '';

	$tmp = 0;
	$prix_unitaire_ht = 0;

	$prix_unitaire_ttc = 0;
	$prix_total_article_ht = 0;//ht total par article
	$prix_total_article = 0;// ttc total par article


	$prix_article = 0;
	$montant_ht = 0;//Prix hors tax
	$montant_ttc = 0;//Prix ttc
	$nb_article_total = 0;

	$montant_tva_55 = 0;
	$montant_tva_20 = 0;
	
	$destinataire = $email;
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = 'info@cafejadore.fr';//$_POST['email'];
     
    $objet = 'Facture Café J\'Adore';//$_POST['subject'];
     
    $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'To: '."\n"; // Mail de reponse
    $headers .= 'From: "Café J\'Adore"<'.$expediteur.'>'."\n"; // Expediteur
     
    
	$List_Commande = Recherche_Commande($id_commande,$email,1);// 1 payer 2 pas payer 3 en cour

	$List_Facture = Recherche_Facture($id_commande);

	$List_Article = Lecture_Commande_Article($id_commande);
	

foreach ($List_Facture as $value)
{
	$message ='<p style="margin:0px;">Facture n=°: '.$value->Id_Facture_get().'</p>';
	$message .='<p style="margin:0px;">Date : '.$value->Date_Facture_get().'</p>';
	foreach($List_Commande as $value2)
	{
		$message .='<p style="margin:0px;">Numéro client : '.$value2->Id_Client_get().'</p>';
		$message .='<p style="margin:0px;">Numéro commande : '.$value2->Id_Commande_get().'</p></br>';
		$id_client = $value2->Id_Client_get();
	}
}

$message .='<div class="addresse_companie">';
$message .='<p style="margin:0px;">Café j\'adore<br>';
$message .='46 Montée de la Grande Côte<br>';
$message .='69001 Lyon</p>';
$message .='</div>';
$message .='<center><img src="https://www.cafejadore.fr/image/cafejadore_logo_insigne_couleurs.png" alt="logo_cafe" height="200" width="200"></center>';

foreach($List_Facture as $value)
{
	$adresse_facture = $value->Adresse_Facture_get();
	$adresse_livraison = $value->Adresse_Livraison_get();
	$arraylenght = strlen($adresse_facture);
	$i=0;
	// pour avoir l'adresse de facturation dans 3 variables
	// $nom_prenom,$adresse,$ville
	for($x=0; $x<$arraylenght; $x++)
	{
		if($adresse_facture[$x] != '@' && $i<2)
		{
			$nom_prenom = $nom_prenom.$adresse_facture[$x];
		}
		else
		{
			if($adresse_facture[$x] =='@' && $i<2)
			{
				$nom_prenom = $nom_prenom.' ';
				$i++;
			}
			else
			{
				if($adresse_facture[$x] != '@' && $i<3)
				{
					$adresse = $adresse.$adresse_facture[$x];
				}
				else
				{
					if($adresse_facture[$x] =='@' && $i<3)
					{
						$i++;
					}
					else
					{
						if($adresse_facture[$x] !='@' && $i<4)
						{
							$ville = $ville.$adresse_facture[$x];
						}
						else
						{
							if($adresse_facture[$x] =='@' && $i<4)
							{
								$ville = $ville.' ';
								$i++;
							}
							else
							{
								$ville = $ville.$adresse_facture[$x];
							}
						}
					}
				}
			}
		}
	}
	
	$arraylenght = strlen($adresse_livraison);
	$i=0;
	// pour avoir l'adresse de livraison dans 3 variables
	// $nom_prenom_liv,$adresse_liv,$ville_liv
	for($x=0; $x<$arraylenght; $x++)
	{
		if($adresse_livraison[$x] != '@' && $i<2)
		{
			$nom_prenom_liv = $nom_prenom_liv.$adresse_livraison[$x];
		}
		else
		{
			if($adresse_livraison[$x] =='@' && $i<2)
			{
				$nom_prenom_liv = $nom_prenom_liv.' ';
				$i++;
			}
			else
			{
				if($adresse_livraison[$x] != '@' && $i<3)
				{
					$adresse_liv = $adresse_liv.$adresse_livraison[$x];
				}
				else
				{
					if($adresse_livraison[$x] =='@' && $i<3)
					{
						$i++;
					}
					else
					{
						if($adresse_livraison[$x] !='@' && $i<4)
						{
							$ville_liv = $ville_liv.$adresse_livraison[$x];
						}
						else
						{
							if($adresse_livraison[$x] =='@' && $i<4)
							{
								$ville_liv = $ville_liv.' ';
								$i++;
							}
							else
							{
								$ville_liv = $ville_liv.$adresse_livraison[$x];
							}
						}
					}
				}
			}
		}
	}
}



$message .='<table style="width:60%;margin-left:auto;margin-right:auto;text-align:center;">';
$message .='<tr>';
$message .='<th><h2>Adresse de Facturation</h2></th>';
$message .='<th style="padding-left:300px;"></th>';
$message .='<th><h2>Adresse de Livraison</h2></th>';
$message .='</tr>';
$message .='<tr>';
$message .='<td>'.$nom_prenom.'<br>';
$message .= $adresse.'<br>';
$message .=$ville.'</td>';

$message .='<td style="padding-left:300px;"></td>';
$message .='<td>'.$nom_prenom_liv.'<br>';
$message .=$adresse_liv.'<br>';
$message .=$ville_liv.'</td>';

$message .='</tr>';
$message .='</table>';

$message .='<div style="margin-top:50px;">';
$message .='<center><h2>Détail de la facture</h2></center>';
$message .='<table style="width:90%;margin-left:auto;margin-right:auto;border-collapse:collapse;background-color:#f2f2f2;text-align:center;">';
$message .='<tr>';
$message .='<th style="border:1px solid #424242;">Nom Articles</th>';
$message .='<th style="border:1px solid #424242;">Quantité</th>';
$message .='<th style="border:1px solid #424242;">Prix unitaire Hors Taxe</th>';
$message .='<th style="border:1px solid #424242;">Prix unitaire TTC</th>';
$message .='<th style="border:1px solid #424242;">Prix total Article Hors Taxe</th>';
$message .='<th style="border:1px solid #424242;">Prix total Article TTC</th>';
$message .='</tr>';


foreach($List_Article as $value)
{
	
	$tmp = $value->Prix_Article_get()*($value->Tva_Article_get()/100);
	$prix_unitaire_ht = $value->Prix_Article_get() - $tmp;
	
	$prix_unitaire_ttc = $value->Prix_Article_get();
	$prix_total_article_ht = $prix_unitaire_ht * $value->Nb_Article_get();//ht total par article
	$prix_total_article = $value->Prix_Article_get() * $value->Nb_Article_get();// ttc total par article
	
	
	$prix_article += $value->Nb_Article_get() * $value->Prix_Article_get();
	$montant_ht += $prix_unitaire_ht * $value->Nb_Article_get();//Prix hors tax
	$montant_ttc += $prix_unitaire_ttc * $value->Nb_Article_get();//Prix ttc
	$nb_article_total += $value->Nb_Article_get();
	
	if($value->Tva_Article_get() == 5.5)
		{
			$montant_tva_55 += $tmp * $value->Nb_Article_get();
		}
		else
		{
			if($value->Tva_Article_get() > 5.5)
			{
				$montant_tva_20 += $tmp * $value->Nb_Article_get();
			}
		}
	
	$message .='<tr>';
	$message .='<td style="border:1px solid #424242;">'.$value->Nom_Article_get().'</td>';
	$message .='<td style="border:1px solid #424242;">'.$value->Nb_Article_get().'</td>';
	$message .='<td style="border:1px solid #424242;">'.$prix_unitaire_ht.'€</td>';
	$message .='<td style="border:1px solid #424242;">'.$prix_unitaire_ttc.'</td>';
	$message .='<td style="border:1px solid #424242;">'.$prix_total_article_ht.'</td>';
	$message .='<td style="border:1px solid #424242;">'.$prix_total_article.'</td>';
	$message .='</tr>';
	$x++;
}
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>Prix des Article HT :</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$montant_ht.'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>TVA 5.5%</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$montant_tva_55.'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>TVA 20%</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$montant_tva_20.'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>Prix Total TTC :</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$montant_ttc.'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	$fdp = $List_Commande[0]->Total_Commande_get() - $montant_ttc;
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>Frais de Port :</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$fdp.'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	
	$message .='<tr>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='<td style="border:1px solid #424242;"><strong>Prix Total net à payer :</strong></td>';
	$message .='<td style="border:1px solid #424242;">'.$List_Commande[0]->Total_Commande_get().'</td>';
	$message .='<td style="padding-top:30px;padding-left:150px;border:1px solid #424242;"></td>';
	$message .='</tr>';
	
	
	$message .='</table>';
	$message .='<div>';
     
    if(mail($destinataire, $objet, $message, $headers))
    {
        echo '<script languag="javascript" >alert("La facture a bien été envoyé à votre adresse mail ");</script>';
    }
    else // Non envoyé
    {
        echo '<script languag="javascript">alert("Votre message n\'a pas pu être envoyé");</script>';
    }
    //header('Location: monformulaire.php');
 }
 ?>