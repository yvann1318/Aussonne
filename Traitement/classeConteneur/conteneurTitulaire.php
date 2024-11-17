<?php

class conteneurTitulaire
{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesTitulaires;

	//le constructeur créer un tableau vide
	public function __construct()
	{
		$this->lesTitulaires = new arrayObject();
	}

	//les méthodes habituellement indispensables
	public function ajouterUnTitulaire(int $unIdEntraineur, string $unNomEntraineur, string $unLoginEntraineur, string $unPwdEntraineur, string $uneDateEmbauche, conteneurSpecialite $lesSpecialite)
	{
		$unTitulaire = new metierTitulaire($lesSpecialite, $unIdEntraineur, $unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur, $uneDateEmbauche);
		$this->lesTitulaires->append($unTitulaire);
	}

	public function nbTitulaire()
	{
		return $this->lesTitulaires->count();
	}

	public function listeDesTitulaires()
	{
		$liste = '';
		foreach ($this->lesTitulaires as $unTitulaire)
		{
			$liste = $liste . $unTitulaire->afficheTitulaire();
		}
		return $liste;
	}


	public function lesTitulairesAuFormatHTML()
	{
		$liste = "<SELECT name = 'idTitulaire'>";
		foreach ($this->lesTitulaires as $unTitulaire)
		{
			$liste = $liste . "<OPTION value='" . $unTitulaire->idEntraineur . "'>" . $unTitulaire->nomEntraineur . "</OPTION>";
		}
		$liste = $liste . "</SELECT>";
		return $liste;
	}

	public function donneObjetTitulaireDepuisNumero($unIdTitulaire)
	{

		$leBonTitulaire = null;
		foreach ($this->lesTitulaires as $unTitulaire)
		{
			if ($unTitulaire->idEntraineur == $unIdTitulaire)
			{

				$leBonTitulaire = $unTitulaire;
				
			}
		}
		return $leBonTitulaire;
	}

	public function chercherExistanceIdTitulaire($unId)
	{
		$trouve = false;
		foreach ($this->lesTitulaires as $unTitulaire)
		{
			if ($unTitulaire->idEntraineur == $unId)
				$trouve = true;
		}
		return $trouve;
	}
}
