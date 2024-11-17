<?php

class conteneurAdherent
{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesAdherents;

	//le constructeur créer un tableau vide
	public function __construct()
	{
		$this->lesAdherents = new arrayObject();
	}

	//les méthodes habituellement indispensables
	public function ajouterUnAdherent(conteneurEquipe $lesEquipes, int $unIdAdherent, string $unNomAdherent, string $unPrenomAdherent, int $ageAdherent, string $sexeAdherent, string $unLoginAdherent, string $unPwdAdherent)
	{
		$unAdherent = new metierAdherent($lesEquipes, $unIdAdherent, $unNomAdherent, $unPrenomAdherent, $ageAdherent, $sexeAdherent, $unLoginAdherent, $unPwdAdherent);
		$this->lesAdherents->append($unAdherent);
	}
	public function nbAdherent()
	{
		return $this->lesAdherents->count();
	}

	// recupére les infos de l'utilisateur en cour
	public function infoAdherent()
	{
		$infos = '';
		foreach ($this->lesAdherents as $unAdherent)
		{
			if ($_SESSION['login'] == $unAdherent->loginAdherent)
			{
				$infos = $unAdherent->afficheAdherent();
			}
		}
		return $infos;
	}
	public function idAdherent()
	{
		$infos = '';
		foreach ($this->lesAdherents as $unAdherent)
		{
			if ($_SESSION['login'] == $unAdherent->loginAdherent)
			{
				$infos = $unAdherent->afficheIdAdherent();
			}
		}
		return $infos;
	}

	public function listeDesAdherents()
	{
		$liste = '';
		foreach ($this->lesAdherents as $unAdherent)
		{
			$liste = $liste . $unAdherent->afficheAdherent();
		}
		return $liste;
	}

	public function sexeAdherentAuFormatHTML($sexeSelectionne)
	{
		$liste = "<select id='sexEquipe' name='sexEquipe' required>";
		$liste .= "<option value='Féminin'";
		if ($sexeSelectionne === "Féminin")
		{
			$liste .= " selected";
		}
		$liste .= ">Féminin</option>";

		$liste .= "<option value='Masculin'";
		if ($sexeSelectionne === "Masculin")
		{
			$liste .= " selected";
		}
		$liste .= ">Masculin</option>";

		$liste .= "</select>";
		return $liste;
	}

	public function lesAdherentsAuFormatHTML()
	{
		$liste = "<SELECT name = 'idAdherent'>";
		foreach ($this->lesAdherents as $unAdherent)
		{
			$liste = $liste . "<OPTION value='" . $unAdherent->idAdherent . "'>" . $unAdherent->nomAdherent . "</OPTION>";
		}
		$liste = $liste . "</SELECT>";
		return $liste;
	}

	public function donneObjetAdherentDepuisNumero($unIdAdherent)
	{
		$trouve = false;
		$leBonAdherent = null;
		$iAdherent = $this->lesAdherents->getIterator();
		while ((!$trouve) && ($iAdherent->valid()))
		{
			if ($iAdherent->current()->idAdherent == $unIdAdherent)
			{
				$trouve = true;
				$leBonAdherent = $iAdherent->current();
			}
			else
				$iAdherent->next();
		}
		return $leBonAdherent;
	}
}
