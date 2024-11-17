<?php


class conteneurVacataire
{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesVacataires;

	//le constructeur créer un tableau vide
	public function __construct()
	{
		$this->lesVacataires = new arrayObject();
	}

	//les méthodes habituellement indispensables
	public function ajouterUnVacataire(int $unIdEntraineur, string $unNomEntraineur, string $unLoginEntraineur, string $unPwdEntraineur, string $unTelephone, conteneurSpecialite $lesSpecialite)
	{
		$unVacataire = new metierVacataire($lesSpecialite, $unIdEntraineur, $unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur, $unTelephone);
		$this->lesVacataires->append($unVacataire);
	}

	public function nbVacataire()
	{
		return $this->lesVacataires->count();
	}

	public function listeDesVacataires()
	{
		$liste = '';
		foreach ($this->lesVacataires as $unVacataire)
		{
			$liste = $liste . $unVacataire->afficheVacataire();
		}
		return $liste;
	}


	public function lesVacatairesAuFormatHTML()
	{
		$liste = "<SELECT name = 'idVacataire'>";
		foreach ($this->lesVacataires as $unVacataire)
		{
			$liste = $liste . "<OPTION value='" . $unVacataire->idEntraineur . "'>" . $unVacataire->nomEntraineur . "</OPTION>";
		}
		$liste = $liste . "</SELECT>";
		return $liste;
	}

	public function donneObjetVacataireDepuisNumero($unIdVacataire)
	{
		$leBonVacataire = null;
		foreach ($this->lesVacataires as $unVacataire)
		{
			if ($unVacataire->idEntraineur == $unIdVacataire)
			{
				$leBonVacataire = $unVacataire;
				
			}
		}

		return $leBonVacataire;
	}

	public function chercherExistanceIdVacataire($unId)
	{
		$trouve = false;
		foreach ($this->lesVacataires as $unVacataire)
		{
			if ($unVacataire->idEntraineur == $unId)
			{
				$trouve = true;
				break;
			}
		}
		return $trouve;
	}
}
