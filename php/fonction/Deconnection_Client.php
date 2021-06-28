<?php
//session_start();
function Deconnexion_Client()
{
	session_destroy();
	header('Location:Boutique.php');
}

?>