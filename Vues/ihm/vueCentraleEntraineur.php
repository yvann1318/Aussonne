	<?php

	class vueCentraleEntraineur
	{
		public function __construct()
		{
		}

		public function modifierSonProfilEntraineur()
		{	//form pour passer la variable npass
			echo '<form action="" method="POST">
			<label>Changer le mot de passe</label>
			<input type="password" id="npass" name="npass" required"><br>
			<input type="submit" value="Envoyer">
			</form>';
		}
		public function afficheSesEquipes($sesEquipes)
		{
			$equipes = [];

			// Regrouper les membres par équipe
			foreach ($sesEquipes as $row)
			{
				$equipe = $row[0];
				$nom = $row[1];
				$prenom = $row[2];

				// Si l'équipe n'existe pas encore dans le tableau $equipes, on la crée
				if (!isset($equipes[$equipe]))
				{
					$equipes[$equipe] = [];
				}

				// Ajouter le membre à l'équipe correspondante
				$equipes[$equipe][] = ['nom' => $nom, 'prenom' => $prenom];
			}
			echo "<p class='text-center h4'><b>Voici les équipes avec ses adherent que vous entrainés</b></p>";
			foreach ($equipes as $nomEquipe => $membres)
			{
				echo '<div class="row">
				<div class="col-sm">
				</div>
				<div class="col-sm pt-3">
					<div class="card col d-flex" style="width: 18rem;">
						<div class="card-body">
							<h5 class="card-title">Équipe: '.$nomEquipe.'</h5>
								<h6 class="card-subtitle mb-2 text-muted">Detail des adherents</h6>';
								foreach ($membres as $membre)
								{
									echo 'Adherent : ' . $membre['nom'] . ' ' . $membre['prenom'] . '<br>';
								}
				echo '      </div>
					</div>
				</div>
				<div class="col-sm">
				</div>
			</div>';
			}
			
		}
		public function informationEntraineur($id)
		{
			$listeEntraineur = explode("|", $id);
			//print_r($listeEntraineur);
			echo '<div class="row">
					<div class="col-sm">
					</div>
					<div class="col-sm">
						<div class="card col d-flex" style="width: 18rem;">
							<div class="card-body">
								<h5 class="card-title text-center">Visualisation d\'un Entraineur</h5>
									<h6 class="card-subtitle mb-2 text-muted text-center">Detail de l\'entraineur</h6>
										<p class="card-text text-center"><b class="h5">' . $listeEntraineur[1] . '</b><br> 
										Login : ' . $listeEntraineur[2] . '<br> 
										Specialite : ' . $listeEntraineur[3] . '<br>
										</p>
							</div>
						</div>
					</div>
					<div class="col-sm">
					</div>
				</div>';
		}

		public function ajouterEntraineur()
		{
			echo '<form action=index.php?vue=Entraineur&action=SaisirEntraineur method=POST align=center>
							<fieldset>
							<legend>L entraineur est un : </legend>
							<input type="radio" name="typeEntraineur" value="Vacataire" id="vacataire">
							<label for="vacataire">Vacataire</label> <br/>

							<input type="radio" name="typeEntraineur" value="Titulaire" id="titulaire">
							<label for="titulaire">Titulaire</label> <br/>

							
							
							<button type="submit" class="btn btn-primary">Valider</button>
							</fieldset>	
						  </form>';
		}
		public function visualiserEntraineur($liste)
		{
			$listeEntraineur = explode('\n', $liste);

			echo '<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Nom</th>
							<th scope="col">Login</th>
							<th scope="col">Spécialité</th>
							<th scope="col">Date ou Téléphone</th>
						</tr>
					</thead>
					<tbody>';
			/*$nbE = 0;
			while ($nbE < sizeof($listeEntraineur)) {
				$i = 0;
				echo '<tr>';
				while (($i < 5) && ($nbE < sizeof($listeEntraineur))) {
					echo '<td scope>';
					echo trim($listeEntraineur[$nbE]);
					$i++;
					$nbE++;
					echo '</td>';
				}
				echo '</tr>';
			}*/
			foreach (array_filter($listeEntraineur) as $entraineur)
			{
				echo '<tr><td>';
				echo str_replace('|', "</td><td>", $entraineur);
				echo '</td></tr>';
			}

			echo '</tbody>';
			echo '</table>';
		}
		public function saisirEntraineur($listeSpecialite)
		{
			$typeEntraineur = $_POST['typeEntraineur'];

			echo '<form action=index.php?vue=Entraineur&action=enregistrer method=POST>';

			switch ($typeEntraineur)
			{
				case 'Vacataire':
					echo '<legend>Information du Vacataire</legend>
							
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Téléphone</th>
									  <th scope="col">Nom</th>
									  <th scope="col">Login</th>
									  <th scope="col">Password</th>
									  <th scope="col">Spécialité</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									  <td scope>
										<input type="text" name="numTelVacataire" id="NumTel" required="true" pattern="\d{10}" title="Veuillez entrer exactement 10 chiffres.">
									  </td>
									  <td>
										<input type=text name=nomEntraineur id=nomEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=loginEntraineur id=loginEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=pwdEntraineur id=pwdEntraineur required=true>
									  </td>
									  <td>';
					echo $listeSpecialite;
					echo '</td>
									</tr>
									<tr colspan=5>
									  <input type=hidden name=typeEntraineur value=' . $typeEntraineur . '>
									</tr>
								</tbody>
							</table>
							<p class="text-danger">M\'intenir la touche Ctrl appuiyer pour sélectionner plusieur spécialités</p>
							<div class="text-center pt-3">
							<button type="submit" class="btn btn-primary">Valider</button>
							</div>
							
					</form>';
					break;

				case 'Titulaire':
					echo '<legend>Information du Titulaire</legend>
												
							<table class="table table-bordered table-sm table-striped">
								<thead>
									<tr>
									  <th scope="col">Date Entrée</th>
									  <th scope="col">Nom</th>
									  <th scope="col">Login</th>
									  <th scope="col">Password</th>
									  <th scope="col">Spécialité</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									  <td scope>
									    <input type=date name="dateEmbaucheTitulaire" id="dateEmbaucheTitulaire" required="true">
									  </td>
									  <td>
										<input type=text name=nomEntraineur id=nomEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=loginEntraineur id=loginEntraineur required=true>
									  </td>
									  <td>
										<input type=text name=pwdEntraineur id=pwdEntraineur required=true>
									  </td>
									  <td>';
					echo $listeSpecialite;
					echo '</td>
									</tr>
									<tr colspan=5>
									  <input type=hidden name=typeEntraineur value=' . $typeEntraineur . '>
									</tr>
								</tbody>
							</table>
							<p class="text-danger">M\'intenir la touche Ctrl appuiyer pour sélectionner plusieur spécialités</p>
							<div class="text-center pt-3">
							<button type="submit" class="btn btn-primary">Valider</button>
							</div>
					</form>';
					break;
			}
		}

		public function modifierEntraineur($liste)
		{
			echo '<form action=index.php?vue=Entraineur&action=saisirModification method=POST>
				<legend class="text-center">Choisir L \'entraineur à modifier : ' . $liste . ' </legend>';
			echo '<div class="text-center">
			 <button type="submit" class="btn btn-primary text-center">Valider</button>
			 </div>
			 </form>';
		}
		public function saisirModifEntraineur($listeSpecialite, $idEntraineur, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateOuTel, $vacataire, $titulaire)
		{

			echo '<form action=index.php?vue=Entraineur&action=enregistrerModification method=POST>';

			echo '<div class="container pt-5">
			<p class="h2 text-center pb-3">Modifier entraineur<p>
			<div class="row justify-content-center">
				<div class="col-6">
					<table class="table text-center">
						<tr>
							<td>Nom entraineur :</td>
							<td><input type="text" name="nomEntraineur" id="nomEntraineur" value="' . $nomEntraineur . '" required="true"></td>
						</tr>
						<tr>
							<td>Login entraineur :</td>
							<td><input type="text" name="loginEntraineur" id="loginEntraineur" value="' . $loginEntraineur . '" required="true"></td>
						</tr>
						<tr>
							<td>Mot de passe entraineur :</td>
							<td><input type="text" name="pwdEntraineur" id="pwdEntraineur" value="' . $pwdEntraineur . '" required="true"></td>
						</tr>';

			if ($vacataire)
			{
				echo '<tr>
				<td>Téléphone :</td>
				<td><input type="text" name="dateOuTel" id="dateOuTel" value="' . $dateOuTel . '" required="true" pattern="\d{10}" title="Veuillez entrer exactement 10 chiffres."></td>
			  </tr>';
			}

			if ($titulaire)
			{
				echo '<tr>
				<td>Date d\'embauche :</td>
				<td><input type="date" name="dateOuTel" id="dateOuTel" value="' . $dateOuTel . '" required="true"></td>
			  </tr>';
			}

			echo '</table>
		  			</div>
				</div>
			</div>';


			echo '<div class="row pt-5 text-center">
			<div class="col-9">
				<legend>Choisir les spécialités que l\'entraineur pourras enseigner a partir de maintenant: <br>
				Attention a changer les équipes d\'entraineur en conséquence</legend>
				<p class="text-danger"><b>M\'intenir la touche Ctrl appuiyer pour sélectionner plusieur spécialités</b></p>
			</div>
			<div class="col-3 text-left">
				<legend>' . $listeSpecialite . '</legend>
			</div>
		</div>
			<div class="text-center">			
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>

			<input type="hidden" name="idEntraineur" value="' . $idEntraineur . '">
			<input type="hidden" name="vacataire" value="' . $vacataire . '">
			<input type="hidden" name="titulaire" value="' . $titulaire . '">';

			echo '</form>';
		}

		public function messageRequeteCreation()
		{
			echo '<div class="text-center h2 pt-4">
	
			La création de l\'entraineur est prit en compte.
	
			</div>';
		}

		public function messageRequeteModification()
		{
			echo '<div class="text-center h2 pt-4">
	
			Le changement sur l\'entraineur est prit en compte.
	
			</div>';
		}
	}
