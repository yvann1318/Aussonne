<HTML>
	<HEAD>
		<TITLE>
		code JavaScript
		</TITLE>
		
	</HEAD>
	<BODY>
	<?php
	include ('accesBD.php');
	$maConnexion = new accesBD();
	if ($maConnexion)
	{
		// On affiche la liste deroulante des enseignements
		echo $maConnexion->affichelisteSELECT();
		
		
	};
	?>
	<UL id=zoneResultat>
	 <!-- Ici on pourrait mettre un appel a $listeDesMatieres[0] avec un echo pour afficher la valeur de base -->
	</UL>
	<SCRIPT language = 'javascript'>
			function fonctionJavascript()
			{
				var laListe;
				laListe = document.getElementById('theme');
				var uneRef;
				uneRef = laListe.options[laListe.selectedIndex].value;
				var listeDesNouvelleJS = document.getElementById('zoneResultat');
				
				if(uneRef==1) {
					listeDesNouvelleJS.innerHTML = "<?php echo $listeDesNouvelle[0]; ?>";
				} else if(uneRef==2) {
					listeDesNouvelleJS.innerHTML = "<?php echo $listeDesNouvelle[1]; ?>";
				}
			}
		</SCRIPT>
		<A href = codeJavascript.php>retour</A>
	</BODY>
</HTML>