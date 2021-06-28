<?php
 
 function Mdp_Oublier($client)
 {
	$destinataire = $client->Email_Client_get();
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = 'info@cafejadore.fr';//$_POST['email'];
     
    $objet = 'Voici vos identifiants du café j\'adore';//$_POST['subject'];
     
    $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'To: '."\n"; // Mail de reponse
    $headers .= 'From: "Café J\'Adore"<'.$expediteur.'>'."\n"; // Expediteur
     
    $message =  '<div style="width: 100%; text-align: center; font-weight: bold"> Bonjour !<br>
	Voici vos identifiant :<br>
	Pour Le Login :'.$client->Email_Client_get().'<br>
	Pour Le Mot de Passe : '.$client->Mdp_Client_get().'</div>';
     
    if(mail($destinataire, $objet, $message, $headers))
    {
        echo '<script languag="javascript" >alert("Un message a bien été envoyé à votre adresse mail ");</script>';
    }
    else // Non envoyé
    {
        echo '<script languag="javascript">alert("Votre message n\'a pas pu être envoyé");</script>';
    }
    //header('Location: monformulaire.php');
 }
 ?>