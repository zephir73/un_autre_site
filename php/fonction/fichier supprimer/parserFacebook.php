<?php
function parserFacebook($idPage = '', $nb = 5, $keepImg = false) {
	// URL de Facebook
	$url = "https://www.facebook.com/feeds/page.php?id=";
	$url.= $idPage;
	$url.= "&format=rss20"; // ou "json" ou "atom10"
 
	// Lancement de cURL
	$curl = curl_init($url);
 
	// Ajout d'entêtes pour se faire passer pour un robot
	$header = array(
		"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
		"Cache-Control: max-age=0",
		"Accept-Charset: UTF-8;q=0.7,*;q=0.7",
		"Pragma: " // Pas de cache par défaut
	);
	
	// User-agent automatique (au pire, en choisir un précis)
	$ua = $_SERVER['HTTP_USER_AGENT'];
	
	// URL referer à renvoyer à Facebook (vide recommandé !)
	$referer = "";
	
	// Timeout de cURL
	$timeout = 30;
	
	// Options de cURL
	curl_setopt($curl, CURLOPT_USERAGENT, $ua);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_REFERER, $referer);
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
 
	// Exécution de cURL
	$cURLxml = curl_exec($curl);
 
	// Fermeture de cURL
	curl_close($curl);
 
	// Récupération des données XML avec simpleXML
	$simpleXML = simplexml_load_string($cURLxml);
	$simpleXML = $simpleXML->channel->item;
 
	// Conservation uniquement des posts réels
	foreach($simpleXML as $item) {
		$verif = preg_match("#(/posts/|/photos/|permalink)#iU", $item->link);
		if($verif == true) {
			$tabItem[] = $item;
		}
	}
 
	// Instanciation des variables par défaut
	$resultat = '';
	$i = 0;
	
	// Boucle de récupération des résultats
	foreach($tabItem as $item) {
		// Instanciation des variables
		$urlPage= "https://www.facebook.com/".$idPage;
		$date	= date("d/m/Y à h:i:s", strtotime($item->pubDate));
		$auteur	= $item->author;
		$lien	= $item->link;
		$titre	= trim($item->title);
		$texte	= trim($item->description);
		
		// Tant que le nombre de résultats correspond à nos souhaits
		if($i < $nb) {
			// Supprime les sauts de ligne inutiles
			$regex = '#(<br(/?)>)+(<a(.*)>(.*)</a>)(<br(/?)>)?#iU';
			$texte = preg_replace($regex, '$3', $texte);
			$regex = '#(<br(/?)>){2,}#iU';
			$texte = preg_replace($regex, '<br/>', $texte);
 
			// On supprime les images si on ne veut garder que le texte
			if($keepImg == false) {
				$regex = '#(<a(.*)><img(.*)></a>)#iU';
				$texte = preg_replace($regex, '', $texte);
			} else {
				$regex = '#(<a(.*)><img(.*)></a>)#iU';
				$texte = preg_replace($regex, '<p>$1<p>', $texte);
			}
 
			// Suppression du titre répété dans le texte...
			$texte = str_ireplace($titre, '', $texte);
 
			// Formatage du résultat
			$resultat .= '<div class="block">';
			$resultat .= '<h3 class="titre"><a href="'.$lien.'" target="_blank">'.$titre.'</a></h3>';
			$resultat .= '<div class="meta">Publié le '.$date.' par <a href="'.$urlPage.'" target="_blank">'.$auteur.'</a></div>';
			$resultat .= '<div class="contenu">'.$texte.'</div>';
			$resultat .= '</div>';
		} else {
			break;
		}
 
		// Incrémentation
		$i++;
	}
	
	// Retourne le résultat final
	return $resultat;
}
?>