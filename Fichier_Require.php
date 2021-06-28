<?php

/* CLASS */
require_once 'php/class/Article.php';
require_once 'php/class/Bdd_Connection.php';
require_once 'php/class/Categorie.php';
require_once 'php/class/Client.php';
require_once 'php/class/Commande.php';
require_once 'php/class/Composer.php';
require_once 'php/class/Etat_Commande.php';
require_once 'php/class/Facture.php';
require_once 'php/class/Stock.php';
require_once 'php/class/Transporteur.php';


/* FONCTION */
require_once 'php/fonction/Article_Existe.php';
require_once 'php/fonction/Categorie_Existe.php';
require_once 'php/fonction/Client_Existe.php';
require_once 'php/fonction/Deconnection_Client.php';
require_once 'php/fonction/Enregistrement_Article.php';
require_once 'php/fonction/Enregistrement_Categorie.php';
require_once 'php/fonction/Enregistrement_Client.php';
require_once 'php/fonction/Enregistrement_Commande.php';
require_once 'php/fonction/Enregistrement_Facture.php';
require_once 'php/fonction/Enregistrement_Transporteur.php';
require_once 'php/fonction/Envoie_Facture.php';
require_once 'php/fonction/fonctions-panier.php'; // pas moi qui l'ait fait
require_once 'php/fonction/Lecture_Article.php';
require_once 'php/fonction/Lecture_Categorie.php';
require_once 'php/fonction/Lecture_Client.php';
require_once 'php/fonction/Lecture_Commande.php';
require_once 'php/fonction/Lecture_Commande_Article.php';
require_once 'php/fonction/Lecture_Etat_Commande.php';
require_once 'php/fonction/Lecture_Stock.php';
require_once 'php/fonction/Lecture_Transporteur.php';
require_once 'php/fonction/Mail_Inscription.php';
require_once 'php/fonction/Mdp_Oublier.php';
//require_once 'php/fonction/Mise_A_Zero_Bdd.php';
require_once 'php/fonction/Modification_Article.php';
require_once 'php/fonction/Modification_Client.php';
require_once 'php/fonction/Modification_Commande.php';
require_once 'php/fonction/Modification_Etat_Commande.php';
//require_once 'php/fonction/Modification_Nb_Article_Commande.php'; // a garder ou pas ???
require_once 'php/fonction/Modification_Stock.php';
require_once 'php/fonction/Modification_Transporteur.php';
require_once 'php/fonction/Recherche_Commande.php';
require_once 'php/fonction/Recherche_Facture.php';
//require_once 'php/fonction/Recherche_Transporteur.php';
require_once 'php/fonction/Suppression_Commande.php';
require_once 'php/fonction/Suppression_Transporteur.php';
require_once 'php/fonction/Supprime_Article.php';
require_once 'php/fonction/Supprime_Categorie.php';
//require_once 'php/fonction/Transporteur_Existe.php';
require_once 'php/fonction/Suppression_Client.php';
?>