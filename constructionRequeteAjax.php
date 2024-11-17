<?php
	include ('Outil\accesBD.php');
	$maConnexion = new accesBD();
	$listeDesmatieres ="";
	if ($maConnexion)
	{
		$listeDesMatieres = $maConnexion->afficheListeDesNouvelleAjax();
		echo $listeDesMatieres;
	};
	?>
