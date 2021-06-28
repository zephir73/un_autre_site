<?php

function Mail_Inscription($email,$mdp)
{
	$destinataire = $email;
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = 'info@cafejadore.fr';
     
    $objet = 'Confirmation d\'inscription sur café j\'adore';//$_POST['subject'];
     
    $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'To: '."\n"; //???
    $headers .= 'From: "Café J\'Adore"<'.$expediteur.'>'."\n"; // Expediteur
     
    $message =  '<div style="width: 100%; text-align: center; font-weight: bold"> Bonjour !<br>
	Voici vos identifiant :<br>
	Pour Le Login : '.$email.'<br>
	Pour Le Mot de Passe : '.$mdp.'</div>';
     
    if(mail($destinataire, $objet, $message, $headers))
    {
        echo '<script languag="javascript" >alert("Un message avec vos indentifient a bien été envoyé à votre adresse mail ");</script>';
    }
    else // Non envoyé
    {
        echo '<script languag="javascript">alert("Votre message n\'a pas pu être envoyé");</script>';
    }
}
?>