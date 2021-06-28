<?php
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*                Fonctions de base de gestion du panier                   */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

function creation_panier()
{
	if(!isset($_SESSION['panier']))
	{
    /* Initialisation du panier */
    $_SESSION['panier'] = array();
    /* Subdivision du panier */
	$_SESSION['panier']['id_article'] = array();
	$_SESSION['panier']['nom_article'] = array();
    $_SESSION['panier']['qte'] = array();
    $_SESSION['panier']['prix'] = array();
	$_SESSION['panier']['tva'] = array();
	$_SESSION['panier']['chemin_image'] = array();
	$_SESSION['prix_transporteur'] = 0;
	} 
	
	return true;
}



/**
* Ajoute un article dans le panier après vérification que nous ne somme pas en phase de paiement
*
* @param array  $select variable tableau associatif contenant les valeurs de l'article
* @return Mixed Retourne VRAI si l'ajout est effectué, FAUX sinon voire une autre valeur si l'ajout
*               est renvoyé vers la modification de quantité.
* @see {@link modif_qte()}
*/
function ajout($select)
{
    $ajout = false;
	
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        if(!verif_panier($select['id_article']))
        {
            array_push($_SESSION['panier']['id_article'],$select['id_article']);
			array_push($_SESSION['panier']['nom_article'],$select['nom_article']);// nom_article
            array_push($_SESSION['panier']['qte'],$select['qte']);
            array_push($_SESSION['panier']['prix'],$select['prix']);
			array_push($_SESSION['panier']['tva'],$select['tva']);
			array_push($_SESSION['panier']['chemin_image'],$select['chemin_image']);
            $ajout = true;
        }
        else
        {
            $ajout = modif_qte($select['id_article'],$select['qte']);	
        }
    }
	
    return $ajout;
}

/**
* Modifie la quantité d'un article dans le panier après vérification que nous ne somme pas en phase de paiement
*
* @param String $ref_article    Identifiant de l'article à modifier
* @param Int $qte               Nouvelle quantité à enregistrer
* @return Mixed                 Retourne VRAI si la modification a bien eu lieu,
*                               FAUX sinon,
*                               "absent" si l'article est absent du panier,
*                               "qte_ok" si la quantité n'est pas modifiée car déjà correctement enregistrée.
*/
function modif_qte($ref_article, $qte)
{
    /* On initialise la variable de retour */
    $modifie = false;
	$_SESSION['panier']['verrouille'] = false;// pas de verouillage possible didier
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        if(nombre_article($ref_article) != false && $qte != nombre_article($ref_article))
        {
            /* On compte le nombre d'articles différents dans le panier */
            $nb_articles = count($_SESSION['panier']['id_article']);
            /* On parcoure le tableau de session pour modifier l'article précis. */
            for($i = 0; $i < $nb_articles; $i++)
            {
                if($ref_article == $_SESSION['panier']['id_article'][$i])
                {
                    $_SESSION['panier']['qte'][$i] = $qte;
                    $modifie = true;
                }
            }
        }
        else
        {
            /* L'article est absent du panier, donc on ne peut pas modifier la quantité ou bien
            * le nombre est exactement le même et il est inutile de le modifier
            * Si l'article est absent, comme on a ni la taille  ni le prix, on ne peut pas l'ajouter
            * Si le nombre est le même, on ne fait pas de changement. On peut donc retourner un autre
            * type de valeur pour indiquer une erreur qu'il faudra traiter à part lors du retour d'appel
            */
            if(nombre_article($ref_article) == false)
            {
                $modifie = "absent";
            }
            if($qte != nombre_article($ref_article))
            {
                $modifie = "qte_ok";
            }
        }
    }

    return $modifie;
}

/**
* Supprimer un article du panier après vérification que nous ne somme pas en phase de paiement
*
* @param String     $ref_article numéro de référence de l'article à supprimer
* @return Mixed     Retourne TRUE si la suppression a bien été effectuée,
*                   FALSE sinon, "absent" si l'article était déjà retiré du panier
*/
function supprim_article($ref_article)
{	
    $suppression = false;
	$_SESSION['panier']['verrouille'] = false;// pas de verouillage possible didier
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        /* On vérifie que l'article à supprimer est bien présent dans le panier */
        if(nombre_article($ref_article) != false)
        {
            /* création d'un tableau associatif temporaire de stockage des articles */
            $panier_tmp = array("id_article"=>array(),"nom_article"=>array(),"qte"=>array(),"prix"=>array(),"tva"=>array(),"chemin_image"=>array());
            /* Comptage des articles du panier */
            $nb_articles = count($_SESSION['panier']['id_article']);
            /* Transfert du panier dans le panier temporaire */
            for($i = 0; $i < $nb_articles; $i++)
            {
                /* On transfère tout sauf l'article à supprimer */
                if($_SESSION['panier']['id_article'][$i] != $ref_article)
                {
                    array_push($panier_tmp['id_article'],$_SESSION['panier']['id_article'][$i]);
					array_push($panier_tmp['nom_article'],$_SESSION['panier']['nom_article'][$i]);
                    array_push($panier_tmp['qte'],$_SESSION['panier']['qte'][$i]);
                    array_push($panier_tmp['prix'],$_SESSION['panier']['prix'][$i]);
					array_push($panier_tmp['tva'],$_SESSION['panier']['tva'][$i]);
					array_push($panier_tmp['chemin_image'],$_SESSION['panier']['chemin_image'][$i]);
                }
            }
            /* Le transfert est terminé, on ré-initialise le panier */
            $_SESSION['panier'] = $panier_tmp;
			
            /* Option : on peut maintenant supprimer notre panier temporaire: */
            unset($panier_tmp);
            $suppression = true;
        }
        else
        {
            $suppression == "absent";
        }
    }
	
	/*/ si plus d'article dans le panier on le supprime (evite un bug quand le meme client revien)
	if(count($_SESSION['panier']['id_article']) < 1)
	{
		unset($_SESSION['panier']);
		die('stop');
	}
	*/
    return $suppression;
}

/**
* Supprimer un article du panier : autre méthode.
*
* @param String     $ref_article numéro de référence de l'article à supprimer
* @param Boolean    $reindex : facultatif, par défaut, vaut true pour ré-indexer le tableau après
*                   suppression. On peut envoyer false si cette ré-indexation n'est pas nécessaire.
* @return Mixed     Retourne TRUE si la suppression a bien été effectuée,
*                   FALSE sinon, "absent" si l'article était déjà retiré du panier
*/
function supprim_article2($ref_article, $reindex = true)
{
    $suppression = false;
	$_SESSION['panier']['verrouille'] = false;// pas de verouillage possible didier
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        $aCleSuppr = array_keys($_SESSION['panier']['id_article'], $ref_article);

        /* sortie la clé a été trouvée */
        if (!empty ($aCleSuppr))
        {
            /* on traverse le panier pour supprimer ce qui doit l'être */
            foreach ($_SESSION['panier'] as $k=>$v)
            {
                foreach($aCleSuppr as $v1)
                {
                    unset($_SESSION['panier'][$k][$v1]);    // remplace la ligne foireuse
                }
                /* Réindexation des clés du panier si l'option $reindex a été laissée à true */
                if($reindex == true)
                {
                    $_SESSION['panier'][$k] = array_values($_SESSION['panier'][$k]);
                }
                $suppression = true;
            }
        }
        else
        {
            $suppression = "absent";
        }
    }
    return $suppression;
}

/**
* Fonction qui supprime tout le contenu du panier en détruisant la variable après
* vérification qu'on ne soit pas en phase de paiement.
*
* @return Mixed    Retourne VRAI si l'exécution s'est correctement déroulée, Faux sinon et "inexistant" si
*                  le panier avait déjà été détruit ou n'avait jamais été créé.
*/
function vider_panier()
{
    $vide = false;
	$_SESSION['panier']['verrouille'] = false;// pas de verouillage possible didier
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        if(isset($_SESSION['panier']))
        {
            unset($_SESSION['panier']);
            if(!isset($_SESSION['panier']))
            {
                $vide = true;
            }
        }
        else
        {
            /* Le panier était déjà détruit, on renvoie une autre valeur exploitable au retour */
            $vide = "inexistant";
        }
    }
    return $vide;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*                 Fonctions annexes de gestion du panier                  */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
* Vérifie la quantité enregistrée d'un article dans le panier
*
* @param String $ref_article référence de l'article à vérifier
* @return Mixed Renvoie le nombre d'article s'il y en a, ou Faux si cet article est absent du panier
*/
function nombre_article($ref_article)
{
    /* On initialise la variable de retour */
    $nombre = false;
    /* Comptage du panier */
    $nb_art = count($_SESSION['panier']['id_article']);	
    /* On parcoure le panier à la recherche de l'article pour vérifier le cas échéant combien sont enregistrés */
    for($i = 0; $i < $nb_art; $i++)
    {
        if($_SESSION['panier']['id_article'][$i] == $ref_article)
        $nombre = $_SESSION['panier']['qte'][$i];
    }
    return $nombre;
}

/**
* Calcule le montant total du panier
*
* @return Double
*/
function montant_panier()
{
    /* On initialise le montant */
    $montant = 0;
    /* Comptage des articles du panier */
    $nb_articles = count($_SESSION['panier']['id_article']);
    /* On va calculer le total par article */
    for($i = 0; $i < $nb_articles; $i++)
    {
        $montant += $_SESSION['panier']['qte'][$i] * $_SESSION['panier']['prix'][$i];
    }
    
    return $montant;
}

/**
* Vérifie la présence d'un article dans le panier
*
* @param String $ref_article référence de l'article à vérifier
* @return Boolean Renvoie Vrai si l'article est trouvé dans le panier, Faux sinon
*/
function verif_panier($ref_article)
{
    /* On initialise la variable de retour */
    $present = false;
    /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */
    if( count($_SESSION['panier']['id_article']) > 0 && array_search($ref_article,$_SESSION['panier']['id_article']) !== false)
    {
        $present = true;
    }
    return $present;
}

/**
* Fonction de verrouillage du panier pendant la phase de paiement.
*
*/
function preparerPaiement()
{
	
}

/**
* Fonction qui va enregistrer les informations de la commande dans
* la base de données et détruire le panier.
*
*/
function paiementAccepte($id_commande)
{
	/*
	require_once '/class/Facture.php';
	require_once 'Enregistrement_Facture.php';
	require_once 'Modification_Etat_Commande.php';
	$facture = new Facture();
	date_default_timezone_set("Europe/Paris");
	$facture->Date_Facture_set(date("d/m/Y").' '.date("h:i:sa"));
	$facture->Total_Facture_set($_SESSION['MontantGlobal']);
	$facture->Id_Commande_set($id_commande);
	
	Enregistrement_Facture($facture);
	$id_etat_commande = Modification_Etat_Commande($id_commande);
	
    unset($_SESSION['panier']);
	creation_panier();
	
	header("location:Facture_Client.php?ID_Commande=".$id_commande."&Nom_Client=".$_SESSION['Nom_Client']."&ID_Etat_Commande=".$id_etat_commande);
	*/
}
?>