<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Menu Entraîneur
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
		<li><a class="dropdown-item" href='index.php?vue=Entraineur&action=visualiser'>Visualiser les entraineurs</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuSpecialite" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Menu Specialite
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuSpecialite">
		<li><a class="dropdown-item" href='index.php?vue=Specialite&action=visualiser'>Visualiser les spéciatés</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Menu Adherent
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuAdherent">
		<li><a class="dropdown-item" href='index.php?vue=Adherent&action=visualiser'>Visualiser les Adherents</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Menu Equipe
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuAdherent">
		<li><a class="dropdown-item" href='index.php?vue=Adherent&action=visualiser'>Visualiser les Equipes</a></li>
	</ul>
</div>

</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-2 col-xs-12 infosComplementaires">
			<?php require "vues/ihm/connexion.php"; ?>
			<?php require "vues/ihm/deconnexion.php";  ?>
			<p class ="pt-3"></p>
		</div>
		<div class="col-md-10 col-xs-12 ">