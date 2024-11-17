<?php
	
	class vueCentraleSpecialite
	{
		public function __construct()
		{
			
		}
		
		public function modifierSpecialite($listeSpecialite)
		{
			{
				echo '<form action=index.php?vue=Specialite&action=saisirModif method=POST>
					<legend class="text-center">Choisir La spécialité à modifier : ' . $listeSpecialite . ' </legend>';
				echo '<div class="text-center">
				 <button type="submit" class="btn btn-primary text-center">Valider</button>
				 </div>
				 </form>';
			}
		}

		public function saisirModifSpecialite($idSpecialite, $nomSpecialite)
		{

			echo '<form action=index.php?vue=Specialite&action=enregModif method=POST>';

			echo '<div class="container pt-5">
			<p class="h2 text-center pb-3">Modifier entraineur<p>
			<div class="row justify-content-center">
				<div class="col-6">
					<table class="table text-center">
						<tr>
							<td>Nom entraineur :</td>
							<td><input type="text" name="nomSpecialite" id="nomSpecialite" value="' . $nomSpecialite . '" required="true"></td>
						</tr>
						</table>
		  			</div>
				</div>
			</div>

			<div class="text-center">			
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>

			<input type="hidden" name="idSpecialite" value="' . $idSpecialite . '">';

			echo '</form>';
		}

		function saisirSpecialite()
		{
			echo '<form action=index.php?vue=Specialite&action=enregistrer method=POST>
			<legend>Information de la spécialité</legend>
							
			<table class="table table-bordered text-center table-sm table-striped">
				<thead>
					<tr>
					  <th scope="col">Nom spécialité</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					  <td scope>
						<input type="text" name="nomSpecialite" id="NumTel" required="true">
					  </td>
				</tbody>
			</table>
			<div class="text-center pt-3">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>
			</form>';
		}
		public function visualiserSpecialite($message)
		{
						
			$listeSpecialite=explode('\n',$message);
			echo '<table class="table table-striped table-bordered table-sm ">
					<thead>
						<tr>
							<th scope="col">Nom</th>
														
						</tr>
					</thead>
					<tbody>';
			/*$nbE=0;
			while ($nbE<sizeof($listeSpecialite))
			{	
				$i=0;
				while (($i<6) && ($nbE<sizeof($listeSpecialite)))
				{
					echo '<td scope>';
					echo trim($listeSpecialite[$nbE]);
					$i++;
					$nbE++;
					echo '</td>';
				}
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';*/
			foreach (array_filter($listeSpecialite) as $specialite)
			{
				echo '<tr><td>';
				echo str_replace('|', "</td><td>", $specialite);
				echo '</td></tr>';
			}
			echo '</tbody>';
			echo '</table>';
			
		}

		public function messageRequeteModification()
		{
			echo '<div class="text-center h2 pt-4">
	
			Le changement sur la spécialité est prit en compte.
	
			</div>';
		}

		public function messageRequeteInsert()
		{
			echo '<div class="text-center h2 pt-4">
	
				Le l\'ajout sur la spécialité est prit en compte.
	
			</div>';
		}
		

}
