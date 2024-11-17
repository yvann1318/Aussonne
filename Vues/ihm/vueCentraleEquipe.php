<?php

class vueCentraleEquipe
{
  public function __construct()
  {
  }

  public function modifierEquipe($listeEquipe)
  {
    {
      echo '<form action=index.php?vue=Equipe&action=saisirModif method=POST>
                <legend class="text-center">Choisir L \'equipe à modifier : ' . $listeEquipe . ' </legend>';
      echo '<div class="text-center">
             <button type="submit" class="btn btn-primary text-center">Valider</button>
             </div>
             </form>';
    }
  }

  public function saisirModifEquipe($idEquipe, $nomEquipe, $nbrPlaceEquipe, $ageMin, $ageMax, $listeSpecialite, $listeEntraineur, $listeSexe)
  {

    echo '<form action=index.php?vue=Equipe&action=enregistrerModification method=POST>';

    echo '<div class="container pt-5">
    <p class="h2 text-center pb-3">Modifier entraineur<p>
      <div class="row justify-content-center">
        <div class="col-6">
          <table class="table text-center">
            <tr>
              <td>Nom equipe :</td>
              <td><input type="text" name="nomEquipe" id="nomEquipe" value="' . $nomEquipe . '" required="true"></td>
            </tr>
            <tr>
              <td>Nombre de place dans l\'équipe :</td>
              <td><input type="text" name="nbrPlaceEquipe" id="nbrPlaceEquipe" value="' . $nbrPlaceEquipe . '" required="true"></td>
            </tr>
            <tr>
              <td>Age minimum :</td>
              <td><input type="text" name="ageMin" id="ageMin" value="' . $ageMin . '" required="true"></td>
            </tr>
            <tr>
              <td>Age maximum :</td>
              <td><input type="text" name="ageMax" id="ageMax" value="' . $ageMax . '" required="true"></td>
            </tr>
            <tr>
            <td>sexe de l\'équipe :</td>
            <td> ' . $listeSexe . '</td>
            </tr>
            <tr>
              <td>Nom de la spécialité :</td>
              <td> ' . $listeSpecialite . '</td>
            </tr>
            <tr>
              <td>Nom de l\'entraineur :</td>
              <td> ' . $listeEntraineur . '</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="text-center">		
    <legend>Attention de changer les adherents d\'équipe, en conséquence des nouvelles informations</legend>	<br>
      <button type="submit" class="btn btn-primary">Valider</button>
    </div>

    <input type="hidden" name="idEquipe" value="' . $idEquipe . '">

    </form>';
  }

  public function visualiserEquipe($message)
  {

    $listeEquipe = explode('\n', $message);
    echo '<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
                            <th scope="col">Age Min</th>
							<th scope="col">Age Max</th>
							<th scope="col">Sexe</th>
							<th scope="col">Nbr de pers Max par équipe</th>
                            <th scope="col">Spécialité</th>
							<th scope="col">Entraineur</th>						
						</tr>
					</thead>
					<tbody>';
    foreach (array_filter($listeEquipe) as $equipe)
    {
      echo '<tr><td>';
      echo str_replace('|', "</td><td>", $equipe);
      echo '</td></tr>';
    }
    echo '</tbody>';
    echo '</table>';
  }

  public function saisirEquipe($listeSpecialite, $listeEntraineur)
  {
    echo '<form action=index.php?vue=Equipe&action=enregistrer method=POST>';
    echo '<legend>Information de l\'équipe</legend>
                        
      <table class="table table-bordered table-sm table-striped">
          <thead>
              <tr>
                <th scope="col">nom équipe</th>
                <th scope="col">nombre de place équipe</th>
                <th scope="col">Age minimum</th>
                <th scope="col">Age maximum</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                <td scope>
                  <input type="text" name="nomEquipe" id="nomEquipe" required=true>
                </td>
                <td>
                  <input type=text name=placeEquipe id=placeEquipe required=true pattern="\d{1,2}" title="Veuillez entrer un chiffres.">
                </td>
                <td>
                  <input type=text name=ageMin id=ageMin required=true pattern="\d{1,2}" title="Veuillez entrer un chiffres.">
                </td>
                <td>
                  <input type=text name=ageMax id=ageMax required=true pattern="\d{1,2}" title="Veuillez entrer un chiffres.">
                </td>
              </tr>
          </tbody>
      </table>
      <table class="table table-bordered table-sm table-striped">
      <thead>
          <tr>
            <th scope="col">Sexe équipe</th>
            <th scope="col">Spécialité</th>
            <th scope="col">Entraineur</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <td>
              <select id="sexEquipe" name="sexEquipe">
                <option value="Féminin">Féminin</option>
                <option value="Masculin">Masculin</option>
              </select>
            </td>
            <td>';
    echo $listeSpecialite;
    echo '</td>
            <td>';
    echo $listeEntraineur;
    echo '</td>
          </tr>
      </tbody>
  </table>
  <div class="text-center">
  <button type="submit" class="btn btn-primary">Valider</button>
  </div>
      
</form>';
  }

  public function messageRequeteCreation()
  {
    echo '<div class="text-center h2 pt-4">
	
			La création de l\'équipe est prit en compte.

      <div class="pt-4">
      <img src="Vues/design/photos/minion.gif">
    </div>

	
			</div>';
  }

  public function messageRequeteModification()
  {
    echo '<div class="text-center h2 pt-4">
	
			Le changement sur l\'équipe est prit en compte.

      <div class="pt-4">
        <img src="Vues/design/photos/minion.gif">
      </div>
	
			</div>';
  }

  public function messageRequeteTriggerOccupeEquipe()
  {
    echo '<div class="text-center h2 pt-4">
	
			Un entraineur ne peut pas entrainer plus de 3 équipes.

      <div class="pt-4">
        <img src="Vues/design/photos/minionMechant.gif">
      </div>
	
			</div>';
  }
  public function messageRequeteTriggerCompEntraineur()
  {
    echo '<div class="text-center h2 pt-4">
	
    L\'entraineur n\'est pas compétent dans cette spécialité.

      <div class="pt-4">
        <img src="Vues/design/photos/minionMechant.gif">
      </div>
	
			</div>';
  }
}
