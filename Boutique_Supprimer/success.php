<?php

// si il y a payment effectuer je retourne sur la page commande client
echo ('<script language="Javascript">
	<!--
	document.location.replace("Commande_Client.php?PayPal=success");
	// -->
	</script>');			

?>