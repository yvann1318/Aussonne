<?php


class conteneurSpecialite
{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesSpecialites;

	//le constructeur créer un tableau vide
	public function __construct()
	{
		$this->lesSpecialites = new arrayObject();
	}

	//les méthodes habituellement indispensables
	public function ajouterUneSpecialite(int $unIdSpecialite, string $unNomSpecialite)
	{
		$uneSpecialite = new metierSpecialite(idSpecialite: $unIdSpecialite, nomSpecialite: $unNomSpecialite);
		$this->lesSpecialites->append($uneSpecialite);
	}

	public function modifierUneSpecialite($unIdSpecialite, $unNomSpecialite)
	{

		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			if ($uneSpecialite->idSpecialite == $unIdSpecialite)
			{
				$uneSpecialite->nomSpecialite = $unNomSpecialite;
			}
		}
	}



	public function nbSpecialite()
	{
		return $this->lesSpecialites->count();
	}

	public function listeDesSpecialites()
	{
		$liste = '';
		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			$liste = $liste . $uneSpecialite->afficheSpecialite();
		}
		return $liste;
	}

	public function leNomDesSpecialites()
	{
		$return = array();

		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			array_push($return, $uneSpecialite->nomSpecialite);
		}

		return implode(', ', $return);
	}
	public function idDesSpecialites()
	{
		$return = array();

		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			array_push($return, $uneSpecialite->idSpecialite);
		}

		return $return;
	}

	public function lesSpecialitesAuFormatHTML()
	{
		$liste = "<SELECT name = 'idSpecialite'>";
		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			$liste = $liste . "<OPTION value='" . $uneSpecialite->idSpecialite . "'>" . $uneSpecialite->nomSpecialite . "</OPTION>";
		}
		$liste = $liste . "</SELECT>";
		return $liste;
	}

	public function lesSpecialitesSelectedAuFormatHTML($unIdSpecialite)
	{
		$liste = "<SELECT name = 'idSpecialite'>";
		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			//(condition) ? (valeur si vraie) : (valeur si fausse)
			$selected = ($uneSpecialite->idSpecialite == $unIdSpecialite) ? "selected" : "";
			$liste .= "<OPTION value='" . $uneSpecialite->idSpecialite . "' $selected>" . $uneSpecialite->nomSpecialite . "</OPTION>";
			//$liste = $liste . "<OPTION value='" . $uneSpecialite->idSpecialite . "'>" . $uneSpecialite->nomSpecialite . "</OPTION>";
		}
		$liste = $liste . "</SELECT>";
		return $liste;
	}

	public function lesSpecialitesMultipleAuFormatHTML()
	{
		$liste = "<select name='idSpecialite[]' multiple required>";

		foreach ($this->lesSpecialites as $uneSpecialite) {
			$liste .= "<option value='" . $uneSpecialite->idSpecialite . "'>" . " " .$uneSpecialite->nomSpecialite . "</option>";
		}

		$liste .= "</select>";

		return $liste;
	}

	public function lesSpecialitesMultipleSelectedAuFormatHTML($listeIdSpecialites)
	{
		$liste = "<select name='idSpecialite[]' multiple required>";

		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			// Vérifier si l'ID de la spécialité est dans la liste des ID spécifiés
			$selected = in_array($uneSpecialite->idSpecialite, $listeIdSpecialites) ? 'selected' : '';
			$liste .= "<option value='" . $uneSpecialite->idSpecialite . "' $selected>" . $uneSpecialite->nomSpecialite . "</option>";
		}

		$liste .= "</select>";

		return $liste;
	}

	public function donneObjetSpecialiteDepuisNumero($unIdSpecialite)
	{

		$trouve = false;
		$laBonneSpecialite = null;
		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			if ($uneSpecialite->idSpecialite == $unIdSpecialite)
			{
				$trouve = true;
				$laBonneSpecialite = $uneSpecialite;
			}
		}
		return $laBonneSpecialite;
	}
}
