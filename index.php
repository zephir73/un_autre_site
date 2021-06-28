<?php
session_start(); // On démarre la session AVANT toute chose
// verif adresse securitée
if(!isset($_SERVER['REDIRECT_HTTPS']))
{
	header('Location:https://www.cafejadore.fr/');
}
// charge tous les fichiers utilisés pour le site
include 'Fichier_Require.php';

?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
        <title>Home Café J'Adore</title>
        <meta charset="utf-8">
        <meta name="description" content="165c. uniques">
		<meta name="viewport" content="width=device-width" />
		<meta name="viewport" content="height=device-width" />		
		<link href="css/Global.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="css/Index.css" media="screen" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" media="screen and (max-width: 500px)" href="css/Index_500px.css" type="text/css" />
		
		
</head>

<body>    
<?php
include 'Header.php';

include 'Slide.php';
?>


       
<article>
		<p>REJOINS-NOUS SUR <b>FACEBOOK</b>  <a href="https://www.facebook.com/Cafejadorelyon/"><img src="./image/icon_fb.jpg" alt="icon_fb" height="42" width="42"></a></p>
		<div id="ligne"></div>
		</br>
		<table>
			<tr>
			<!--<td><img src="./image/wrap.jpg" alt="wrap" height="200" width="300"></td>
			<td><img src="./image/wrap.jpg" alt="wrap" height="200" width="300"></td>
			<!--<td><img src="./image/wrap.jpg" alt="wrap" height="200" width="300"></td>!-->
			<td><iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCafejadorelyon&tabs=timeline%2C%20events%2C%20messages&width=340&height=500&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></td>

			<td><p><b>Café j'adore-coffee & tea shop lyonnais</b></br>
				Nos délicieux wrap vous attendent au <a href="https://www.instagram.com/explore/locations/7919568/cafe-jadore-coffee-tea-shop/">#coffeeshop</a> </p>
			</td>
			</tr>
		</table> 
		<!--
		<p>REJOINS-NOUS SUR <b>INSTAGRAM</b>  <a href="https://www.instagram.com"><img src="./image/icon_insta.jpg" alt="icon_insta" height="42" width="42"></a></p>
		<div id="ligne"></div>
		</br>
		<table>
			<tr>
			<td><img src="./image/Lunch_salade.jpg" alt="lunch_salade" height="33%" width="100%"></td>
			<td><img src="./image/Lunch_salade.jpg" alt="lunch_salade" height="33%" width="100%"></td>
			<td><img src="./image/Lunch_salade.jpg" alt="lunch_salade" height="33%" width="100%"></td>
			<td><p><b>Café j'adore-coffee & tea shop lyonnais</br>
				@Cafejadorelyon</b></br>
				Un déjeuner de champion vous attend au Café j'adore </br>
				ce midi <a href="https://www.instagram.com">#lyon</a>
						<a href="https://www.instagram.com">#croixrousse</a>
						<a href="https://www.instagram.com">#igerslyon</a>
						<a href="https://www.instagram.com">#coffeeshop</a></br>
						<a href="https://www.instagram.com">#teashop</a>
						<a href="https://www.instagram.com">#lunch</a>
						<a href="https://www.instagram.com">#yummy</a>
						<a href="https://www.instagram.com">#miam</a>
						<a href="https://www.instagram.com">#fresh</a>
						<a href="https://www.instagram.com">#food</a>
						<a href="https://www.instagram.com">#igfood</a></br>
						<a href="https://www.instagram.com">#miam</a> <!-- doublon
						<a href="https://www.instagram.com">#cafejadore</a>
						<a href="https://www.instagram.com">#summer</a>
						<a href="https://www.instagram.com">#salade</a>
						<a href="https://www.instagram.com">#healty</a></p></td>
			</tr>
		</table>
		-->
		</br>
		<div id="ligne_long"></div>
		</br>
		
		<p id="nsa">NOTRE <b>SAVOIR-FAIRE</b></p>
		<div id="ligne"></div>
		</br>
		
		<table>
			<tr>
			<td><img src="./image/coffee-300x200.jpg" class="imgIndex" alt="coffee" height="100%" width="100%"></td>
			<td id="ec" class="description"><h1 class="description_titre">Expertise du Café</h1>
			<div id="ligne_des"></div>
			</br>
					<p>Nos baristi ont été formés en Italie,</br>
					ils se feront un plaisir de faire du Latte Art sur</br>
					votre cappuccino, dessins réalisés avec la</br>
					crema (mousse de lait) et le café, ou/et avec</br>
					des coulis de chocolat noir ou de caramel.</br>
					</br>
					Chez Café J'Adore le plaisir visuel rejoint le</br>
					plaisir gustatif !</p>
			</td>
			</tr>
		</table>
		</br>
		<table>
			<tr>
			<td id="dt" class="description"><h1 class="description_titre">Découvrez nos thés</h1>
			<div id="ligne_des"></div>
			</br>
					<p>Venez déguster nos délicieux thés</br>
					aux divers parfums ...</br></p>
			</td>
			<td><img src="./image/titlis-2-300x300.jpg" class="imgIndex the" alt="thé" height="100%" width="100%"></td>
			</tr>
		</table>
		</br>
		<table>
			<tr>
			<td><img src="./image/wrap.jpg" class="imgIndex" alt="wrap" height="100%" width="100%"></td>
			<td id="ds" class="description"><h1 class="description_titre">Dégustations salées</h1>
			<div id="ligne_des"></div>
			</br>
					<p>Chaque week-end de 11h à 14h nous vous</br>
					faisons découvrir les specialités culinaires (type</br>
					street-food) de différents pays : Etats Unis,</br>
					Mexique, Italie, Canada, autour d'un brunch.</br>
					</br>
					A déguster sur place, sur réservation, à</br>
					emporter, ou même se faire livrer par</br>
					Deliveroo.fr</p>
			</td>
			</tr>
		</table> 
		</br>
		<table>
			<tr>
			<td id="dess" class="description"><h1 class="description_titre">Desserts sucrés</h1>
			<div id="ligne_des"></div>
			</br>
					<p>Venez déguster nos délicieuses glaces</br>
					artisanales sur place ou à emporter, en</br>
					cornet ou en pot.</br>
					Nous avons une trentaine de saveurs</br>
					différentes : sorbets ou glaces, grands</br>
					classiques ou créations spéciales.</br>
					Nous vous proposons également des coupes</br>
					glacées : Milkshake, Affrogato, Café Liégeois...</p>
			</td>
			<td><img src="./image/dessert.png" class="imgIndex espace" alt="dessert" height="100%" width="100%"></td>
			</tr>
		</table>
		
		</br>
		<div id="ligne_long"></div>
		</br>
		
		<p id="cont"><b>CONTACT</b></p>
		<div id="ligne"></div>
		</br>
		
		<table id="contact">
			<tr>
				<th class="contact">Café J'Adore Les pentes</th>
				<th class="contact">Café J'Adore Clos-Jouve</th>
			</tr>
			<tr>
				<td><p><b>46 Montée de la Grande Côte</br>
					69001 Lyon</b></br>
					</br>
					Métro A - Croix-Paquet<br>
					Ligne C18, 13 et S6 - Mairie du 1er</br>
					Ligne S12 - Neyret</p>
				</td>
				<td><p><b>28 Boulevard de la Croix-Rousse</br>
					69001 Lyon</b></br>
					</br>
					Métro C - Croix-Rousse</br>
					Ligne C18, C13, 45, 2 - Clos Jouve</p></br></td>
			</tr>
			<tr>
				<td class="contact">Nous vous accueillons :</td>
				<td class="contact">Nous vous accueillons :</td>
			</tr>
			<tr>
				<td><p><b>Du Lundi au Ventredi 8h - 19h</br>
					Du Samedi au Dimanche 9h - 19h</b></br>
					</br>
					info@cafejadore.fr</br>
					09.81.73.29.04</br>
					06.69.99.10.20</br></p>
				</td>
				<td><p><b>Du Lundi au Ventredi 8h - 19h</br>
					Du Samedi au Dimanche 9h - 19h</b></br>
					</br>
					info@cafejadore.fr</br>
					09.81.73.29.04</br>
					06.69.99.10.20</br></p>
				</td>
			</tr>
			<tr class="i_frame">
				<td class="i_frame"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2782.9853135012204!2d4.829238615665486!3d45.77148457910575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4eafd7b885edb%3A0x1df6a8e6d1d95baf!2s46+Mont%C3%A9e+de+la+Grande-C%C3%B4te%2C+69001+Lyon!5e0!3m2!1sfr!2sfr!4v1508065478617" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></td>
				<td class="i_frame"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2782.924896094723!2d4.818756615665514!3d45.77269537910583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4eb056875851d%3A0xcf6a6588ebc3f5f1!2s28+Boulevard+de+la+Croix-Rousse%2C+69001+Lyon-1ER-Arrondissement!5e0!3m2!1sfr!2sfr!4v1508065611730" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></td>
			</tr>	
		</table>
		</article>      
<?php
include 'Footer.php';
?>  
</body>
</html>